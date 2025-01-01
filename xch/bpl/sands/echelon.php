<?php

// Database connection
$dsn = 'mysql:host=localhost;dbname=b2p_db;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Step 1: Fetch all users
$users = [];
$stmt = $pdo->query("SELECT id FROM network_users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[$row['id']] = [
        'bonus_echelon' => 0, // Changed to echelon bonus
        'downlines' => [],
        'earnings_summary' => [] // To store detailed earnings
    ];
}

// Step 2: Fetch all sponsor-downline relationships
$stmt = $pdo->query("SELECT id, sponsor_id FROM network_users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['sponsor_id'] != 0) {
        $users[$row['sponsor_id']]['downlines'][] = $row['id'];
    }
}

// Step 3: Fetch all approved conversions
$conversions = [];
$stmt = $pdo->query("SELECT user_id, amount FROM network_efund_convert WHERE date_approved > 0");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $conversions[$row['user_id']] = ($conversions[$row['user_id']] ?? 0) + $row['amount'];
}

// Step 4: Recursively find indirect downlines and calculate echelon bonuses
function calculateEchelonBonuses($user_id, &$users, &$conversions)
{
    $earnings = 0;
    foreach ($users[$user_id]['downlines'] as $downline_id) {
        // Add earnings from direct downline
        if (isset($conversions[$downline_id])) {
            $downline_earning = $conversions[$downline_id] * 0.10; // 10% echelon bonus
            $earnings += $downline_earning;
            // Add detailed earnings summary
            $users[$user_id]['earnings_summary'][$downline_id] = $downline_earning;
        }
        // Recursively add earnings from indirect downlines
        $indirect_earnings = calculateEchelonBonuses($downline_id, $users, $conversions);
        $earnings += $indirect_earnings;
    }
    return $earnings;
}

// Calculate echelon bonuses for each user
foreach ($users as $user_id => &$user) {
    $user['bonus_echelon'] = calculateEchelonBonuses($user_id, $users, $conversions);
}

// Step 5: Update user echelon bonuses in the database
foreach ($users as $user_id => $user) {
    $bonus = $user['bonus_echelon'];
    $stmt = $pdo->prepare("UPDATE network_users SET bonus_echelon = bonus_echelon + ? WHERE id = ?");
    $stmt->execute([$bonus, $user_id]);
}

// Output summary of echelon bonuses for debugging
echo "<pre>";
print_r($users);
echo "</pre>";

// Close connection
$pdo = null;

echo "Echelon bonuses calculated and updated successfully!";
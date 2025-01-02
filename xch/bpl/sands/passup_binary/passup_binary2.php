<?php

// Database connection
$dsn = 'mysql:host=localhost;dbname=b2p_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to get compensation based on account_type
function getCompensation($account_type)
{
    $compensation = [
        'chairman' => 1000,
        'executive' => 800,
        'regular' => 600,
        'associate' => 400,
        'basic' => 200,
        'starter' => 100
    ];

    return $compensation[$account_type] ?? 0;
}

// Function to get percentage based on account_type
function getPercentage($account_type)
{
    $percentages = [
        'chairman' => 0.2,
        'executive' => 0.15,
        'regular' => 0.1,
        'associate' => 0.05,
        'basic' => 0.03,
        'starter' => 0.01
    ];

    return $percentages[$account_type] ?? 0;
}

// Function to calculate the income for a user from C's down the line
function calculateIncomeFromCs($user_id, $pdo, $compound = false)
{
    $total_income = 0;
    $C_incomes = [];

    // Get D, the downline_right_id of the user
    $stmt = $pdo->prepare("SELECT downline_right_id FROM network_binary WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $D_id = $stmt->fetchColumn();

    if ($D_id) {
        // Get the first C, the downline_left_id of D
        $stmt = $pdo->prepare("SELECT downline_left_id FROM network_binary WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $D_id]);
        $C_id = $stmt->fetchColumn();

        // Initialize the cumulative percentage
        $cumulative_percentage = 1;

        // Traverse through the C's
        while ($C_id) {
            // Fetch the account_type and username for the current C
            $stmt = $pdo->prepare("SELECT account_type, username FROM network_users WHERE id = :user_id");
            $stmt->execute(['user_id' => $C_id]);
            $C_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $account_type = $C_data['account_type'];
            $username = $C_data['username'];

            // Get the compensation and percentage based on the account_type
            $compensation = getCompensation($account_type);
            $percentage = getPercentage($account_type);

            // If compounding, update the cumulative percentage
            if ($compound) {
                $cumulative_percentage *= $percentage;
            } else {
                $cumulative_percentage = $percentage;
            }

            // Calculate the income for the current C
            $C_income = $compensation * $cumulative_percentage;
            $C_incomes[$username] = $C_income;

            // Add the income to the total income
            $total_income += $C_income;

            // Get the next C, the downline_left_id of the current C
            $stmt = $pdo->prepare("SELECT downline_left_id FROM network_binary WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $C_id]);
            $C_id = $stmt->fetchColumn();
        }
    }

    return [
        'passup_binary' => $total_income,
        'C_incomes' => $C_incomes
    ];
}

// Fetch all users from network_users
$stmt = $pdo->query("SELECT id, username FROM network_users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate income for each user and store the results in an array
$compound = true; // Set to false if you don't want to compound the percentage
$results = [];

foreach ($users as $user) {
    $user_id = $user['id'];
    $username = $user['username'];

    // Check if the user exists in network_binary
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM network_binary WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // Calculate income for the user from C's down the line
        $income_data = calculateIncomeFromCs($user_id, $pdo, $compound);

        // Only include users with non-zero income
        if ($income_data['passup_binary'] > 0) {
            $results[$username] = [
                'passup_binary' => $income_data['passup_binary'],
                'C_incomes' => $income_data['C_incomes']
            ];
        }
    }
}


echo '<pre>';
// Return the results array
print_r($results);
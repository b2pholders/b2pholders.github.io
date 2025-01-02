<?php

// Database connection
$dsn = 'mysql:host=your_host;dbname=b2p_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to calculate the income for a given user_id
function calculateIncome($user_id, $pdo, $compound = false, &$memo = [])
{
    if (isset($memo[$user_id])) {
        return $memo[$user_id];
    }

    $income = 0;

    // Fetch the downline_left_id and downline_right_id for the current user
    $stmt = $pdo->prepare("SELECT downline_left_id, downline_right_id FROM network_binary WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $downline_left_id = $row['downline_left_id'];
        $downline_right_id = $row['downline_right_id'];

        // Fetch the account_type for the current user
        $stmt = $pdo->prepare("SELECT account_type FROM network_users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $account_type = $stmt->fetchColumn();

        $percentage = getPercentage($account_type);

        // Calculate income from the left downline
        if ($downline_left_id != 0) {
            $stmt = $pdo->prepare("SELECT account_type FROM network_users WHERE id = :id");
            $stmt->execute(['id' => $downline_left_id]);
            $downline_account_type = $stmt->fetchColumn();

            $compensation = getCompensation($downline_account_type);
            $income += $compensation * $percentage;

            if ($compound) {
                $income += calculateIncome($downline_left_id, $pdo, $compound, $memo) * $percentage;
            } else {
                $income += calculateIncome($downline_left_id, $pdo, $compound, $memo) * getPercentage($downline_account_type);
            }
        }

        // Calculate income from the right downline
        if ($downline_right_id != 0) {
            $stmt = $pdo->prepare("SELECT account_type FROM network_users WHERE id = :id");
            $stmt->execute(['id' => $downline_right_id]);
            $downline_account_type = $stmt->fetchColumn();

            $compensation = getCompensation($downline_account_type);
            $income += $compensation * $percentage;

            if ($compound) {
                $income += calculateIncome($downline_right_id, $pdo, $compound, $memo) * $percentage;
            } else {
                $income += calculateIncome($downline_right_id, $pdo, $compound, $memo) * getPercentage($downline_account_type);
            }
        }
    }

    $memo[$user_id] = $income;
    return $income;
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

// Fetch all user_ids from network_binary
$stmt = $pdo->query("SELECT user_id FROM network_binary");
$user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Calculate income for each user and update their income in network_users
$memo = [];
$compound = true; // Set to false if you don't want to compound the percentage
foreach ($user_ids as $user_id) {
    $income = calculateIncome($user_id, $pdo, $compound, $memo);

    // Update the income in network_users
    $stmt = $pdo->prepare("UPDATE network_users SET income_cycle_global = :income WHERE id = :user_id");
    $stmt->execute(['income' => $income, 'user_id' => $user_id]);

    echo "Income for user_id $user_id: $income\n";
}
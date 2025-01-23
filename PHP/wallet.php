<?php
// Start the session to track logged-in user
session_start();

// Assuming the user's type is stored in the session after login
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'patient'; // Default to 'patient'

// Fetch wallet details based on user type from the database (this is a placeholder)
if ($userType == 'patient') {
    $balance = 500; // Example balance
    $availableBalance = 500; // Example available balance
    $paymentHistory = []; // No history for the patient
} elseif ($userType == 'therapist') {
    $balance = 1200; // Example balance
    $availableBalance = 1080; // 10% commission deducted for therapist
    $paymentHistory = [
        ['date' => '2024-12-20', 'amount' => 100, 'method' => 'Bkash', 'status' => 'Completed'],
        ['date' => '2024-12-19', 'amount' => 200, 'method' => 'Nagad', 'status' => 'Completed'],
        ['date' => '2024-12-18', 'amount' => 50, 'method' => 'Cash', 'status' => 'Completed'],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS as before */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Wallet Information</h1>

        <!-- Dynamic content based on user type -->
        <div id="walletContent">
            <?php if ($userType == 'patient'): ?>
                <h4>Patient Wallet</h4>
                <p><strong>Balance:</strong> $<?php echo $balance; ?></p>
                <p><strong>Available Balance:</strong> $<?php echo $availableBalance; ?></p>
                <p><strong>Payment History:</strong> No history available.</p>
            <?php elseif ($userType == 'therapist'): ?>
                <h4>Therapist Wallet</h4>
                <p><strong>Balance:</strong> $<?php echo $balance; ?></p>
                <p><strong>Available Balance (after 10% commission):</strong> $<?php echo $availableBalance; ?></p>
                <p><strong>Payment History:</strong></p>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentHistory as $payment): ?>
                            <tr>
                                <td><?php echo $payment['date']; ?></td>
                                <td>$<?php echo $payment['amount']; ?></td>
                                <td><?php echo $payment['method']; ?></td>
                                <td><?php echo $payment['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <button class="btn btn-primary mt-3" onclick="window.location.href='profile.php'">Back to Profile</button>
    </div>
</body>
</html>

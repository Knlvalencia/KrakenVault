<?php
session_start();
require_once __DIR__ . '/classes/Account.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($studentId) || empty($password)) {
        header("Location: login.php?error=" . urlencode("Student ID and Password are required."));
        exit();
    }

    $accountModel = new Account();
    $officerId = $accountModel->verifyAccountByStudentId($studentId, $password);

    if ($officerId) {
        // Login successful
        $_SESSION['officer_id'] = $officerId;
        // Redirect to Document Archive as default authenticated page
        header("Location: documentarchive.php");
        exit();
    } else {
        // Login failed
        header("Location: login.php?error=" . urlencode("Invalid Student ID or Password."));
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

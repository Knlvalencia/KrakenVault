<?php 
session_start();
if (isset($_SESSION['officer_id'])) {
    header("Location: documentarchive.php");
    exit();
}
$pageTitle = 'Login - Kraken Vault'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="logo.png" alt="Kraken Vault Logo" class="logo login-logo">
                <h1>Kraken Vault</h1>
                <p>Secure Student Document Management</p>
            </div>

            <form action="auth.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="studentId">Student ID</label>
                    <input 
                        type="text" 
                        id="studentId" 
                        name="student_id" 
                        placeholder="e.g., 2024-00123" 
                        pattern="20[0-9]{2}-[0-9]{5}" 
                        title="Format: 20XX-XXXXX"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password" 
                        required
                    >
                </div>

                <div class="login-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="#">Contact Administrator</a></p>
            </div>
        </div>
    </div>

</body>
</html>
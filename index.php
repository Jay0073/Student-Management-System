<?php
session_start();
require 'php/connection.php';
 
// Preinitialized admin credentials
$admin_email = 'admin@example.com';
$admin_password = 'admin123';

$error_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for admin
    if ($email == $admin_email && $password == $admin_password) {
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    }

    // Check in students table
    $student_query = "SELECT * FROM students WHERE email='$email'";
    $student_result = mysqli_query($conn, $student_query);

    if ($student_result && mysqli_num_rows($student_result) == 1) {
        $student = mysqli_fetch_assoc($student_result);
        $_SESSION['role'] = 'student';
        $_SESSION['user_id'] = $student['student_id']; // Store student ID in session
        header("Location: student_dashboard.php");
        exit();
    }

    // Check in teachers table
    $teacher_query = "SELECT * FROM teachers WHERE email='$email'";
    $teacher_result = mysqli_query($conn, $teacher_query);

    if ($teacher_result && mysqli_num_rows($teacher_result) == 1) {
        $teacher = mysqli_fetch_assoc($teacher_result);
        $_SESSION['role'] = 'teacher';
        $_SESSION['user_id'] = $teacher['teacher_id']; // Store teacher ID in session
        header("Location: teacher_dashboard.php");
        exit();
    }

    // If no match found, show error
    $error_message = "Invalid email or password!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            width: 360px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin: 0 0 20px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #0288d1;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0277bd;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link a {
            color: #0288d1;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error_message): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login_submit">Login</button>
        </form>
        
        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>

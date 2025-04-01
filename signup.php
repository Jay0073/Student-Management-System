<?php
require 'php/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($role == 'student') {
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $query = "INSERT INTO students (name, email, class) VALUES ('$name', '$email', '$class', '')";
    } elseif ($role == 'teacher') {
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $query = "INSERT INTO teachers (name, email, subject, phone_number) VALUES ('$name', '$email', '$subject', '$phone')";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Signup successful! Redirecting...');</script>";
        header("Location: {$role}_dashboard.php");
    } else {
        $error_message = "Signup failed! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .form-container {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 94%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0277bd;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } ?>
        <form method="POST">
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div id="additional-fields"></div>
            <input type="submit" value="Sign Up">
        </form>
    </div>

    <script>
        const roleSelect = document.querySelector('[name="role"]');
        const additionalFields = document.getElementById('additional-fields');

        roleSelect.addEventListener('change', function () {
            additionalFields.innerHTML = '';
            if (this.value === 'student') {
                additionalFields.innerHTML = `
                    <select name="class" required>
                        <option value="" disabled selected>Select Class</option>
                        <option value="1st class">1st class</option>
                        <option value="2nd class">2nd class</option>
                        <option value="3rd class">3rd class</option>
                        <option value="4th class">4th class</option>
                        <option value="5th class">5th class</option>
                        <option value="6th class">6th class</option>
                        <option value="7th class">7th class</option>
                        <option value="8th class">8th class</option>
                        <option value="9th class">9th class</option>
                        <option value="10th class">10th class</option>
                    </select>
                `;
            } else if (this.value === 'teacher') {
                additionalFields.innerHTML = `
                    <input type="text" name="subject" placeholder="Subject" required>
                    <input type="text" name="phone" placeholder="Phone Number" required>
                `;
            }
        });
    </script>
</body>

</html>
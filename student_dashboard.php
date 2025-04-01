<?php
session_start();
require 'php/connection.php';

// Check if the user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Fetch student details
$student_query = "SELECT * FROM students WHERE student_id='$student_id'";
$student_result = mysqli_query($conn, $student_query);
$student = mysqli_fetch_assoc($student_result);

// Fetch attendance details
$attendance_query = "SELECT * FROM attendance WHERE user_id='$student_id' AND role='student'";
$attendance_result = mysqli_query($conn, $attendance_query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .container {
            margin: 20px auto;
            width: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .student-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }

        .student-info {
            font-size: 18px;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .buttons button {
            padding: 10px 15px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #0277bd;
        }

        .attendance-history {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .no-attendance {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Student Details Section -->
        <div class="student-details">
            <div class="student-info">
                <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
                <p><strong>Class:</strong> <?php echo $student['class']; ?></p>

            </div>
            <div class="buttons">
                <button onclick="window.location.href='logout.php'">Logout</button>
                <button onclick="markAttendance()">Mark Today's Attendance</button>
            </div>
        </div>

        <!-- Attendance History Section -->
        <div class="attendance-history">
            <h2>Attendance History</h2>
            <?php if (mysqli_num_rows($attendance_result) > 0): ?>
                <table>
                    <thead>
                        <tr style="background-color: #0288d1; color: white;">
                            <th style="padding: 10px; text-align: left;">Date</th>
                            <th style="padding: 10px; text-align: left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($attendance = mysqli_fetch_assoc($attendance_result)): ?>
                            <tr style="background-color: <?php echo $attendance['status'] == 'Present' ? '#e8f5e9' : '#ffebee'; ?>;">
                                <td style="padding: 10px;"><?php echo $attendance['attendance_date']; ?></td>
                                <td style="padding: 10px;">
                                    <?php if ($attendance['status'] == 'Present'): ?>
                                        <span style="color: white; background-color: green; padding: 5px 10px; border-radius: 4px;">Present</span>
                                    <?php else: ?>
                                        <span style="color: white; background-color: red; padding: 5px 10px; border-radius: 4px;">Absent</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                            
                </table>
            <?php else: ?>
                <p class="no-attendance">No attendance records found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function markAttendance() {
            // AJAX request to mark attendance
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "mark_attendance.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    location.reload(); // Reload the page to show updated attendance
                }
            };
            xhr.send("user_id=<?php echo $student_id; ?>&role=student");
        }
    </script>
</body>

</html>
<?php
session_start();
require 'php/connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch student and teacher details
$students_query = "SELECT * FROM students";
$students_result = mysqli_query($conn, $students_query);

$teachers_query = "SELECT * FROM teachers";
$teachers_result = mysqli_query($conn, $teachers_query);

// Fetch attendance details grouped by date for students
$students_attendance_query = "SELECT * FROM attendance WHERE role='student' ORDER BY attendance_date DESC";
$students_attendance_result = mysqli_query($conn, $students_attendance_query);

// Fetch attendance details grouped by date for teachers
$teachers_attendance_query = "SELECT * FROM attendance WHERE role='teacher' ORDER BY attendance_date DESC";
$teachers_attendance_result = mysqli_query($conn, $teachers_attendance_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
        }

        .sidebar {
            width: 20%;
            background-color: #0288d1;
            color: white;
            height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .list {
            margin-bottom: 40px;
        }

        .list ul {
            list-style-type: none;
            padding: 0;
        }

        .list li {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid white;
        }

        .list li:hover {
            background-color: #0277bd;
        }

        .content {
            width: 80%;
            padding: 20px;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            background-color: #f0f8ff;
            border: 1px solid #ccc;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }

        .tab.active {
            background-color: #0288d1;
            color: white;
            border: none;
        }

        .attendance-table {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #0288d1;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin Panel</h3>

        <!-- Student List -->
        <div class="list">
            <h4>Students</h4>
            <ul>
                <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                    <li><?php echo $student['name']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Teacher List -->
        <div class="list">
            <h4>Teachers</h4>
            <ul>
                <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                    <li><?php echo $teacher['name']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Tabs -->
        <div class="tabs">
            <div id="studentsTab" class="tab active" onclick="showTab('students')">Students</div>
            <div id="teachersTab" class="tab" onclick="showTab('teachers')">Teachers</div>
        </div>

        <!-- Students Attendance Content -->
        <div id="studentsContent" class="attendance-table">
            <h3>Student Attendance by Date</h3>
            <?php if (mysqli_num_rows($students_attendance_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($attendance = mysqli_fetch_assoc($students_attendance_result)): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $student_query = "SELECT name FROM students WHERE student_id = '{$attendance['user_id']}'";
                                    $student_name_result = mysqli_query($conn, $student_query);
                                    $student_name = mysqli_fetch_assoc($student_name_result)['name'];
                                    echo $student_name;
                                    ?>
                                </td>
                                <td><?php echo $attendance['attendance_date']; ?></td>
                                <td><?php echo $attendance['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No attendance records found for students.</p>
            <?php endif; ?>
        </div>

        <!-- Teachers Attendance Content -->
        <div id="teachersContent" class="attendance-table" style="display: none;">
            <h3>Teacher Attendance by Date</h3>
            <?php if (mysqli_num_rows($teachers_attendance_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($attendance = mysqli_fetch_assoc($teachers_attendance_result)): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $teacher_query = "SELECT name FROM teachers WHERE teacher_id = '{$attendance['user_id']}'";
                                    $teacher_name_result = mysqli_query($conn, $teacher_query);
                                    $teacher_name = mysqli_fetch_assoc($teacher_name_result)['name'];
                                    echo $teacher_name;
                                    ?>
                                </td>
                                <td><?php echo $attendance['attendance_date']; ?></td>
                                <td><?php echo $attendance['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No attendance records found for teachers.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showTab(tab) {
            const studentsTab = document.getElementById('studentsTab');
            const teachersTab = document.getElementById('teachersTab');
            const studentsContent = document.getElementById('studentsContent');
            const teachersContent = document.getElementById('teachersContent');

            if (tab === 'students') {
                studentsTab.classList.add('active');
                teachersTab.classList.remove('active');
                studentsContent.style.display = 'block';
                teachersContent.style.display = 'none';
            } else {
                studentsTab.classList.remove('active');
                teachersTab.classList.add('active');
                studentsContent.style.display = 'none';
                teachersContent.style.display = 'block';
            }
        }
    </script>
</body>
</html>
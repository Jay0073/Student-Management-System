<?php
session_start();
require 'php/connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch students and teachers from the database
$students_query = "SELECT * FROM students";
$students_result = mysqli_query($conn, $students_query);

$teachers_query = "SELECT * FROM teachers";
$teachers_result = mysqli_query($conn, $teachers_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #0288d1;
            color: white;
        }

        .tabs {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .tab {
            padding: 10px 20px;
            background-color: #f0f8ff;
            border: 1px solid #ccc;
            cursor: pointer;
            border-radius: 4px;
        }

        .tab.active {
            background-color: #0288d1;
            color: white;
            border: none;
        }

        .content {
            margin: 20px auto;
            width: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .filters {
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            margin-right: 10px;
            border-radius: 4px;
        }

        .logout {
            background-color: white;
            color: #0288d1;
            padding: 10px 15px;
            border: 1px solid #0288d1;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout:hover {
            background-color: #0277bd;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h2>Admin Dashboard</h2>
        <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <!-- Tabs Section -->
    <div class="tabs">
        <div id="studentsTab" class="tab active" onclick="showTab('students')">Students</div>
        <div id="teachersTab" class="tab" onclick="showTab('teachers')">Teachers</div>
    </div>

    <!-- Content Section -->
    <div id="studentsContent" class="content">
        <h3>Student Details</h3>

        <!-- Filters -->
        <div class="filters">
            <select id="studentClassFilter" onchange="filterTable('studentsTable', 3, this.value)">
                <option value="">Filter by Class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
            </select>
        </div>

        <!-- Students Table -->
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Age</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = mysqli_fetch_assoc($students_result)): ?>
                    <tr>
                        <td><?php echo $student['student_id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['class']; ?></td>
                        <td><?php echo $student['age']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="teachersContent" class="content" style="display: none;">
        <h3>Teacher Details</h3>

        <!-- Filters -->
        <div class="filters">
            <select id="teacherSubjectFilter" onchange="filterTable('teachersTable', 3, this.value)">
                <option value="">Filter by Subject</option>
                <option value="Math">Math</option>
                <option value="Science">Science</option>
            </select>
        </div>

        <!-- Teachers Table -->
        <table id="teachersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($teacher = mysqli_fetch_assoc($teachers_result)): ?>
                    <tr>
                        <td><?php echo $teacher['teacher_id']; ?></td>
                        <td><?php echo $teacher['name']; ?></td>
                        <td><?php echo $teacher['email']; ?></td>
                        <td><?php echo $teacher['subject']; ?></td>
                        <td><?php echo $teacher['phone_number']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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

        function filterTable(tableId, columnIndex, filterValue) {
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (filterValue === "" || cells[columnIndex].textContent === filterValue) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
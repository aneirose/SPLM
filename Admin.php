<?php
session_start();
$user = $_SESSION['Email'];
$role = $_SESSION['Role'];

// Redirect to login if session data is empty
if (empty($_SESSION['Email'])) {
    header("location:index.php");
    exit();
} else {
    // Database connection
    include('connection.php');   
    
    // Fetch total numbers
    $total_students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
    $total_projects = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];
    $total_supervisor = $conn->query("SELECT COUNT(*) as total FROM supervisor")->fetch_assoc()['total'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        .totals-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .total-box {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 25%;
            text-align: center;
        }
    </style>
    <title>SPLMS</title>
</head>
<body>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#b2beb5">
        <th width="74" scope="col">&nbsp;</th>
        <th width="164" scope="col"></th>
        <th width="646" scope="col"><font size="8" color="White">Senior Project Lifecycle Monitoring System</font></th>
        <th width="140" scope="col"><font color="White" size="5">
            <?php
            echo htmlspecialchars($role);
            echo "<br/>";
            echo htmlspecialchars($user);
            ?>
        </font></th>
        <th width="63" scope="col">&nbsp;</th>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
    <?php if ($role == "Admin"): ?>
    <tr bgcolor="#99CCFF">
        <th width="5%" scope="col"><h4>&nbsp;</h4></th>
        <th width="12%" scope="col"><a href="ADMIN/student.php">Add Student</a></th>
        <th width="11%" scope="col"><a href="ADMIN/instructor.php">Add Instructor</a></th>
        <th width="11%" scope="col"><a href="ADMIN/supervisor.php">Add Supervisor</a></th>
        <th width="11%" scope="col"><a href="ADMIN/view_student.php">View Student</a></th>
        <th width="11%" scope="col"><a href="ADMIN/view_supervisor.php">View Supervisor</a></th>
        <th width="11%" scope="col"><a href="ADMIN/view_instructor.php">View Instructor</a></th>
        <th width="11%" scope="col"><a href="logout.php">Logout</a></th>
        <th width="6%" scope="col">&nbsp;</th>
    </tr>
    <?php elseif ($role == "Instructor"): ?>
    <tr bgcolor="#99CCFF">
        <th width="7%" scope="col"><h4>&nbsp;</h4></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/projects/index.php">Projects</a></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/students/index.php">View Students</a></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/supervisors/index.php">Supervisors</a></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/instructorview.php">View Registered Students</a></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/grading/addmarks.php">Add Marks</a></th>
        <th width="13%" scope="col"><a href="INSTRUCTOR/grading/view_marks.php">View Marks</a></th>
        <th width="15%" scope="col"><a href="logout.php">Logout</a></th>
        <th width="6%" scope="col">&nbsp;</th>
    </tr>
    <?php elseif ($role == "Supervisor"): ?>
    <tr bgcolor="#99CCFF">
        <th width="6%" scope="col"><h4>&nbsp;</h4></th>
        <th width="13%" scope="col"><a href="SUPERVISOR/students/index.php">View Students</a></th>
        <th width="13%" scope="col"><a href="SUPERVISOR/viewproject.php">View Project</a></th>
        <th width="13%" scope="col"><a href="SUPERVISOR/files/download.php">Download Reports</a></th>
        <th width="15%" scope="col"><a href="logout.php">Logout</a></th>
        <th width="6%" scope="col">&nbsp;</th>
    </tr>
    <?php elseif ($role == "Student"): ?>
    <tr bgcolor="#99CCFF">
        <th width="6%" scope="col"><h4>&nbsp;</h4></th>
        <th width="13%" scope="col"><a href="STUDENT/course.php">Register Course</a></th>
        <th width="13%" scope="col"><a href="STUDENT/project.php">Projects</a></th>
        <th width="13%" scope="col"><a href="STUDENT/files/index.php">Upload Report</a></th>
        <th width="13%" scope="col"><a href="STUDENT/view_grade.php">My grade</a></th>
        <th width="15%" scope="col"><a href="logout.php">Logout</a></th>
        <th width="6%" scope="col">&nbsp;</th>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="10"></td>
    </tr>
    </table>
    <div class="totals-container">
        <?php if ($role == "Admin" || $role == "Instructor" || $role == "Supervisor"): ?>
        <div class="total-box">
            <h3>Total Students</h3>
            <p><?php echo $total_students; ?></p>
        </div>
        <div class="total-box">
            <h3>Total Projects</h3>
            <p><?php echo $total_projects; ?></p>
        </div>
       
        <?php endif; ?>
        <?php if ($role == "Admin" || $role == "Instructor" || $role == "Supervisor"): ?>
        <div class="total-box">
            <h3>Total Supervisors</h3>
            <p><?php echo $total_supervisor; ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php } ?>

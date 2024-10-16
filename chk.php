<?php
session_start();
include 'connection.php';

$user = $_POST['id'];
$pass = $_POST['pass'];
$role = $_POST['role'];

function redirect($url) {
    header("Location: $url");
    exit();
}

if (!empty($user) && !empty($pass)) {
    // Prepare the SQL statement based on the role
    $sql = "";
    $stmt = null;
    if ($role == "Admin") {
        $sql = "SELECT * FROM admin WHERE ID=? AND password=?";
    } elseif ($role == "Instructor") {
        $sql = "SELECT * FROM instructor WHERE ins_id=? AND password=?";
    } elseif ($role == "Supervisor") {
        $sql = "SELECT * FROM supervisor WHERE sup_id=? AND password=?";
    } else {
        $sql = "SELECT * FROM students WHERE s_id=? AND password=?";
    }

    // Use prepared statements
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $count = mysqli_num_rows($res);

        if ($count == 0) {
            echo "Username or password incorrect";
            redirect("index.php");
        } else {
            $userData = mysqli_fetch_assoc($res);
            $_SESSION['Email'] = $user;
            $_SESSION['Role'] = $role;

            // Set session variable for student ID
            if ($role == "Student") {
                $_SESSION['s_id'] = $userData['s_id'];
            }

            // Set session variable for supervisor ID
            if ($role == "Supervisor") {
                $_SESSION['supervisor_id'] = $userData['sup_id'];
            }

            // Redirect to the appropriate page based on the role
            redirect("Admin.php?image=image.php");
        }
    } else {
        echo "Database error: Unable to prepare statement";
    }
} else {
    echo 'Fill up all fields';
}
?>

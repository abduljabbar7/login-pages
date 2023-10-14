<?php
// Start a session
session_start();
include 'db_connection.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    $userRole = $_POST['role'];

    // Prepare the SQL query
    $sql = "SELECT * FROM register WHERE email = ? AND password = ? AND role = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $userEmail, $userPassword, $userRole);
    mysqli_stmt_execute($stmt);

    // Fetch the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Store user information in session variables
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userEmail'] = $user['email'];
        $_SESSION['userRole'] = $user['role'];

        // Redirect based on the user's role
        if ($userRole === 'admin') {
            header('location: ../admin/index.html');
            exit();
        } else if ($userRole === 'student') {
             header('location: ../student/index.html');
            exit();
        }
    } else {
        // If no matching user is found, show an error message
        echo "Invalid email, password, or role.";
    }
}
?>

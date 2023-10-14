<?php 
include 'db_connection.php';
if (isset($_POST['register'])) {
  $role    = $_POST['role'];
  $name    = $_POST['name'];
  $email   = $_POST['email'];
  $pass    = $_POST['password'];
  $number  = $_POST['number'];
  $gender  = $_POST['gender'];
  $zipcode = $_POST['zipcode'];
  $about   = $_POST['about'];
  $password = stripslashes($password);
$password = addslashes($password);
$password = md5($password);
 
//create connection

if(mysqli_connect_error()){
      die('connection error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }else{
      $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $INSERT = "INSERT Into register (role, name, email, password, phNumber, gender, zipcode, about) values( ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($SELECT);
             $stmt->bind_param("s", $email);
            $stmt->execute();
             $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssssisis", $role, $name, $email, $pass, $number, $gender, $zipcode, $about);
                $stmt->execute();
                header("location: ../index.html");
              }else
{
//header("location:../register.html?q7=Email Already Registered!!!");
header("location:../index.html?q7=Email Already Registered!!!");
}
ob_end_flush();
      }
  }



  ?>
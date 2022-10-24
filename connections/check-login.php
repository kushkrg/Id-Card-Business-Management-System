<?php  
session_start();
include "config.php";

if (isset($_POST['submit'])){

	$email = $_POST['email'];
	$password = $_POST['password'];


	// if (empty($email)) {
	// 	header("Location: ../user/login.php?error=User Name is Required");
	// }else if (empty($password)) {
	// 	header("Location: ../user/login.php?error=Password is Required");
	// }else {

		// Hashing the password
		// $password = md5($password);
        
        $sql = "SELECT * FROM schools WHERE email='$email' AND password='$password'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) === 1) {
        	// the user name must be unique
        	$row = mysqli_fetch_assoc($result);
        	if ($row['password'] === 123) {
        		$_SESSION['name'] = $row['name'];
        		$_SESSION['id'] = $row['id'];
        		$_SESSION['phone'] = $row['phone'];
        		$_SESSION['email'] = $row['email'];

        		header("Location: index.php");

        	}else {
        		header("Location: ../user/login.php?error=Incorect User name or password");
        	}
        }else {
        	header("Location: ../user/login.php?error=Incorect User name or password");
        }

	}
	
else {
	header("Location: ../user/login.php");
}
<?php
include('connections/config.php');

$id = $_GET['id'];
$delete = "DELETE FROM schools WHERE id = $id";
$run_data = mysqli_query($con, $delete);
if($run_data){
    // unlink($row['student_images/']);
	// 		$error = "<p align=center>Image ".$row["img_path"].""."<br /> has been deleted from table.</p>";
	header('location:index.php');
}else{
	echo "Donot Delete";
}



?>
<?php
include("auth_session.php");
include('../connections/config.php');
include("compressimage.php");
$ids = $_SESSION['ids'];
$added = false;
$error = false;

if(isset($_POST['submit'])){
    
    $sname = $_SESSION['sname'];
	$adm_no = mysqli_real_escape_string($con, $_POST['adm_no']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $class = mysqli_real_escape_string($con, $_POST['class']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $roll = mysqli_real_escape_string($con, $_POST['roll']);
    $father = mysqli_real_escape_string($con, $_POST['father']);
    $mother = mysqli_real_escape_string($con, $_POST['mother']);
    $mob = mysqli_real_escape_string($con, $_POST['mob']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $transport = mysqli_real_escape_string($con, $_POST['transport']);
	
    //image rename
    $rename = $ids."_".$mob."_".$class."_".$roll;
    
	//image upload

	$image = $_FILES['image']['name'];
    $ext = strtolower(substr(strrchr($image, '.'), 1)); //Get extension
    $image_name = $rename . '.' . $ext; //New image name
    // $target = "student_images/".basename($file);
    
     
    $maxsize = 524288; //maximum size of allowed image being uploaded (around half MB)
    $maxwidth = 170; //maximum width of allowed image dimension in pixels
    // $mheight = 160; //max height
    $extsAllowed = array( 'jpg', 'jpeg', 'png' ); //allowed extensions
    $uploadedfile = $_FILES["image"]["name"];
    $extension = pathinfo($uploadedfile, PATHINFO_EXTENSION);
                 
    //if uploaded image is in one of allowed extensions/formats, then proceed to next steps
    if(in_array($extension, $extsAllowed) ) { 
                     
                    //generate random image file name
                    $newppic = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 10);
                    $target = "student_images/" . $rename .".". $extension;
                     
                    //if uploaded image is exceeding max size then compress it
                    if(($_FILES['image']['size'] >= $maxsize)){
                        // echo "Uploaded image size is greater than $maxsize.<br>";
                        compressimage($_FILES['image']['tmp_name'], "student_images/" . $rename .".". $extension, $maxwidth); // resize it to 512pixels width
                        
                
                    }else{
                        //check if the uploaded image width in pixels is greater than maxwidth
                        list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                        if($width > $maxwidth){
                            // echo "Uploaded image width is greater than $maxwidth.<br>";
                            compressimage($_FILES['image']['tmp_name'], "student_images/" . $rename .".". $extension, $maxwidth); // resize it to 120pixels width
                        }else{
                            echo "This image is just nice.<br>";
                            $result = move_uploaded_file($_FILES['image']['tmp_name'], $rename);
                        }
                    }

    }else{
        echo "<script>
                alert('Invalid! Please Choose Valid File type only jpg or png');
                window.location.href = 'index.php';
              </script>";
    }

  	$insert_data = "INSERT INTO `student_data`(`sname`,`adm_no`,`name`, `dob`, `class`, `section`, `roll`, `father`, `mother`, `mob`, `address`, `transport`, `image`) VALUES ('$sname','$adm_no','$name','$dob','$class','$section','$roll','$father','$mother','$mob','$address','$transport','$image_name')";

  	$run_data = mysqli_query($con, $insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" >
    <script defer src="../js/all.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="style-2.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#"><?= $_SESSION['sname'] ?></a>
  <button
    class="navbar-toggler"
    type="button"
    data-toggle="collapse"
    data-target="#navbarCollapse"
    aria-controls="navbarCollapse"
    aria-expanded="false"
    aria-label="Toggle navigation"
  >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
      <li class="nav-item active">
        <a class="nav-link" href="#">Add Student's Data <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view-data.php">View Data</a>
      </li>
    
    </ul>
    <div class="form-inline ml-auto mt-2 mt-md-0">
      
      <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0">Logout</a>
</div>
  </div>
  
</nav>

<main class="content-wrapper">
  <div class="container-fluid">

    <!-- showing success message after adding the data  -->
    <?php
      if($added){
        echo "
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$name Added Successfully!</strong> Now you can insert new Student Data in below the form.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
              ";
      }
       if($error){
        echo "
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Invalid File Type!</strong> Please choose only JPG or PNG file.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
              ";
      }
    ?>
    <!-- main form  -->
    <div class="card">
        <div class="card-header">
            Add Student's Data
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <input class="form-control my-2" type="text" name="adm_no" placeholder="Admission/ SL No." >
            <input class="form-control my-2" type="text" name="name" placeholder="Name" required>
            <label for="DOB">Date of Birth</label>
            <input class="form-control my-2" type="date" name="dob">
            <select class="form-control my-2" name="class" required>
                <option disabled selected>Choose Class</option>
                <option value="Nursery">Nursery</option>
                <option value="LKG">LKG</option>
                <option value="UKG">UKG</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
                <option value="V">V</option>
                <option value="VI">VI</option>
                <option value="VII">VII</option>
                <option value="VIII">VIII</option>
                <option value="IX">IX</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>

            </select>
            <select name="section" class="form-control" name="section">
              <option disabled selected>Choose Section</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="N/A">N/A</option>
            </select>
            <input type="number" class="form-control my-2" name="roll" placeholder="Roll No." required>
            <input type="text" class="form-control my-2" name="father" placeholder="Father's Name">
            <input type="text" class="form-control my-2" name="mother" placeholder="Mother's Name">
            <input type="text" class="form-control my-2" name="mob" placeholder="Mobile No." required>

            <input type="text" class="form-control my-2" name="address" placeholder="Residence Address">

            <input type="text" class="form-control my-2" name="transport" placeholder="Transport">
            <input type="file" class="form-control my-2" name="image" required>
            
            <input type="submit" class="btn btn-primary btn-lg btn-block btn-sm my-4" name="submit" value="Submit">
            </form>
        </div>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
      <div class="text-center">
          <span>Copyright - 2022</span>
      </div>
  </div>
</footer>



  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.3.1.slim.min.js"></script>

    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script>
        window.addEventListener('load', function () {

            document.querySelector('.navbar-toggler').innerHTML = '<i class="fas fa-arrow-down"></i>';
        })
    </script>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#mytable').DataTable();

    });
  </script>
  <script>
    $(document).ready(function() {
  $('.nav-link-collapse').on('click', function() {
    $('.nav-link-collapse').not(this).removeClass('nav-link-show');
    $(this).toggleClass('nav-link-show');
  });
});

  </script>
</body>
</html>

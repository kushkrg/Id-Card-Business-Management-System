<?php
include("auth_session.php");
include('../connections/config.php');
$found = false;
$school = $_SESSION['sname'];
$cnt = 0;
$class = "Please Select Class";
if(isset($_POST['submit'])){
      $class = $_POST['class'];
      $get_data = "SELECT * FROM student_data WHERE class = '$class' AND sname = '$school'";
      $run_data = mysqli_query($con,$get_data);

      if($run_data){
        $found = true;
        $cnt = mysqli_num_rows($run_data);
      }
      else{
        $found = false;
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
    <title>View data</title>
    <style>
      span{
        color: #007BFF;
      }
    </style>
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
        <h5><a class="nav-link" href="index.php">Add Student Data <span class="sr-only">(current)</span></a></h5>
      </li>
      <li class="nav-item">
       <div class="card" style="background-color: transparent; border: 1px solid #fff; padding: 0px">
         <div class="card-body">
            <h5 style="color: #fff">View Data</h5>
            <form method="POST" enctype="multipart/form-data">
              <select class="form-control my-2" name="class">
                      <option>Choose Class</option>
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
            <input type="submit" class="btn btn-primary btn-lg btn-block btn-sm my-4" value="Submit" name="submit">
        </form>
         </div>
       </div>
      </li>
    
    </ul>
    <div class="form-inline ml-auto mt-2 mt-md-0">
      
    <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0">Logout</a>
</div>
  </div>
</nav>

<main class="content-wrapper">
  <div class="container-fluid">
  <h2>Class - <span> <?= $class ?></span> | Total Students: <span><?= $cnt ?> <span></h2>
    <!-- main form  -->
      <table id='mytable' class='table table-hover table-sm'>
      <thead>
          <tr>
          <th scope='col'>#</th>
          <th scope='col'>Admission No.</th>
          <th scope='col'>Student Name</th>
          <th scope='col'>Roll No.</th>
          <th scope='col'>Mobile</th>
          <th scope='col'>Address</th>
          <th scope='col'>Photo</th>
          <th scope='col'>Action</th>
          </tr>
      </thead>
      <tbody>
    <?php
    if($found){
      $sl = 0;
      while($row = mysqli_fetch_array($run_data))
        	{
            $sl++;
            $id = $row['id'];
            $adm_no = $row['adm_no'];
            $name = $row['name'];
            $roll = $row['roll'];
            $mob = $row['mob'];
            $add = $row['address'];
            $img = $row['image'];    
            echo "
                <tr>
                    <th scope='row'> $sl</th>
                    <th scope='row'>$adm_no</th>
                    <td>$name</td>
                    <td>$roll</td>
                    <td>$mob</td>
                    <td>$add</td>
                    <td><img src='student_images/$img' width='60px'/></td>
                    <td>
                     
                      <a href='delete.php?id=$id' type='button' class='btn btn-danger'>
                       <i class='fa fa-trash'></i>
                      </a>
                    
                    </td>
                </tr>   "; 
          } 
        }  
   ?>
      </tbody>
       </table>
       <!-- table end  -->
  </div>
</main>


<!-- delete modal start  -->

<!-- delete modal end  -->


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
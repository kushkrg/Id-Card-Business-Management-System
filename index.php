<?php
include("auth_session.php");
include('connections/config.php');
$added = false;

$get_data = "SELECT * FROM schools";
$run_data = mysqli_query($con,$get_data);

// counting no. of schools 
$cnt = mysqli_num_rows($run_data);



if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mob = mysqli_real_escape_string($con, $_POST['mob']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = md5($password);
  	$insert_data = "INSERT INTO `schools`(`name`, `mob`, `email`, `password`, `address`) VALUES ('$name','$mob','$email','$password','$address')";

  	$run_data = mysqli_query($con, $insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}

?>
<!-- header start  -->
<?php include('includes/header.php'); ?>
<title>Manage Schools</title>
<style>
    span{
        color: blue;
        font-size: 30px;
    }
</style>
</head>
<!-- header end  -->

<body>
    <!-- navbar start  -->
    <?php include('includes/navbar.php'); ?>
    <!-- navbar End  -->

    <!-- main start  -->
    <section id="main">
        <div class="container-fluid">
              
            <div class="row">
                <!-- sidebar start  -->
                <?php include('includes/sidebar.php'); ?>
                <!-- sidebar end  -->
                  <!-- showing success message after adding the data  -->
                    
                <!-- breadcrumb  -->
                 <!-- MAIN CARDS-->
                 <div class="col-lg-10 py-2 bg-light my-3">
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
                    ?>
                    <!-- Add new school button -->
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>
                     Add New School
                    </button> <span>Total Schools: 0<?= $cnt ?></span>

                   <!-- table start  -->
                   <table id="mytable" class="table table-hover table-sm">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">School Name</th>
                        <th scope="col">Mobile No.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $get_data = "SELECT * FROM schools order by 1 desc";
                        $run_data = mysqli_query($con,$get_data);
                        $i = 0;
                        while($row = mysqli_fetch_array($run_data))
                        {
                            $sl = ++$i;
                            $id = $row['id'];
                            $name = $row['name'];
                            $mob = $row['mob'];
                            $email = $row['email'];
                            $address = $row['address'];
                       
                            echo "
                        <tr>
                            <th scope='row'>$id</th>
                            <td>$name</td>
                            <td>$mob</td>
                            <td>$email</td>
                            <td>$address</td>
                            <td>
                                <a class='btn btn-danger' href='delete.php?id=$id'><i class='fa fa-trash'></i></a>
                              
                            </td>
                        </tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                   <!-- table end  -->
                </div>
            </div>
    </section>

        <!-- add school modal  -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New School Form </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="School Name">
      </div>
      <div class="form-group">
        <input type="text" name="mob" class="form-control" id="formGroupExampleInput2" placeholder="Mobile No">
      </div>
      <div class="form-group">
        <input type="email" name="email" class="form-control" id="formGroupExampleInput2" placeholder="Email Id">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" id="formGroupExampleInput2" placeholder="Enter your Password">
      </div>
      <div class="form-group">
        <input type="text" name="address" class="form-control" id="formGroupExampleInput2" placeholder="Address">
      </div>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </form>
      </div>
      <div class="modal-footer">
        
        
      </div>
    </div>
  </div>
</div>

    <!-- main end  -->

<!-- Modal popup start  -->
<?php include('includes/modals.php'); ?>
<!-- Modal popup end  -->

<!-- Footer start  -->
<?php include('includes/footer.php'); ?>
<!-- Footer end  -->
<?php 
include("auth_session.php");
include('connections/config.php'); ?>
<!-- header start  -->
<?php include('includes/header.php'); ?>
<title>Dashboard</title>
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

                 <!-- MAIN CARDS-->
                 <div class="col-lg-10 py-5 bg-light my-3">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-info">Export /
                                <small class="text-muted">Export Data</small>
                            </h2>
                        </div>
                    </div>

                    <!-- export form  -->
                    <div class="card my-3" style="width: 18rem;">
                    <div class="card-header">
                        Please Select the Options 
                    </div>
                    <div class="card-body text-center">
                        <form action="export-file.php" method="post">
                        <select class="form-control" name="sname">
                             <option disabled selected>Please choose School</option>
                             <?php
                                $get_data = "SELECT * FROM schools order by 1 desc";
                                $run_data = mysqli_query($con,$get_data);
                                $i = 0;
                                while($row = mysqli_fetch_array($run_data))
                                {
                                    $name = $row['name'];                         
                                    echo "
                                         <option value='$name'>$name</option>
                                    ";
                                }?>
                        </select>
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
                         <input type="submit" class="btn btn-primary my-3" name="submit" value="Export in Excel" />
                        </form>
                    </div>
                    </div>

                </div>
            </div>
    </section>


    <!-- main end  -->

<!-- Modal popup start  -->
<?php include('includes/modals.php'); ?>
<!-- Modal popup end  -->

<!-- Footer start  -->
<?php include('includes/footer.php'); ?>
<!-- Footer end  -->
<?php
include("connections/config.php");

$output = '';
if(isset($_POST["submit"])){
    $sname = $_POST['sname'];
    $class = $_POST['class'];
    $qry = "SELECT * FROM student_data WHERE sname ='$sname' AND class ='$class'";
    $res = mysqli_query($con, $qry);
    if(mysqli_fetch_assoc($res)>0){
        $output .='
        <table border="1" id = "example">
        <thead>
             <th style="width: 200px;">Name</th>
             <th style="width: 200px;">Phone</th>
             <th style="width: 200px;">photo</th>
        </thead>
        <tbody>
        ';
        while($row = mysqli_fetch_array($res)){
            $name = $row['name'];
            $phone = $row['mob'];
            $dp = $row['image'];

            $output .= '
                <tr style="height: 110px">
                    <td> '.$name.'</td>
                    <td> '.$phone.'</td>
                    // <td><img style="width: 100px;" src="http://localhost/idcard/administrator/user/student_images/'.$dp.'"></td>
                </tr>
            ';
        }
        $output .= '</tbody></table>';
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename=UserData.xls');
        header('Content-Transfer-Encoding: BINARY');

        echo $output;
    }
    else{
        echo '<script type="text/javascript">alert("Record Not Found! Select Correct school name and class.");
                window.location.href="index.php";
        </script>';
    }
}
?>
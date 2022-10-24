<?php
include("connections/config.php");

$output = '';
if(isset($_POST["submit"])){
    $sname = $_POST['sname'];
    $class = $_POST['class'];
    
    $qry = "SELECT * FROM student_data WHERE sname ='$sname' AND class ='$class'";
    $res = mysqli_query($con, $qry);
    
    $html ='
        <table style="text-align: center" border="1" id = "example">
        <thead style="background-color: #000000; color: #fff;">
             <th style="width: 30px;">Unique ID</th>
             <th style="width: 250px;">School Name</th>
             <th style="width: 50px;">Admission No</th>
             <th style="width: 200px;">Students Name</th>
             <th style="width: 80px;">Birthday</th>
             <th style="width: 50px;">Class</th>
              <th style="width: 40px;">Section</th>
             <th style="width: 40px;">Roll No</th>
             <th style="width: 100px;">Father</th>
              <th style="width: 100px;">Mother</th>
             <th style="width: 80px;">Phone</th>
             <th style="width: 300px;">Address</th>
              <th style="width: 200px;">Transport</th>
             <th style="width: 180px;">Image</th>
        </thead>
        <tbody>
    ';
    while($row=mysqli_fetch_assoc($res)){
        $filename = $row['sname'].'__'.$row['class'];
        $html.='
            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['sname'].'</td>
                <td>'.$row['adm_no'].'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['dob'].'</td>
                <td>'.$row['class'].'</td>
                <td>'.$row['section'].'</td>
                <td>'.$row['roll'].'</td>
                <td>'.$row['father'].'</td>
                <td>'.$row['mother'].'</td>
                <td>'.$row['mob'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['transport'].'</td>
             
                <td style="height: 200px"><img style="width: 100px; height: 100px;" src="https://codingcush.com/idcard/user/student_images/'.$row['image'].'"></td>
            </tr>
        ';
    }
    $html.='</tbody></table>';
    
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=Students_Data.xls');
        header('Content-Transfer-Encoding: BINARY');
        echo $html;
}
    
?>
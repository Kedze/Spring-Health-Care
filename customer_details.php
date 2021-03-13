<?php
    $con = mysqli( 'localhost:3306', 'root', '', 'myspring_mydb');
    if (!$con) {
        #code...
        echo "Not connected to database".mysqli_error($con);
        
    }
?>

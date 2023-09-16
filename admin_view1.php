<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>FootnPass ADMS</title>
    <link rel="stylesheet" href="style2.css">
    <style>
    a:link, a:visited {
    background-color: #2691d9;
    border-radius: 25px;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    }

    a:hover, a:active {
    background-color: skyblue;
    }
    </style>
    </head>
    <body>
    <a href="index.php" >HOME</a>
    <a href="ADMIN_DASHBORD.php" >ADMIN DASHBORD</a> 
    
    <div class="container">
        <h1>VIEWS</h1>
        <h4 style="color:white;">CUSTOMER'S DETAILS OF BOOKING SLOTS</h4>
    </div>
    <div id="mainHolder" style="overflow: auto; max-height: 400px;">
    <?php
        $conn = oci_connect('ADMS', 'ADMS', '//localhost/XE'); 
        if (!$conn) {
          echo 'Failed to connect to oracle' . "<br>";
        }

        $stid = oci_parse($conn, 'SELECT * FROM customer_slot_booking');
        oci_execute($stid);
        echo "<table border='1'>
        <tr>
            <th>CUSTOMER_ID</th>
            <th>CUSTOMER_NAME</th>
            <th>CUSTOMER_EMAIL</th>
            <th>CUSTOMER_PHN</th>
            <th>BOOKING_ID</th>
            <th>SLOT_ID</th>         
        </tr>";

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
    echo "<tr>";
    echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
    echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
    echo "<td>" . $row['CUSTOMER_EMAIL'] . "</td>";
    echo "<td>" . $row['CUSTOMER_PHN'] . "</td>";
    echo "<td>" . $row['BOOKING_ID'] . "</td>";
    echo "<td>" . $row['SLOT_ID'] . "</td>";
    echo "</tr>";
    }
    echo "</table>\n";
    
    ?>
</div>

<div class="container">
<h4 style="color:white;"><br>SLOTS DETAILS OF CUSTOMER</h4>
</div>

<div id="mainHolder" style="overflow: auto; max-height: 400px;">
<?php
    $stid = oci_parse($conn, 'SELECT * FROM customer_slot_details');
    oci_execute($stid);
    echo "<table border='1'>
    <tr>
        <th>CUSTOMER_ID</th>
        <th>CUSTOMER_NAME</th>
        <th>SLOT_ID</th>
        <th>STARTTIME</th>
        <th>TICKET_ID</th>
        <th>TOTAL_TICKET</th>    
        <th>TOTAL_SLOT_COST</th>   
    </tr>";
    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
        echo "<tr>";
        echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
        echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
        echo "<td>" . $row['SLOT_ID'] . "</td>";
        echo "<td>" . $row['STARTTIME'] . "</td>";
        echo "<td>" . $row['TICKET_ID'] . "</td>";
        echo "<td>" . $row['TOTAL_TICKET'] . "</td>";
        echo "<td>" . $row['TOTAL_SLOT_COST'] . "</td>";  
        echo "</tr>";
        }
        echo "</table>\n";   
?>
</div>

<?php 
    oci_free_statement($stid);
    oci_close($conn);
?>
</body>
</html>
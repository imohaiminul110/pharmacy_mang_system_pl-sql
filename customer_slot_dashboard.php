<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">

    <title>FoornPass ADMS</title>
    <link rel="stylesheet" href="style2.css">
    </head>
    <body>
    <div class="container">
        <h1>CUSTOMER SLOT DASHBOARD</h1>
    </div>
    <div id="mainHolder" style="overflow: auto; max-height: 500px;">
    <?php
        $conn = oci_connect('ADMS', 'ADMS', '//localhost/XE');   
        if (!$conn) {
          echo 'Failed to connect to oracle' . "<br>";
        }

        $stid = oci_parse($conn, 'SELECT * FROM slot');
        oci_execute($stid);
        echo "<table border='1'>
        <tr>
            <th>SLOT_ID</th>
            <th>STARTTIME</th>
            <th>ENDTIME</th>
            <th>SLOT_COST</th>
            
        </tr>";

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
    echo "<tr>";
    echo "<td>" . $row['SLOT_ID'] . "</td>";
    echo "<td>" . $row['STARTTIME'] . "</td>";
    echo "<td>" . $row['ENDTIME'] . "</td>";
    echo "<td>" . $row['SLOT_COST'] . "</td>";
    echo "</tr>";
    }
    echo "</table>\n";
    ?>
</div>

<div class="center">    
  <form method="post">

      <div class="txt_field">
        <input type="date" name="starttime" required>
        <label>Start Time</label>
      </div>

      <div class="txt_field">
      <input type="date" name="endtime" required>
        <label>End Time</label>
      </div>

      <div class="txt_field">
        <input type="number" name="cost" required>
        <label>Slot Cost </label>
      </div>

      <div class="txt_field">
        <input type="number" name="mgr_id" required>
        <label>Assigned Manager ID </label>
      </div>

      <input type="submit" value="ADD SLOT" name="submit">
    </form>
</div>      

<?php
    if (isset($_POST['submit'])) {
      $starttime = $_POST["starttime"];
      $endtime = $_POST["endtime"];
      $cost = $_POST["cost"];    
      $mgr_id = $_POST["mgr_id"];
      
      $query="INSERT INTO SLOT VALUES (seq_slot_id.NEXTVAL, '$starttime','$endtime', '$cost','$mgr_id')";
      $stid = oci_parse($conn, $query);
      
      if (!$stid) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      $r = oci_execute($stid );
      if (!$r) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      else{
        echo '<script>alert("Booking status pending. Waiting for payment")</script>';
      } 
    }      
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>
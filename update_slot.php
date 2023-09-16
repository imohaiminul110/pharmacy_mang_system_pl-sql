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
    <a href="ADMIN_DASHBORD.php" >ADMIN DASHBOARD</a>
    <div class="container">
        <h1>SLOT DASHBOARD FOR UPDATE</h1>
    </div>
    <div id="mainHolder" style="overflow: auto; max-height: 450px;">
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
			<th>MGR_ID</th>
			
            
        </tr>";

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
    echo "<tr>";
    echo "<td>" . $row['SLOT_ID'] . "</td>";
    echo "<td>" . $row['STARTTIME'] . "</td>";
    echo "<td>" . $row['ENDTIME'] . "</td>";
    echo "<td>" . $row['SLOT_COST'] . "</td>";
	echo "<td>" . $row['MGR_ID'] . "</td>";
	
    echo "</tr>";
    }
    echo "</table>\n";
    ?>
</div>

        <div class="center">    
            <form method="post">

          

            <div class="txt_field">
                <input type="string" name="starttime" required>
                <label>Start Time</label>
            </div>

            <div class="txt_field">
            <input type="string" name="endtime" required>
                <label>End Time</label>
            </div>

            <div class="txt_field">
                <input type="number" name="cost" required>
                <label>Slot Cost </label>
            </div>


            <div class="txt_field">
                <input type="number" name="s_id" required>
                <label>Slot ID </label>
            </div>
			
			 <div class="txt_field">
                <input type="number" name="mgr_id" required>
                <label>MGR ID </label>
            </div>

            <input type="submit" value="UPDATE SLOT" name="submit">
            </form>
        </div> 
  </div>
 

     

<?php
    if (isset($_POST['submit'])) {
      $starttime=$_POST["starttime"];
      $endtime = $_POST["endtime"];
      $cost = $_POST["cost"];    
      $s_id=$_POST["s_id"];
	  $mgr_id=$_POST["mgr_id"];
	  
      
      $query="UPDATE SLOT SET  STARTTIME='$starttime', 
	                           ENDTIME='$endtime',                           
                               SLOT_COST='$cost',
							   MGR_ID='$mgr_id'
                               WHERE SLOT_ID=$s_id";
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
        echo '<script>alert("Slot UPDATED successfully")</script>';
        header("refresh: 0; url=update_slot.php");
      } 
    }    
      
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>
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
        <h1>SLOT DASHBOARD FOR DELETION</h1>
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
                <input type="number" name="s_id" required>
                <label>SLOT ID </label>
            </div>
            <input type="submit" value="DELETE SLOT" name="submit">
            </form>
        </div> 
</div>	
	
	
	
	

<?php
    if (isset($_POST['submit'])){
      $f_id=$_POST["s_id"];

      $sql="begin
      delete_slot(:s_id);
      end;";
      $stid = oci_parse($conn, $sql);
      oci_bind_by_name($stid,':s_id',$s_id,50);

      if (!$stid) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      $r = oci_execute($stid );
      if ($r) {
        oci_commit($conn);
        echo '<script>alert("Slot deleted successfully")</script>';
        header("refresh: 0; url=delete_slot.php"); 
      }
      else {
        echo '<script>alert("Slot deletion unsuccessfull")</script>';
        
      } 
    }
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
        
</body>
</html>
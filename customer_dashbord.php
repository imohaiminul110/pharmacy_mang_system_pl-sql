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
<a href="index.php">HOME</a>
 
<div class="container">
  <h1>SLOT DETAILS</h1>
</div>
<div id="mainHolder" style="overflow: auto; max-height: 600px;">
<?php
  $conn = oci_connect('ADMS', 'ADMS', '//localhost/XE');      
  if (!$conn) {
    echo 'Failed to connect to oracle' . "<br>";
  }

  $stid = oci_parse($conn, 'SELECT * FROM SLOT ');
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
<!--another -->
<div class="center">    
  <form method="post">
    <div class="txt_field">
      <input type="text" name="slot_id" required>
      <label>Slot Id</label>
    </div>

    <div class="txt_field">
      <input type="text" name="user_id" required>
        <label>User Id</label>
      </div>

      <div class="txt_field">
        <input type="text" name="no_ticket" required>
        <label>Number of tickets </label>
      </div>

      <input type="submit" value="BOOK SLOT" name="submit">
    </form>
</div>      

<?php
    if (isset($_POST['submit'])) {
      $slot_id=$_POST["slot_id"];
      $user_id = $_POST["user_id"];
      $no_ticket = $_POST["no_ticket"];
      
      $query="insert into TICKET values (seq_ticket_id.NEXTVAL, '$no_ticket', 'pending','$user_id')";
      $stid = oci_parse($conn, $query);
    
      $query1="insert into BOOKING values (seq_booking_id.NEXTVAL,'$user_id','$slot_id')";
      $stid1 = oci_parse($conn, $query1);
    
      if (!$stid or !$stid1) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      
      $r = oci_execute($stid );
      $r1 =oci_execute($stid1);
      if (!$r or !$r1) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        $m1 = oci_error($stid1);
        trigger_error('Could not execute statement: '. $m1['message'], E_USER_ERROR);
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
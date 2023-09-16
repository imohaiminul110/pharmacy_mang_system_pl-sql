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
        <h1>SEARCHING QUERIES</h1>
    </div>
    
</div>
    <div class="row">
        <div class="column">
            <!--one-->
            <h2 style="color:white;">Slot With Minimum Cost</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    $conn = oci_connect('ADMS', 'ADMS', '//localhost/XE');  
                    if (!$conn) {
                    echo 'Failed to connect to oracle' . "<br>";
                    }

                    $stid = oci_parse($conn, 'select * from slot where slot_cost=(select min(slot_cost) from slot)');
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
        </div>    
        <div class="column">

        <h2 style="color:white;">Manager Who Approved Maximum Slots</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, 'select mgr_id,mgr_name from manager where mgr_id in (select m.mgr_id from manager m, slot s where m.mgr_id=s.mgr_id group by m.mgr_id having count(m.mgr_id) in (select max(count(m.mgr_id)) from manager m, slot s where m.mgr_id=s.mgr_id group by m.mgr_id))');
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>MANAGER_ID</th>
                        <th>MANAGER_NAME</th>
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['MGR_ID'] . "</td>";
                echo "<td>" . $row['MGR_NAME'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
        <div class="column">
            <h2 style="color:white;">Customer With Maximum Booked Slot</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, "select * from customer where customer_id in (select c.customer_id from customer c, slot s, booking b where c.customer_id=b.customer_id and b.slot_id=s.slot_id group by c.customer_id having count(c.customer_id) in (select max(count(c.customer_id)) from customer c, slot s, booking b where c.customer_id=b.customer_id and b.slot_id=s.slot_id group by c.customer_id))");
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>CUSTOMER_ID</th>
                        <th>CUSTOMER_NAME</th>
                        <th>CUSTOMER_EMAIL</th>
                        <th>CUSTOMER_PHN</th>                        
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
                echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
                echo "<td>" . $row['CUSTOMER_EMAIL'] . "</td>";
                echo "<td>" . $row['CUSTOMER_PHN'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <!--two-->
            <h2 style="color:white;">SLOT-WISE TOTAL BOOKED TICKETS</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    $stid = oci_parse($conn, 'select s.slot_id, sum(t.total_ticket) as booked_tickets from slot s, ticket t, order_ticket ot where t.ticket_id=ot.ticket_id and ot.slot_id=s.slot_id group by s.slot_id');
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>SLOT_ID</th>
                        <th>TOTAL BOOKED TICKETS</th>
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['SLOT_ID'] . "</td>";
                echo "<td>" . $row['BOOKED_TICKETS'] . "</td>";
                
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>    
        
		
		
		....
		
		
		
		
		 <div class="column">
        <h2 style="color:white;">Customers Who Approved BY MGR 1</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, "select c.customer_name, s.slot_cost, t.total_ticket from CUSTOMER c, SLOT s, Ticket t, 
ORDER_TICKET ot, BOOKING b where c.customer_id=b.customer_id and b.slot_id=s.slot_id 
and t.ticket_id=ot.ticket_id and ot.slot_id=s.slot_id and s.mgr_id=1");
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>CUSTOMER_NAME</th>
						<th>SLOT_COST</th>
                        <th>TOTAL_TICKET</th>
                        
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
                echo "<td>" . $row['SLOT_COST'] . "</td>";
				echo "<td>" . $row['TOTAL_TICKET'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
		
    </div>



     

<?php  
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>
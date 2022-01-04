<?php 

// Code to fetch charging history from database

// Include the file that has charging database credentials
include_once 'db_charging.php';

// Define a URL path back to homepage
$goback = '../index.php';
 
// SQL query to fetch data from charging database, ordered by charge date 
$sql = "SELECT * FROM ev_charging ORDER BY charge_date";

// Make the SQL query to database 
$query = mysqli_query($conn,$sql);

// Create table structure that will display data from database 
if(!$query)
{
    echo "Query does not work.".mysqli_error($conn);die;
}

echo "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
}
body {
    font-family: Verdana, Arial, Helvetica, monospace;
}
</style>
<br><h2> Charging History</h2><br>
<table border='1'>
<tr>
<th>Charge Date</th>
<th>Start Percent</th>
<th>End Percent</th>
<th>Charge Type</th>
<th>Charge Time</th>
<th>Units</th>
<th>Cost</th>
</tr>";

// Run loop for as many rows as there is data from database
while($data = mysqli_fetch_array($query))
{
    echo "<tr>";
    echo "<td>" . $data['charge_date'] . "</td>";
    echo "<td>" . $data['start_percent'] . "</td>";
    echo "<td>" . $data['end_percent'] . "</td>";
    echo "<td>" . $data['charge_type'] . "</td>";
    echo "<td>" . $data['charge_time'] . "</td>";
    echo "<td>" . $data['units'] . "</td>";
    echo "<td>" . $data['cost'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Link to go back to homepage
echo "<br><a href='".$goback."'><h2>Go Back</h2></a>";

// Close SQL connection
mysqli_close($con);
?>
<?php 

// Code to fetch usage data from database

// include the file that has usage database credentials
include_once 'db_usage.php';

// Define path back to homepage
$goback = '../index.php';
 
// SQL query to read all usage data sorted by start date
$sql = "SELECT * FROM ev_usage ORDER BY start_date";
 
// Make the SQL query to database 
$query = mysqli_query($conn,$sql);

// Prepare table structure to display data fetched from DB 
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
<br><h2> Ride History</h2><br>
<table border='1'>
<tr>
<th>Start Date</th>
<th>End Date</th>
<th>Start Percent</th>
<th>End Percent</th>
<th>Start KM</th>
<th>End KM</th>
<th>KM Run</th>
<th>Effective Range</th>
<th>Charged At</th>
<th>Cost/unit</th>
<th>Cost/KM</th>
</tr>";

// Loop for as many rows as there is data in the response from database
while($data = mysqli_fetch_array($query))
{
    echo "<tr>";
echo "<td>" . $data['start_date'] . "</td>";
echo "<td>" . $data['end_date'] . "</td>";
echo "<td>" . $data['start_percent'] . "</td>";
echo "<td>" . $data['end_percent'] . "</td>";
echo "<td>" . $data['start_km'] . "</td>";
echo "<td>" . $data['end_km'] . "</td>";
echo "<td>" . $data['km_run'] . "</td>";
echo "<td>" . $data['km_range'] . "</td>";
echo "<td>" . $data['charged_at'] . "</td>";
echo "<td>" . $data['unit_cost'] . "</td>";
echo "<td>" . $data['cost_per_km'] . "</td>";
echo "</tr>";
}

echo "</table>";

// Link back to homepage
echo "<br><a href='".$goback."'><h2>Go Back</h2></a>";

// Close SQL connection
mysqli_close($con);
?>
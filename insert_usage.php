<?php

// Code for inserting USAGE details into database

// Include the file that has db connection details for usage database
include_once 'db_usage.php';

// define a href url to go back to main page
$goback = '../index.php';

// define all variables to be empty initially
$start_date = $end_date = $start_percent = $end_percent = $start_km = $end_km = $km_run = $km_range = $charged_at = $unit_cost = $cost_per_km = $percent_used = $cost_per_percent = "";

// if data has been submitted using POST method from an input field with name "submit"
if(isset($_POST['submit']))
{    
    // input data sanitization - running each item thru function below and saving output in variables
     $start_date = test_input($_POST['start_date']);
     $end_date = test_input($_POST['end_date']);
     $start_percent = test_input($_POST['start_percent']);
     $end_percent = test_input($_POST['end_percent']);
     $start_km = test_input($_POST['start_km']);
     $end_km = test_input($_POST['end_km']);
     $charged_at = test_input($_POST['charged_at']);
     $unit_cost = test_input($_POST['unit_cost']);

     // Calculate some fields based on input values

     // 1) calculate KM run as end_m minus start_km
     $km_run = $end_km - $start_km;

     // 2) calculate effective range as distance covered / battery used * 100
     $percent_used = $start_percent - $end_percent;
     $km_range = ($km_run/$percent_used) * 100;

     // 3) calculate cost per km
     // cost for 1% is unit cost * 30 units battery capacity / 100
     $cost_per_percent = $unit_cost * 30 / 100;
     // cost per km is total cost for X percent / km run
     $cost_per_km = ($cost_per_percent * $percent_used) / $km_run;

     // insert into SQL database named ev_charging values in variables ($xxx) corresponding to these column names
     $sql = "INSERT INTO ev_usage (start_date,end_date,start_percent,end_percent,start_km,end_km,km_run,km_range,charged_at,unit_cost,cost_per_km)
     VALUES ('$start_date','$end_date','$start_percent','$end_percent','$start_km','$end_km','$km_run','$km_range','$charged_at','$unit_cost','$cost_per_km')";
     
     // if insert is successful or failed, display appropriate message and link to go back to homepage
     if (mysqli_query($conn, $sql)) {
        echo "<center><h1>New usage record has been added successfully!</h1></center><br>";
        echo "<center><h2>Effective range: ".$km_range."</h2></center><br>";
        echo "<center><h2>Cost per km: ".$cost_per_km."</h2></center><br>";
        echo "<br><a href='".$goback."'><h2>Go Back</h2></a>";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
        echo "<br><a href='".$goback."'><h2>Go Back</h2></a>";
     }

     // close SQL connection
     mysqli_close($conn);
}

// function to sanitize input - remove blank spaces, remove backslashes, make special chars HTML to prevent XSS
// Refer: https://www.w3schools.com/php/php_form_validation.asp
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
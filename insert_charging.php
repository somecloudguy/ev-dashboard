<?php

// Code for inserting charging details to database

// Include the file that has db connection details for charging database
include_once 'db_charging.php';

// define a href url to go back to main page
$goback = '../index.php';

// define all variables to be empty initially
$charge_date = $start_percent = $end_percent = $charge_type = $charge_time = $units = $cost = $cost_per_unit = "";

// if data has been submitted using POST method from an input field with name "submit"
if(isset($_POST['submit']))
{    
    // input data sanitization - running each item thru function below and saving output in variables
     $charge_date = test_input($_POST['charge_date']);
     $start_percent = test_input($_POST['start_percent']);
     $end_percent = test_input($_POST['end_percent']);
     $charge_type = test_input($_POST['charge_type']);
     $charge_time = test_input($_POST['charge_time']);
     $units = test_input($_POST['units']);
     $cost_per_unit = test_input($_POST['cost_per_unit']);

     // Calculate total cost based on cost per unit and units consumed
     $cost = $units * $cost_per_unit;

     // insert into SQL database named ev_charging values in variables ($xxx) corresponding to these column names
     $sql = "INSERT INTO ev_charging (charge_date,start_percent,end_percent,charge_type,charge_time,units,cost)
     VALUES ('$charge_date','$start_percent','$end_percent','$charge_type','$charge_time','$units','$cost')";
     
     // if insert is successful or failed, display appropriate message and link to go back to homepage
     if (mysqli_query($conn, $sql)) {
        echo "<center><h1>New charging record has been added successfully!<h1></center><br>";
        echo "<center><h2>Total charging cost: ".$cost."</h2></center><br>";
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
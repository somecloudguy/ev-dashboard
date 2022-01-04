<!-- Homepage to enter details and fetch historical data -->

<!DOCTYPE html>
<html lang="en">    
    <head>    
        <title>EV Charging and Usage</title>    
    </head>    
    <body> 
        <!-- CSS details are in style.css file -->
        <link href = "style.css" type = "text/css" rel = "stylesheet" />    
        <h2>Enter Charging details</h2>
        
        <!-- PART 1: CHARGING INFO SECTION -->

        <!-- Details to load form data into RDS is in insert_charging.php file -->    
        <form action="insert_charging.php" method = "post">    
            <div class = "container">    
                <div class = "form_group">    
                    <label>Charge date (YYYY-MM-DD):</label>    
                    <!-- input type date gives calendar to pick from -->
                    <input type="date" name="charge_date" value="" required/>    
                </div>    
                <div class = "form_group">    
                    <label>Start Percent:</label>
                    <!-- input type number gives number picker with arrows -->    
                    <input type="number" min="0" max="100" name="start_percent" value="" required />    
                </div>    
                <div class = "form_group">    
                    <label>End Percent:</label>    
                    <input type="number" min="0" max="100" name="end_percent" value="" required/>    
                </div>    
                <!-- Radio button for charge type -->
                <div class = "form_group">    
                    <label>Charge type:</label>    
                    <input type="radio" name="charge_type" value="Slow">Slow
                    <input type="radio" name="charge_type" value="Fast">Fast    
                </div>    
                 <div class = "form_group">    
                    <label>Charge time (HH:MM:SS):</label>    
                    <input type="text" name="charge_time" value="" required/>    
                </div>  
                <div class = "form_group">    
                    <label>Units (kWh):</label>
                      <input type="number" min="0" max="100" name="units" value="" required/>    
                </div>        
                <div class = "form_group">    
                    <label>Cost per kWh:</label>    
                    <input type="text" name="cost_per_unit" value="" required/>    
                </div>
            </div>    
            <div class = "button">
                <input type="submit" name="submit" value="Submit Charging Details">
            </div> 
        </form>

        <!-- Details to fetch charging data from DB is in select_charging.php file -->
        <h3>View Charging History</h3> 
        <form action="select_charging.php" method = "get">
            <div class = "button">
                <input type="submit" name="fetch" value="Fetch Charging History">
            </div>
        </form>

        <!-- PART 2: USAGE INFO SECTION -->
        <br>
        <h2>Enter Usage details</h2>
        <!-- Details to load form data into RDS is in insert_usage.php file -->    
        <form action="insert_usage.php" method = "post">    
            <div class = "container">    
                <div class = "form_group">    
                    <label>Start date (YYYY-MM-DD):</label>    
                    <!-- input type date gives calendar to pick from -->
                    <input type="date" name="start_date" value="" required/>    
                </div>    
                <div class = "form_group">    
                    <label>End date (YYYY-MM-DD):</label>    
                    <!-- input type date gives calendar to pick from -->
                    <input type="date" name="end_date" value="" required/>    
                </div>                
                <div class = "form_group">    
                    <label>Start Percent:</label>
                    <!-- input type number gives number picker with arrows -->    
                    <input type="number" min="0" max="100" name="start_percent" value="" required />    
                </div>    
                <div class = "form_group">    
                    <label>End Percent:</label>    
                    <input type="number" min="0" max="100" name="end_percent" value="" required/>    
                </div> 
                <div class = "form_group">    
                    <label>Start KM:</label>    
                    <input type="number" min="0" max="100000" name="start_km" value="" required/>    
                </div> 
                <div class = "form_group">    
                    <label>End KM:</label>    
                    <input type="number" min="0" max="100000" name="end_km" value="" required/>    
                </div>                    
                <div class = "form_group">    
                    <label>Charged at:</label>    
                    <input type="text" name="charged_at" value="" required/>    
                </div>  
                <div class = "form_group">    
                    <label>Unit Cost:</label>
                     <input type="text" name="unit_cost" value="" required/>    
                </div>        
            </div>    
            <div class = "button">
                <input type="submit" name="submit" value="Submit Usage Details">
            </div> 
        </form>

        <!-- Details to fetch data from DB is in select.php file -->
        <h3>View Usage History</h3> 
        <form action="select_usage.php" method = "get">
            <div class = "button">
                <input type="submit" name="fetch" value="Fetch Usage History">
            </div>
        </form>

        <!-- Quicksight dashboard -->
        <a href="<INSERT_QUICKSIGHT_URL_HERE>" target="_blank"><center><h5>View Usage Dashboard (Requires Admin login)</h5></center></a>

    </body>    
</html>    
# The EV Dashboard Project

When I purchased an electric vehicle (EV), I decided to maintain a detailed log of every charging and every usage of the car. This was initially done in an Excel sheet but to make it scalable, highly-available, and easy to view from anywhere, I have created this dashboard that can be deployed on AWS and made available either as a public link or restricted only to specific viewers.

<img src="https://github.com/somecloudguy/ev-dashboard/blob/main/screenshots/ss2.jpeg" width="200">   <img src="https://github.com/somecloudguy/ev-dashboard/blob/main/screenshots/ss4.jpeg" width="200">   <img src="https://github.com/somecloudguy/ev-dashboard/blob/main/screenshots/ss1.jpeg" width="200">   <img src="https://github.com/somecloudguy/ev-dashboard/blob/main/screenshots/ss3.jpeg" width="200">

## The Architecture

* Frontend is a single page PHP website hosted on an Amazon EC2 instance.
* Database is an Amazon Aurora RDS MySQL cluster. 
* Historic data from Excel sheets is uploaded to Amazon S3 as CSV files and loaded into the database using Aurora's 'Load from S3' capability.
* New data is written directly into MySQL database from the web frontend.
* Website is delivered using Amazon CloudFront with AWS WAF Managed rules applied on it.
* Amazon Quicksight is connected to use Aurora as dataset to pull in data for making dashboard graphs.

## The Files

* index.php is the frontend website
* style.css is the CSS for the website
* db_charging.php contains the database credentials for charging data table
* db_usage.php contains the database credentials for usage data table
* insert_charging.php contains the code to insert charging data into database
* insert_usage.php contains the code to insert usage data into database
* select_charging.php contains the code to fetch charging data from database
* select_usage.php contains the code to fetch usage data from database
* ev_charging.csv and ev_usage.csv contain sample data in the format used for the database tables defined in this project

## Implementation Steps
1. Download all files from this Github repository to your local machine
2. Create an Aurora cluster, note the database username, password, and endpoint URL 
3. Follow instructions from SQL queries section below to set up initial database tables. You can use MySQL Workbench to connect to the Aurora database from your local machine
4. Update db_charging.php and db_usage.php files you just downloaded with the database credentials
5. Create an EC2 instance, install Apache web server on it, and upload all downloaded files to /var/www/html directory
7. Create a Cloudfront distribution and enter the public DNS of the EC2 instance as the Origin, forward requests over HTTP only
8. Update security groups to establish connectivity between Cloudfront, EC2, RDS and QuickSight
  a. EC2 security group should allow inbound access on port 80 from Cloudfront managed IP prefix only, and port 22 from your personal IP
  b. Aurora security group should allow inbound access on port 3306 from your personal IP, from EC2's security group, and from QuickSight's CIDR for the AWS region you are using. You can find QuickSight CIDR from AWS documentation
9. Create a new Quicksight dataset from Aurora as the data source, and create a new analysis using this dataset

## Tips and Troubleshooting

* Search for AWS documentation for each step of the build and follow the instructions from them without skipping steps
* Use a standard Aurora cluster, not Aurora Serverless if you plan to load historical data from S3
* Use a unique ID as primary key, not any component from actual charging and usage data. Add this ID while creating database table
* Aurora needs an IAM role with a policy to access S3 to be able to load from S3
* Remember to use a custom parameter group for Aurora cluster and update the parameters with S3 ARN as per AWS docs
* If using MySQL Workbench from local machine to run SQL queries on Aurora, remember to update Security Group to allow port 3306 from local IP
* Allow POST method on Cloudfront and disable standard caching rules for the database queries to work correctly
* Quicksight dashboard is not public. Only people with a Quicksight account can view them
* If Quicksight is unable to refresh data, make sure your Aurora cluster has Quicksight CIDR added to its security group
* If website is unable to insert data into database, check security group and table schema. It should match exactly the order and names written in insert_usage.php and insert_charging.php files
* To check if DB is updating with latest data, login to DB using MySQL Workbench on local machine and check tables
* If Cloudfront returns 500 error, most likely it is because it auto-selected “HTTPS only” for connection to EC2. Change it to “HTTP only”

## Sample SQL queries to set up the database initially

* Create database
```
CREATE DATABASE evcharging;

CREATE DATABASE evusage;
```
* Create table for charging data
```
CREATE TABLE ev_charging(
  charge_id INT NOT NULL AUTO_INCREMENT,
  charge_date DATE,
  start_percent TINYINT,
  end_percent TINYINT,
  charge_type VARCHAR(4) NOT NULL,
  charge_time TIME,
  units TINYINT,
  cost FLOAT(6,2),
  PRIMARY KEY (charge_id)
  );
```  
* Create table for usage data  
```
CREATE TABLE ev_usage(
  ride_id INT NOT NULL AUTO_INCREMENT,
  start_date DATE,
  end_date DATE,
  start_percent TINYINT,
  end_percent TINYINT,
  start_km INT(8),
  end_km INT(8),
  km_run SMALLINT(3),
  km_range SMALLINT(3),
  charged_at VARCHAR(24),
  unit_cost FLOAT(4,2),
  cost_per_km FLOAT(4,2),
  PRIMARY KEY (ride_id)
  );
```
* Load data from S3
```
LOAD DATA FROM S3 's3://S3_BUCKET_NAME/FILENAME.csv'
INTO TABLE ev_usage
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(ride_id, start_date, end_date, start_percent, end_percent, start_km, end_km, km_run, km_range, charged_at, unit_cost, cost_per_km);
```
* Read data from database
```
SELECT * FROM ev_charging
ORDER BY charge_id;
```
* Delete a row from database table
```
DELETE FROM ev_charging WHERE charge_id='99';
```

## Disclaimer: 
_This is a weekend hobby project that I created for myself. It is NOT production-quality, please do not use as-is and then blame me for any errors, bugs, performance issues, costs that you run into._ 



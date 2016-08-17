# Pinterest Pinner

This script automates pins to pinterest. It is a wrapper around: https://github.com/dzafel/pinterest-pinner

Items are stored in a CSV file. (config/input.csv). It attempts to pin each item while creating a connection trough the script from dzavel. 

A new (login) connection is created per item. There is a certain limit of connections. All successful attemts are logged (log/status.log). If the script has failed, run it again later. I estimate that the limit is about 30 connections per hour.

## Installation:
Copy this script to a public apache server. 
Setup a /config/config.php file. 
Prepare the "/scripts/deploy.sh" file or use for reference.
Make sure the /log/status.php has correct permissions.

## Usage:
A default "input.csv" and "public/images" are provided.
Create a "dynamic_content" folder to add your content.
Update "dynamic_content/input.csv".
Add images in "dynamic_content/images/*.png"
Run: "/scripts/deploy_dynamic_content.sh" to publish the latest info.
Then run /public/index.php. 







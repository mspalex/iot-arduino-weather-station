# IoT-arduino-weather-station

This application connects an Arduino that reads data from sensors* (temperature and humidity in this case) to a PHP application that stores the information on a Database and displays it with a Javascript library specific for Data Visualization.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisities

- Arduino with ehternet shield or other network interface
- Apache Web Server
- MySQL Database Server

The web application can run within a local area network, with the help of XAMP application stack (on linux) or WAMP (on windows), but the server needs to be configured to accept local IP's. Or, like i did, on a server located outside your home network.

To know how to wire the arduino with the sensor, please refer to the guide i have hosted on instructables [www.instructables.com/id/PART-1-Send-Arduino-data-to-the-Web-PHP-MySQL-D3js]

[www.instructables.com/id/PART-1-Send-Arduino-data-to-the-Web-PHP-MySQL-D3js]:http://www.instructables.com/id/PART-1-Send-Arduino-data-to-the-Web-PHP-MySQL-D3js/

#### Database preparation

First, create a database named anything you like and then run the following sql script:

```sql
	CREATE TABLE tempLog (
			timeStamp TIMESTAMP NOT NULL PRIMARY KEY,
			temperature int(11) NOT NULL,
			humidity int(11) NOT NULL
	);
```
Then create an SQL user with password and attribute previleges for the newly created database. 

You will need to replace the credentials in the file ***includes/connect.php*** with the new ones.
```php
	function Connection(){

		$server="server";
		$user="user";
		$pass="pass";
		$db="XXX";
		
		...
	}
```

#### PHP Web Application

Next, copy the php app files to a server location, taking into account the following:

- Put the PHP code within the root of the server, and it will be accessible through:
	- **www.yourwebsite.domain**


- Or, you can create a subdomain and put the PHP inside the subdomain code folder, and it will be accessible through:
	- **www.yoursubdomain.yourwebsite.domain**


- Or, you can create a folder and put the PHP code inside it, and it will be accessible through:
	- **www.yourwebsite.domain/foldername**




#### Arduino Web Client

To configure the server ther arduino connects to, in the file **Arduino_client.ino**, lines 42 and 44 will take the address of your own server. This address can either be a normal webdomain or an IP Address.

```C
	void loop(){
	
		...

		if (client.connect("www.*****.*************.com",80)) { // REPLACE WITH YOUR SERVER ADDRESS
			... 
			client.println("Host: *****.*************.com"); // SERVER ADDRESS HERE TOO
			... 
		} 

		...
	}
```

Next, you can upload the code to your Arduino and connect it to the network. This Arduino code is designed to use Dynamic IP Addresses, so that it can be used on normal home networks without IPS conflicts.

#### Data Visualization with D3.js

This javascript library integration will render the information like in the following image.

![D3_data_viz_double_axis](https://cloud.githubusercontent.com/assets/4175297/18608876/ee4fdffe-7cec-11e6-9d6e-60c883305128.png)


### Updates to this application

First release is the code shared on Instructables, with the fully functional Arduino Client and a basic PHP Web App. The app only shows a table with the raw sql data.

The second release is the full Application using the D3.js Javascript framework to show an awesome Data Visualization of the information gathered.



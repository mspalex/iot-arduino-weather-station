# iot-arduino-weather-station

Arduino Web client reading data from sensors (temperature and humidity) and sending to a PHP Web app to store and display the information

### Full Guide on instructables [here]

[here]:http://www.instructables.com/id/PART-1-Send-Arduino-data-to-the-Web-PHP-MySQL-D3js/



## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisities

- Apache Web Server to run the PHP code
- MySQL Database Server

You can either run this application within your local network, with an application stack like XAMPP (on linux) or WAMP (on windows) with your computer, or on a webserver located outside your home network (the internet!)

#### Database preparation

Create a database named anything you like and then run the following sql script:

```sql
	CREATE TABLE tempLog (
			timeStamp TIMESTAMP NOT NULL PRIMARY KEY,
			temperature int(11) NOT NULL,
			humidity int(11) NOT NULL
	);
```

#### PHP Web Application

Next, you can either :

- Put the PHP code within the root of the server, and it will be accessible through:
	- **www.yourwebsite.domain**


- Or, you can create a subdomain and put the PHP inside the subdomain code folder, and it will be accessible through:
	- **www.yoursubdomain.yourwebsite.domain**


- Or, you can create a folder and put the PHP code inside it, and it will be accessible through:
	- **www.yourwebsite.domain/foldername**


After the PHP code is in place, create an SQL user with password and attribute previleges for the newly created database. You need to replace the credentials within ***includes/connect.php*** with your own.

```php
	function Connection(){

		$server="server";
		$user="user";
		$pass="pass";
		$db="XXX";
		
		...
	}
```

#### Arduino Web Client

If you consult the **Arduino_client** code, on lines 42 and 44 you can see the comments telling you to change the addresses with asterisks to the location of your own server. This address can either be a normal webdomain or an IP Address.

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

Next, you can upload the code to your Arduino and connect it to the network. This Arduino code is designed to use Dynamic IP Addresses, so that it can be used on normal home networks without incompatibilities.

### Updates to this application

First release is the code shared on Instructables, with the fully functional Arduino Client and a basic PHP Web App. The app only shows a table with the raw sql data.

The second release is the full Application using the D3.js Javascript framework to show an awesome Data Visualization of the information gathered.

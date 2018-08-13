Title: PHP API Development Assignment Author: Mohana Srinivasan U Date: 12-Aug-2018

Requires:

PHP 5.6.35
Apache 2.4.33
PHP Curl Extension enabled
Apache mod_rewrite enabled
Description: This is an API in PHP that calls a "backend API" to get information about crash test ratings for vehicles.

Please clone repo into your local enviroment, and keep "vehicles" folder in your root directory path(http://localhost:8080). And execute the below mentioned Requirement via any API Builder[Ex: Chrome-Postman,..etc]

Requirement 1: [GET http://localhost:8080/vehicles///] Test Url GET http://localhost:8080/vehicles/2015/Audi/A3 GET http://localhost:8080/vehicles/2015/Toyota/Yaris GET http://localhost:8080/vehicles/2015/Ford/Crown Victoria GET http://localhost:8080/vehicles/undefined/Ford/Fusion

Requirement 1: [POST http://localhost:8080/vehicles/] Test Data: 1) { "modelYear": 2015, "manufacturer": "Audi", "model": "A3" }

	2)
	{
	 "modelYear": 2015,
	 "manufacturer": "Toyota",
	 "model": "Yaris"
	}
Requirement 3: [GET http://localhost:8080/vehicles///?withRating=true] Test Url: GET http://localhost:8080/vehicles///?withRating=true

	GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=false 
	(should return the same output as Requirement 1)

	GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=bananas 
	(should return the same output as Requirement 1)

	GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL> 
	(should return the same output as Requirement 1)

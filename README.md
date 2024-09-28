# Multipoint Route Planner

## Description

This is a web application developed using the Laravel framework. It allows the user to find the optimal route on multiple destinations. Additionally, using MySQL as the database management, this web app implements a database for storign routes of specific user. 
This web app uses Direction Application Programming Interface (API) from OpenRouteService [https://openrouteservice.org/]

## Installation

in order to get all the dependencies (since the vendor folder is not uploaded), run
`composer update`
`composer install`

Obtain API key from OpenRouteService[https://openrouteservice.org/]
and paste it on MapController.

# Run this code

Create a database named 'routeplanner_db'. Run the migration to create the database schema.
`php artisan migrate`
Navigate to the directory of the project. In the terminal, run
`php artisan serve `
Navigate to your browser. The web application can now be accessed on localhost:8000.


## License

This project contains code licensed under the MIT License.
See the LICENSE file for more information.

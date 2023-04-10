## Laravel Monte Carlo Simulation for Football Matches
This is a sample project that demonstrates how to use Monte Carlo simulation to simulate football matches and calculate win probabilities for each team. The project is built using Laravel framework.

## Requirements
PHP 8.1 or higher
MySQL 5.7 or higher
Laravel 10.0 or higher

## Installation
 - Clone the repository.
 - Install dependencies: `composer install `
 - Install npm dependencies: `npm install & npm run build`
 - Create a new MySQL database
 - Rename .env.example to .env and update the database configuration settings
 - Generate a new application key: `php artisan key:generate`
 - Run migrations: `php artisan migrate`
 - Seed the database with sample data: `php artisan db:seed`

## Configuration
The simulation is configured in the `config/simulation.php` file. The following settings are available:
 - `number_of_simulations` - the number of simulations to run
 - `weeks` - the number of weeks to simulate

## Usage
Run the simulation and calculate win probabilities for each team: php artisan simulate
View the league table with updated standings: php artisan table
License
This project is licensed under the MIT License. See LICENSE for details.

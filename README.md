# News Aggregator Platform

## About The Project

This project is a modular and feature-rich news aggregator platform, structured in a unique way to enhance maintainability, scalability, and ease of use. Inspired by `nwidart/laravel-modules`, it organizes code into `features`, each encapsulating specific functionalities.

### Features

- Modular code structure using `features`.
- Dynamic response handling for both API and HTML.
- Customized database operations and migrations.
- Repository and Specification patterns for clean and maintainable code.

## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

- Git
- Composer
- redis
- PHP >= 8.1
- Laravel 10

### Installation

1. **Clone the repository:**

   ```sh
   git clone https://github.com/SepehrMoafi/Innoscripta.git

2. **Install Composer dependencies:**
   ```sh
    composer install
   
3. **Generate autoload files:**
   ```sh
   composer dump-autoload

4. **Migrate database:**
   ```sh
   php artisan migrate
   
5. **Run project:**
   ```sh
   php artisan serve
   
6. **Run project:**
   ```sh
   php artisan queue:work --queue:
## Configuration

### Environment Setup:
- Configure your `.env` file with the necessary database and API settings.

### Database Migrations:
- Run `php artisan migrate` to set up your database.

## Usage

This platform is designed to fetch and display news articles from various sources.

### Schedule Data Fetching:
- Data from The Guardian is fetched every 30 minutes. Enable this by uncommenting the code in `app/console/Kernel.php`.
- For other sources, refer to custom jobs in `app/jobs`.

## Code Structure

### Features:
- Organized by functionality, each feature contains its DB operations, responses, migrations, and more.

### [Feature Name]Responses:
- Utilizes facades to handle dynamic responses for different client needs.
- Facilitates the gathering of live data based on user search queries.

### Live Data Handling:
- To provide live data, the system attempts to fetch data directly from data sources.
- A job is then called to fetch and store this data, ensuring users have access to the latest information.
- This approach is designed to gather data based on user searches, considering the rate limits of APIs.

### Repository and Specification Patterns:
- Ensures clean, maintainable, and testable code.

## Contact

Name - [Sepehr Moafi](mailto:sepehrmoafi02@gmail.com)

Website - [sepehrmoafi.com](https://sepehrmoafi.com/)

Project Link: [https://github.com/SepehrMoafi/Innoscripta](https://github.com/SepehrMoafi/Innoscripta)

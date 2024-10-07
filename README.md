# Project: Book Management
This project is a REST API for managing books, developed using the Laravel framework. The main goal was to create an architecture that adheres to SOLID principles, ensuring scalability, maintainability, and testability of the code.

## Installation Guide

### Prerequisites
- **Git**: For cloning the repository.
- **Docker and Docker Compose**: For containerization and managing services.

### Installation and Setup Steps

#### Clone the Repository
Clone the project repository to your local machine using the following command:
```shell
git clone https://github.com/GlebSolncev/book-managment your-repository
```

#### Navigate to the Project Directory
Change your current directory to the project directory:
```shell
cd your-repository
```

### Start Docker Containers
Start the Docker containers in detached mode:
```shell
docker-compose up -d
```

### Run the _entrypoint.sh_ Script
Execute the entrypoint.sh script inside the PHP container:
```shell
docker-compose exec php ./entrypoint.sh
```

### Access the Application
After successfully starting the containers and running the entrypoint.sh script, your application should be accessible at http://localhost:8000 or the port specified in your docker-compose.yml file.

- [Swagger Documentation link](http://localhost:8000/api/documentation)
- Show UI Coverage Tests **your-repository/coverage-html/index.html**

## Project Structure
- Model: Book — represents the book entity.
- Controllers: BookController — handles HTTP requests and formulates responses.
- Services: BookService — contains the business logic of the application.
- Repositories: BookRepository — responsible for interacting with the database.
- Form Requests: StoreBookRequest and UpdateBookRequest — perform validation of incoming data.
- Resources: BookResource — formats data before sending it to the client.
- Routes: Defined in routes/api.php using Route::apiResource.

## Project Features
- Pagination: Implemented pagination for the list of books, allowing efficient handling of large amounts of data.
- Data Validation: Use of Form Request classes ensures reliable validation of incoming requests.
- Response Formatting: Use of Resource classes for consistent and client-friendly API responses.
- Exception Handling: A global exception handler returns clear error messages with appropriate HTTP status codes.
- Testing: The code is covered with functional and unit tests, enhancing the reliability and stability of the application.
- API Documentation: Swagger/OpenAPI annotations are used for automatic generation of API documentation.

# Task
Write Rest API application for the book library which allow to track what books they have.

(only books, without any other dependencies like clients, etc.)

## Required
- Application should use the latest PHP version
- Application should use "composer" to install all dependencies
- Application should support GET/POST/PATCH/DELETE actions
- Application should have PHPUnit tests
- Application should have README instructions on how to setup and run an application
- The final result should be posted on GitHub and should have comments with a clear messages for what was done there

## Not required (but will be a plus)
- Application should have a Swagger UI page
- Application should use Symfony/Laravel framework
- Application should have an automatic setup process with fixtures and migrations
- Application should be built using Docker container (docker-compose)

## Book model:
- Title (string)
- Publisher (string)
- Author (string)
- Genre (string)
- Book publication (date)
- Amount of words in the book (int)
- Book price in US Dollars


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# movie_details-API

The Movie Details API is a RESTful web service that allows you to manage movie details using defined endpoints. This API is built using the Slim PHP framework, adheres to RESTful principles, and provides features for CRUD operations, sorting, pagination, and more.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)

## Features

- API Authentication: None.
- API Caching: implemented via Controller Properties and within class methods (No third Party Libraries/Extensions).
- API Request and Response Logging: via MiddleWares (N.B: ResponseLogMiddleWare was deactactivated because it it's implementation throws a bug.)

- `GET /v1`: Get the list of all available endpoints for this API.
- `GET /v1/movies`: Get a list of all existing movies.
- `POST /v1/movies`: Add a new movie to the collection.
- `PUT /v1/movies/{uid}`: Update a movie by UID (Unique Identifier).
- `DELETE /v1/movies/{uid}`: Delete a movie by UID (Unique Identifier).
- `PATCH /v1/movies/{uid}`: Update specific data of a movie by UID (Unique Identifier).
- `GET /v1/movies/{numberPerPage}`: Get a list of movies with pagination (user defined value).
- `GET /v1/movies/{numberPerPage}/sort/{fieldToSort}`: Get a list of movies sorted by a specific field with pagination.
- `GET /v1/movies/search/{title}`: Search for a movie.

## Installation

1. Clone the repository to your xampp's htdocs directory:
   ```bash
   git clone https://github.com/Dev-Clair/v1.git
   ```
2. Navigate to the project directory:
   ```bash
   cd v1
   ```
3. Install the required dependencies using Composer:
   ```bash
   composer install
   composer dump-autoload
   ```
4. Configure your web server (e.g., Apache, Nginx) to point to the project's `public` directory.
5. Start php local development server:
   `php -S localhost:8888 -t public`
6. Open Xampp and start Mysql and Apache service engines
7. Using your preferred editor, navigate to the public directory and run `boostrap.php` to create database, tables and insert sample data into the database table.

## Usage

1. Access the application through your preferred http API Client and make a request to any of the above endpoints.
2. This API doesn't require authentication, so no requirement is expected like adding bearer tokens or user api keys to the payload.
3. Make defined requests to each of the endpoints to see what the web service has to offer.
4. All endpoints except `GET /v1/movies/search/{title}` was tested.
5. Navigate to the tests/ directory and run the command `./vendor/bin/phpunit tests/MovieControllerTest.php` with or without any of the following options ` --colors` and `--testdox`.

## API Documentation

The API documentation is generated using Swagger (OpenAPI). You can access the documentation by visiting the following URL in your browser: `http://localhost:8888/docs/`

Swagger UI

This documentation provides detailed information about each endpoint, input parameters, response formats, and example requests/responses

## Technologies Used

- PHP (>= 8.0)
- PostMan as http client for making request to endpoints.
- Guzzle as http client for testing.
- MySQL database for data storage.
- Composer for dependency management.
- MRC (Model-Response-Controller) design architecture.

## Contributing

Contributions are welcome! If you find a bug or want to make a helpful recommendation, please follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Make your changes and test them thoroughly.
4. Create a pull request describing the changes you've made.

## License

This project was developed for learning purposes (Courtesy: Jagaad Academy).
This project is licensed under the [MIT License](LICENSE).

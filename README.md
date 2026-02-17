# blog-from-api
A simple application built with Laravel, designed to fetch blog items from the mock-api https://jsonplaceholder.typicode.com/. Build as requested in the assignment file [OPDRACHT.md](OPDRACHT.md). Thoughts and considerations are documented in the assignment elaboration file [OPDRACHT-UITWERKING.md](OPDRACHT-UITWERKING.md).

## Installation
1. Clone the repository:
   ```git clone git@github.com:miyvrey2/blog-from-api.git```
2. Change directory:
   ```cd blog-from-api```
3. Install dependencies:
   ```composer install```
4. Copy the `.env.example` file to `.env`:
   ```cp .env.example .env```
5. Generate the application key:
   ```php artisan key:generate```
6. Run the migrations:
   ```php artisan migrate```
7. Seed the database with the API data:
   ```php artisan import:from-api```
8. Visit the `/posts` page to see the imported posts, authors and comments

# Click Intelligence Ltd - Word counter
A simple website word counter.

The project uses the following technologies:

 - PHP 8.1.10
 - Laravel Framework 10.48.22
 - MySQL 8.0.30
 - Node 18.8.0
 - TailwindCSS

Optimised for the following screen sizes:

- 1440px and above (Desktop and larger screens)
- 768px (Tablet)
- 375px (Mobile)

## Getting started

### 1. Clone the repo

```
git clone <repository-url>
cd <project-directory>
```

### 2. Install dependencies

```
composer install
npm install
```

### 3. Setup env variable

Point the project to your database in the .env file located at the root folder.

### 4. Generate application key

```
php artisan key:generate
```

### 5. Setup the database

```
php artisan migrate
```

### 6. Compile front-end assets such as Tailwind

```
npm run dev
```

### 7. Start development server

```
php artisan serve
```

This will start the server at ``http://localhost:8000`` by default.
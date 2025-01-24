# Project Name: Innoscripta News Test

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Usage](#usage)
  - [Running the Project](#running-the-project)
  - [Scheduler Setup](#scheduler-setup)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Introduction
Innoscripta News Test is a Laravel-based application designed to fetch and manage articles from various third-party APIs. The system provides features such as user preferences for filtering articles, a robust logging system for API interactions, and efficient scheduling for periodic updates.

---

## Features
- **User Authentication:** Secure login and registration functionality.
- **Article Management:** Fetch articles from third-party APIs and store them in the database.
- **User Preferences:** Allow users to customize their preferences for authors, categories, and sources.
- **Search Functionality:** Advanced search with filtering options based on user preferences.
- **Scheduler:** Automates periodic tasks such as fetching new articles.
- **API Logging:** Logs all interactions with third-party APIs for better debugging and tracking.

---

## Technologies Used
- **Backend:** Laravel Framework
- **Database:** MySQL
- **Third-Party APIs:** NewsAPI.org, The Guardian API, New York Times API
- **Scheduler:** Laravel Task Scheduler
- **Authentication:** Laravel Passport

---

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Movicworld/innoscripta-backend-case-study.git.
   cd innoscripta-news-test
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment variables:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Seed the database:
   ```bash
   php artisan db:seed
   ```

---

## Environment Variables
The `.env` file should include the following variables:

```env
APP_NAME=Innoscripta News Test
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=client_id
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=client_secret

NEWS_API_KEY=your_news_api_key // W5dSaQ2k43aq3lZUmSU6pNUNzWZ5xFfl
GUARDIAN_API_KEY=your_guardian_api_key // f36d5669-69ec-46fb-a480-89c7f2ffea28
NYT_API_KEY=your_nyt_api_key // f36d5669-69ec-46fb-a480-89c7f2ffea28
```

---

## Usage

### Running the Project
1. Start the local development server:
   ```bash
   php artisan serve --port=4281
   ```

2. Access the application at:
   ```
   http://localhost:4281
   ```

### Scheduler Setup
1. Add the following command to your system's task scheduler to execute every minute:
   ```bash
   * * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1
   ```
   On Windows, use Task Scheduler to set up the equivalent cron job.

2. The scheduler includes the necessary task below:
   ```php
   $schedule->command('news:update')->hourly();
   ```

---

## API Documentation
Comprehensive API documentation is available via Postman and accessible through (https://documenter.getpostman.com/view/34201461/2sAYQfDUaH). The endpoints include:
- **Search Articles:** Allows authenticated and unauthenticated users to search articles with filters.
- **User Preferences:** Manage user preferences for authors, sources, and categories.
- **Article Logs:** Access logs of third-party API responses.

### Important Notes
- The `searchArticles` endpoint accepts a token for filtering with user preferences. If no token is provided, the endpoint still works with general filters.

---

## Testing
1. Run the test suite:
   ```bash
   php artisan test
   ```

2. Check test coverage and ensure all features are working as expected.

---

## Contributing
1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add new feature"
   ```
4. Push to the branch:
   ```bash
   git push origin feature-name
   ```
5. Submit a pull request.

---

## License
This project is licensed under the [MIT License](LICENSE).

---

Feel free to reach out with any questions or suggestions for improvement!


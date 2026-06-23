# Issue Tracker
A mini issue tracker built with Laravel where teams can manage projects, issues, tags, and comments.

## Tech Stack
- Laravel 12
- MySQL
- Blade + Tailwind CSS
- Vanilla JavaScript (AJAX)

## Setup
1. Clone the repository
   git clone <repo-url>
   cd issue-tracker

2. Install dependencies
   composer install

3. Configure environment
   cp .env.example .env
   php artisan key:generate
   
   Set your database credentials in .env
   DB_DATABASE=issue_tracker
   DB_USERNAME=root
   DB_PASSWORD=

4. Run migrations and seed demo data
   php artisan migrate --seed

5. Start the server
   php artisan serve

Visit: http://localhost:8000

## Features
- Full CRUD system for Projects, Issues, and Tags, with clean relationships between them
- Issues can be filtered by status, priority, and tags to quickly find relevant tasks
- Tags — create and list, attach/detach to issues via AJAX
- Comments system with async loading, pagination, and basic validation for faster interaction
- Backend validation handled using Laravel Form Request classes for cleaner controllers
- Database structured with migrations, factories, and seeders to generate realistic demo data
- Projects include additional fields like start date and deadline to support basic planning workflows

## Bonus
- *(coming soon)* User assignment, authorization policies, search with debounce




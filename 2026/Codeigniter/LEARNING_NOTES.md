# CodeIgniter 4: Beginner-to-Advanced Learning Guide

**Goal:** Learn CodeIgniter 4 in the correct order and become able to build, test, secure, and deploy real applications.

**Recommended duration:** 16 weeks  
**Daily time:** 1.5–2 hours, 6 days per week  
**Main practice projects:** Task Manager → Inventory System → REST API

> Follow the phases in order. Do not start the next phase until you can complete the checkpoint at the end of the current phase.

---

## 1. What You Will Use

Use the latest stable CodeIgniter 4 release. At the time this guide was prepared, the official documentation was for CodeIgniter **4.7.4** and required **PHP 8.2 or newer**. Check the official requirements page before installation because requirements may change.

You need:

- PHP 8.2 or newer
- Composer 2
- MySQL or MariaDB
- VS Code
- Git
- A browser
- Postman or Bruno for API testing (later)

### Windows setup options

Choose only one:

1. **Simple option:** Install Laragon, then install/update Composer separately.
2. **Alternative:** Install XAMPP, Composer, and Git separately.

Whichever option you choose, verify everything in PowerShell or Command Prompt:

```bash
php -v
composer --version
git --version
```

Check PHP extensions:

```bash
php -m
```

Make sure `intl` and `mbstring` appear. For MySQL, also enable `mysqli` and/or `pdo_mysql`.

### Linux setup

Install PHP 8.2+, Composer, Git, MySQL, and the PHP extensions `intl`, `mbstring`, and `mysql`. Package names vary by distribution.

---

## 2. The One Learning Rule

Use this cycle for every topic:

1. **Read** for 15–20 minutes.
2. **Type** the example yourself; do not copy and paste blindly.
3. **Close** the example.
4. **Rebuild** it from memory.
5. **Change** one feature.
6. **Commit** it with Git.
7. Write what you learned in `LEARNING_NOTES.md`.

Use this daily schedule:

- 20 minutes: Learn one concept
- 60 minutes: Code it
- 20 minutes: Debug and review
- 10 minutes: Notes and Git commit

If you miss a day, continue the next day. Do not skip a topic to catch up.

---

# Phase 0 — Prerequisites (Weeks 1–3)

Do not begin CodeIgniter until you understand basic PHP, OOP, SQL, HTTP, Composer, and Git.

## Week 1: PHP basics

### Day 1

Learn:

- PHP tags and syntax
- Variables and constants
- Strings, integers, floats, booleans, and `null`
- `echo` and string interpolation

Practice: Print a user profile from variables.

### Day 2

Learn:

- Arrays and associative arrays
- `if`, `elseif`, `else`
- Comparison and logical operators

Practice: Calculate whether a student passed based on marks.

### Day 3

Learn:

- `for`, `while`, and `foreach`
- Functions
- Parameters and return types

Practice: Write a function that calculates an invoice total.

### Day 4

Learn:

- HTML forms
- `$_GET` and `$_POST`
- Basic server-side validation

Practice: Make a registration form and validate name, email, and password.

### Day 5

Learn:

- `include` and `require`
- Files and folders
- Error reporting
- Exceptions and `try/catch`

Practice: Split a page into header, content, and footer files.

### Day 6 — Review project

Build a plain-PHP **Expense Calculator**:

- Form to enter title and amount
- Validate the values
- Store expenses temporarily in an array
- Display total expenses

### Week 1 checkpoint

Continue only if you can write functions, loops, arrays, and form validation without following a video step by step.

---

## Week 2: Object-oriented PHP and Composer

### Day 1

Learn classes, objects, properties, methods, constructors, and visibility.

### Day 2

Learn inheritance, abstract classes, interfaces, and traits.

### Day 3

Learn namespaces, `use` statements, and PSR-4 autoloading.

### Day 4

Learn dependency injection at a basic level:

```php
class OrderService
{
    public function __construct(private PaymentGateway $gateway)
    {
    }
}
```

Understand that the class receives its dependency instead of creating it internally.

### Day 5

Learn Composer:

```bash
composer init
composer install
composer update
composer require vendor/package
composer dump-autoload
```

Understand `composer.json`, `composer.lock`, and `vendor/`.

### Day 6 — Review project

Build a plain-PHP OOP mini application with:

- `Product` class
- `Cart` class
- `DiscountInterface`
- One discount implementation
- Composer autoloading

### Week 2 checkpoint

You should be able to explain:

- Class versus object
- Interface versus class
- Namespace
- Constructor injection
- Why `vendor/` normally should not be edited

---

## Week 3: SQL, HTTP, and Git

### Days 1–2: SQL

Learn:

- Create database and table
- `INSERT`, `SELECT`, `UPDATE`, `DELETE`
- `WHERE`, `ORDER BY`, `LIMIT`
- Primary keys, foreign keys, and indexes
- `INNER JOIN` and `LEFT JOIN`
- Transactions

Practice with these tables:

- `users`
- `categories`
- `products`

### Day 3: HTTP

Understand:

- Request and response
- URL, route, headers, and body
- Cookies and sessions
- `GET`, `POST`, `PUT`, `PATCH`, `DELETE`
- Status codes: 200, 201, 204, 400, 401, 403, 404, 422, 500

### Days 4–5: Git

Learn:

```bash
git init
git status
git add .
git commit -m "Create product form"
git branch
git switch -c feature/products
git log
```

Also learn `.gitignore`, GitHub repositories, push, pull, and basic merging.

### Day 6 — Final prerequisite test

Create a small plain-PHP product database application. It should connect to MySQL, list products, and add one product.

### Phase 0 checkpoint

You are ready for CodeIgniter if you can:

- Submit and validate a PHP form
- Create and use an OOP class
- Write CRUD SQL queries
- Explain a GET request versus a POST request
- Commit code with Git

---

# Phase 1 — CodeIgniter Foundations (Weeks 4–5)

## Week 4: Installation, structure, routes, controllers, and views

### Day 1: Create the project

```bash
composer create-project codeigniter4/appstarter task-manager
cd task-manager
```

Copy or rename `env` to `.env`. In `.env`, set:

```ini
CI_ENVIRONMENT = development
```

Run:

```bash
php spark serve
```

Open `http://localhost:8080`.

Initialize Git:

```bash
git init
git add .
git commit -m "Install CodeIgniter application"
```

Never commit real passwords or production secrets.

### Day 2: Learn the project structure

Only focus on these folders now:

- `app/Config` — application configuration
- `app/Controllers` — request handling
- `app/Models` — database access
- `app/Views` — page templates
- `app/Database/Migrations` — database structure
- `app/Database/Seeds` — sample data
- `public` — web document root
- `writable` — logs, cache, sessions, and uploads
- `tests` — automated tests
- `vendor` — Composer dependencies; do not edit

Learn useful Spark commands:

```bash
php spark list
php spark routes
php spark make:controller TaskController
php spark make:model TaskModel
```

### Day 3: Routes and controllers

In `app/Config/Routes.php`:

```php
$routes->get('/tasks', 'TaskController::index');
$routes->get('/tasks/(:num)', 'TaskController::show/$1');
```

Create a controller that returns text first, then a view.

### Day 4: Views and data

Learn to pass data:

```php
return view('tasks/index', [
    'title' => 'My Tasks',
    'tasks' => $tasks,
]);
```

Escape output:

```php
<?= esc($title) ?>
```

Learn layouts with `extend()`, `section()`, and `renderSection()`.

### Day 5: Request and response

Learn:

- `$this->request->getGet()`
- `$this->request->getPost()`
- Redirects
- Named routes
- 404 responses

### Day 6: Mini exercise

Build static pages for:

- `/`
- `/about`
- `/contact`
- `/tasks`
- `/tasks/1`

### Week 4 checkpoint

Without notes, create a route, controller method, and view, then pass and display escaped data.

---

## Week 5: Database, migrations, models, and seeders

### Day 1: Configure the database

Create a MySQL database named `task_manager`. Set `.env` values:

```ini
database.default.hostname = localhost
database.default.database = task_manager
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Use your actual local username and password.

### Day 2: Create a migration

```bash
php spark make:migration CreateTasksTable
```

Create fields:

- `id` — unsigned integer, auto-increment, primary key
- `title` — varchar 150
- `description` — text, nullable
- `status` — varchar 30, default `pending`
- `due_date` — date, nullable
- `created_at` and `updated_at` — datetime, nullable

Run:

```bash
php spark migrate
```

Learn:

```bash
php spark migrate:status
php spark migrate:rollback
php spark migrate:refresh
```

### Day 3: Create the model

```bash
php spark make:model TaskModel
```

Configure:

```php
protected $table = 'tasks';
protected $primaryKey = 'id';
protected $allowedFields = [
    'title', 'description', 'status', 'due_date'
];
protected $useTimestamps = true;
```

Learn:

- `find()`
- `findAll()`
- `first()`
- `insert()`
- `update()`
- `delete()`
- `where()`
- `orderBy()`

### Day 4: Seed sample data

```bash
php spark make:seeder TaskSeeder
php spark db:seed TaskSeeder
```

### Days 5–6: Read-only task screens

Build:

- Task list
- Task details
- Filter by status
- Sort by due date

### Phase 1 checkpoint

Recreate the task migration, model, seeder, list page, and details page without copying old code.

---

# Phase 2 — Complete CRUD Application (Weeks 6–7)

## Week 6: Create, update, and delete

### Day 1: Create form

Add:

```php
$routes->get('/tasks/new', 'TaskController::new');
$routes->post('/tasks', 'TaskController::create');
```

Use `csrf_field()` inside every state-changing HTML form.

### Day 2: Validation

Validate:

```php
$rules = [
    'title'    => 'required|min_length[3]|max_length[150]',
    'status'   => 'required|in_list[pending,in_progress,completed]',
    'due_date' => 'permit_empty|valid_date[Y-m-d]',
];
```

On failure, redirect back with input and validation errors. Display an error beside each field.

### Day 3: Edit and update

Add:

```php
$routes->get('/tasks/(:num)/edit', 'TaskController::edit/$1');
$routes->put('/tasks/(:num)', 'TaskController::update/$1');
```

Use form method spoofing for PUT.

### Day 4: Delete

Add a DELETE route. Require confirmation. Return a 404 if the task does not exist.

### Day 5: Flash messages

Display success or error messages after redirects.

### Day 6: Cleanup

Remove duplicated view code. Use a layout and partials. Keep database code in the model, not the view.

---

## Week 7: Improve the Task Manager

Add one feature per day:

1. Pagination
2. Search by title
3. Status filtering
4. Due-date filtering
5. Sort controls
6. Final testing and README

Your README should include:

- Project purpose
- Requirements
- Installation steps
- Database setup
- Migration and seeder commands
- How to run it
- Screenshots

### Phase 2 completion requirements

Your Task Manager must have:

- Full CRUD
- Server-side validation
- Escaped output
- CSRF-protected forms
- Search, filter, and pagination
- Migrations and seeders
- Friendly 404 behavior
- Flash messages
- Git history and README

Do not continue until all items work.

---

# Phase 3 — Real Application Features (Weeks 8–10)

Start a new **Inventory Management System**. Do not keep extending the Task Manager forever.

## Week 8: Relationships and transactions

Create tables:

- users
- categories
- products
- stock_movements

Learn:

- Foreign keys
- Indexes
- Joins
- Model methods for related data
- Database transactions
- Entities and casting
- Soft deletes

Features:

- Category CRUD
- Product CRUD
- Product-category relationship
- Stock-in and stock-out transaction
- Prevent negative stock

Use a database transaction when one operation changes multiple records.

## Week 9: Authentication and authorization

Use **CodeIgniter Shield**, the official authentication and authorization package, rather than inventing password and session security yourself.

Install according to the current official Shield documentation. A typical starting sequence is:

```bash
composer require codeigniter4/shield
php spark shield:setup
php spark migrate --all
```

Learn:

- Registration and login
- Logout
- Session authentication
- Password hashing
- Groups and permissions
- Authentication filters
- Authorization checks

Create roles:

- Admin — manage users, categories, products, and reports
- Staff — view products and record stock movements

Test these cases:

- Guest cannot access dashboard
- Staff cannot access admin user management
- Admin can access all admin routes

## Week 10: Uploads, email, logs, and security

Learn and implement:

- Product image upload
- File type, MIME type, extension, and size validation
- Randomized stored filenames
- Email configuration
- Logging
- Custom error pages
- Environment variables
- Rate limiting concepts

Security checklist:

- Escape output with `esc()`
- Keep CSRF enabled
- Validate every request on the server
- Use model `allowedFields`
- Never concatenate user input into SQL
- Never store plain-text passwords
- Do not expose `.env`
- Restrict upload type and size
- Do not trust hidden form fields for authorization
- Return generic messages for sensitive authentication failures

### Phase 3 checkpoint

Ask another person to use your Inventory System. Fix every action that is confusing or broken. Confirm role restrictions manually with guest, staff, and admin accounts.

---

# Phase 4 — REST APIs and Professional Structure (Weeks 11–12)

## Week 11: REST API

Add `/api/v1/products` endpoints:

- `GET /api/v1/products`
- `GET /api/v1/products/{id}`
- `POST /api/v1/products`
- `PUT /api/v1/products/{id}`
- `DELETE /api/v1/products/{id}`

Learn:

- Resource routes and resource controllers
- JSON request and response bodies
- Validation errors in JSON
- Correct HTTP status codes
- API filters
- Token authentication with Shield
- CORS concepts
- Pagination metadata
- API versioning

Use a consistent response shape, for example:

```json
{
  "success": true,
  "message": "Product created",
  "data": {
    "id": 25,
    "name": "Keyboard"
  }
}
```

For validation errors, return an appropriate 4xx status such as 422 and a predictable `errors` object.

Test every endpoint with Postman or Bruno.

## Week 12: Service layer and maintainability

Learn when to use:

- Controllers — translate HTTP requests into application actions
- Models — database persistence and queries
- Services — business operations and rules
- Entities — domain data and transformations
- Libraries — reusable technical functionality
- Filters — before/after request checks
- Events — decoupled reactions to application actions

Refactor one complex operation, such as stock adjustment, into a service. Keep controllers short, but do not add patterns just to make the project look advanced.

Learn:

- Constructor dependency injection
- Custom validation rules
- Events
- Reusable helpers and libraries
- Modules only after the normal application structure feels limiting

### Phase 4 checkpoint

A client should be able to use your API from its documentation without reading your PHP source code.

---

# Phase 5 — Testing, Performance, and Deployment (Weeks 13–16)

## Week 13: Automated testing

Learn:

- Unit tests
- Feature tests
- Database tests
- Controller and API tests
- Test fixtures and seed data
- Mocking only where useful

Run the project's configured test command, commonly:

```bash
composer test
```

Write tests for:

- Validation rejects an empty product name
- Guest cannot access admin page
- Staff cannot delete a user
- Product creation succeeds with valid data
- API returns 404 for a missing product
- Stock transaction cannot create negative stock

Do not treat coverage percentage as the only goal. Test important behavior and failure cases.

## Week 14: Performance and observability

Learn:

- Debug Toolbar
- Reading logs
- Query analysis
- Database indexes
- Avoiding repeated/N+1 queries
- Application caching
- HTTP caching basics
- Pagination instead of loading all rows

Measure before optimizing. Compare query count and response time before and after each change.

## Week 15: Deployment

Learn:

- Development versus production environment
- Apache or Nginx virtual host
- Pointing the document root to `public/`
- Production `.env`
- File permissions for `writable/`
- HTTPS
- Database migrations during release
- Backups and rollback plan
- Cron jobs
- Email and error-log monitoring

Typical production dependency command:

```bash
composer install --no-dev --optimize-autoloader
```

Never deploy with the development server command `php spark serve`.

Before deploying:

- Set production environment
- Disable visible error details
- Back up database and uploaded files
- Configure HTTPS
- Use strong database credentials
- Confirm `writable/` permissions
- Ensure `.env` is not publicly available
- Run tests
- Check logs after release

## Week 16: Docker and CI/CD

Learn the basics of:

- Docker image and container
- PHP/Apache or PHP-FPM service
- MySQL service
- Environment configuration
- Persistent database volumes
- GitHub Actions or another CI tool

Create a CI workflow that:

1. Checks out the repository
2. Installs PHP and Composer dependencies
3. Creates the test environment
4. Runs migrations if needed
5. Runs automated tests
6. Fails the build when tests fail

### Final checkpoint

You are at an employable intermediate/advanced-learning stage when you can:

- Build a CodeIgniter application from an empty AppStarter project
- Design normalized database tables and migrations
- Build secure CRUD screens
- Implement authentication and permissions
- Build and document a REST API
- Write meaningful automated tests
- Debug logs and database queries
- Deploy with secure production configuration
- Explain why your code is structured the way it is

---

# Exact Project Portfolio

## Project 1 — Task Manager

Demonstrates:

- MVC
- Routing
- Views and layouts
- CRUD
- Models and migrations
- Validation
- Search and pagination

## Project 2 — Inventory Management System

Demonstrates:

- Authentication
- Roles and permissions
- Relationships
- Transactions
- Uploads
- Reports
- Security
- Automated testing

## Project 3 — Inventory REST API

Demonstrates:

- REST design
- JSON responses
- Token authentication
- API validation
- Versioning
- Documentation
- API tests
- Deployment

For every portfolio project include a README, screenshots, installation instructions, sample `.env` without secrets, database seeders, and a meaningful Git history.

---

# What Not to Learn Yet

Avoid these until you finish the Task Manager:

- Microservices
- Complex repository patterns
- Kubernetes
- Event-driven architecture
- Multiple databases
- Premature caching
- Building your own authentication system

These topics are not bad; they are simply distractions for a beginner.

---

# How to Debug Without Panic

When something fails, follow this order:

1. Read the complete error message.
2. Note the first line in your own `app/` code.
3. Check `writable/logs/`.
4. Check the Debug Toolbar.
5. Run `php spark routes` for route problems.
6. Verify `.env` values and remove accidental comment characters.
7. Check migration status.
8. Reduce the problem to the smallest failing code.
9. Search the exact error in the official documentation.
10. Change one thing at a time.

Keep an `ERROR_LOG.md` with:

- Error message
- Cause
- Fix
- How to prevent it

This becomes your personal troubleshooting handbook.

---

# Weekly Review Template

At the end of each week, answer:

```text
1. What did I build?
2. Which three concepts can I explain without notes?
3. What confused me?
4. Which bug took the longest and why?
5. Can I rebuild this week's feature without a tutorial?
6. What is next week's first task?
```

If you cannot rebuild the week's main feature, repeat the final two days before moving forward.

---

# Official Learning Resources

Use official documentation as the primary source:

1. CodeIgniter 4 User Guide: https://codeigniter.com/user_guide/
2. First Application tutorial: https://codeigniter.com/user_guide/guides/first-app/index.html
3. Installation with Composer: https://codeigniter.com/user_guide/installation/installing_composer.html
4. Server requirements: https://codeigniter.com/user_guide/intro/requirements.html
5. CodeIgniter Shield: https://shield.codeigniter.com/

When a video tutorial disagrees with the current official documentation, follow the documentation. Check that any tutorial explicitly teaches **CodeIgniter 4**, not CodeIgniter 3.

---

# Your First Action Today

Do only these tasks today:

1. Run `php -v`, `composer --version`, and `git --version`.
2. If PHP knowledge is weak, begin Phase 0, Week 1, Day 1.
3. If you can already build a plain-PHP database CRUD application using OOP, begin Phase 1.
4. Create `LEARNING_NOTES.md`.
5. Schedule the same 90-minute study period for the next six days.

Do not install many courses or start three projects. Follow this one sequence and finish each checkpoint.

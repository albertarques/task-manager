# Simple Task Manager
A simple task manager build with Symfony 7 and Tailwind.
## How to run (in local environment)
### Requirements
- [PHP 8.3](https://www.php.net/downloads.php)
- A database:
  - [MySql](https://www.mysql.com/products/workbench/)
  - [Sqlite](https://www.sqlite.org/)
- [Composer PHP](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download)
### Cloning repository
- Go into your directory and clone Git Hub repository.
~~~
git clone https://github.com/albertarques/task-manager.git
~~~
### Installing dependencies
- Run Composer command to install dependencies.
~~~
composer install
~~~
### Connecting database
- Configure a database connection into .env.local file, you can use .env.example as a base.
- Maybe you need to install a MySQL server or make an Sqlite file before.
~~~
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
~~~
- Create a database schema.
~~~
symfony console doctrine:database:create
~~~
- Prepare database tables.
~~~
symfony console doctrine:migrations:migrate
~~~
### Seeding database (optional)
- Run command to seed database with fake data. It's useful to try the command line to delete old completed tasks.
~~~
symfony console doctrine:fixtures:load
~~~
### Preparing frontend
- Run Tailwind command to build frontend styles.
~~~
php bin/console tailwind:build
~~~
### Starting server
- Start Symfony server.
~~~
symfony serve
~~~
### Entering app
- Open your preferred internet navigator and go to app url, register a user and start to make tasks. Have fun!
### Extra functionality
- To delete completed old tasks (more than 30 days past), you can run the command:
~~~
php bin/console app:clear-old-tasks
~~~

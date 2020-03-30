# Laravel Todo 

## Install notes

1. choose a directory on your server
2. create a database for todo app (mysql supported)
3. in your command line : 
- git clone https://github.com/itanea/laravel-todo.git .
- composer install
- cp .env.example .env
- php artisan key:generate
- set your .env file with database credentials and others datas needed
- php artisan migrate
- register yourself
- to automatically delete old done's todos (older than 7 days), add a line to your crontab like following : * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
- enjoy !

Note : when you migrate if you have a message like :

> [Illuminate\Database\QueryException]
> SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table users add unique users_email_unique(email))

you have to edit your AppServiceProvider.php file and inside the boot method set a default string length:

```
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```



## Release notes

### Version 1.7 - 20200331

- Add scheduling for deleting old done's todos (older than 7 days)
- Add understandable subject to email notification

### Version 1.6 - 20200329

- Add notifications system (mail & web)
- Fix CSS little bug
- Fix error due to the $users param missing
- Improve filters buttons by using component view filters
- Add created by me filter's button

### Version  1.5.1 - 20200328 - Bugfix

- Fix kebab case on resources/views/components/todo.blade.php . Bug appears only for production, probably differences between Windows (dev) and Linux (prod) systems

### Version 1.5 - 20200328

- Purpose : show todos for connected user
- Add todo's view component
- Add columns : affectedTo_id, affectedBy_id, creator_id
- Add route to affect a todo to someone
- Add makeundone function
- update redirect route after login
- Add an app's footer


### Version 1.4.1 - 20200323

- add link, route, view for todos in progress

### Version 1.4 - 20200322

- add page index to list all todos
- status design (currents / done)
- filter all todos or done todos
- create new todo
- delete todo
- update todo
- done todo
- show description
- use carbon API to show dates and duration around todos

### Version 1.3

- Start using Eloquent, the Laravel's ORM

### Version 1.2

- Add a basic static home page

### Version 1.1

- Add authentication

### Version 1.0

- Laravel installation


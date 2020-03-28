# Laravel Todo 

## Release notes

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


<div align='center'>
    <img src='https://www.looiconsulting.com/wp-content/uploads/2014/08/LCL-Logo-long-300x53.png' height="85" />
    <p>Technical Challenge.</p>
    
![PHP](https://badgen.net/badge/Php/8.1/blue?)
![Laravel](https://badgen.net/badge/Laravel/10/red?)
![Vue](https://badgen.net/badge/vue/3/green?)

</div>

---

## 💾 **ABOUT**

This is the LOOI TECH CHALLENGE.

As an Entity, we have added a "ToDo" model.
These are only some of the files used. This will create the DB schema, and seed some dummy info into tables, for a better understanding. 

BE AWARE: A MySql server must be installed and running in order to test this challenge.

Files created for MODELS SCHEMA:

| Type          | Name                                           | Description
| ------------- | ---------------------------------------------- | -------------------------------- |
| Model         | ToDo.php                                       |
| Model         | User.php                                       |


| Type          | Name                                           | Description
| ------------- | ---------------------------------------------- | -------------------------------- |
| Factory       | ToDoFactory.php                                |
| Factory       | UserFactory.php                                |


| Type          | Name                                           | Description
| ------------- | ---------------------------------------------- | -------------------------------- |
| Seeder        | ToDoSeeder.php                                 | Loads Dummy ToDos into DB.


| Type          | Name                                           | Description
| ------------- | ---------------------------------------------- | --------------------------------- |
| Migration     | 2023_08_10_194103_create_todo_table.php        |
| Migration     | 2023_08_10_200537_create_users_table.php       | 

<br />

CHALLENGE: 
- Endpoints for authentication using JWT. Also an endpoint for refreshing the JWT access token. (CSRF sanctrum for cookie not added)

	  POST       api/auths/login ............................................ AuthController@login  
	  POST       api/auths/logout ........................................... AuthController@logout  
	  POST       api/auths/refresh .......................................... AuthController@refresh  
	  POST       api/auths/register ......................................... AuthController@register
  
- Endpoints for CRUD ToDos. It also allow to filter and sort by some field.

	Example: http://127.0.0.1:8000/api/todos?per_page=25&committed_due_date=2023-08-18&sort=title
	Filters for ToDos are by State, Committed Due Date. Sorting by any name of field.
 
	  GET|HEAD  api/todos ..................................... todos.index   › ToDoController@index  
	  POST      api/todos ..................................... todos.store   › ToDoController@store
	  GET|HEAD  api/todos/{todo} .............................. todos.show    › ToDoController@show 
	  PUT|PATCH api/todos/{todo} .............................. todos.update  › ToDoController@update
	  DELETE    api/todos/{todo} .............................. todos.destroy › ToDoController@destroy


For the FRONT-END vue 3 application. 

- We have added login.
- We have added registration (with minimun fields).
- We have added a complete CRUD for ToDos.
- We have added a simple about screen.
- We have added a logout functionality. 

We are using AXIOS for endpoints requests, vuetify 3 for styles framework, and vue 3 with script setup notations. 
- We have created 2 middlewares. 1 to add the JWT on all the neccesary requests. And another one to detect whenever the application is logged out, to push user to login screen.

## 🗒️ **INSTALLATION**

### Deployment:

1. clone the repo

```
git clone https://gitlab.com/iciani/looi.git
```

2. cd into cloned repo

```
cd looi
cd looi_back
```

3. install dependencies

```
composer install
```

4. Remember to Generate .ENV file.

Parameters here are basic. They can be change regarding environment.

```
cp .env.example .env
```

5. Validate the Code
```
./vendor/bin/phplint
./vendor/bin/phpcs -s
php artisan test
```

6. Execute Migrations (This will create all the DATABASE models)
```
php artisan migrate (you will be asked to create the DB, please type yes)
```

7. Execute Seeders (This will fill in dummy information for testing purposes)
```
php artisan db:seed (you can execute this command, as many times as you wish. This will be adding new lines)
```

8. Load POSTMAN collection to TEST the ENDPOINTS (Found in this folder LOOI_BACK)
```
looi.postman_collection.json
```

<br />

### Run the Server App:

1. Execute the App in one Terminal

```
php artisan serve (Being at PWD root of folder LOOI_BACK)
```

3. If you visit the base url configured (default would be http://localhost:8000) you should now see a welcome screen.


<br/>


### Run the Client App:

1. In a new terminal, browse project folder.

```
cd looi
cd looi_front
```

2. Install dependencies.

```
npm install
```

3. Validate the Code.

```
npm run lint
```

4. Run the App.

```
npm run dev
```

5. Run the Tests.

```
npx cypress run
```

6. As default, the DB was seeded with Admin User, or you can Register new user.

```
admin@looi.com // looi
```


---

## 🔎 **SHOWCASE**

<img src="https://i.ibb.co/hXhMPj2/looi-server-welcome-screen.png" alt="looi-server-welcome-screen" border="0">
<br />
<img src="https://i.ibb.co/HDYZWT8/vue-login-page-looi.png" alt="vue-login-page-looi" border="0">
<br />
<img src="https://i.ibb.co/jRFKc94/todo-routes-looi-challenge.jpg" alt="route-list" border="0">
<br />
<img src="https://i.ibb.co/dKGbZ9X/todo-tests-looi-phpunit.png" alt="looi-tests" border="0">
<br />
<img src="https://i.ibb.co/52vppM2/todo-looi-tests-cypress.jpg" alt="cypress-front-tests" border="0">

<br />

---

## 💻 **TECHNOLOGIES**

![PHP](https://img.shields.io/badge/PHP-lightblue)

![Laravel](https://img.shields.io/badge/laravel-red)

![MySQL](https://img.shields.io/badge/mysql-blue)

![VUE3](https://img.shields.io/badge/vue3-green)

<br />

---
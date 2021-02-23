# MVC - basics

In this exercise will develop a simple PHP application following the MVC pattern.

## Prerequisites

To follow the exercise, you need a development environment up and running.

We will use the usual `local-environment` for the project. This time, the environmient is contained in the repository you are in. 
Remember to start your docker services for the project running `docker-compose up -d` (inside the `mvc-intro` folder).

If you see an error stating that there is a conflict between container names or ports, it might be that you have another `local-environment` instance running.
This happens because the actual container names you are using are the same for all your `local-environment` instances; we have only changed the name of this repository (folder) to `mvc-intro`.
Accordingly, shutdown all other instances by navigating to the proper folder and executing `docker-compose down`.
Then, issue `docker-compose up -d` at the `mvc-intro` folder. There should be no errors now.

## Introduction

In this exercise we are going to implement some of the basic functionalities of a To-Do list.

We need to install all the dependencies by running the command `composer install` inside the root folder of the project.

## Hands on

As you can see, if you open the `index.php` file, by default there is only one route defined. This route `/task` displays a basic http form that allow our users to introduce a new task to the system. The problem is that the endpoint of the form (defined in the action field) where the information is submitted is not defined yet. If you submit the form you should see the following message in the screen: '_Sorry, the url that you are looking for does not exist_'.

### Persisting tasks

The first step that you need to take is to add a new route with the following restrictions:

- The HTTP method used to access to this route must be **POST**.
- The URL must be `/task`.

This route should trigger a new action inside the `CreateTaskFormGuiController` that you should place inside the `src/Controller` folder. You can name this action/method as you want. The **requirements** of this new method are listed below:

- It **must** use the `CreateTaskUseCase` defined inside the `src/Model/UseCase` folder to persist the new task.
- It **cannot** execute any model/domain logic inside the controller.
- It **can only** use the renderer in order to display the proper template. (You can't `echo` anything).

Before storing the task into the database and just when you receive the request, you must perform some validations:

- The title cannot be empty and its length must be less than 20 characters.
- The content cannot be empty.

If some of the validations are not OK, you need to show the form again, fill the inputs with the values introduced by the user (the ones that are wrong) and display an error message below all the invalid fields. Finally if everything is correct and the task has been added into the system, a success message must be shown below the form.

#### Sending data to the templates

In order to _send_ data to the templates you can use the render method like this:

```php
$this->renderer->render(create_task', ['name' => 'Max', 'age' => 25]);
```

Then, in the template you can reference those variables by the name of the key:

```twig
// create_task.twig

{{ name }} // This will print Max
{{ age }} // This will print 25
```

#### TaskRepository implementation

As you can see, the `CreateTaskUseCase` that you **must** use in the controller expects to receive a class that implements the `TaskRepository` interface defined inside the model. You need to add a new implementation called `MySQLTaskRepository` that implements the interface. This implementation must use **PDO** to access the database and **must** be defined inside the `src/Repository` folder (you need to create that folder).

#### Service definitions

The previous implementation of the repository and all the services and custom classes that you define/use must be instantiated in the container of the `dependencies.php` in order to be used in the `index.php`. 
Also, remember to add your PDO configuration (the configuration to access your database) inside your dependencies (`dependencies.php` file). 

Be aware that the service must receive an instance of a class that implements the `TaskRepository` interface. You will need to inject an instance of your `MySqlTaskRepository` class to the service:

```php

    $container->set(
        'CreateTaskUseCase',
        function () {
            return new \SallePW\Model\UseCase\CreateTaskUseCase(
                new \SallePW\Repository\MySqlTaskRepository()
            );
        }
    );
```

### Database

Use the following SQL to generate the table to store all the tasks:

```sql
CREATE TABLE `task` (
  `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `content` VARCHAR(255) NOT NULL DEFAULT '',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Advanced insights

As you might have observed, we have separated the **model** from everything else. 
We have a folder named `Model` and then other folders (`Controller`, `ErrorHandler` and `Repository`). 
Actually, these are not only folders: they are namespaces and they have a meaning.
Your **model** enables all that your application can do regardless of the user interface. For example, you could move the `Model` folder to another PHP application that uses another Web framework (e.g. symfony) and you wouldn't need to change anything from your **model**.
Or you could create a CLI (Command Line Interface) to interact with your model via terminal, and you would not have to change any piece of code from your **model**.
Or you cold use another database (e.g. MongoDB) and you wouldn't need to change anything from your **model** (because you are using an interface).

You can look at it this way: the classes and interfaces that are inside the `Model` folder do not contain any `use` statement including any class from your other namespaces that are outside the `Model`.
Therefore, a good practice is to create a new folder `src/Infrastructure` (namespace `Infrastructure`) and move the folders other than `Model` inside it (changing namespaces accordingly).
The namespace `Infrastructure` means that your **model** uses an **infrastructure** to act upon the world.
Hence, everything that acts upon the world or that has this type of _side effects_ or is _impure_ in that regard is in the namespace `Infrastructure`.
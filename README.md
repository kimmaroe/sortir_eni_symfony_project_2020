## Projet ENI - Sortir Octobre 2020
* @Avril Adeline
* @Kim Maroe
* @Quentin Poinsignon

### Introduction
"Sortir" is a website which allows students to organise meet-ups around their campus.
It provides secure login to each student account, a registration form for administrators to
create student accounts, a meet-up creation form and a home page which lists all the meet-ups
students can attend to. We also provide filters and search feature for this home page in order for our users
to get the information they need easily and fast.

### Technologies
- Symfony 5.1
- PHP 7.4.11
- CSS 3
- JavaScript
- MySql 5.7

### Setup
To run this project, make sure to install Symfony on your computer (en français:  https://symfony.com/doc/current/the-fast-track/fr/1-tools.html#composer) (in english :https://symfony.com/doc/current/setup.html), you will need to use Symfony's web server or Apache for example.
you'll need to create a data base, we provide fixtures to get this project up and running. Make sure to load them before trying to run sortir in your browser.
We'll guide you through this process in the next section.

### Create the database and populate it with some data
#### Create your database
Once you get MySql, you can create your own database.

In order to achieve this, please, copy and paste .env file at the root of the project. Name the new file .env.local
Open the file, at the end of it, you can set up your database information. make sure to provide this file with your login and password, the IP adress 
where your database is located and the database's name in the DATABASE_URL as follow :
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Once you're done with this, you can now create your database using Doctrine ORM:
at the root of your project run this command :
php bin/console doctrine:database:create
then, if you are on a local environnement, you can update the schema database running this command :
php bin/console doctrine:schema:update --force

you can also follow Symfony documentation here https://symfony.com/doc/current/doctrine.html#configuring-the-database .

#### load in some data
In order to populate your database, we need you to install DoctrineFixturesBundle. Run this command at the root of your project:
composer require --dev doctrine/doctrine-fixtures-bundle

then load the fixtures using this command:
php bin/console doctrine:fixtures:load

that's it ! you should be ready to write your project url in your browser and start working with it. :)
if you have any issue please feel free to contact us.

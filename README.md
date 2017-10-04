# WordsWontDo
Words Won't Do is a service that allows you to simply and easily share 
exquisite videos with your friends and family.

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
 * PHP >= 7.0
 * Git
 * Composer
 * Vagrant
 * Homestead

### Installing
 * First install PHP 7 on your local machine
 * Install [Composer](https://getcomposer.org) for dependency management
 * cd in projects folder and run composer install
 * Download and install [Vagrant](https://www.vagrantup.com/downloads.html)
 * Install and run [Homestead](https://laravel.com/docs/5.5/homestead#introduction)  (you should set up per project installation, Helpful vid https://www.youtube.com/watch?v=YuvHbC3aBaA & https://www.youtube.com/watch?v=52j2r9oXKJw)

* Checkout dev branch in git, then in project folder rename **.env.example** to **.env.**
	$ mv .env.example .env

Start your virtual machine.
	$ vagrant up

Enter your virtual machine.
	$ vigrant ssh

Create your database from virtual machine project directory.
	$ php artisan migrate

Generate Encrypter key from virtual machine project directory.
	$ php artisan key:generate

Now project should be up and running

Pause or stop VM
	$ vagrant halt
	$ vagrant destroy


## Running the tests

## Deployment

La Liga Test
=============

A Symfony 3.2 project.

# Project Title

This project is about a administation panel where manage football clubs and players.
It is place in "dev" environment


## Getting Started

We need some technologies before check the UI of the project.

### Prerequisites

```
Ruby, npm, compass, sasss...
```

Recommended requirements

```
Ubuntu 16.04.1
PHP v7.0.18
Mysql  v14.14

```

### Installing

I have used compass, yui and sass to compile the assetic part

Install ruby dependences
```
sudo apt-get install ruby-full
```

Install Compass

```
sudo gem install compass
```

Install sass

```
sudo gem install sass
```

Install Vendors

```
composer install
```

Install Assets

```
php bin/console assets:install
```

Create database

```
php bin/console doctrine:database:create

php bin/console doctrine:schema:create
```

## Deployment

```
php bin/console ca:cl --env=dev
```

or

```
sudo rm -rf var/cache/* && sudo rm -rf var/logs/*
```

```
php bin/console assetic:dump
```

## Authors

* ** Julián Grande**


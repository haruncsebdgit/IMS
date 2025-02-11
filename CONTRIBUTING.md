# Contribution Guide

## Table of Contents
<!-- MarkdownTOC -->

- [Overview](#overview)
- [Minimum Requirements](#minimum-requirements)
- [Installation: Option 1: with Docker](#installation-option-1-with-docker)
	- [Development Requirements](#development-requirements)
	- [Clone & Make things ready](#clone--make-things-ready)
	- [Install Docker](#install-docker)
	- [Set `.env` file](#set-env-file)
	- [Run artisan commands](#run-artisan-commands)
	- [Run & Setup](#run--setup)
	- [Create the first user \(Administrator\)](#create-the-first-user-administrator)
	- [Run Seeder](#run-seeder)
	- [Set up the site](#set-up-the-site)
	- [Access PHPMyAdmin](#access-phpmyadmin)
	- [Available Docker commands](#available-docker-commands)
- [Installation: Option 2: without Docker](#installation-option-2-without-docker)
	- [Development Requirements](#development-requirements-1)
	- [Clone & Make things ready](#clone--make-things-ready-1)
	- [Set `.env` file](#set-env-file-1)
	- [Set the Encryption Key](#set-the-encryption-key)
	- [Run artisan commands](#run-artisan-commands-1)
	- [Setup](#setup)
	- [Create the first user \(Administrator\)](#create-the-first-user-administrator-1)
	- [Run Seeder](#run-seeder-1)
	- [Set up the site](#set-up-the-site-1)
- [Set environment ready](#set-environment-ready)
- [Documentation](#documentation)

<!-- /MarkdownTOC -->

## Overview

The whole Application/Framework is made ready based on Laravel `v8.27.x`. The heavily dependent 3rd party Laravel packages are:

- `felixkiss/uniquewith-validator`

## Minimum Requirements

The minimum requirements are:

- PHP >= `7.3`
- MySQL >= `5.7`
- Apache >= `2.4`

Additional Requirements can be found under the following links:

- https://laravel.com/docs/8.x/upgrade#php-7.3.0-required

## Installation: Option 1: with Docker

### Development Requirements

You must have the following dev tools installed and active on your dev environment:

- Git and Gitlab Repo access

For the Windows environment, make sure PHP 7 is in your `$PATH`.

### Clone & Make things ready

Open git bash/command console and write down the following command (please change `NATP2` with your desired name). The command will clone the repo locally:

```bash
git clone git@gitlab.com:technovistaltd/natp2/application.git NATP2 && cd NATP2
```

### Install Docker

[Install Docker in Windows](https://docs.docker.com/docker-for-windows/install/)

### Set `.env` file

In command console put:

```bash
cp .env.example .env
```

Open up the `.env` file in a code editor and set:

- the database,
- db user, and
- db password
- db host will be `mysql`

### Run artisan commands

Using Docker download PHP 8, MySQL 8, NodeJS 14, Apache 2.4 image and run their container

```bash
docker-compose up -d
```

In the command console put the following to install dependencies and build the assets up:

```bash
docker-compose exec app composer install
# Set Encryption Key
docker-compose exec app php artisan key:generate
docker-compose exec app npm install
docker-compose exec app npm run dev
docker-compose exec app php artisan migrate
docker-compose exec app php artisan storage:link
```

> **TROUBLESHOOTING**<br>
> If you run any Bash console, and face the following issue:<br>
> `the input device is not a TTY.  If you are using mintty, try prefixing the command with 'winpty'`<br>
> You can add `-T` after `exec` in each of the Docker command

Now make the user role/capabilities ready:

```bash
docker-compose exec app php artisan setadminpermissions
```

and

```bash
docker-compose exec app php artisan setup-application
```

### Run & Setup

Browse the URL (`http://localhost:8080`) in your browser. It should be ready.

### Create the first user (Administrator)

1. Open up the application in your browser to the `/en/register` URL, for example: `http://localhost:8080/en/register`
2. Create your first user (Administrator)

### Run Seeder

In the console, run:

```bash
docker-compose exec app php artisan db:seed
```

### Set up the site

0. Get to the admin panel: `http://localhost:8080/en/admin`
1. Get to the Settings page in Admin Panel and Set up the Application accordingly
2. You can put the registration open, or you can close it from here in the Settings page

### Access PHPMyAdmin

```bash
http://localhost:8183/
```

### Available Docker commands

```bash
# To download PHP 8, MySQL 8, NodeJS 14, Apache 2.4 image and run their containers
docker-compose up -d
# Run composer update
docker-compose exec app composer update
# Run artisan command
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
# Run npm command
docker-compose exec app npm install
# Stop Docker container
docker-compose down
# Display running containers
docker ps
# Display Docker images
docker images
```

### Minimize ram usage due to `vmmem` process
https://stackoverflow.com/questions/62154016/docker-on-wsl2-very-slow
## Installation: Option 2: without Docker

### Development Requirements

You must have the following dev tools installed and active on your dev environment:

- Composer
- Node (`v6.11.5+`) and npm ([Installing npm](https://docs.npmjs.com/getting-started/installing-node))
- Git and Gitlab Repo access

For Windows environment, make sure PHP 7 is in your `$PATH`.

### Clone & Make things ready

Open git bash/command console and write down the following commands (please change `NATP2` as per your choice). The command is a combination of commands that will<br>
(1) clone the repo locally,<br>
(2) install PHP dependencies,<br>
(3) installing npm packages,<br>
(4) build project resources:

```bash
git clone git@gitlab.com:technovistaltd/natp2/application.git NATP2 && cd NATP2 && composer install && npm install && npm run dev
```

### Set `.env` file

In command console put:

```bash
cp .env.example .env
```

Open up the `.env` file in a code editor and set:

- the database,
- db user, and
- db password

### Set the Encryption Key

In command console put:

```bash
php artisan key:generate
```

Open up the `.env` file in a code editor and set:

- the database,
- db user, and
- db password

### Run artisan commands

In command console put:

```bash
php artisan migrate
```

To create Shortcut link to the storage from the public directory

```bash
php artisan storage:link
```

Now make the basic user role/capabilities ready:

```bash
php artisan setadminpermissions
```

and

```bash
php artisan setup-application
```

### Setup

Setup the virtual host and browse the URL in your browser. It should be ready.

### Create the first user (Administrator)

1. Open up the application in your browser to the `/en/register` URL, for example: `http://example.local/en/register`
2. Create your first user (Administrator)

### Run Seeder

In cosole, run:

```bash
php artisan db:seed
```

### Set up the site

0. Get to the admin panel: `http://example.local/en/admin`
1. Get to the Settings page in Admin Panel and Set up the Application accordingly
2. You can put the registration open, or you can close it from here in the Settings page

## Set environment ready

> Get to the Admin panel **System Status page** `http://example.local/en/admin/status` and solve if there is any red marked issue there

## Documentation

Get detailed documentation under `_docs/` directory

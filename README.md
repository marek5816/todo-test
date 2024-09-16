# ToDo test

## Overview
This repository contains a Laravel application for the Amcef test assignment

## Requirements

Before you can run this project, you'll need to have Docker installed.

### Installing Docker

1. **For Windows and macOS:**
   - Visit the [Docker website](https://www.docker.com/get-started) and download the appropriate installer for your operating system.
   - Follow the installation guide provided by Docker to complete the setup.

2. **For Linux:**
   - You can install Docker using your package manager. For most Linux distributions, you can use the following commands:
     ```bash
     sudo apt-get update
     sudo apt-get install docker-ce docker-ce-cli containerd.io
     ```
   - Ensure that Docker is enabled and running by using:
     ```bash
     sudo systemctl enable docker
     sudo systemctl start docker
     ```

After installing Docker, verify the installation by running `docker --version` in your terminal.

## Setup project with docker
Navigate to the project directory, then build and run the containers with ``docker compose up --build``.

For password reset functionality, set up email inside the .env file.

- The web server will run under port ``8005``
- Adminer will run under port ``8085``
- Db username - ``laravel``
- Db password - ``secret`` 

## Running PHPUnit tests
1. Open shell for php container - ``docker exec -it <container_name/id> bash``
2. Run PHPunit tests - ``php artisan test``

## Running Dusk tests
The application is pre-configured to run Dusk tests. However, aside from some basic login test, no other tests have been created.
1. Open shell for php container - ``docker exec -it <container_name/id> bash``
2. Run Dusk tests - ``php artisan dusk``

## To Do
The application can be improved in several ways to enhance its functionality (was sent in email)
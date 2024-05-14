# Disclaimer
This site was created for personal enjoyment in creating it and is not the official website of Penrith Mountain Rescue Team. Please see https://www.penrithmrt.org.uk/

# Background
The project was aimed to recreate the current PenrithMRT website with some added features. It has News Articles, Contact Page, Callouts map (WIP). It is built using Laravel 9, Bootstrap 5, Filament 3 & OS maps API

# How to use
Note: this was developed on a windows machine using WSL2 & docker and as such has a "development" environment built using these tools. It can be setup on any environment you like but this guide will assume you are using the provided `deploy-dev.sh` script and docker. If you are not running it via WSL2 you might need to tweak vite.config.js as the server address is set to work for WSL and any other tweaks may be required

1. Run `./deploy-dev.sh up` to built and start the containers
2. Open a terminal for the main application container;  `docker exec-it penrithmrt-frontend /bin/bash`
    - Set your `DEMO_USER_PASSWORD` in `.env` for the test user account
    - `php artisan key:generate`
    - `php artisan migrate`
    - `npm install`
    - `npm run dev`
3. Add `::1 team.penrithmrt.org.uk` to your hosts file (Or Mac/ Linux equivalent)
4. Navigate to `https://team.penrithmrt.org.uk`
5. You can access the admin panel at `https://team.penrithmrt.org.uk` using the user account `demo@demopenrithmrt.org.uk` and your chosen `DEMO_USER_PASSWORD`

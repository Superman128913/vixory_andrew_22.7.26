## Testing
1. Notifications

    To test general notification functionality, create a new notification. 
        php artisan notification:test 1

    To test saved search notifications.
        a. Create new coach user.
        b. Go to search and perform a generic search that pulls in some users, and then save it.
        c. Generate some new athletes
            php artisan db:seed --class=GenerateAthletes
        d. Process saved searches by running
            php artisan process-saved-search:run

## Installation
Create new folders here:
storage/app/public/tmp
storage/app/credentials/google.json
---
Go to /resources/frontend and compile the projects assets
npm run serve
---
Install composer packages in the root directory
composer install --ignore-platform-reqs
---
Run: 
php artisan key:generate
php artisan migrate
php artisan db:seed
---
Create /resrouces/frontend/.env.development.local
---
php artisan vendor:publish
Select the number corresponding with the VixoryTheme
---
cd ./nova-components/UserApproval
npm install
---
Batch import scout models
php artisan scout:import "App\Models\College"
php artisan scout:import "App\User"
---
Install chrome driver for Browsershot
https://github.com/spatie/browsershot

On MacOS:
npm install puppeteer --global

On Forge server:
curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
sudo apt-get install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget libgbm-dev
sudo npm install --global --unsafe-perm puppeteer
sudo chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium
---
Update nginx config to allow video uploads
server {
    client_max_body_size 100M;
    ...
}
upload_max_filesize = 200M

## ENVIRONMENT VARIABLES
Environment variables are set both by laravel in the traditional location as well as by Vue in the /resources/frontend directory.

## Asset structure
The usual laravel connection between the /public and /storage folders exists. In addition to those folders there
is the /resources folder which contains all of the frontend assets. When compiling, webpack copies over all of the
images to the public folder in addition to the js/css.

## Asset Compliation
In order to compile assets for local development run "npm run watch". This will pull environment variables from both:
.env.development
.env.development.local

.local will take precendent in instances where variables are declared in both.

## Common commands
php artisan saved-search:run 29
php artisan db:seed --class=GenerateAthletes
php artisan process-saved-search

## Run horizon locally
sudo systemctl start redis
php artisan horizon

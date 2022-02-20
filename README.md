
<a href="http://hxd.vn" target="_blank"><img src="public/images/logo.png"></a>


# HXD LaraK

## Overview
Base Laravel with Vuejs Project

## How to setup
**NOTE**  Require finish setting up environment before.

1 - Pull source code
- Clone project's repository inside `laradev/data`
```
cd ~/laradev/data/sites
git clone {repository_url}
```
2 - Enter the project folder, copy and rename `env-example` to `.env`
```
cd ~/{project_folder}
cp env-example .env
```

3 - Config .env, you can create new database via Laradev instruction, default
database is `laravue`
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE={dbname}
DB_USERNAME=larak
DB_PASSWORD=example
```

```
REDIS_HOST=localhost
REDIS_PASSWORD=null
REDIS_PORT=6379
```

9 - Change hosts file
In local machine, Add bellow config to「/etc/hosts」file.
```
# Add domain to hosts
127.0.0.1 yourproject.dev
```

10 - Using composer to install PHP packages
In project folder, run bellow command
```
composer install
```

11 - Using npm to install Node Js packages
In project folder, run bellow command
```
npm ci
```

12 - Generate the application key
In project folder, run bellow command
```
php artisan key:generate
```
13 - Migrate and seeding database
In project folder, run bellow command
```
php artisan migrate --seed
```

14 - Complie js
In project folder, run bellow command
```
npm run dev
```

15 - Link storage to public
In project folder, run bellow command
```
php artisan storage:link
```

16 - Open your browser and visit `https://yourproject.dev/`   
`That's it! enjoy :)`


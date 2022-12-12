

# Laravel Tenant

A Laravel project that handles multi-site application. 

Imagine you are handling different laravel site (https://site1.com, https://site2.com) that shares  the same core components and entities. It is a nightmare a nightmare to make them align with one another in terms of app version and code base. Even if you build a package for it and include that in every single site you have, I'm pretty sure its a tiresome to deploy each and every one of them. 

So here is the catch. This project will handle all of that. That means you only have to deploy once for all the sites you have as they will share the same document root. 
And that means if you add more site, you just need to setup vhost add some config and database entry and there you have it


## Getting Started

Before all of that, we are using Laravel 9 so make sure you have a proper requirements to run this locally whether it will be from Artisan serve, Valet or Docker

Do the basic laravel stuff

    git clone
    
    cp .env.example .env // update the database credentials
    
    composer install
    
    php artisan migrate
    
    php artisan serve


Now you should be able to access the app at http://localhost:8000. Sweet

 Now lets create some Tenant

    php artisan tenant:create --code=fb --name=Facebook --domain=localhost:8000

Notice when you reload the page. The logo is now changed to `Facebook`

Now lets create another Tenant

    php artisan tenant:create --code=yt --name=Youtube --domain=127.0.0.1:8000

Now visit the domain `http://127.0.0.1:8000` and you'll see that the logo is `Youtube` while localhost:8000 is still showing `Facebook`. Nice right?

Now lets try to add some seeds to the app 

    php artisan db:seeed

Now look around scenes and channels page. Notice that for every Tenant, it has its own scenes and channels. 

## Tenant Config
Tenant config are stored under `/config/tenants/{tenant-code}.php`. That means if you open the site at `http://127.0.0.1:8000`
It is loading the `config/tenants/yt.php`. This config will override any `config()` in the app

Example: 

- `config('app.name')` should be `Laravel` as it is written inside `/config/app.php`
- but visiting the app in `http://127.0.0.1:8000` will override that to the `app` array inside `/config/tenants/yt.php`
- this logic will go to any config you set whether it might be `config('queue.connections')` or any other custom config you have added

## Handling Tenant Domains
If you go back to the tenant's config. You will notice there is an array `config('app.domains')`. 
This is what we use to reference what Tenant we should load. 

Therefore If you have the tenant `Youtube` domain set with `127.0.0.1:8000`, Visiting the with the host will load the `Youtube` tenant

`config('app.domains')` is an array. This is so that you can set multiple domains for a specific Tenant

Example:

    - https://youtube.test - local
    - https://youtube.com - production

    'domains' => [
        'youtube.test',
        'youtube.com'
    ],

Enjoy!
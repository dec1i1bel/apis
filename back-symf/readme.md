# App installation
* Create domain "http://apis-back-symf/" on your server. The domain name must be exactly like this for properly working frontend. Root directory must be /public.
* Go to apis/back-symf 
* Create a copy of the ".env.example", name it .env and put your database connection url
* Open your terminal and execute:
```commandline
composer install
php bin/console doctrine:migrations:migrate
pnp bin/console cities:places
```

You may check if app is installed properly. Go to <your_domain>/api/cities, and you are going to see info from wikidata_cities table in json 


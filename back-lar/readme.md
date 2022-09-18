# App installation
* Create domain "http://apis-back-lar/" on your server. The domain name must be exactly like this for properly working frontend.
* Create file .env that is copy of .env.example, and:
  * put parameters of database connection into DB_* strings. Make sure your connection parameters are correct
  * Create account at rapidapi.com and put your X-RapidApi-Key to RAPIDAPI_KEY. 
* Go to apis/back-symf


* Open your terminal and execute:
```commandline
composer install
php artisan key:generate
php artisan migrate
```

Then you should get data from external apis:
```commandline
php artisan cities:basic
```
After that check the "wikidata_cities" table. It should contain several lines

Then get weather of the cities from another api:
```commandline
php artisan cities:weather
```
Check the "city_current_weather" table, it should also contain several lines.

You may check if app is installed properly. Go to <your_domain>/api/cities, and you are going to see info from wikidata_cities table in json 


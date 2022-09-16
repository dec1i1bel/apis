## How to deploy project localy:
### back-lar, back-symf
- install php. project is being developed and tested with php 7.4. It doesn't work with php 8 (it was tested, too).
#### back-lar
- to install Laravel and required packages with composer:
```commandline
cd back-lar
composer install
php artisan key:generate
php artisan migrate
```
### back-py
- install python
- install libraries:
```commandline
pip install requests
pip3 install lxml
pip3 install bs4
```

# test_app

this application using Laravel 8 + Nginx + MySql with docker. So the Idea to prevent minus of stock is using the Reserved Inventory. Every product has reserved qty and it will be decreased when we place an order and we will reduce the qty when the order has been paid then if the order has been cancelled , we will give back the reserved qty of product base on the ordered item qty in order_item tables.

## Installation


```bash

# clone repo
git clone https://github.com/vani071/test_app.git

cd test_app

cp .env.example .env

#run docker compose
docker-compose up -d

#generate key for laravel
docker-compose exec app php artisan key:generate

#generate migration scheme
docker-compose exec app php artisan migrate

#seed product data 
docker-compose exec app php artisan db:seed --class=ProductSeeder

```

## Testing 

```bash
#from root of repo folder please run this command
docker-compose exec app vendor/bin/phpunit tests/Feature/ProductTest.php

```
## Treasure Hunter

```bash
#from root of repo folder please run this command
docker-compose exec app php artisan treasure:hunter

```
## API documentation

please import postman collection file to try the API `test app.postman_collection.json` 

flow:
- hit get product list API to get SKU in the response of API
- hit add product to cart to get order ID. you can use order ID in body with "order_id" parameter to make multiple item in one order.
- hit checkout API to convert cart to order. you can use product list API to check the reserved qty already decreased or not
- hit cancel order API to bring back reserved qty or hit pay order API to decrease qty of product
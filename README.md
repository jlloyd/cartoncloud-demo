## Installation Steps

git clone git@github.com:jlloyd/cartoncloud-demo.git

[Install SQLite if needed]
apt-get install sqlite
apt-get install php-sqlite3

cp .env.example .env

edit  .env
add absolute path for sqlite db to DB_DATABASE 

add the following keys to
PURCHASE_ORDER_API=https://api.cartoncloud.com.au/CartonCloud_Demo/PurchaseOrders/
PURCHASE_ORDER_USERNAME=
PURCHASE_ORDER_PASSWORD=


./artisan migrate --seed

[sudo] ./artisan serve --port=80


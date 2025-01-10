#!/bin/bash

# Set directory permissions
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

echo "Welcome to School Payment installation"

echo "Please enter key"

read key

echo "Please enter Cipher"

read cipher

php artisan down

php artisan env:decrypt --key $key --cipher $cipher

# Edit .env file
echo "Enter Database Username"
read Username
echo "Enter Database Password"
read Password
echo "Enter Database Name"
read Database

# Replace placeholders in .env file with actual values
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$Password/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$Username/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$Database/" .env

echo "Database Connection has been updated."

# Edit .env file
echo "Enter Dapodik Server"
read ServerDapodik
echo "Enter Dapodik Server Port"
read ServerPortDapodik
echo "Enter Dapodik Token"
read Token
echo "Enter School NPSN"
read NPSN

# Replace placeholders in .env file with actual values
sed -i "s/DAPODIK_SERVER_IP=.*/DAPODIK_SERVER_IP=$ServerDapodik/" .env
sed -i "s/DAPODIK_SERVER_PORT=.*/DAPODIK_SERVER_PORT=$ServerPortDapodik/" .env
sed -i "s/DAPODIK_SERVER_NPSN=.*/DAPODIK_SERVER_NPSN=$NPSN/" .env
sed -i "s/DAPODIK_SERVER_Token=.*/DAPODIK_SERVER_Token=$Token/" .env

echo "Dapodik Connection has been updated."

php artisan migrate

echo "Enter Admin Name"
read AdminName
echo "Enter Admin Email"
read AdminEmail
echo "Enter Admin Password"
read AdminPassword

php artisan admin:new $AdminName $AdminEmail $AdminPassword

php artisan up

echo "Laravel installation is complete."

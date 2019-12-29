# l6-docker-redis quick start

These are the quick steps to setup `l6-docker-redis` project

Comes with [Docker](https://www.docker.com/) [Steps](#Installation) and [Local Setup Instructions](#Requirements-To-Run-Locally):
- l6_app: `Laravel/PHP-7.2`
- l6_nginx: `Nginx:1.10`
- l6_redis: `Redis:3.0-alpine`

## Installation
- `git clone https://github.com/NazmusShakib/l6-docker-redis.git`
- `cd l6-docker-redis`
- `docker-compose up -d`
- `docker-compose exec l6_app composer install && cp .env.example .env && docker-compose exec l6_app php artisan key:generate`

Now that all containers are up.

#### l6_app URL- [127.0.0.1:8081](http://127.0.0.1:8081)


## API Endpoints

Here I have used Redis store to store data with TTL(5 minutes). Use [Postman](https://www.getpostman.com/), [Insomnia](https://insomnia.rest/) or any rest client to access endpoints.

### ```GET /values```
Get all the values of the store.

response: ```{key1: value1, key2: value2, key3: value3...}```

### ```GET /values?keys=key1,key2```
Get one or more specific values from the store and also reset the TTL of those keys.

response: ```{key1: value1, key2: value2}```

### ```POST /values```
Save a value in the store.

request: ```{key1: value1, key2: value2..}```
response: whatever’s appropriate

### ```PATCH /values```
Update a value in the store and also reset the TTL.

request: ```{key1: value1, key2: value2..}```
response: whatever’s appropriate

---

**To stop docker containers:** ```docker-compose kill```


---


Requirements To Run Locally
============

* PHP >= 7.2
* cURL, mcrypt, zip, unzip, libmcrypt-dev, git Extensions
* [redis](https://redis.io/)
* [composer](https://getcomposer.org/)

Installation
============
**TL;DR command list**

    git clone https://github.com/NazmusShakib/l6-docker-redis.git
    cd l6-docker-redis
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct redis connection information before running**

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000


Use the above [API Endpoints](#API-Endpoints) to access all routes 

## Questions and Improvements

For any question or emprovement please send an e-mail to Nazmus Shakib [nshakib.se@gmail.com](mailto:nshakib.se@gmail.com).

## License

NazmusShakib©2019 licensed under the [MIT license](https://opensource.org/licenses/MIT).

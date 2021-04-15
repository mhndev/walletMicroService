### Wallet microservice

#### API DOC

you can find postman.json file in project root directory, so you can test and see all API endpoints by importing that file in your postman

#### Tests

you can run all tests by just running following command:

```
php artisan test
```

just remember to add needed changes to the following files

```
.env
.env.testing
```

#### Docker

this project is dockerized so you can simply run following command while in your terminal you're in the root project directory, to up and run project:

```
docker-compose up -d
```

after this you should run migrations, for this purpose please run following command:

```
docker-compose exec wallet_app php artisan migrate
```

to see sum of all transaction logs run following command:

```
docker-compose logs -f wallet_scheduler
```

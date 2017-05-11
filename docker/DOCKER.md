There are two main docker-compose files. One for production and one for development. 
As the name implies, docker-compose-prod.yml, is executed in a production environment. The
main difference between the production docker compose is the seperation between the mariadb
docker as we want to be able to keep the mariadb container run even if we were to bring
down the app container.

For development everything is self-contained for easy of use, so to run simply type:
```
cd docker
docker-compose up
```

As for production, to run the db container:
```
cd docker/mariadb
docker-compose up
```

And then for the app containers:
```
cd docker
docker-compose up
```
![Re:Nyaa](renyaalogo-nobg.png)

# Re:Nyaa [![Build Status](https://semaphoreci.com/api/v1/renyaa/nyaapantsu/branches/master/badge.svg)](https://semaphoreci.com/renyaa/nyaapantsu)

Think of this as a public library for all things VN and anime related. It is a digital library that is open to everyone, forever; it is a historical artifact, and is a gift each generation imparts to the next.

## Requirements:
Webserver with PHP and SQLITE support (e.g. [XAMPP](https://www.apachefriends.org/index.html))

## Installation
1. Download project files (Clone or download > zip) and unzip them to htdocs for XAMPP
2. Obtain a database file for importing into the server.
3. Start the server (xampp-manager) and find the website at [http://localhost:80/](http://localhost:80/)
4. There you go!

PS. If [http://localhost:80/](http://localhost:80/) does not work try [http://localhost:8080/](http://localhost:8080/)

## Docker

We now have integrated [docker](https://www.docker.com/) into our project for ease of development and deployment.

1. Install docker [here](https://www.docker.com/)
2. Download the latest project files [here](https://github.com/renyaa/renyaa/archive/master.zip)
3. Make sure you have the DB dumps (`nyaa.db`)
4. Run `cd docker`
4. Run `docker-compose up`
5. Go to: http://localhost:8080

Done!

## Contributing
You can find how to contribute on the [CONTRIBUTING.md](./CONTRIBUTING.md) page.

## Planned work or features
Head over to [TODO.md](./TODO.md) page for more information.


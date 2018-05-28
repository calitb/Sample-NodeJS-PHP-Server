# Docker Website

Runs an Apache docker that connects to a MySQL docker. For database management there's also a Adminer docker ready to use. 

### Requirements

* Install [DockerToolbox](https://docs.docker.com/toolbox/toolbox_install_mac/)
* Install [VirtualBox](https://www.virtualbox.org)


For Convenience add `192.168.99.100  local-dev` to your `/etc/hosts`

### Start Container

```
docker-compose up --build -d
```

##### Run the App

Open [http://local-dev:32770]() to see the website. 
The changes in `/php/src` will be reflected in the app.


Add your [PHPUnit](https://phpunit.readthedocs.io/en/7.1/index.html) tests in `/php/src`. To run the tests open the url [http://local-dev:32770/test]().


### Enter Container CLI

```
docker exec -it app-php bash
docker exec -it app-mysql bash
docker exec -it nodejs /bin/ash
```

### Enter Container Database

Open [http://local-dev:32771]() to manage the database with Adminer. 


If you have MySQL in your host machine, you can do in the terminal:

```
mysql -u {user} -p -h 192.168.99.100
```

You can also enter the mysql container CLI first and then access mysql:

```
docker exec -it app-mysql mysql -u {user} -p
```


the user and password are configured in the `./env` file.

server=`myDB`, user=`calitb`, password=`12345`, database=`test`.

### Stop Container


Stop and destroy the containers:

```
docker-compose down
```

Stop containers, but keep them for reuse:

```
docker-compose stop
```


## NodeJS Demo

A sample NodeJS Server is running in [http://local-dev:32774/]()

#### Used Packages
`coffeescript`: This server supports vanilla Javascript (.js) and also Coffeescript (.coffee) files. 
`express`: Minimal and flexible Node.js web application framework that provides a robust set of features.
`body-parser`: Used to parse the params coming through the `body` variable.

### Files

* `index.js`: Enables CoffeeScript and includes the `app.js` file.
* `app.js`: Starts `express` and defines two main routes:  `/` and `/coffeeScript`
* `routesCoffee.coffee`: Defines the routes for the path `/coffeeScript`.
* `routes.js`: Defines the routes for the path `/`.

### Examples:

Javascript:

```
//GET
curl http://local-dev:32774/?var1=1&var2=2

//GET with subpath
curl http://local-dev:32774/someValue?var1=1&var2=2

//POST
curl http://local-dev:32774/ -d "var1=1&var2=2"

//POST with subpath
curl http://local-dev:32774/someValue -d "var1=1&var2=2"
```

CoffeeScript:

```
//GET
curl http://local-dev:32774/coffeeScript/?var1=1&var2=2

//GET with subpath
curl http://local-dev:32774/coffeeScript/someValue?var1=1&var2=2

//POST
curl http://local-dev:32774/coffeeScript -d "var1=1&var2=2"

//POST with subpath
curl http://local-dev:32774/coffeeScript/someValue -d "var1=1&var2=2"
```









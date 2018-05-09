# Docker Website

Runs an Apache docker that connects to a MySQL docker. For database management there's also a Adminer docker ready to use. 

### Requirements

* Install [DockerToolbox](https://docs.docker.com/toolbox/toolbox_install_mac/)
* Install [VirtualBox](https://www.virtualbox.org)


For Convenience add `192.168.99.100  local-dev` to your `/etc/hosts`

### Login to Docker hub

To be able to access the registry, you must first login to [HubDocker](https://hub.docker.com):

```bash
docker login
```

Just type your username and password and you will be set.

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
```

### Enter Container Database

Open [http://local-dev:32771]() to manage the database with Adminer. 


If you have MySQL in your host machine, you can do in the terminal:

```
mysql -u {user} -p -h 192.168.99.100
```

You can also enter the mysql container CLI first and then access mysql:

``
docker exec -it app-mysql bash
mysql -u {user} -p
```


the user and password are configured in the `./env` file.

server=`db`, user=`calitb`, password=`12345`, database=`test`.

### Stop Container


Stop and destroy the containers:

```
docker-compose down
```

Stop containers, but keep them for reuse:

```
docker-compose stop
```
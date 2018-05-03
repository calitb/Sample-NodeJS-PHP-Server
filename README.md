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


### Enter Container Database

Open [http://local-dev:32771]() to manage the database with Adminer. Or use the terminal:

```
mysql -u {user} -p -h 192.168.99.100
```

the user and password are configured in the `./env` file.

server=`db`, user=`calitb`, password=`12345`, database=`test`.

### Enter Container CLI

```
docker exec -it app-php bash
```

### Stop Container

```
docker-compose down
```
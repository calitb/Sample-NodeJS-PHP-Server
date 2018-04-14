# Docker Website

Runs an Apache docker that connects to a MySQL docker. For database management there's also a Adminer docker ready to use. 

### Requirements

 - Docker >= 1.10 : [Installation Instructions Linux](https://docs.docker.com/linux/step_one/) [Installation Instructions Mac](https://docs.docker.com/mac/step_one/)
 - Docker Compose >= 1.6.2 [Installation Instructions](https://docs.docker.com/compose/install/)

### Running the app

#### Step 1: Login to Docker hub
To be able to access the registry, you must first login:

```bash
docker login
```
Just type your username and password and you will be set.

#### Step 2: Configuration

Set the MySQL params and Adminer theme in the `.env` file, Or leave it as it is.

#### Step 3: Launch the containers

Execute the following command:

```bash
docker-compose up
```

#### Step 4: Run the App

Open [http://localhost:32770]()

#### Step 5: Run Adminer to manage the database

Open [http://localhost:32771](http://localhost:32771)

#### Step 6: Make changes

The changes in `/php/src` will be reflected in the app.

#### Step 7: Add tests

Add your [PHPUnit](https://phpunit.readthedocs.io/en/7.1/index.html) tests in `/php/src`. To run the tests execute `/php/src/runtests` or open the url [http://localhost:32770/test.php](http://localhost:32770/test.php).

#### Access the database through the terminal

```shell
mysql -u calitb -P 13306 -h 127.0.0.1 -p
```

The default password is `12345`, and database is `test`.

#### Access a container terminal

List your containers:

```shell
docker ps
```

Access:

```bash
docker exec -it {container-name} bash
```

#### Stop the containers

Execute the following command:

```bash
docker-compose down
```





# Important!!

When accessing the services inside the containers you need to use the `links` defined in the `/docker-compose.yml` file. 

For example,

When running adminer [http://localhost:32771](), in `server` you need to use `db`, because that's how it is defined: `links: - mysql:db`. 

To access `mysql` inside the `php` container you do for example `$conn = new mysqli('db', ...)`, because that's how it is defined: `links: - mysql:db`.

The following are the defined links:

- `db`: links to `mysql`, available for `php` and `adminer`
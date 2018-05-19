'use strict';

const app = require('express')();
const bodyParser = require('body-parser');

app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); //support encoded bodies

// Define main routes
app.use('/', require('./routes/routesJS'));
app.use('/coffeeScript', require('./routes/routesCoffee'));

app.listen(3000,  () =>  {
  console.log('App listening on port 3000!');
});

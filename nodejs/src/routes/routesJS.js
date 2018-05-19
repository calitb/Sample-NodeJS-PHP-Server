const express = require('express');

const router = express.Router();

router.get('/', (req, res) =>  {
    const params = formatParams(req.query);
    const method = req.method;
    res.send(`Hello World from Javascript! (${method}) ${params}`);
});

router.get('/:someValue', (req, res) =>  {
    const params = formatParams(req.query);
    const method = req.method;
    const someValue = req.params.someValue;
    res.send(`Hello World from Javascript! (${method}) ${someValue}${params}`);
});

router.post('/', (req, res) =>  {
    const params = formatParams(req.body);
    const method = req.method;
    res.send(`Hello World from Javascript! (${method}) ${params}`);
});

router.post('/:someValue', (req, res) =>  {
    const params = formatParams(req.body);
    const method = req.method;
    const someValue = req.params.someValue;
    res.send(`Hello World from Javascript! (${method}) ${someValue}${params}`);
});

formatParams = (params) => {
    var str = '<br /><br />List of Params:<br />';
    const keys = Object.keys(params);
    
    keys.map((key)=>{
        const value = params[key];
        str += `${key} = ${value}<br />`;
    });

    return str;
}

module.exports = router;
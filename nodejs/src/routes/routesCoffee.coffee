express = require 'express'
module.exports = router = express.Router()

router.get '/', (req, res) ->
    params = formatParams req.query
    method = req.method
    res.send "Hello World from CoffeeScript! (#{method}) #{params}"

router.get '/:someValue', (req, res) ->
    params = formatParams req.query
    method = req.method
    someValue = req.params.someValue
    res.send "Hello World from CoffeeScript! (#{method}) #{someValue}#{params}"

router.post '/', (req, res) ->
    params = formatParams req.body
    method = req.method
    res.send "Hello World from CoffeeScript! (#{method}) #{params}"

router.post '/:someValue', (req, res) ->
    params = formatParams req.body
    method = req.method
    someValue = req.params.someValue
    res.send "Hello World from CoffeeScript! (#{method}) #{someValue}#{params}"

formatParams = (params) ->
    str = '<br /><br />List of Params:<br />'
    keys = Object.keys params
    
    keys.map (key) ->
        value = params[key]
        str += "#{key} = #{value}<br />"

    return str;
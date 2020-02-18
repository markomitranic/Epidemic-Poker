const getenv = require('getenv');
const express = require('express');
const app = express();
const shardResolver = require('./ShardResolver');
const port = getenv.int('HTTP_PORT');

app.get('/', (req, res) => {
    shardResolver.resolve(req, res);
});
app.listen(port, () => console.log(`Listening on port ${port}!`));
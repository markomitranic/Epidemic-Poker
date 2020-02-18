const getenv = require('getenv');
const express = require('express');
const app = express();
const shardResolver = require('./ShardResolver');
const port = getenv.int('HTTP_PORT');

app.get('/', (request, response) => {
    const shardName = shardResolver.resolve();

    response.setHeader('Content-Type', 'application/json');
    response.send({
        'success': true,
        'delegatedShard': shardName
    });
});

app.listen(port, () => console.log(`Listening on port ${port}!`));
# Epidemic Poker
A Collaborative planning app! This repository contains a practice task based on the planning poker gamification technique. The containerized project is ready to run on Mac and Linux. Windows support depends on Docker compatibility and is out of our hands. Requirements as shown below.

## Game Rules

In order to estimate how complex a task is for a team of developers to complete, a common technique that is used is called "planning poker".
- Each developer gets to vote on a task by giving their estimate as a point.
- The set of points you can cast your vote on is usually a predefined set of arbitrary numbers, something like this: 0, 1/2, 1, 2, 3, 5, 8, 13.
- The higher the number, the more complex the task is to complete.

When everyone has cast their votes, the team can have a discussion about what points the different team members have given to a task.

This application should allow the team members to vote on a "task" and visualize the results of the vote in real-time.

The users of the application should be able to do the following:
- Create a poll. A user creates a poll and can share this with other people (this could for example be a code or a link).
- Join a pre-existing poll created by you or someone else. You should be able to cast your vote on different points in a predefined set (0, 1/2, 1, 2, 3, 5, 8, 13). A user can only vote once, but is permitted to change their vote.
- Visualize the results in real-time of a poll: Anyone should be able to see the results of a poll. If user A is casting a vote "2", user B should in real-time be able to see that the point "2" has a value of 1.

## Technical details
The project is a set of Docker containers, orchestrated via `docker-compose`. Other orchestrators might be used but are out of scope of this project. 

### Initial build
The first thing to do is to copy and customize environment values in `.env.dist`. In the present setup ENV is used for secret management as well, although this can be extended with propper system if needed.

With nothing out of the ordinary, a simple `docker-compose build && docker-compose up` should spin everything up. For ease of use, i have attached a `./deploy.sh` as well as `./deploy_dev.sh` script. Once up and running, the application is awailable at port 8080, and ready to be proxied further.

## Service Architecture && Talk Protocol
Talking protocol is based on tuples with the first member describing the name of the message (similar to route) and the second the body of the message.

*GS says:*
- `{title:'sessionChange', payload: { 'cookieName': (string), 'token': (string) }}` A session token change has occured. This happens only once per connection and server the purpose to prevent auth race conditions.
- `{title:'authSuccess', payload: { 'cookieName': (string) }}` An existing session is authentificated. This happens instead of `sessionChange` if the client provided a valid token. 
- `{title:'error', payload: { 'originalMessage': (array), 'errorMessage': (string), 'errorCode': (int) }}` An error occured.
- `{title:'initialState', payload: { 'roomId': (string), 'clientName': (string), 'type': (string), 'currentRound': (int) 'results': (array)[(object[]){name: (string), value: (float)}] }}` Sent after the client joins a room.
- `{title:'voteChange', payload: { 'roomId': (string), value: (float), name: (string) }}` Someone has voted into this room.
- `{title:'coffeeBreak', {roomId: (string), clientName: (string)}` A room member has asked everyone to go on a coffee break.

*Client says:*
- `{title:'create', payload: { 'type': (string) }}` Create a new room.
- `{title:'join', payload: { 'roomId': (string) }}` Ask to join a specific room.
- `{title:'leave', payload: { 'roomId': (string) }}` Leave a room.
- `{title:'vote', {roomId: (string), value: (float)}` Cast a vote to the room.
- `{title:'coffeeBreak', {roomId: (string), clientName: (string)}` A room member has asked everyone to go on a coffee break.

### Scaling
Since docker-compose does not support scaling or autoscaling anymore, the only way to scale the number of GS instances/shards is to duplicate the GS service blocks within the docker-compose configuration.
If you are omitting docker-compose in favor of using Docker CLI directly, you can spin up multiple shards manually, but you must add the appropriate and unique shard names to each one, via `SHARD_NAME` vars. As a future prospect, a superpowered orchestrator like k8s or terraform can be implemented, and should be able to handle scaling without any changes to the codebase.

In this example, i have manually set up two shards with a round robin balancing. The balancing is only performed during room creation. 

*Nginx load-balancing*

Additionally, in order for proxy to recognize the new services and load balance them, `gateway/shards-map.conf` must be edited with the same info.
This can also be edited on-the-fly by manual changes to `/etc/nginx/conf.d/shards-map.conf` and reloading nginx conf `nginx -s reload` from within the container.

At a later date, a more appropriate load balancer may be added easily, since nginx does not support hot ENV var replacement.
Alternatively, `envsubst` may be used as a future prospect, if hot-scaling is not needed.

## Known issues

### Bugs
- After room rejoin (pare reload for example), the vote button is not selected, if i have already voted.
- In certain scenarios (multiple chrome windows open), GS seems to stop sending updates to the clients. It seems to be related to the way reactPHP handles socket operation batching, although i am way too sleepy to deal with that.

### Features
- Scaling and load balancing is a pain. It can be done via env vars, i am sure of it.
- GS already supports it. Front does not.
- Navigation list of joined rooms should be persisted in localstorage or cookie.
- Re-check 12-factor methodology, we may have strayed off.
- Frontend needs a smoother loading animation
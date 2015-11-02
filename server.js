var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis(6379, '176.58.96.224');

redis.subscribe('test-channel', function(err, count) {
	//
});

io.on('connection', function(socket) {
  	console.log('a user connected');

  	socket.on('message', function(message) {
    	console.log('server received message: ' + message);
    	io.emit('test-channel:Test', 'message in message');
	});

	socket.on('test-channel:Test', function(message) {
    	console.log('server received message: ' + message);
    	io.emit('test-channel:Test', message);
	});
});

//io.set('transports',['xhr-polling','jsonp-polling']); apply this if websocket is failing to connect on modern browsers
redis.on('message', function(channel, message) {
	console.log('Message received!');

	message = JSON.parse(message);
	io.emit(channel + ':' + message.event, message.payload);
});

http.listen(3000, function() {
	console.log('Listening on *:3000');
});
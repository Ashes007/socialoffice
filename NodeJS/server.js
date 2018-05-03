var http 		= require("http");
var server 		= http.createServer();
var io 			= require('socket.io')(server);
var redis 		= require('redis');

server.listen(9002, function(){
  console.log("Server connected...");
});
var cnt = 1;
io.on('connection', function (socket) {
 
  console.log("new client connected");
  console.log(cnt++);
  var redisClient = redis.createClient();
  redisClient.psubscribe('*', function(socket) {});
  //redisClient.subscribe('redis_message');
 
  redisClient.on("pmessage", function(pattern,channel, message) {
    console.log("mew message in queue "+ message + "--" + channel);
    socket.emit(channel, message);
  });
 
  socket.on('disconnect', function() {
    cnt--;
  	console.log('Client disconnected.....');
    redisClient.quit();
  });
 
});
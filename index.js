var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static(__dirname));
app.get('/', function(req, res){
  res.sendfile('index.html');
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});

var Twit = require("twit");
var T = new Twit({
  consumer_key: "K0v4N9SwMjVDmbxcuF97WPZcy",
  consumer_secret: "CNkhoLBGzR5xXP5v4v4NXywjMXFWJS6xrOPq00XehdCgGyOYXk",
  access_token: "770973461728690177-1Xip2lk5fIzTkNci4OuwMtyyldCMeix",
  access_token_secret: "6I5jqHtEocJHTuMQRzeSzaJNNDsVtfYk3yWKTvqUSYexf",
  timeout_ms: 60000
});

var stream = T.stream("statuses/filter", {
    track: "#wtc_request"
});

stream.on("tweet", function(status) {
    // console.log({
    //     name: status.user.screen_name,
    //     text: status.text,
    //     created_at: status.created_at,
    // });

    io.emit("tweet", {
        username: status.user.screen_name,
        name: status.user.name,
        text: status.text,
        created_at: status.created_at,
    });
});

var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);


var gpio = require('rpi-gpio');

gpio.setup(21, DIR_OUT, write);

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
    track: "#wtcblink"
});

stream.on("tweet", function(status) {
     console.log({
         name: status.user.screen_name,
         text: status.text,
         created_at: status.created_at,
         
    });

var myArr = status.text.split(' ')

    for (var i = 0; i < myArr.length; ++i) {
      if (myArr[i] == 'on') {
        console.log('on')
        gpio.setup(21, DIR_OUT, write);
        function write() {
          gpio.write(21, true, function(err) {
            if (err) throw err;

          });
        }
      }
      console.log('value at index [' + i + '] is: [' + myArr[i] + ']');
    }

    io.emit("tweet", {
        username: status.user.screen_name,
        name: status.user.name,
        text: status.text,
        created_at: status.created_at,
    });
});

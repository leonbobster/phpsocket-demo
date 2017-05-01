var app = require('http').createServer(function (request, response) {});
var io = require('socket.io')(app);

app.listen(2021);

io.on('connection', function (socket) {
    socket.on('start', async function (msg) {
        console.log('started ' + msg.id);
        var i = 0;
        while (i <= 100) {    
            var handler = (function (i) {
                return function () { 
                    socket.emit('progress' + msg.id, {progress: i});
                };    
            })(i);
            setTimeout(handler, (i / 5) * 1000);
            i += 5;
        }
    });    
});


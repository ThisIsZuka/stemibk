"use strict";

var socket = require('socket.io');

var express = require('express');

var app = express();

var server = require('http').createServer(app);

var io = socket.listen(server);
var port = process.env.PORT || 9900;
server.listen(port, function () {
  console.log('Server listening at port %d', port); // setTimeout(3000);
});
app.get('/room', function (req, res) {
  res.status(200).render('room', {
    success: true
  });
}); // // io.on('test', function (data) {
// //   socket.on( 'notidoctor', function(data) {
// //     console.log(data);
// //     io.sockets.emit('notidoctor',{
// //       id:data.id
// //   })
// // })
// });

io.on('connection', function (socket) {
  console.log(socket.id);
  socket.on('chat', function (data) {
    console.log(data);
    io.sockets.emit('chat', {
      name: data.name,
      lastname: data.lastname,
      pt_name: data.pt_name,
      pt_id: data.pt_id,
      hos_name: data.hos_name,
      pt_gender: data.pt_gender
    });
  });
  socket.on('notidoctor', function (data) {
    console.log(data);
    io.sockets.emit('notidoctor', {
      id: data.id
    });
  });
  socket.on('doctorconf', function (data) {
    console.log(data.ptid);
    io.sockets.emit('doctorconf', {
      text: data.text,
      ptid: data.ptid
    });
  });
  socket.on('doctorcancel', function (data) {
    console.log(data.ptid);
    io.sockets.emit('doctorcancel', {
      text: data.text,
      ptid: data.ptid
    });
  });
  socket.on('amlsend', function (data) {
    console.log(data);
    io.sockets.emit('amlsend', {
      text: data.text,
      idambulance: data.idambulance,
      name: data.name
    });
  });
  socket.on('chatroom', function (data) {
    io.sockets.emit('chatroom', {
      hos_us: data.hos_us,
      hos_us_name: data.hos_us_name,
      hos_des: data.hos_des,
      message: data.message
    });
  });
  socket.on('res', function (data) {
    io.sockets.emit('res', {
      name: data.name,
      lastname: data.lastname,
      btn: data.btn
    });
  });
});
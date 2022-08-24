<?php

$server = new Swoole\Websocket\Server('127.0.0.1', 80);

$server->on('start', function ($server) {
	echo "Websocket Server is started at ws://127.0.0.1:9502\n";
});

$server->on('open', function($server, $req) {
	echo "connection open: {$req->fd}\n";
});

$server->on('message', function($server, $frame) {
	echo "received message: {$frame->data}\n";
	$server->push($frame->fd, json_encode(['hello', 'world']));
});

$server->on('close', function($server, $fd) {
	echo "connection close: {$fd}\n";
});

$server->start();
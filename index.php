<?php

require_once __DIR__ . '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

// listen port 2021 for socket.io client
$io = new SocketIO(2021);
$io->on('connection', function ($socket) use ($io) {
    $socket->on('start', function ($msg) use ($io) {
        $worker = new MyWorker($msg['id'], $io);
        $worker->run();
    });
});
Worker::runAll();

class MyWorker
{
    private $id;
    private $socket;

    public function __construct($id, SocketIO $socket)
    {
        $this->socket = $socket;
        $this->id = $id;       
    }

    public function run()
    {
        $i = 0;
        while ($i <= 100) {
            $this->socket->emit('progress' . $this->id, ['progress' => $i]);
            sleep(1); 
            $i += 5;   
        }       
    }    
}

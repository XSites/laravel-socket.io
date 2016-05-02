<?php
/**
 * @author Anton Pavlov <anton@xsites.co.il>
 * @copyright xsites.co.il
 * @company xsites
 */

namespace Xsites\LaravelSocketIO;

use Illuminate\Contracts\Broadcasting\Broadcaster;
use Exls\SocketIOEmitter\Emitter;

/**
 * Class SocketIOBroadcaster
 * @package Xsites\LaravelSocketIO
 */
class SocketIOBroadcaster implements Broadcaster
{
    /**
     * @var Emitter
     */
    protected $emitter;

    /**
     * SocketIOBroadcaster constructor.
     * @param Emitter $emitter
     */
    function __construct(Emitter $emitter) {
        $this->emitter = $emitter;
    }

    /**
     * Broadcast the given event.
     *
     * @param  array $channels
     * @param  string $event
     * @param  array $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
        //$event contains the class name. So, we will use channel as event names
        foreach ($channels as $channel) {
            $this->emitter->emit($channel, $payload);
        }
    }
}
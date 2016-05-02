Laravel Socket.io Broadcaster
=============

## Installation

Pull this package in through Composer.

```sh
    composer require xsites/laravel-socket.io
```


### Laravel 5.* Integration

Add the service provider to your `config/app.php` file:

```php

    'providers'  => array(

    //...
    Xsites\LaravelSocketIO\Providers\SocketIOServiceProvider::class,

),

```

### Configuration

Add the broadcaster to your `config/broadcasting.php` file:

```php

    // Set here the new broadcast connection
    'default' => 'socket-io',
    
    //...

    'connections' => [

        // Add additional connection for socket.io broadcaster
        'socket-io' => [
            'driver' => 'socket.io',
            'redis' => [
                //set the redis connection
                'connection' => 'default',
            ],
        ],
        //...

    ],
```

## Usage

See the official documentation https://laravel.com/docs/5.1/events#broadcasting-events

### Example

```php
    
    class Test extends Event implements ShouldBroadcast
    {
        /**
         * @var array
         */
        public $data;
    
        /**
         * Create a new event instance.
         *
         * @param mixed $data
         */
        public function __construct($data)
        {
            $this->data = $data;
        }
    
        /**
         * Get the channels the event should be broadcast on.
         *
         * @return array
         */
        public function broadcastOn()
        {
            return ['test-channel-name'];
        }
    }
    
    ...
    //In your BLL
    Event::fire(new Test(['param1' => 'value'1]));
    //
    Event::fire(new Test(123));
    
```
## Contact

Anton Pavlov

- Email: anton@xsites.co.il
<?php
/**
 * @author Anton Pavlov <anton@xsites.co.il>
 * @copyright xsites.co.il
 * @company xsites
 */
namespace Xsites\LaravelSocketIO\Providers;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use Exls\SocketIOEmitter\Emitter;
use Xsites\LaravelSocketIO\SocketIOBroadcaster;
use Xsites\LaravelSocketIO\Constants;

/**
 * Class SocketIOServiceProvider
 * @package Xsites\LaravelSocketIO\Providers
 */
class SocketIOServiceProvider extends ServiceProvider
{
    /**
     * Extend broadcast manager
     */
    public function boot() {
        //publish
        $this->publishes([
            //%1$ - __DIR__
            //%2$ - DIRECTORY_SEPARATOR
            //%3$ - tag config name
            sprintf('%1$s%2$s..%2$s%3$s%2$s%3$s.php', __DIR__, DIRECTORY_SEPARATOR, Constants\Common::TAG_CONFIG)
            => base_path(sprintf('%s%s%s.php', Constants\Common::TAG_CONFIG, DIRECTORY_SEPARATOR, Constants\Common::T_NAMESPACE))
        ], Constants\Common::TAG_CONFIG);

        //extend broadcast manager
        app(BroadcastManager::class)->extend(/*driver*/'socket.io', function ($app) {
            $config = $app['config'];
            //init socket.io broadcaster
            return new SocketIOBroadcaster(
                //see isms/socket.io-emitter package
                new Emitter(
                    //Redis Client
                    Redis::connection($config->get('broadcasting.connections.socket\.io.redis.connection', 'default')),
                    //Emitter Prefix
                    $config->get(sprintf('%s.emitter.prefix', Constants\Common::T_NAMESPACE), Constants\Common::EMITTER_PREFIX)
                )
            );
        });

    }

    /**
     * Register the service provider.
     *
     * @return  void
     */
    public function register() {
        $this->mergeConfigFrom(
            //%1$ - __DIR__
            //%2$ - DIRECTORY_SEPARATOR
            //%3$ - tag config name
            sprintf('%1$s%2$s..%2$s%3$s%2$s%3$s.php', __DIR__, DIRECTORY_SEPARATOR, Constants\Common::TAG_CONFIG),
            Constants\Common::T_NAMESPACE
        );
    }
}

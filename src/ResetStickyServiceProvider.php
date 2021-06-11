<?php

namespace RingierIMU\ResetSticky;

use Illuminate\Foundation\Application;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ResetStickyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            Looping::class,
            function ($event) {
                /** @var Application $container */
                $container = app();
                if (!$container->resolved('db')) {
                    return;
                }

                foreach ($container->make('db')->getConnections() as $connection) {
                    $connection->forgetRecordModificationState();
                }
            }
        );
    }
}

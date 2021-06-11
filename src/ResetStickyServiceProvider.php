<?php

namespace RingierIMU\ResetSticky;

use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ResetStickyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            JobProcessing::class,
            function ($event) {
                if ($event->job->getQueue() === 'sync') {
                    return;
                }

                /** @var \Illuminate\Container\Container $container */
                $container = $event->job->getContainer();
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

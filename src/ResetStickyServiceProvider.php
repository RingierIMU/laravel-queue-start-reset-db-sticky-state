<?php

namespace RingierIMU\ResetSticky;

use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ResetStickyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->booting(
            function () {
                Event::listen(
                    JobProcessing::class,
                    function ($event) {
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
        );
    }
}

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
                    function () {
                        DB::connection()->forgetRecordModificationState();
                    }
                );
            }
        );
    }
}

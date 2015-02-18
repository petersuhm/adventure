<?php

namespace Adventure\Events;

use League\Container\ServiceProvider;
use League\Event\Emitter;

class EventServiceProvider extends ServiceProvider
{
    protected $provides = [
        'emitter',
    ];

    public function register()
    {
        $this->getContainer()->singleton('emitter', function()
        {
            return new WordPressEventEmitter(new Emitter);
        });
    }
}

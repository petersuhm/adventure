<?php

namespace Adventure\Events;

use League\Event\Emitter;

class WordPressEventEmitter
{
    private $emitter;

    public function __construct(Emitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function emit($event)
    {
        $this->emitter->emit($event);
    }

    public function when($event, $listener, $priority = Emitter::P_NORMAL)
    {
        $this->emitter->addListener($event, $listener, $priority);
    }

    public function whenWordPress($action, $listener, $priority = Emitter::P_NORMAL)
    {
        add_action($action, function () use ($action)
        {
            $this->emit('wp_' . $action);
        });

        $this->when('wp_' . $action, $listener, $priority);
    }
}

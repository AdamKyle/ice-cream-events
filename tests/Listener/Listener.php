<?php

namespace IceCreamEvents\Tests\Listener;

use IceCreamEvents\Tests\Event\OrderEvent;

class Listener {

    public function onCreate(OrderEvent $event) {
        return $event->getOrder()->getName();
    }

    protected function uncallable() {}
}

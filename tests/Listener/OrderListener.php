<?php

namespace IceCreamEvents\Tests\Listener;

use IceCreamEvents\Listener;
use IceCreamEvents\Tests\Event\OrderEvent;

class OrderListener extends Listener {

    public function onCreate(OrderEvent $event) {
        return $event->getOrder()->getName();
    }

    protected function uncallable() {}
}

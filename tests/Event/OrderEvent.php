<?php

namespace IceCreamEvents\Tests\Event;

use IceCreamEvents\Tests\Order\Order;

class OrderEvent {

    private $_order;

    public function __construct(Order $order) {
        $this->_order = $order;
    }

    public function getOrder() {
        return $this->_order;
    }
}

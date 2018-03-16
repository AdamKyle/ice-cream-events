<?php

use IceCreamEvents\EventHandler;

use IceCreamEvents\Tests\Order\Order;
use IceCreamEvents\Tests\Event\OrderEvent;
use IceCreamEvents\Tests\Listener\OrderListener;
use PHPUnit\Framework\TestCase;

class EventHandlerTest extends TestCase {

    public function testCreateEventAndListener() {
        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new OrderListener();

        $eventHandler = new EventHandler();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onCreate');

        $this->assertTrue(isset($eventHandler->getListeners()['order.create']));
    }

    /**
     * @expectedException \Exception
     */
    public function testMethodOnListenerDoesNotExist() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new OrderListener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onSomthing');
    }

    /**
     * @expectedException \Exception
     */
    public function testMethodIsNotAccessible() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new OrderListener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'uncallable');
    }

    public function testDispatchDoesNotReturnFalse() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new OrderListener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onCreate');

        $this->assertNotFalse($eventHandler->dispatch('order.create'));
        $this->assertEquals('order name', $eventHandler->dispatch('order.create'));
    }

    public function testDispatchDoesReturnFalse() {
        $eventHandler = new EventHandler();

        $this->assertFalse($eventHandler->dispatch('order.create'));
    }
}

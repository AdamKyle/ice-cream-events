<?php

use IceCreamEvents\EventHandler;

use IceCreamEvents\Tests\Order\Order;
use IceCreamEvents\Tests\Event\OrderEvent;
use IceCreamEvents\Tests\Listener\Listener;


class EventHandlerTest extends \PHPUnit_Framework_TestCase {

    public function testCreateEventAndListener() {
        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new Listener();

        $eventHandler = new EventHandler();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onCreate');

        $this->assertTrue(isset($eventHandler->getListeners()['order.create']));
    }

    /**
     * @expectedException \Exception
     */
    public function testEventIsNotAClass() {
        $eventHandler = new EventHandler();

        $listener     = new Listener();

        $eventHandler->register('order.create', 'some event', $listener, 'onCreate');
    }

    /**
     * @expectedException \Exception
     */
    public function testListenerIsNotAClass() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);

        $eventHandler->register('order.create', $orderEvent, 'listner', 'onCreate');
    }

    /**
     * @expectedException \Exception
     */
    public function testMethodOnListenerDoesNotExist() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new Listener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onSomthing');
    }

    /**
     * @expectedException \Exception
     */
    public function testMethodIsNotAccessible() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new Listener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'uncallable');
    }

    public function testDispatchDoesNotReturnFalse() {
        $eventHandler = new EventHandler();

        $order        = new Order();
        $orderEvent   = new OrderEvent($order);
        $listener     = new Listener();

        $eventHandler->register('order.create', $orderEvent, $listener, 'onCreate');

        $this->assertNotFalse($eventHandler->dispatch('order.create'));
        $this->assertEquals('order name', $eventHandler->dispatch('order.create'));
    }

    public function testDispatchDoesReturnFalse() {
        $eventHandler = new EventHandler();

        $this->assertFalse($eventHandler->dispatch('order.create'));
    }
}

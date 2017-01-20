<?php

namespace IceCreamEvents;

use IceCreamEvents\Event;
use IceCreamEvents\Listener;

class EventHandler {

    private $_listeners = [];

    public function register($name, Event $event, Listener $listener, $method) {

        if (!method_exists($listener, $method)) {
            throw new \Exception($method . ' does not exist for listener.');
        }

        if (!is_callable([$listener, $method])) {
            throw new \Exception($method . ' for listener is not callable. Please only register public methods.');
        }

        $this->_listeners[$name] = [
            'event'    => $event,
            'listener' => $listener,
            'method'   => $method
        ];
    }

    public function getListeners(): array {
        return $this->_listeners;
    }

    public function dispatch($name) {

        if (isset($this->_listeners[$name])) {
            return call_user_func_array(
                [$this->_listeners[$name]['listener'], $this->_listeners[$name]['method']],
                [$this->_listeners[$name]['event']]
            );
        }

        return false;
    }
}

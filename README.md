# Ice Cream Events

[![Build Status](https://travis-ci.org/AdamKyle/ice-cream-events.svg?branch=master)](https://travis-ci.org/AdamKyle/ice-cream-events)
[![Packagist](https://img.shields.io/packagist/v/ice-cream/events.svg?style=flat)](https://packagist.org/packages/ice-cream/events)
[![Maintenance](https://img.shields.io/maintenance/yes/2018.svg)]()
[![Made With Love](https://img.shields.io/badge/Made%20With-Love-green.svg)]()

Simple event handler for managing events in Ice Cream.

## Requirements

- PHP 7.2
- Is Stand Alone

## Documentation

You can view this packages documentation [here](https://github.com/AdamKyle/ice-cream-events/blob/master/docs/ApiIndex.md)

## Usage

Usage is rather simple, first we have to create a listener and register it. A listener is going to listen for new events to be dispatched and then do something when that event is dispatched.

This is very similar to Symfony's event Dispatcher:

```php

// Create the handler:

$eventHandler = new EventHandler();

// Create a listener to listen to events being fired:

$listener = new Listener();
```

Lets define the listener class:

```php
use IceCreamEvents\Listener;

class PageViewEventListener extends Listener{

  // Read on to see the event definition.
  public function onAction(PageViewEvent $pageViewedEvent) {
     // ... Do something.
  }
}
```

Now lets create an event:

```php
use IceCreamEvents\Event;

class PageViewEvent extends Event {

  protected $pageViewed;

  public function __construct(PageViewed $pageViewed) {
    $this->pageViewed = $pageViewed;
  }

  public function getPageViewed() {
    return $this->pageViewed;
  }
}
```

Finally lets register the event with the appropriate listener:

```php
$eventHandler->register('page.viewed', PageViewEvent::class, PageViewEventListener::class, 'onAction');
```

Next we dispatch the event:

```php
$eventHandler->dispatch('page.viewed');
```

What this does is register the page viewed event with the listener class and when the event is fired we call the `onAction` method and pass it the event class. This is similar to how Laravel registers events.

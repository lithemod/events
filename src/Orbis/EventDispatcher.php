<?php

namespace Lithe\Orbis\Events;

use Lithe\Events\Event;
use Lithe\Orbis\Orbis;

/**
 * Registers a listener for the specified event.
 *
 * @param string   $eventName The name of the event to listen for.
 * @param callable|array $listener   The listener callback to be executed when the event is emitted.
 */
function on(string $eventName, callable|array $listener): void {
    // Retrieve the event dispatcher instance from the Orbis singleton.
    $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);

    // If the dispatcher doesn't exist, register a new instance of it.
    if (!$dispatcher) {
        Orbis::register(\Lithe\Events\EventDispatcher::class);
        $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);
    }

    // Register the listener for the specified event.
    $dispatcher->on($eventName, $listener);
}

/**
 * Emits the specified event, calling all registered listeners.
 *
 * @param \Lithe\Events\Event $event The event object containing the event name and data.
 */
function emit(Event $event): void {
    // Retrieve the event dispatcher instance from the Orbis singleton.
    $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);

    // If the dispatcher doesn't exist, register a new instance of it.
    if (!$dispatcher) {
        Orbis::register(\Lithe\Events\EventDispatcher::class);
        $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);
    }

    // Emit the event, triggering all registered listeners.
    $dispatcher->emit($event);
}

/**
 * Removes a listener for the specified event.
 *
 * @param string   $eventName The name of the event to stop listening for.
 * @param callable|array $listener   The listener callback to be removed.
 */
function off(string $eventName, callable|array $listener): void {
    // Retrieve the event dispatcher instance from the Orbis singleton.
    $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);

    // If the dispatcher doesn't exist, register a new instance of it.
    if (!$dispatcher) {
        Orbis::register(\Lithe\Events\EventDispatcher::class);
        $dispatcher = Orbis::instance(\Lithe\Events\EventDispatcher::class);
    }

    // Remove the specified listener for the event.
    $dispatcher->off($eventName, $listener);
}

<?php

namespace Lithe\Events;

class EventDispatcher
{
    /** @var array<string, array<callable>> */
    private array $listeners = [];

    /**
     * Adds a listener for the specified event.
     *
     * @param string $eventName The name of the event to listen for.
     * @param callable|array  $listener  The listener callback to be executed when the event is emitted.
     * 
     * @throws \InvalidArgumentException If the listener is not callable.
     */
    public function on(string $eventName, callable|array $listener): void
    {
        // Checks if the listener is a valid callable
        if (!is_callable($listener) && !is_array($listener)) {
            throw new \InvalidArgumentException("The listener must be callable or a callable array.");
        }

        // Adds the listener to the event
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * Emits the specified event, calling all registered listeners.
     *
     * @param \Lithe\Events\Event $event The event object containing the event name and data.
     */
    public function emit(Event $event): void
    {
        $eventName = $event->getName();
        $data = $event->getData();

        // If there are no listeners registered for the event, return
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        // Calls all listeners registered for the event
        foreach ($this->listeners[$eventName] as $listener) {
            call_user_func($listener, $data);
        }
    }

    /**
     * Removes a listener for the specified event.
     *
     * @param string $eventName The name of the event to stop listening for.
     * @param callable|array  $listener  The listener callback to be removed.
     */
    public function off(string $eventName, callable|array $listener): void
    {
        // If the event has registered listeners
        if (isset($this->listeners[$eventName])) {
            // Filters and removes the corresponding listener
            $this->listeners[$eventName] = array_filter($this->listeners[$eventName], function ($registeredListener) use ($listener) {
                return $registeredListener !== $listener;
            });
        }
    }
}

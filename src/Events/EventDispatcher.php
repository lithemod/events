<?php

namespace Lithe\Events;

class EventDispatcher
{
    /** @var array<string, array<callable>> */
    private array $listeners = [];

    /**
     * Adds a listener for the specified event.
     *
     * @param string   $eventName The name of the event to listen for.
     * @param callable $listener   The listener callback to be executed when the event is emitted.
     */
    public function on(string $eventName, callable $listener): void
    {
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

        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            call_user_func($listener, $data);
        }
    }

    /**
     * Removes a listener for the specified event.
     *
     * @param string   $eventName The name of the event to stop listening for.
     * @param callable $listener   The listener callback to be removed.
     */
    public function off(string $eventName, callable $listener): void
    {
        if (isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = array_filter($this->listeners[$eventName], function ($registeredListener) use ($listener) {
                return $registeredListener !== $listener;
            });
        }
    }
}

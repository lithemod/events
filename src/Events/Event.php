<?php

namespace Lithe\Events;

class Event
{
    /** @var string The name of the event. */
    private string $name;

    /** @var array The data associated with the event. */
    private array $data;

    /**
     * Constructs a new Event instance.
     *
     * @param string $name The name of the event.
     * @param array  $data Optional. An associative array of data related to the event.
     */
    public function __construct(string $name, array $data = [])
    {
        $this->name = $name; // Set the name of the event.
        $this->data = $data; // Set the associated data for the event.
    }

    /**
     * Gets the name of the event.
     *
     * @return string The name of the event.
     */
    public function getName(): string
    {
        return $this->name; // Return the event name.
    }

    /**
     * Gets the data associated with the event.
     *
     * @return array The data associated with the event.
     */
    public function getData(): array
    {
        return $this->data; // Return the event data.
    }
}

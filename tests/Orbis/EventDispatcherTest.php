<?php

namespace Lithe\Orbis\Tests;

use Lithe\Events\Event;
use Lithe\Orbis\Events;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    public function testOn()
    {
        $eventName = 'test.event';
        $listenerCalled = false;

        // Defines the listener
        $listener = function () use (&$listenerCalled) {
            $listenerCalled = true;
        };

        // Registers the listener
        Events\on($eventName, $listener);

        // Emits the event
        Events\emit(new Event($eventName));

        // Checks if the listener was called
        $this->assertTrue($listenerCalled, 'Listener should have been called.');
    }

    public function testEmitWithData()
    {
        $eventName = 'data.event';
        $dataReceived = null;

        // Defines the listener that processes data
        $listener = function (array $data) use (&$dataReceived) {
            $dataReceived = $data;
        };

        // Registers the listener
        Events\on($eventName, $listener);

        // Emits the event with data
        $testData = ['key' => 'value'];
        Events\emit(new Event($eventName, $testData));

        // Checks if the data was received correctly
        $this->assertSame($testData, $dataReceived, 'Listener should receive the correct data.');
    }

    public function testOff()
    {
        $eventName = 'remove.event';
        $listenerCalled = false;

        // Defines the listener
        $listener = function () use (&$listenerCalled) {
            $listenerCalled = true;
        };

        // Registers the listener
        Events\on($eventName, $listener);

        // Removes the listener
        Events\off($eventName, $listener);

        // Emits the event
        Events\emit(new Event($eventName));

        // Checks if the listener was not called
        $this->assertFalse($listenerCalled, 'Listener should not have been called after being removed.');
    }
}

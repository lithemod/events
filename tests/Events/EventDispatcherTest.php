<?php

namespace Lithe\Events\Tests;

use Lithe\Events\Event;
use Lithe\Events\EventDispatcher;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    protected EventDispatcher $dispatcher;

    protected function setUp(): void
    {
        // Initializes the EventDispatcher before each test
        $this->dispatcher = new EventDispatcher();
    }

    public function testOnAndEmit()
    {
        $eventName = 'test.event';
        $listenerCalled = false;

        // Defines a listener that marks when it has been called
        $listener = function () use (&$listenerCalled) {
            $listenerCalled = true;
        };

        // Registers the listener
        $this->dispatcher->on($eventName, $listener);

        // Emits the event
        $this->dispatcher->emit(new Event($eventName));

        // Checks if the listener was called
        $this->assertTrue($listenerCalled, 'Listener should have been called.');
    }

    public function testEmitWithData()
    {
        $eventName = 'data.event';
        $dataReceived = null;

        // Defines a listener that processes data
        $listener = function ($data) use (&$dataReceived) {
            $dataReceived = $data;
        };

        // Registers the listener
        $this->dispatcher->on($eventName, $listener);

        // Emits the event with data
        $testData = ['key' => 'value'];
        $this->dispatcher->emit(new Event($eventName, $testData));

        // Checks if the data was received correctly
        $this->assertSame($testData, $dataReceived, 'Listener should receive the correct data.');
    }

    public function testOff()
    {
        $eventName = 'remove.event';
        $listenerCalled = false;

        // Defines a listener
        $listener = function () use (&$listenerCalled) {
            $listenerCalled = true;
        };

        // Registers the listener
        $this->dispatcher->on($eventName, $listener);

        // Removes the listener
        $this->dispatcher->off($eventName, $listener);

        // Emits the event
        $this->dispatcher->emit(new Event($eventName));

        // Checks if the listener was not called
        $this->assertFalse($listenerCalled, 'Listener should not have been called after being removed.');
    }

    public function testMultipleListenersForSameEvent()
    {
        $eventName = 'multi.event';
        $callCount = 0;

        // Defines two listeners
        $listener1 = function () use (&$callCount) {
            $callCount++;
        };
        
        $listener2 = function () use (&$callCount) {
            $callCount++;
        };

        // Registers the listeners
        $this->dispatcher->on($eventName, $listener1);
        $this->dispatcher->on($eventName, $listener2);

        // Emits the event
        $this->dispatcher->emit(new Event($eventName));

        // Checks if both listeners were called
        $this->assertSame(2, $callCount, 'Both listeners should have been called.');
    }

    public function testEmitNonExistentEvent()
    {
        // Emits an event that has no listeners
        $this->dispatcher->emit(new Event('non.existent.event'));

        // Tests that no errors or unexpected behavior occurs
        $this->assertTrue(true, 'Emitting a non-existent event should not cause errors.');
    }
}

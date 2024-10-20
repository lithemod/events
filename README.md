# Lithe Events

Lithe Events is a lightweight event handling library designed for PHP applications. It provides a straightforward way to create and manage events, supporting a decoupled architecture that enhances the maintainability and flexibility of your applications.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
  - [Using the EventDispatcher Class](#using-the-eventdispatcher-class)
    - [Creating an Event](#creating-an-event)
    - [Registering Listeners](#registering-listeners)
    - [Emitting Events](#emitting-events)
    - [Removing Listeners](#removing-listeners)
  - [Using Orbis Event Functions](#using-orbis-event-functions)
- [Example](#example)
- [License](#license)

## Installation

To install `lithemod/events`, use Composer. Run the following command in your project directory:

```bash
composer require lithemod/events
```

This command will download the package and update your `composer.json` file accordingly.

## Usage

### Using the EventDispatcher Class

The `EventDispatcher` class serves as the core for managing events and listeners. Here's how to use it effectively:

#### Creating an Event

To create an event, instantiate the `Event` class:

```php
use Lithe\Events\Event;

$event = new Event('event.name', ['key' => 'value']);
```

- **Parameters**:
  - `event.name`: A string that identifies the event.
  - `['key' => 'value']`: An optional associative array to store additional event data.

#### Registering Listeners

You can create an instance of `EventDispatcher` and register a listener for an event using the `on` method. A listener is a callable executed when the event is emitted.

```php
use Lithe\Events\EventDispatcher;

$dispatcher = new EventDispatcher();

$listener = function ($data) {
    echo "Event data: " . json_encode($data);
};

// Register the listener
$dispatcher->on('event.name', $listener);
```

#### Emitting Events

To emit an event and trigger all registered listeners, use the `emit` method:

```php
$event = new Event('event.name', ['key' => 'value']);
$dispatcher->emit($event);
```

#### Removing Listeners

If you need to remove a listener from an event, use the `off` method:

```php
$dispatcher->off('event.name', $listener);
```

### Using Orbis Event Functions

In addition to using the `EventDispatcher`, you can utilize helper functions provided by the `Orbis` namespace for convenient event management.

#### Registering Listeners

To register a listener for an event using Orbis, use the `on` function:

```php
use Lithe\Orbis\Events;

$listener = function ($data) {
    echo "Event data: " . json_encode($data);
};

// Register the listener
Events\on('event.name', $listener);
```

#### Emitting Events

To emit an event using Orbis, call the `emit` function:

```php
use Lithe\Orbis\Events;
use Lithe\Events\Event;

$event = new Event('event.name', ['key' => 'value']);
Events\emit($event);
```

#### Removing Listeners

To remove a registered listener with Orbis, use the `off` function:

```php
Events\off('event.name', $listener);
```

## Example

Here's a complete example of how to use `lithemod/events` with the `Orbis` event functions:

```php
use Lithe\Events\Event;
use Lithe\Orbis\Events;

// Create a listener
$listener = function ($data) {
    echo "Event received with data: " . json_encode($data) . "\n";
};

// Register the listener
Events\on('my.event', $listener);

// Emit the event
$data = ['msg' => 'Hello, world!'];
Events\emit(new Event('my.event', $data));

// Remove the listener
Events\off('my.event', $listener);
```

## License

This project is licensed under the [MIT License](LICENSE).
# Adventure
**A WordPress plugin framework build on top of Composer packages**

```php
/*
 * Plugin Name: My Plugin
 */

use Adventure\WordPressPlugin;

class AwesomePlugin extends WordPressPlugin
{
    // ...
}

$plugin = new AwesomePlugin;
```

## Dependency Injection Container

The `WordPressPlugin` class in Adventure is based on top of the
[Container](http://container.thephpleague.com/) package from the
[PHP League](http://thephpleague.com/). This gives us everything
we need: automatic dependency resolving, factory closures and
service providers.

## Event Emitter

The event emitter in Adventure is build on top of the Event package
from the PHP League. It wraps the WordPress action API.

```php
use Adventure\Events\EventServiceProvider;

// Enable the event emitter
$plugin->addServiceProvider(new EventServiceProvider);

// You can listen for your own events ...
$plugin['emitter']->when('test.event', function ()
{
    var_dump('event!'); die();
});
// ... and emit them.
$plugin['emitter']->emit('test.event');
````

### Listening for WordPress actions

```php
// Or, you can listen for WordPress actions (do_action())
$plugin['emitter']->whenWordPress('init', function ()
{
    var_dump('WordPress init!'); die();
});
```

### Using classes as event listeners

```php
// You can also implement your own event listeners
$plugin['emitter']->whenWordPress('init', $plugin['SayHelloWhenWordPressIsInitiated']);

// Creating listener classes is awesome, because it
// lets you use services automatically resolved out
// of the DI container
use League\Event\EventInterface;
use League\Event\ListenerInterface;

class SayHelloWhenWordPressIsInitiated implements ListenerInterface
{
    private $service;

    // RandomService is automatically resolved out of the
    // DI container
    public function __construct(RandomService $service)
    {
        $this->service = $service;
    }

    public function handle(EventInterface $event)
    {
        var_dump('Hello!'); die();
    }

    public function isListener($listener)
    {
        return $listener === $this;
    }
}
```
 

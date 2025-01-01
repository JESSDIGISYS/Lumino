<?php

namespace Lumino\Provider;





use JDS\Dbal\Events\PostPersist;
use JDS\EventDispatcher\EventDispatcher;
use JDS\Http\Event\ResponseEvent;
use JDS\ServiceProvider\ServiceProviderInterface;
use Lumino\EventListener\ContentLengthListener;
use Lumino\EventListener\InternalErrorListener;

class EventServiceProvider implements ServiceProviderInterface
{

    // Array of listeners
    private array $listen = [
        ResponseEvent::class => [
            InternalErrorListener::class,
            ContentLengthListener::class,
        ],
        PostPersist::class => [
            // Post Persist happens after the data has been sent to the database

        ]
    ];

    public function __construct(private EventDispatcher $eventDispatcher)
    {
    }

    Public function register(): void
    {
        // loop over each event in the listen array
        foreach ($this->listen as $eventName => $listeners) {
            // loop over each listener
            foreach (array_unique($listeners) as $listener) {
                // call eventDispatcher->addListener
                $this->eventDispatcher->addListener($eventName, new $listener);
            }
        }
    }
}


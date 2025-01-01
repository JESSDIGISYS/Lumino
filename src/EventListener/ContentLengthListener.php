<?php

namespace Lumino\EventListener;

use JDS\Http\Event\ResponseEvent;

class ContentLengthListener
{
    public function __invoke(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if (!array_key_exists('Content-Length', $response->getHeaders())) {
            $response->setHeader('Content-Length', strlen($response->getContent()));
        }
    }
}


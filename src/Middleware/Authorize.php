<?php

namespace Lumino\Middleware;

use JDS\Http\Middleware\MiddlewareInterface;
use JDS\Http\Middleware\RequestHandlerInterface;
use JDS\Http\RedirectResponse;
use JDS\Http\Request;
use JDS\Http\Response;
use JDS\Session\SessionInterface;

class Authorize implements MiddlewareInterface
{

    public function __construct(
        private SessionInterface $session
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();

        if (!$this->session->isAuthenticated()) {
            return new RedirectResponse($requestHandler->getContainer()->get('routePath') . '/');
        }
        return $requestHandler->handle($request);
    }
}


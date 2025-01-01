<?php

namespace Lumino\Controller;

use JDS\Authentication\SessionAuthentication;
use JDS\Controller\AbstractController;
use JDS\Http\RedirectResponse;
use JDS\Http\Response;
use Lumino\Generators\BreadcrumbGenerator;
use Lumino\Generators\MenuGenerator;

class LoginController extends AbstractController
{

    public function __construct(private SessionAuthentication $authComponent)
    {
    }

    public function index(): Response
    {
        $menu = $this->container->get(MenuGenerator::class)->generateMenu();
        $uri = $this->getURI();
        $breadcrumbs = $this->container->get(BreadcrumbGenerator::class)->generateBreadcrumbs($uri);
        return $this->render('login.html.twig', ['menu' => $menu, 'breadcrumbs' => $breadcrumbs]);
    }

    public function login(): Response
    {
        $userIsAuthenticated = $this->authComponent->authenticate(
            $this->request->postInput('email'),
            $this->request->postInput('passcode')
        );

        if (!$userIsAuthenticated) {
            $this->request->getSession()->setFlash('error', 'Email and/or password is invalid');
            return new RedirectResponse($this->container->get('routePath') . '/login');
        }

        $user = $this->authComponent->getUser();

        $this->request->getSession()->setFlash('success', 'You are now logged in');

        return new RedirectResponse($this->container->get('routePath') . '/');

    }

    public function logout(): Response
    {
        $this->authComponent->logout();

        $this->request->getSession()->setFlash('success', 'You have been logged out.');
        return new RedirectResponse($this->container->get('routePath') . '/login');
    }
}
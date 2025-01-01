<?php

namespace Lumino\Controller;

use JDS\Controller\AbstractController;
use JDS\Http\Response;
use Lumino\Generators\BreadcrumbGenerator;
use Lumino\Generators\MenuGenerator;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        $menu = $this->container->get(MenuGenerator::class)->generateMenu();
        $uri = $this->getURI();
        $breadcrumbs = $this->container->get(BreadcrumbGenerator::class)->generateBreadcrumbs($uri);
        return $this->render('home.html.twig', ['menu' => $menu, 'breadcrumbs' => $breadcrumbs]);
    }

    public function about(): Response
    {
        $menu = $this->container->get(MenuGenerator::class)->generateMenu();
        $uri = $this->getURI();
        $breadcrumbs = $this->container->get(BreadcrumbGenerator::class)->generateBreadcrumbs($uri);
        return $this->render('about.html.twig', ['menu' => $menu, 'breadcrumbs' => $breadcrumbs]);
    }
}
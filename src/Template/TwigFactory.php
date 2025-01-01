<?php

namespace Lumino\Template;

use JDS\Session\SessionInterface;
use JDS\Templates\TwigFactoryInterface;
use Symfony\Component\VarDumper\VarDumper;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory implements TwigFactoryInterface
{

    public function __construct(
        private SessionInterface $session,
        private readonly string $templatePath,
        private readonly string $routePath,
        private readonly bool $maintMode
    )
    {
    }

    public function create(): Environment
    {
        // instantiate FileSystemLoader with templates path
        $loader = new FilesystemLoader($this->templatePath);

        // instantiate Twig Environment with loader
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false,
        ]);

        // add new twig session() function to Environment
        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new AssetExtension($this->routePath));
        $twig->addFunction(new TwigFunction('session', [$this, 'getSession']));
        $twig->addFunction(new TwigFunction('csrf', [$this, 'generateCsrfHiddenInput'], ['is_safe' => ['html']]));
        $twig->addFunction(new TwigFunction('showDebug', [$this, 'showVariable']));
        $twig->addFunction(new TwigFunction('maintMode', [$this, 'maintMode']));

        return $twig;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function generateCsrfHiddenInput(): string
    {
        return sprintf(
            '<input type="hidden" name="_token" value="%s">',
            $this->session->get('csrf_token')
        );
    }

    public function showVariable($variable): string
    {
        VarDumper::dump($variable);
        return ''; // Return empty to avoid rendering extra text
    }

    public function maintMode(): bool
    {
        return $this->maintMode;
    }

}


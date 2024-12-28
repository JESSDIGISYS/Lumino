<?php
global $container;

$providers = [
    EventServiceProvider::class,
];

foreach($providers as $providerClass) {
    $provider = $container->get($providerClass);
    $provider->register();
}

<?php

global $di;
$router = $di->getRouter();

// Define your routes here

$router->handle();

$router->add(
    '/juniorMembers',
    [
        'controller' => 'members',
        'action' => 'search',
        3 => ['memberType' => 'Junior'],
    ]
);

$router->add(
    '/seniorMembers',
    [
        'controller' => 'members',
        'action' => 'search',
        3 => ['memberType' => 'Senior'],
    ]
);

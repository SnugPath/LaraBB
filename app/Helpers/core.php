<?php

$sidebar = new \App\Helpers\AdminMenu\Sidebar();
$GLOBALS['sidebar'] = $sidebar;

try {

    $sidebar->addSection('Dashboard', 0)
        ->addMenu('Home', 0, '/', false)
        ->addMenu('About', 1, '/')
        ->addSubmenu('Contact', 0, '/');

    // TODO

} catch (Exception $e) {
    throw new Exception($e);
}


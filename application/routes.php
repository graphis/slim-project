<?php
// Routes

$app->get('/', Application\Action\HomeAction::class)
    ->setName('homepage');


$app->get('/mikka/{name}', Application\Action\MikkaAction::class)
    ->setName('mikka');
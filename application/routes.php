<?php
// Routes

$app->get('/', Application\Action\HomeAction::class)
    ->setName('homepage');

<?php 

$app->get('/','App\Action\Admin\LoginAction:index');
$app->post('/login','App\Action\Admin\LoginAction:logar');
$app->get('/logout','App\Action\Admin\LoginAction:logout');

$app->get('/admin','App\Action\Admin\PostAction:index');

?>
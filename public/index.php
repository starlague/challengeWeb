<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$data = $controller->index();

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';
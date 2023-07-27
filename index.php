<?php

use App\Core\App;

include_once 'vendor/autoload.php';

$app = new App();
try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
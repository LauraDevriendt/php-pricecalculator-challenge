<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

//include all your model files here
require 'Model/Discount.php';
require 'Model/Product.php';
require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/DatabaseManager.php';

//include all your controllers here
require 'resources/secret.php';
require 'Controller/HomepageController.php';
require 'Controller/LoginController.php';


//if(isset($_GET['page'])) { // Don't have other file at the moment otherwise use if or switch
    $controller = new HomepageController();
// }

$controller->render();








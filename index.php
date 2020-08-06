<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

// start session
session_start();
//include all your model files here
require 'Model/Login.php';
require 'Model/Discount.php';
require 'Model/Product.php';
require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/PriceCalculator.php';
require 'Model/DatabaseManager.php';

//include all your controllers here
require 'resources/secret.php';
require 'Controller/HomepageController.php';
require 'Controller/LoginController.php';

$controller = new LoginController();
if(isset($_POST['submitPriceSearch'])) { // Don't have other file at the moment otherwise use if or switch
  $controller=new HomepageController();
 }
if(isset($_POST['Logout'])){
    $controller= new LoginController();
}

$controller->render();








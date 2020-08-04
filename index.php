<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

//include all your model files here
require 'Model/Product.php';
require 'Model/Customer.php';
require 'Model/CustomerGroup.php';
require 'Model/DatabaseManager.php';

//include all your controllers here
require 'resources/secret.php';
require 'Controller/Controller.php';

//you could write a simple IF here based on some $_GET or $_POST vars, to choose your controller
//this file should never be more than 20 lines of code!
$pdo = new DatabaseManager();
if(!empty($_POST['products']) && !empty($_POST['customers'])){

  $product= $pdo->findProductById((int) htmlspecialchars($_POST['products']));
  $customer= $pdo->findCustomerById((int) htmlspecialchars($_POST['customers']));
    $customer->getGroupId()

  //@todo discount berekenen
  /*
  var_dump($customer->getDiscount());
    var_dump($customer->isFixed());
  */
}


require 'View/view.php';



/*
$controller = new HomepageController();
if(isset($_GET['page']) && $_GET['page'] === 'info') {
    $controller = new InfoController();
}

$controller->render($_GET, $_POST);
*/
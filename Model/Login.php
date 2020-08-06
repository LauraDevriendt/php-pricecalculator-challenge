<?php
class Login {


public static function searchMatchInDatbase($pdo, $surname):void{
    $customer = $pdo->findCustomerByFirstName($surname);
    if ($customer === Null) {
        $errorLoginMessage = $pdo->createErrorMessage('No customer with this surname');
        require 'View/loginView.php';
        return;
    }

    if ($customer->getLastName() === htmlspecialchars($_POST['password'])) {
        $_SESSION['customer']=serialize($customer);
        require 'View/homepageView.php';

    } else {
        $errorLoginMessage = $pdo->createErrorMessage('password incorrect');
        require 'View/loginView.php';
    }
}


}
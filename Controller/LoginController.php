<?php

class LoginController
{
    public function render()
    {
        $errorLoginMessage = "";
        $pdo = new DatabaseManager();
        if (!empty($_POST['surname']) && !empty($_POST['password'])) {

            $customer = $pdo->findCustomerByFirstName(htmlspecialchars($_POST['surname']));

            if ($customer === Null) {
                $errorLoginMessage = $pdo->createErrorMessage('No customer with this surname');
                require 'View/loginView.php';
                return;
            }

            if ($customer->getLastName() === htmlspecialchars($_POST['password'])) {
                require 'View/homepageView.php';
            } else {
                $errorLoginMessage = $pdo->createErrorMessage('password incorrect');
            }

            var_dump($customer);
        } else {
            $errorLoginMessage = $pdo->createErrorMessage('You need to fill in both fields');
        }
        require 'View/loginView.php';
    }


}
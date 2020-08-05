<?php

class LoginController
{
    public function render()
    {
        $errorLoginMessage = "";
        $pdo = new DatabaseManager();

        if (!empty($_POST['surname']) && !empty($_POST['password'])) {
            Login::searchMatchInDatbase($pdo,htmlspecialchars($_POST['surname']));
        } else {
            $errorLoginMessage = $pdo->createErrorMessage('You need to fill in both fields');
            require 'View/loginView.php';
        }

    }


}
<?php
declare(strict_types = 1);

class HomepageController
{
    //render function with both $_GET and $_POST vars available if it would be needed.
    public function render()
    {
        $pdo = new DatabaseManager();

        if (!empty($_POST['products']) && !empty($_POST['customers'])) {

            $product = $pdo->findProductById((int)$_POST['products']);
            $customer = $pdo->findCustomerById((int)$_POST['customers']);
            $customerGroup = $pdo->findCustomerGroupById($customer->getGroupId());
            $customerGroup->setFamily($pdo);
            $customerGroup->setDiscountsFamily();
            $bestPrice = $product->getBestPrice($customerGroup, $customer);
            var_dump($bestPrice);


        }

        require 'View/homepageView.php';
    }
}

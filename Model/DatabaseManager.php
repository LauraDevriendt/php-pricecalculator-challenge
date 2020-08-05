<?php

class DatabaseException extends Exception {}


class DatabaseManager
{
    private PDO $dbController;
    private array $products = [];
    private array $customers = [];
    private array $customerGroups = [];

    public function __construct()
    {
        // No bugs in this function, just use the right credentials.
            $dbhost = "localhost";
            $dbuser = "becode";
            $dbpass = PASS;
            $db = "pricecalculator_db";

            $driverOptions = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $this->dbController = new PDO('mysql:host=' . $dbhost . ';dbname=' . $db, $dbuser, $dbpass, $driverOptions);;
            $this->fetchProductData();
            $this->fetchCustomerData();
            $this->fetchCustomerGroupData();


    }

    /**
     * @return Customer[]
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return CustomerGroup[]
     */
    public function getCustomerGroups(): array
    {
        return $this->customerGroups;
    }


    public function fetchProductData()
    {
        $handle = $this->dbController->prepare('SELECT id, name, price FROM product');
        $handle->execute();
        $products = $handle->fetchAll();
        foreach ($products as $product) {
            $item = new Product($product['id'], $product['name'], $product['price']);
            $this->products[] = $item;
        }
    }

    public function fetchCustomerData()
    {
        $handle = $this->dbController->prepare('SELECT * FROM customer');
        $handle->execute();
        $customers = $handle->fetchAll();
        foreach ($customers as $customerData) {
            $customer = new Customer($customerData['id'], $customerData['firstname'], $customerData['lastname'], $customerData['group_id'], (int)$customerData['fixed_discount'], (int)$customerData['variable_discount']);
            $this->customers[] = $customer;
        }
    }

    public function fetchCustomerGroupData()
    {
        $handle = $this->dbController->prepare('SELECT * FROM customer_group');
        $handle->execute();
        $customerGroups = $handle->fetchAll();
        foreach ($customerGroups as $customerGroupData) {
            $customerGroup = new CustomerGroup($customerGroupData['id'], $customerGroupData['name'], (int)$customerGroupData['parent_id'], (int)$customerGroupData['fixed_discount'], (int)$customerGroupData['variable_discount']);
            $this->customerGroups[] = $customerGroup;
        }
    }

    public function findProductById(int $id): Product
    {
        foreach ($this->getProducts() as $product) {
            if ($id === $product->getId()) {
                return $product;
            }
        }
    }

    public function findCustomerById(int $id): Customer
    {
        foreach ($this->getCustomers() as $customer) {
            if ($id === $customer->getId()) {
                return $customer;
            }
        }
    }


    public function findCustomerByFirstName(string $name):? Customer
    {
        foreach ($this->getCustomers() as $customer) {
            if ($name === $customer->getFirstName()) {
                return $customer;
            }
        }
        return null;

    }



    public function findCustomerGroupById(int $id): CustomerGroup
    {
        foreach ($this->getCustomerGroups() as $customerGroup) {
            if ($id === $customerGroup->getId()) {
                return $customerGroup;
            }
        }
    }
    public function createErrorMessage($message){
        return "<div class='alert alert-danger' role='alert'>
                                  <strong>Oh snap!</strong> $message</div>";
    }

}
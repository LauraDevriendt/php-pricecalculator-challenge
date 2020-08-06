<?php


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

            $this->dbController = new PDO('mysql:host=' . $dbhost . ';dbname=' . $db, $dbuser, $dbpass, $driverOptions);
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
            $item = new Product($product['id'], $product['name'], $product['price']/100);
            $this->products[] = $item;
        }
    }

    public function fetchCustomerData()
    {
        $handle = $this->dbController->prepare('SELECT customer.id as customer_id,
firstname,
lastname,
group_id,
customer.fixed_discount as customer_fixed_discount, 
customer.variable_discount as customer_variable_discount,
customer_group.name,
customer_group.parent_id,
customer_group.fixed_discount as group_fixed_discount,
customer_group.variable_discount as group_variable_discount
FROM customer 
LEFT JOIN customer_group 
ON customer.group_id =customer_group.id;
');
        $handle->execute();
        $customers = $handle->fetchAll();
        foreach ($customers as $customerData) {
            $customer = new Customer(
                $customerData['customer_id'], $customerData['firstname'],
                $customerData['lastname'],
                new Discount($customerData['customer_fixed_discount'], $customerData['customer_variable_discount']),
                new CustomerGroup($customerData['group_id'], $customerData['name'], (int)$customerData['parent_id'], new Discount($customerData['group_fixed_discount'], $customerData['group_variable_discount']))
            );
            $this->customers[] = $customer;
        }
    }

    public function fetchCustomerGroupData()
    {
        $handle = $this->dbController->prepare('SELECT * FROM customer_group');
        $handle->execute();
        $customerGroups = $handle->fetchAll();
        foreach ($customerGroups as $customerGroupData) {
            $customerGroup = new CustomerGroup($customerGroupData['id'], $customerGroupData['name'], (int)$customerGroupData['parent_id'], new Discount($customerGroupData['fixed_discount'], $customerGroupData['variable_discount']));
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

    public function findCustomerGroupById(int $id): CustomerGroup
    {

        foreach ($this->getCustomerGroups() as $customerGroup) {
            if ($id === $customerGroup->getId()) {
                return $customerGroup;
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




    public function createErrorMessage($message){
        return "<div class='alert alert-danger' role='alert'>
                                  <strong>Oh snap!</strong> $message</div>";
    }

}
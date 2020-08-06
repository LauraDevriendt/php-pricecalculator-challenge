<?php
class Customer{
    private int $id;
    private string $firstName;
    private string $lastName;
    private CustomerGroup $customerGroup;


    public function getCustomerGroup(): CustomerGroup
    {
        return $this->customerGroup;
    }

    private Discount $discount;

    public function __construct(int $id, string $firstName, string $lastName, Discount $discount, CustomerGroup $customerGroup)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->discount = $discount;
        $this->customerGroup=$customerGroup;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }


    public function getDiscount(): Discount
    {
        return $this->discount;
    }
}
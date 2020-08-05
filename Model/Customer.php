<?php
class Customer{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $groupId;

    private Discount $discount;

    public function __construct(int $id, string $firstName, string $lastName, int $groupId, Discount $discount)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->groupId = $groupId;
        $this->discount = $discount;
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
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getDiscount(): Discount
    {
        return $this->discount;
    }
}
<?php
class Customer{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $groupId;
    private int $fixedDiscount;
    private int $varDiscount;
    private bool $fixed;

    public function __construct(int $id, string $firstName, string $lastName, int $groupId, int $fixedDiscount, int $varDiscount)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->groupId = $groupId;
        $this->fixedDiscount = $fixedDiscount;
        $this->varDiscount = $varDiscount;
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

    public function getFixedDiscount(): int
    {
        return $this->fixedDiscount;
    }

    public function getVarDiscount(): int
    {
        return $this->varDiscount;
    }
    public function isFixed(): bool
    {
        return $this->fixed;
    }

    public function getDiscount(): int
    {
        if($this->getFixedDiscount()===0){
            $this->fixed=false;
            return $this->getVarDiscount();
        }else{
            $this->fixed=true;
            return $this->getFixedDiscount();
        }

    }





}
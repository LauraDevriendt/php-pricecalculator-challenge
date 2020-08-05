<?php

class CustomerGroup
{
    private int $id;
    private string $name;
    private int $parentId;
    private array $family;

    private ?Discount $maxVariableDiscount = null;
    private ?Discount $sumFixedDiscount = null;
    private Discount $discount;

    public function __construct(int $id, string $name, int $parentId, Discount $discount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->discount = $discount;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return CustomerGroup[]
     */
    public function getFamily(): array
    {
        return $this->family;
    }

    public function setFamily(DatabaseManager $pdo)
    {
        $this->family[] = $this;
        $customerGroupId = $this->getParentId();
        while ($customerGroupId !== 0) {
            $customerGroup = $pdo->findCustomerGroupById($customerGroupId);
            $this->family[] = $customerGroup;
            $customerGroupId = $customerGroup->getParentId();
        }
    }
    public function getMaxVariableDiscount(): Discount
    {
        if($this->maxVariableDiscount === null) { //lazy loading
            $this->calculateDiscountsFamily();
        }

        return $this->maxVariableDiscount;
    }

    public function getSumFixedDiscount(): Discount
    {
        if(is_null($this->sumFixedDiscount)) {
            $this->calculateDiscountsFamily();
        }

        return $this->sumFixedDiscount;
    }

    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    private function calculateDiscountsFamily() : void
    {
        $this->maxVariableDiscount = new Discount(null, 0);

        $sumFixedDiscount = 0;
        foreach ($this->getFamily() as $member) {
            $discount=$member->getDiscount(); // also important to initiate  fixed bool
            if ($discount->getType() === Discount::PERCENTAGE_TYPE) {
                if($this->maxVariableDiscount<$discount){
                    $this->maxVariableDiscount = $discount;
                }
            } else {
                $sumFixedDiscount += $member->getDiscount()->getValue();
            }
        }

        $this->sumFixedDiscount = new Discount($sumFixedDiscount, null);
    }
}
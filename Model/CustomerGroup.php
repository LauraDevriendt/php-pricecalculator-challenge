<?php

class CustomerGroup
{
    private int $id;
    private string $name;
    private int $parentId;
    private int $fixedDiscount;
    private int $varDiscount;
    private array $family;
    private bool $fixed;
    private int $maxVariableDiscount=0;
    private int $sumFixedDiscount=0;


    public function __construct(int $id, string $name, int $parentId, int $fixedDiscount, int $varDiscount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->fixedDiscount = $fixedDiscount;
        $this->varDiscount = $varDiscount;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function getFixedDiscount(): int
    {
        return $this->fixedDiscount;
    }


    public function getVarDiscount(): int
    {
        return $this->varDiscount;
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
    public function getMaxVariableDiscount(): int
    {
        return $this->maxVariableDiscount;
    }

    public function getSumFixedDiscount(): int
    {
        return $this->sumFixedDiscount;
    }


    //@todo VRAAG KOEN duplicated from customer??

    public function isFixed(): bool
    {
        return $this->fixed;
    }

    public function getDiscount(): int
    {
        if ($this->getFixedDiscount() === 0) {
            $this->fixed = false;
            return $this->getVarDiscount();
        } else {
            $this->fixed = true;
            return $this->getFixedDiscount();
        }

    }

    public function setDiscountsFamily()
    {

        foreach ($this->getFamily() as $member) {
            $discount=$member->getDiscount(); // also important to initiate  fixed bool
            if ($member->isFixed() === false) {
                if($this->maxVariableDiscount<$discount){
                $this->maxVariableDiscount = $discount;
                }
            } else {
                $this->sumFixedDiscount += $member->getDiscount();
            }

        }
    }



}
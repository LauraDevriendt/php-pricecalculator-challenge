<?php
class CustomerGroup{
    private int $id;
    private string $name;
    private int $parentId;
    private int $fixedDiscount;
    private int $varDiscount;
    private array $family;

    public function __construct(int $id, string $name, int $parentId, int $fixedDiscount, int $varDiscount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->fixedDiscount = $fixedDiscount;
        $this->varDiscount = $varDiscount;
    }

    public function getId(): int
    {
        return $this->id;
    }

}
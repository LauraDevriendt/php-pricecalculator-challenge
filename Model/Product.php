<?php
class Product{
    private int $price;
    private int $id;
    private string $name;


    public function __construct($id, $name,$price)
    {
        $this->price = $price;
        $this->id = $id;
        $this->name = $name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBestGroupDiscount(CustomerGroup $customerGroup):Discount{
        $fixedPrice=$customerGroup->getSumFixedDiscount()->apply($this->getPrice());
        $variablePrice = $customerGroup->getMaxVariableDiscount()->apply($this->getPrice());
        if($fixedPrice < $variablePrice){
            return $customerGroup->getSumFixedDiscount();
        }

        return $customerGroup->getMaxVariableDiscount();
    }

    public function getBestPrice(CustomerGroup $customerGroup, Customer $customer):float{
        $priceCalculator= new PriceCalculator($customer,$this,$customerGroup);
         return $priceCalculator->getBestprice();

    }

    public function getBestPriceDisplay(CustomerGroup $customerGroup, Customer $customer):string{
        $priceCalculator= new PriceCalculator($customer,$this,$customerGroup);
        return $priceCalculator->getCalculationDisplay();

    }







}
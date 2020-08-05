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
        $customerDiscount= $customer->getDiscount()->getValue();
        $customerMethod= $customer->getDiscount()->getType();

        $groupBestDiscount = $this->getBestGroupDiscount($customerGroup);
        $groupDiscount= $groupBestDiscount->getValue();
        $groupMethod= $groupBestDiscount->getType();
        $price=0;

        if($customerMethod===Discount::PERCENTAGE_TYPE && $groupMethod=== Discount::PERCENTAGE_TYPE){
            if($customerDiscount<$groupDiscount){
                $price= $groupBestDiscount->apply($price);
            } else{
                $price= $customer->getDiscount()->apply($price);
            }
        }
        //@todo: could refactor it below to use Discount methods
        if($customerMethod===Discount::FIXED_TYPE && $groupMethod===Discount::PERCENTAGE_TYPE) {
            $price=($this->getPrice()/100-$customerDiscount)*(1-$groupDiscount/100);
        }
        if($customerMethod===Discount::PERCENTAGE_TYPE && $groupMethod===Discount::FIXED_TYPE) {
            $price=($this->getPrice()/100-$groupDiscount)*(1-$customerDiscount/100);
        }
        if($customerMethod===Discount::PERCENTAGE_TYPE &&$groupMethod===Discount::PERCENTAGE_TYPE) {
            $price=($this->getPrice()/100-($groupDiscount+$customerDiscount));
        }

        return $price;
    }







}
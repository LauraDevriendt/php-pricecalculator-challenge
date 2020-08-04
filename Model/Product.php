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

    public function getBestGroupDiscount(CustomerGroup $customerGroup):int{
        $fixedPrice=$this->getPrice()/100-$customerGroup->getSumFixedDiscount();
        $variablePrice= $this->getPrice()/100*(1-$customerGroup->getMaxVariableDiscount()/100);
        if($fixedPrice<$variablePrice){
            return $customerGroup->getSumFixedDiscount();
        }else{
            return $customerGroup->getMaxVariableDiscount();
        }


    }

    public function getBestCustomerDiscount(Customer $customer):int{
        $fixedPrice=$this->getPrice()/100-$customer->getFixedDiscount();
        $variablePrice= $this->getPrice()/100*(1-$customer->getVarDiscount()/100);
        if($fixedPrice<$variablePrice){
            return $customer->getFixedDiscount();
        }else{
            return $customer->getVarDiscount();
        }

    }

    public function getBestPrice(CustomerGroup $customerGroup, Customer $customer):float{
       $customerDiscount= $this->getBestCustomerDiscount($customer);
        $groupDiscount= $this->getBestGroupDiscount($customerGroup);
        $customerGroup->getDiscount();
        $customer->getDiscount();
        $price=0;

        if($customerGroup->isFixed()===false && $customer->isFixed()===false){
            if($customerDiscount<$groupDiscount){
                $price= ($this->getPrice()/100)*(1-$groupDiscount/100);
            } else{
                $price= ($this->getPrice()/100)*(1-$customerDiscount/100);
            }
        }
        if($customerGroup->isFixed()===true && $customer->isFixed()===false) {
        $price=($this->getPrice()/100-$customerDiscount)*(1-$groupDiscount/100);
        }
        if($customerGroup->isFixed()===false && $customer->isFixed()===true) {
            $price=($this->getPrice()/100-$groupDiscount)*(1-$customerGroup/100);
        }
        if($customerGroup->isFixed()===true && $customer->isFixed()===true) {
            $price=($this->getPrice()/100-($groupDiscount+$customerDiscount));
        }
        if($price<0){
            $price=0;
        }
        return $price;
    }







}
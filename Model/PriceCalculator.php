<?php


class PriceCalculator
{
private int $bestprice=0;
private string $calculationDisplay="";

    public function __construct(Customer $customer, Product $product, CustomerGroup $customerGroup)
    {
        $customerDiscount= $customer->getDiscount()->getValue();
        $customerMethod= $customer->getDiscount()->getType();
        $groupBestDiscount = $product->getBestGroupDiscount($customerGroup);
        $groupDiscount= $groupBestDiscount->getValue();
        $groupMethod= $groupBestDiscount->getType();
        $price=$product->getPrice();

        if($customerMethod===Discount::PERCENTAGE_TYPE && $groupMethod=== Discount::PERCENTAGE_TYPE){
            if($customerDiscount<$groupDiscount){
                $this->bestprice= round($groupBestDiscount->apply($price),2);
                $this->calculationDisplay="$price * (1 - $groupDiscount %) = $this->bestprice euro";
            } else{
                $this->bestprice= $customer->getDiscount()->apply($price);
                $this->calculationDisplay="$price * ( 1 - $customerDiscount %) = $this->bestprice euro";
            }
        }

        if($customerMethod===Discount::FIXED_TYPE && $groupMethod===Discount::PERCENTAGE_TYPE) {
            $this->bestprice=round(($price-$customerDiscount)*(1-$groupDiscount/100),2);
            $this->calculationDisplay="($price - $customerDiscount) * (1 - $groupDiscount%) =$this->bestprice euro";
        }
        if($customerMethod===Discount::PERCENTAGE_TYPE && $groupMethod===Discount::FIXED_TYPE) {
            $this->bestprice=round(($price-$groupDiscount)*(1-$customerDiscount/100),2);
            $this->calculationDisplay="($price - $groupDiscount) * (1 - $customerDiscount%) = $this->bestprice euro";
        }
        if($customerMethod===Discount::FIXED_TYPE &&$groupMethod===Discount::FIXED_TYPE) {
            $this->bestprice=round(($price-($groupDiscount+$customerDiscount)),2);
            $this->calculationDisplay="($price - ($groupDiscount + $customerDiscount) = $this->bestprice) euro";
        }

        if($this->bestprice<0){
            $this->bestprice=0;
        }


    }

    public function getBestprice(): int
    {
        return $this->bestprice;
    }


    public function getCalculationDisplay(): string
    {
        return $this->calculationDisplay;
    }


}
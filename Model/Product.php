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

    public function getBestGroupDiscount(CustomerGroup $customerGroup):array{
        $fixedPrice=$this->getPrice()/100-$customerGroup->getSumFixedDiscount();
        $variablePrice= $this->getPrice()/100*(1-$customerGroup->getMaxVariableDiscount()/100);
        if($fixedPrice<$variablePrice){
            return ["discount"=>$customerGroup->getSumFixedDiscount(),"method"=>'fixed'];
        }else{
            return ["discount"=>$customerGroup->getMaxVariableDiscount(),"method"=>'variable'];
        }


    }

    public function getBestCustomerDiscount(Customer $customer):array{
        $fixedPrice=$this->getPrice()/100-$customer->getFixedDiscount();
        $variablePrice= $this->getPrice()/100*(1-$customer->getVarDiscount()/100);
        if($fixedPrice<$variablePrice){
            return ["discount"=>$customer->getFixedDiscount(), "method"=> 'fixed'];
        }else{
            return ["discount"=>$customer->getVarDiscount(),"method"=>'variable'];
        }

    }

    public function getBestPrice(CustomerGroup $customerGroup, Customer $customer):float{
       $customerDiscount= $this->getBestCustomerDiscount($customer)['discount'];
       $customerMethod= $this->getBestCustomerDiscount($customer)['method'];
        $groupDiscount= $this->getBestGroupDiscount($customerGroup)['discount'];
        $groupMethod= $this->getBestGroupDiscount($customerGroup)['method'];
        $price=0;

        if($customerMethod==='variable' && $groupMethod==='variable'){
            if($customerDiscount<$groupDiscount){
                $price= ($this->getPrice()/100)*(1-$groupDiscount/100);
            } else{
                $price= ($this->getPrice()/100)*(1-$customerDiscount/100);
            }
        }
        if($customerMethod==='fixed' && $groupMethod==='variable') {
        $price=($this->getPrice()/100-$customerDiscount)*(1-$groupDiscount/100);
        }
        if($customerMethod==='variable' && $groupMethod==='fixed') {
            $price=($this->getPrice()/100-$groupDiscount)*(1-$customerDiscount/100);
        }
        if($customerMethod==='variable' &&$groupMethod==='variable') {
            $price=($this->getPrice()/100-($groupDiscount+$customerDiscount));
        }
        if($price<0){
            $price=0;
        }
        return $price;
    }







}
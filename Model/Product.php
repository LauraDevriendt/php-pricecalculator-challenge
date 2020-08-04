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





}
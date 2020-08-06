<?php

class Discount //immutable
{
    public const FIXED_TYPE = 'fixed';
    public const PERCENTAGE_TYPE = 'percentage';

    private int $value;
    private string $type;

    public function __construct(?int $fixedValue, ?int $percentageValue)
    {
        if($fixedValue !== null) {
            $this->value = $fixedValue;
            $this->type = self::FIXED_TYPE;
        }
        elseif($percentageValue !== null) {
            $this->value = $percentageValue;
            $this->type = self::PERCENTAGE_TYPE;
        }
        else {
            throw new InvalidArgumentException('You cannot have a discount with both a fixed value and a percentage');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function apply(int $price) : float
    {
        $price /= 100;
        if($this->type === self::FIXED_TYPE) {
            return round(max(0,$price - $this->value),2);
        }

        return round($price * (1-$this->value/100), 2);
    }
}


<?php

namespace App\Utils;

interface CalculatorInterface
{
    public function calculate(float $firstNumber, float $secondNumber, string $operand): float;
}

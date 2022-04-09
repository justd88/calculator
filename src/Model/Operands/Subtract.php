<?php

namespace App\Model\Operands;

use App\Model\OperationInterface;

class Subtract implements OperationInterface
{
    public function execute(float $firstNumber, float $secondNumber): float
    {
        return $firstNumber - $secondNumber;
    }

    public function isSupported(string $operand): bool
    {
        return '-' === $operand || 'subtract' === $operand;
    }
}
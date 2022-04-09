<?php

namespace App\Model\Operands;

use App\Exception\IllegalOperation;
use App\Model\OperationInterface;

class Divide implements OperationInterface
{
    /**
     * @throws IllegalOperation
     */
    public function execute(float $firstNumber, float $secondNumber): float
    {
        if (0.0 === $secondNumber) {
            throw new IllegalOperation('Cannot divide by 0');
        }

        return $firstNumber / $secondNumber;
    }

    public function isSupported(string $operand): bool
    {
        return '/' === $operand || 'divide' === $operand;
    }
}
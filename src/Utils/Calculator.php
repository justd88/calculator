<?php

namespace App\Utils;

use App\Exception\OperandHandlerNotFound;
use App\Model\OperationInterface;

class Calculator implements CalculatorInterface
{
    /**
     * @var OperationInterface[]
     */
    private $operations;

    public function __construct(OperationInterface ...$operations)
    {
        $this->operations = $operations;
    }

    /**
     * @throws OperandHandlerNotFound
     */
    public function calculate(float $firstNumber, float $secondNumber, string $operand): float
    {
        foreach ($this->operations as $operation) {
            if ($operation->isSupported($operand)) {
                return $operation->execute($firstNumber, $secondNumber);
            }
        }
        throw new OperandHandlerNotFound('Operation is not supported!');
    }
}
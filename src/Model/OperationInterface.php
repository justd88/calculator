<?php

namespace App\Model;

interface OperationInterface
{
    public function execute(float $firstNumber, float $secondNumber): float;

    public function isSupported(string $operand): bool;
}

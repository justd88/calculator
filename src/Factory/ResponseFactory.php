<?php

namespace App\Factory;

use App\Utils\CalculatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory
{
    public function __construct(
        private CalculatorInterface $calculator,
    ) {
    }

    public function create(float $firstNumber, float $secondNumber, string $operand): JsonResponse
    {
        try {
            $result = $this->calculator->calculate($firstNumber, $secondNumber, $operand);
            return new JsonResponse(['result' => $result]);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }
}

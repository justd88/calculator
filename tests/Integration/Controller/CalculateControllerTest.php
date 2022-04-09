<?php

namespace App\Tests\Integration\Controller;

use App\Controller\CalculateController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateControllerTest extends KernelTestCase
{
    private CalculateController $calculateController;

    public function setUp(): void
    {
        self::bootKernel();

        $this->calculateController = static::getContainer()->get(CalculateController::class);
    }

    /**
     * @dataProvider operationsDataProvider
     */
    public function testOperations(
        float  $firstNumber,
        float  $secondNumber,
        string $operand,
        array  $expected
    ): void
    {
        $result = $this->calculateController->calculate($firstNumber, $secondNumber, $operand);
        $this->assertSame(json_encode($expected), $result->getContent());
    }

    public function operationsDataProvider(): array
    {
        return [
            'add' => [11.5, 12.5, 'add', ['result' => 24.0]],
            'multiply' => [2.3, 11.4, 'multiply', ['result' => 26.22]],
            'subtract' => [11.5, 12.5, 'subtract', ['result' => -1.0]],
            'divide' => [15.0, 3, 'divide', ['result' => 5.0]],
            'divide by zero' => [11, 0, 'divide', ['error' => 'Cannot divide by 0']]
        ];
    }
}

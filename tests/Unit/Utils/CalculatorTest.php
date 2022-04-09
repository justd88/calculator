<?php

namespace App\Tests\Unit\Utils;

use App\Model\OperationInterface;
use App\Utils\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    private OperationInterface $op1;

    private OperationInterface $op2;

    private OperationInterface $op3;

    public function setUp(): void
    {
        $this->op1 = $this->getMockBuilder(OperationInterface::class)->getMock();
        $this->op2 = $this->getMockBuilder(OperationInterface::class)->getMock();
        $this->op3 = $this->getMockBuilder(OperationInterface::class)->getMock();

        $this->calculator = new Calculator($this->op1, $this->op2, $this->op3);
    }

    public function testThrowErrorIfHandlersCannotHandle()
    {
        $this->op1->expects($this->once())
            ->method('isSupported')
            ->with('noHandlerForThisOperation')
            ->willReturn(false);

        $this->op2->expects($this->once())
            ->method('isSupported')
            ->with('noHandlerForThisOperation')
            ->willReturn(false);

        $this->op3->expects($this->once())
            ->method('isSupported')
            ->with('noHandlerForThisOperation')
            ->willReturn(false);

        $this->expectExceptionMessage('Operation is not supported!');
        $this->calculator->calculate(
            1,
            2,
            'noHandlerForThisOperation'
        );
    }

    public function testThrowErrorIfNoHandlers(): void
    {
        $calculatorWithoutOperations = new Calculator();

        $this->expectExceptionMessage('Operation is not supported!');
        $calculatorWithoutOperations->calculate(
            1,
            2,
            'noHandlerForThisOperation'
        );
    }

    public function testWhenHandlerCanHandleExecuteOperation(): void
    {
        $this->op1->expects($this->once())
            ->method('isSupported')
            ->with('+')
            ->willReturn(false);

        $this->op2->expects($this->once())
            ->method('isSupported')
            ->with('+')
            ->willReturn(false);

        $this->op3->expects($this->once())
            ->method('isSupported')
            ->with('+')
            ->willReturn(true);

        $this->op3->expects($this->once())
            ->method('execute')
            ->with(10, 11)
            ->willReturn(21.0);

        $this->assertSame(
            21.0,
            $this->calculator->calculate(
                10,
                11,
                '+'
            )
        );
    }

    public function testBailEarlyWhenHandlerFound()
    {
        $this->op1->expects($this->once())
            ->method('isSupported')
            ->with('+')
            ->willReturn(false);

        $this->op2->expects($this->once())
            ->method('isSupported')
            ->with('+')
            ->willReturn(true);

        $this->op2->expects($this->once())
            ->method('execute')
            ->with(10, 11)
            ->willReturn(21.0);

        $this->op3->expects($this->never())
            ->method('isSupported')
            ->with('+')
            ->willReturn(false);

        $this->assertSame(
            21.0,
            $this->calculator->calculate(
                10,
                11,
                '+'
            )
        );
    }
}

<?php

namespace App\Tests\Unit\Controller;

use App\Controller\CalculateController;
use App\Factory\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CalculateControllerTest extends TestCase
{
    private CalculateController $controller;

    private ResponseFactory $responseFactory;

    public function setUp(): void
    {
        $this->responseFactory = $this->getMockBuilder(ResponseFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new CalculateController($this->responseFactory);
    }

    public function testControllerCallsWithParameters(): void
    {
        $expected = $this->getMockBuilder(JsonResponse::class)->getMock();

        $this->responseFactory->expects($this->once())
            ->method('create')
            ->with(1, 2, 'operand')
            ->willReturn($expected);

        $this->assertSame($expected, $this->controller->calculate(1,2,'operand'));
    }
}

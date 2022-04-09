<?php

namespace App\Controller;

use App\Factory\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculateController extends AbstractController
{
    public function __construct(protected ResponseFactory $responseFactory)
    {
    }

    #[Route(
        '/calculate/{first}/{operand}/{second}',
        name: 'app_result',
        requirements: [
            'first' => '[+-]?([0-9]*[.])?[0-9]+',
            'second' => '[+-]?([0-9]*[.])?[0-9]+',
            'operand' => '\w+'
        ],
        methods: ['GET']
    )]
    public function calculate(float $first, float $second, string $operand): Response
    {
        return $$this->responseFactory->create($first, $second, $operand);
    }
}

<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Middleware\Order;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Oqq\Broetchen\Domain\User\UserId;
use Oqq\Broetchen\Service\OrderServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

final class OrdersMiddleware implements MiddlewareInterface
{
    private $orderService;
    private $resourceGenerator;
    private $responseFactory;

    public function __construct(
        OrderServiceInterface $orderService,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    )
    {
        $this->resourceGenerator = $resourceGenerator;
        $this->responseFactory = $responseFactory;
        $this->orderService = $orderService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        /** @var UserId $userId */
        $userId = $request->getAttribute('user_id');

        if (!$userId) {
            return new EmptyResponse(401);
        }

        $orders = $this->orderService->getOrdersFromUser($userId);

        return $this->responseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($orders, $request)
        );
    }
}

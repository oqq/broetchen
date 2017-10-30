<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Oqq\Broetchen\Command\CreateOrder;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\User\UserId;
use Oqq\Broetchen\Service\OrderServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

final class OrderMiddleware implements MiddlewareInterface
{
    private $orderService;
    private $resourceGenerator;
    private $responseFactory;

    public function __construct(
        OrderServiceInterface $orderService,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    ) {
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

        if ($request->getMethod() === 'POST') {
            $values = $request->getParsedBody();
            $values['order_id'] = OrderId::generate()->toString();
            $values['user_id'] = $userId->toString();

            $createOrder = CreateOrder::fromArray(['order' => $values]);
            $this->orderService->addOrder($createOrder);

            return $delegate->process($request);
        }

        $orders = $this->orderService->getOrdersFromUser($userId);

        return $this->responseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromArray($orders->getArrayCopy())
        );
    }
}

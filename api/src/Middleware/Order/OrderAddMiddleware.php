<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Middleware\Order;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Oqq\Broetchen\Command\CreateOrder;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\User\UserId;
use Oqq\Broetchen\Domain\Order\OrderService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;

final class OrderAddMiddleware implements MiddlewareInterface
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        /** @var UserId $userId */
        $userId = $request->getAttribute('user_id');

        if (!$userId) {
            return new EmptyResponse(401);
        }

        $values = $request->getParsedBody();
        $values['order_id'] = OrderId::generate()->toString();
        $values['user_id'] = $userId->toString();

        $createOrder = CreateOrder::fromArray(['order' => $values]);
        $this->orderService->addOrder($createOrder);

        return $delegate->process($request);
    }
}

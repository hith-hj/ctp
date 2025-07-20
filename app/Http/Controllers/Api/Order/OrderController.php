<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\ApiController;
use App\Models\OrderDetail;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 10;
        if ($limit > 30) {
            $limit = 30;
        }

        $user = $this->getUser($request);
        if (! $user) {
            return $this->respondError(__('api.user_not_found'));
        }

        $request->request->add(['user_id' => $user->id]);

        $orders = $this->orderRepository
            ->getOrders($request)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->respondSuccess($orders->all(), $this->createApiPaginator($orders));
    }

    public function order($id): JsonResponse
    {
        $order = OrderDetail::query()->find($id);
        if (! $order) {
            return $this->respondError(__('api.order_not_found'));
        }

        return $this->respondSuccess($order);
    }
}

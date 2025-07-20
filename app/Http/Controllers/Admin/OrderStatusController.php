<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class OrderStatusController extends Controller
{
    private $orderRepository;

    public $resource = 'order';

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        view()->share('item', $this->resource);
        view()->share('class', Order::class);
    }

    public function index($status = null)
    {
        return view('admin.order.indexStatus', compact('status'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  null  $status
     */
    public function byStatus(Request $request, $status = null): JsonResponse
    {
        $oldRequest = $request->query->all();
        $params = [
            'query' => [
                'status' => $status,
                'from_date' => $request->get('query')['from_date'] ?? null,
                'to_date' => $request->get('query')['to_date'] ?? null,
            ],
        ];
        $merged = array_merge($oldRequest, $params);
        $request->merge($merged);

        $orders = $this->orderRepository
            ->getOrdersDataTable($request);

        $data = [];

        foreach ($orders as $order) {
            array_push($data, [
                'id' => $order->id,
                'code' => $order->code,
                'user_id' => $order->name,
                'created_at' => Date::parse($order->created_at)->format('Y-m-d'),
                'status' => $order->status,
            ]);
        }

        return response()->json(
            [
                'meta' => [
                    'page' => $orders->currentPage(),
                    'pages' => $orders->lastPage(),
                    'perpage' => $orders->perPage(),
                    'total' => $orders->total(),
                    'sort' => $request->get('sort')['sort'] ?? 0,
                    'field' => $request->get('sort')['field'] ?? '',
                ],
                'data' => $data,
            ]
        );

    }
}

<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderRepository
{
    public function getOrders(Request $request): Builder
    {
        $orders = Order::query();

        if ($status = $request->get('status')) {
            $orders->where('status', $status);
        }

        if ($userId = $request->get('user_id')) {
            $orders->where('user_id', $userId);
        }

        if ($adminId = $request->get('admin_id')) {
            $orders->where('admin_id', $adminId);
        }

        if ($request->query('from_date') != null) {
            $orders->where('created_at', '>=', $request->query('from_date'));
        }

        if ($request->query('to_date') != null) {
            $orders->where('created_at', '<=', Carbon::parse($request->query('to_date'))->endOfDay());
        }

        return $orders;
    }

    public function getOrderDetails(Request $request): Builder
    {
        $orders = OrderDetail::query();

        if ($status = $request->get('status')) {
            $orders->whereHas('orders', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        if ($adminId = $request->get('admin_id')) {
            $orders->whereHas('orders', function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            });
        }

        if ($userId = $request->get('user_id')) {
            $orders->where('user_id', $userId);
        }

        if ($request->query('from_date') != null) {
            $orders->where('created_at', '>=', $request->query('from_date'));
        }

        if ($request->query('to_date') != null) {
            $orders->where('created_at', '<=', Carbon::parse($request->query('to_date'))->endOfDay());
        }

        return $orders;

    }

    public function getOrdersDataTable(Request $request): LengthAwarePaginator
    {
        $orders = Order::query();

        $admin = auth()->user();
        if (! $admin->hasRole('Admin')) {
            $orders->where('admin_id', $admin->id);
        }

        if (isset($request->get('query')['status']) != null) {
            $orders->where('status', $request->get('query')['status']);
        }

        if (isset($request->get('query')['from_date']) != null) {
            $orders->where('created_at', '>=', $request->get('query')['from_date']);
        }

        if (isset($request->get('query')['to_date']) != null) {
            $orders->where('created_at', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
        }

        $orders = $orders->orderBy($request->get('sort')['field'] ?? 'code', $request->get('sort')['sort'] ?? 'asc')
            ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);

        return $orders;
    }

    public function getRecentOrder(Request $request)
    {
        return Order::orderBy('created_at', 'desc')
            ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
    }
}

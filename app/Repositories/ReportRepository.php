<?php

namespace App\Repositories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function getDataWiseSales(Request $request): \Illuminate\Database\Query\Builder
    {

        $reports = DB::table('orders')
            ->select(DB::raw('DATE(`created_at`) as date, count(*) as total_order, sum(total_price) as total_amount'));

        $admin = auth()->user();
        if (! $admin->hasRole('Admin')) {
            $reports->where('admin_id', $admin->id);
        }

        if ($request->query('from_date') != null) {
            $reports->where('created_at', '>=', $request->query('from_date'));
        }

        if ($request->query('to_date') != null) {
            $reports->where('created_at', '<=', Carbon::parse($request->query('to_date'))->endOfDay());
        }

        $reports = $reports
            ->groupBy(DB::raw('date'));

        return $reports;
    }

    public function getSalesDetails(Request $request): Builder
    {
        $reports = Order::query();

        $admin = auth()->user();
        if (! $admin->hasRole('Admin')) {
            $reports->where('admin_id', $admin->id);
        }

        if ($request->query('from_date') != null) {
            $reports->where('created_at', '>=', $request->query('from_date'));
        }

        if ($request->query('to_date') != null) {
            $reports->where('created_at', '<=', Carbon::parse($request->query('to_date'))->endOfDay());
        }

        return $reports;
    }

    public function getItemWiseSales(Request $request): \Illuminate\Database\Query\Builder
    {
        $reports = DB::table('cart_items')
            ->select(DB::raw('product_translations.name as item, COUNT(*) as total_order, SUM(cart_items.price) as total_amount, products.id as item_id'))
            ->leftJoin('products', 'cart_items.product_id', '=', 'products.id')
            ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->leftJoin('carts', 'cart_items.cart_id', '=', 'carts.id')
            ->leftJoin('orders', 'carts.order_id', '=', 'orders.id')
            ->where('product_translations.locale', app()->getLocale());

        $admin = auth()->user();
        if (! $admin->hasRole('Admin')) {
            $reports->where('cart_items.admin_id', $admin->id);
        }

        if ($request->query('from_date') != null) {
            $reports->where('orders.created_at', '>=', $request->query('from_date'));
        }

        if ($request->query('to_date') != null) {
            $reports->where('orders.created_at', '<=', Carbon::parse($request->query('to_date'))->endOfDay());
        }

        $reports = $reports->groupBy(DB::raw('product_translations.name'))
            ->groupBy(DB::raw('products.id'));

        return $reports;
    }
}

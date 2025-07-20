<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\CheckoutRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShippingDetails;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends ApiController
{
    public function store(CheckoutRequest $request)
    {

        try {
            DB::beginTransaction();

            $items = $request->get('items');

            if (! $items) {
                return $this->respondError(__('api.please_add_items_first'));
            }

            $user = $this->getUser($request);
            if (! $user) {
                return $this->respondError(__('api.user_not_found'));
            }

            $orderDetail = $this->createOrderDetails($request, $user->id);

            $orderDetail->save();

            $vendors = [];
            foreach ($items as $sentItem) {
                $product = Product::query()->find($sentItem['product_id']);
                $cartItem = $this->createCartItem($product, $sentItem);

                $vendors[$cartItem->admin_id][] = $cartItem;
            }

            /**
             * @var  $id
             * @var  $vendor
             * key => id
             * value => vendor
             */
            foreach ($vendors as $id => $vendor) {
                $order = $this->createOrder($user, $id, $orderDetail->id);
                $order->save();

                $cart = $this->createCart($order);
                $cart->save();
                $cart->items()->saveMany($vendor);

                $cart->calculateTotalPrice();
                $order->calculatePrices();
            }

        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            // send an email to the management to inform them.
            return $this->respondError(__($e->getMessage()));
        }
        DB::commit();

        // modify response
        return $this->respondSuccess(['orders' => $orderDetail]);
    }

    public function webCheckout(CheckoutRequest $request): JsonResponse
    {

        try {
            DB::beginTransaction();

            $items = $request->get('items', '[]');
            if (! $items) {
                return $this->respondError(__('api.please_add_items_first'));
            }

            $items = json_decode($items, true);

            $user = $this->getUser($request);
            if (! $user) {
                return $this->respondError(__('api.user_not_found'));
            }

            $orderDetail = $this->createOrderDetails($request, $user->id);
            $orderDetail->save();

            $vendors = [];
            foreach ($items as $sentItem) {
                $product = Product::query()->find($sentItem['product_id']);
                $cartItem = $this->createCartItem($product, $sentItem);

                $vendors[$cartItem->admin_id][] = $cartItem;
            }

            /**
             * @var  $id
             * @var  $vendor
             */
            foreach ($vendors as $id => $vendor) {
                $order = $this->createOrder($user, $id, $orderDetail->id);
                $order->save();

                $cart = $this->createCart($order);
                $cart->save();
                $cart->items()->saveMany($vendor);

                $cart->calculateTotalPrice();
                $order->calculatePrices();
            }

        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            // send an email to the management to inform them.
            return $this->respondError(__($e->getMessage()));
        }
        DB::commit();

        // modify response
        return $this->respondSuccess(['orders' => $orderDetail]);
    }

    public function createOrderDetails(Request $request, $userId): OrderDetail
    {
        $fillableAttributes = app(ShippingDetails::class)->getFillable();

        if ($request->hasAny($fillableAttributes)) {
            $shippingDetails = ShippingDetails::query()->create($request->only($fillableAttributes));

            return new OrderDetail([
                'user_id' => $userId,
                'shipping_details_id' => $shippingDetails->id,
            ]);
        }

        return new OrderDetail([
            'user_id' => $userId,
        ]);
    }

    public function createOrder(User $user, $vendorId, $orderDetailId): Order
    {
        return new Order([
            'user_id' => $user->id,
            'admin_id' => $vendorId,
            'order_detail_id' => $orderDetailId,
        ]);
    }

    public function createCart(Order $order): Cart
    {
        return new Cart([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'status' => 1,
            'currency_id' => getAppCurrency()->id,
        ]);
    }

    public function createCartItem($product, $sentItem): CartItem
    {
        return new CartItem([
            'product_id' => $sentItem['product_id'],
            'qty' => $sentItem['qty'] ?? 1,
            'price' => round($product->getRawOriginal('price') * $sentItem['qty'], 2),
            'price_before_discount' => round($product->getRawOriginal('price_before_discount') * $sentItem['qty'], 2),
            'admin_id' => $product->admin_id,
        ]);
    }
}

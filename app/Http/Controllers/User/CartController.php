<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShippingDetails;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function getIndex()
    {
        $cart = Cart::with('items')->notActive()->where('user_id', auth('user')->id())->first();
        if (! is_null($cart) && $cart->items()->count() > 0) {
            foreach ($cart->items as $item) {
                $item->ranges = DB::table('product_price_ranges')
                    ->where('product_id', $item->product_id)
                    ->get(['id', 'price', 'range_start', 'range_end']);
            }
        }

        return view('website.pages.cart.cart', compact('cart'));
    }

    public function getOrders()
    {
        $user = User::query()
            ->where('id', auth('user')
                ->id())->first();
        $order = $user->orders()
            ->orderByDesc('created_at')->first();

        return view('website.pages.cart.order', compact('user', 'order'));
    }

    public function showOrder($code)
    {
        $user = auth('user')->user();

        $order = Order::query()->with('orderDetail')
            ->whereCode($code)
            ->first();

        if (! $order) {
            abort(404);
        }

        return view('website.pages.cart.order', compact('user', 'order'));
    }

    public function checkout()
    {
        $user = auth('user')->user();
        $cart = Cart::query()->notActive()->whereUserId($user->id)->first();
        if ($cart) {
            $BillingAddress = $user->shippingDetails()
                ->orderByDesc('created_at')->first();
            request()->session()->flash('message', __('front.thanks_for_ordering'));

            return view('website.pages.cart.checkout', compact('cart', 'user', 'BillingAddress'));
        } else {
            request()->session()->flash('warring', __('front.you_dont_have_any_item'));

            return redirect()->route('user.products.index');
        }

    }

    public function AddToCart(Request $request): JsonResponse
    {
        $product = Product::query()->findOrFail($request->get('id'));
        $userId = auth('user')->id();
        $quantity = $request->get('quantity') ?? 1;
        if (! $this->updateInventory($product->id, $quantity)) {
            return response()->json(['message' => 'Out of Stock'], 404);
        }
        $cart = Cart::query()->notActive()->whereUserId($userId)->first();
        if ($cart) {
            $this->createCartItem($product, $quantity, $cart);
        } else {
            $cart = $this->createCart();
            $cart->save();
            $this->createCartItem($product, $quantity, $cart);
        }
        $cart = Cart::find($cart->id);
        $cart->calculateTotalPrice();
        $countCartItems = getCountCartItems();

        return response()->json(['message' => 'success', 'value' => __('front.add_to_cart'), 'countItems' => $countCartItems], 200);
    }

    public function updateInventory($product_id, $quantity)
    {
        $inventory = DB::table('inventory')->where('product_id', $product_id);
        if ($inventory->exists()) {
            if ($inventory->first()->quantity > $quantity) {
                return $inventory->update(['quantity' => $inventory->first()->quantity - $quantity]);
            } else {
                return false;
            }
        }
    }

    public function removeProduct(Request $request): JsonResponse
    {
        if ($request->has('product_id')) {
            $cartItem = CartItem::whereCartId($request->get('cart_id'))->whereProductId($request->get('product_id'))->first();
            $cartItem->delete();
            $this->restorInventory($request->product_id, $cartItem->qty);
            $cart = Cart::find($request->get('cart_id'));
            $cart->calculateTotalPrice();
            if ($cart->items()->count() == 0) {
                $cart->delete();
            }
        } else {
            $cartItems = CartItem::whereCartId($request->get('cart_id'))->get();
            foreach ($cartItems as $item) {
                $this->restorInventory($item->product_id, $item->qty);
                $item->delete();
            }
            $cart = Cart::findOrFail($request->get('cart_id'));
            $cart->delete();

            return response()->json(['message' => 'success', 'value' => __('front.clear_cart_items')], 200);
        }
        $countCartItems = getCountCartItems();

        return response()->json(['message' => 'success', 'status' => 200, 'value' => __('front.remove_from_cart'), 'countItems' => $countCartItems]);

    }

    public function restorInventory($product_id, $quantity)
    {
        $inventory = DB::table('inventory')->where('product_id', $product_id);
        if ($inventory->exists()) {
            $inventory->update(['quantity' => $inventory->first()->quantity + $quantity]);
        }
    }

    public function update(Request $request)
    {
        $quantities = json_decode($request->get('quantities'), true);
        foreach ($quantities as $itemId => $qty) {
            $id = intval(getStringBetween($itemId, '[', ']'));
            $item = CartItem::query()->find($id);
            if ($item === null) {
                return response()->json(['message' => 'product not found'], 404);
            }
            $this->restorInventory($item->product_id, $item->qty);
            if (! $this->updateInventory($item->product_id, $qty)) {
                $this->updateInventory($item->product_id, $item->qty);

                return response()->json(['message' => 'Stock quantity is not sufficient for this order'], 404);
            }
            $ranges = DB::table('product_price_ranges')->where('product_id', $item->product_id)->get();
            $price = round($item->product->getRawOriginal('price') * $qty, 2);
            if (isset($ranges) && ! is_null($ranges)) {
                foreach ($ranges as $range) {
                    if ($qty > $range->range_start && $qty <= $range->range_end) {
                        $price = round($range->price * $qty, 2);
                    }
                }
            }
            $item->update([
                'qty' => $qty,
                'price' => $price,
                'price_before_discount' => round($item->product->getRawOriginal('price_before_discount') * $qty, 2),
            ]);
        }
        $cart = Cart::query()->find($request->get('cart_id'));
        $cart->calculateTotalPrice();

        return response()->json(['message' => 'success', 'status' => 200, 'value' => __('front.update_the_cart'), 'data' => $cart]);
    }

    public function proceedToCheckout(Request $request): RedirectResponse
    {
        $payWithCards = $request->has('cards_payment') && $request->cards_payment == 'true';
        $items = $request->get('items');
        $user = auth('user')->user();
        $cart = Cart::notActive()->whereUserId($user->id)->firstOrFail();
        $cartItems = CartItem::whereCartId($cart->id)->get();
        $userAddressDetails = $user->shippingDetails()->orderByDesc('created_at')->first();
        try {
            $coupon = $request->filled('coupon') ? Coupon::findOrFail($request->coupon) : null;
            if (! $userAddressDetails) {
                $shippingDetails = $this->createShippingDetails($request->all(), $user);
            } elseif ($request->has('checkeds')) {
                $shippingDetails = $this->createShippingDetails($request->all(), $user);
            } else {
                $shippingDetails = $userAddressDetails;
            }
            $shippingPrice = $cart->calculateShippingPrice();
            $orderDetails = $this->createOrderDetails($user->id, $shippingDetails->id, $shippingPrice);
            $orderDetails->save();
            $order = $this->createOrder($user->id, $cartItems->first()->admin_id, $orderDetails->id, $coupon);
            $order->save();
            $cart->update(['order_id' => $order->id, 'status' => 1]);
            foreach ($cartItems as $key => $item) {
                $cart->items()->save($item);
            }
            $cart->calculateTotalPrice();
            $order->calculatePrices($shippingPrice);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        $request->session()->flash('success', __('front.your_order_has_been_created_successfully'));
        if ($payWithCards) {
            return redirect()->route('payment.item', ['id' => $order->id, 'type' => 'order']);
        }

        return redirect()->route('user.order');
    }

    public function createShippingDetailsFromUser()
    {
        $user = auth('user')->user();
        $this->createShippingDetails($user->toArray(), $user);

        return redirect()->back()->with('success', 'shipping Details created based on your info');
    }

    /* CREATE MODELS FUNCTIONS */

    public function createCart($orderId = null, $status = 0): Cart
    {
        return new Cart([
            'user_id' => auth('user')->id(),
            'currency_id' => getAppCurrency()->id,
            'order_id' => $orderId,
            'status' => $status ?? 0,
        ]);
    }

    public function createOrderDetails($userId, $shippingDetailsId, $shippingFees = 0): OrderDetail
    {
        return new OrderDetail([
            'user_id' => $userId,
            'shipping_details_id' => $shippingDetailsId,
            'shipping_fees' => $shippingFees,
        ]);
    }

    public function createOrder($userId, $vendorId, $orderDetailId, $coupon = null): Order
    {
        return new Order([
            'user_id' => $userId,
            'admin_id' => $vendorId,
            'currency_id' => getAppCurrency()->id,
            'order_detail_id' => $orderDetailId,
            'coupon_id' => $coupon->id ?? null,
        ]);
    }

    public function createShippingDetails($request, $user): ShippingDetails
    {
        return $user->shippingDetails()->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'city_id' => $request['city_id'] ?? null,
            'post_code' => $request['post_code'] ?? 00000,
            'address' => $request['address'] ?? 'address',
            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
        ]);
    }

    public function createOtherDetails($request): ShippingDetails
    {
        return new ShippingDetails([
            'user_id' => auth('user')->id(),
            'first_name' => $request['firstname'],
            'last_name' => $request['lastname'],
            'city_id' => null,
            'post_code' => $request['postcode'] ?? 00000,
            'main' => 0,
            'address' => $request['billing_address'] ?? 'address',
            'phone_number' => $request['mobile'],
            'email' => $request['email2'],
        ]);
    }

    public function createCartItem($product, $quantity, $cart)
    {
        $cart->items()->create([
            'product_id' => $product->id,
            'qty' => $quantity,
            'price' => $product->getRawOriginal('price') * $quantity,
            'price_before_discount' => $product->getRawOriginal('price_before_discount') * $quantity,
            'admin_id' => $product->admin_id,
        ]);
    }

    public function fetchData(): JsonResponse
    {
        $cart = Cart::notActive()->whereUserId(auth('user')->id())->first();
        if ($cart and count($cart->items) > 0) {
            $data = '';
            $items = $cart->items()->orderByDesc('created_at')->get();
            foreach ($items as $item) {
                $data .= view('website.section.cart-item', compact('item'));
            }
            $subtotal = $cart->total_price.' '.getAppCurrency()->symbol;

            return response()->json(['data' => $data, 'subtotal' => $subtotal]);
        } else {
            return response()->json(['message' => __('front.no_result')]);
        }

    }
}

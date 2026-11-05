<?php
namespace App\Http\Controllers;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function index(CartService $cart): View
    {
        return view('checkout.index', ['cart' => $cart->getCart()->load('items.product')]);
    }

    public function store(Request $request, CartService $cart): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $currentCart = $cart->getCart()->load('items');
        if ($currentCart->items->isEmpty()) {
            return back()->withErrors(['cart' => __('Your cart is empty.')])->withInput();
        }

        $order = $currentCart->order()->save(Order::factory()->make([
            ...$validated,
            'code' => 'OR-'.Str::upper(Str::random(9)),
        ]));

        OrderCreated::dispatch($order);

        return redirect()->to($order->getOrderCompletePath());
    }
}

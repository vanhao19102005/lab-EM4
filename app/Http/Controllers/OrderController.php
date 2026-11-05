<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
class OrderController extends Controller
{
    public function show(Request $request, Order $order): View
    {
        abort_unless($request->hasValidSignature(), 403);
        $order->load('cart.items.product');
        return view('checkout.show', compact('order'));
    }
}

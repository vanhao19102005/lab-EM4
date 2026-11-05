<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller { public function show(Request $request, Order $order) { abort_unless($request->hasValidSignature(), 403); $order->load('cart.items.product'); return view('orders.show', compact('order')); } }

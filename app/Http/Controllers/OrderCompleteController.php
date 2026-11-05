<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
class OrderCompleteController extends Controller
{
    public function __invoke(Request $request, Order $order): View
    {
        abort_unless($request->hasValidSignature(), 403);
        return view('orders.complete', compact('order'));
    }
}

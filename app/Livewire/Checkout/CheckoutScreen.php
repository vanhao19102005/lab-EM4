<?php
namespace App\Livewire\Checkout;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
class CheckoutScreen extends Component {
 public string $full_name=''; public string $phone_number=''; public string $email=''; public string $shipping_address=''; public string $notes='';
 public function getCartProperty() { return app(CartService::class)->getCart()->load('items.product'); }
 public function placeOrder(CartService $service) {
  $this->validate(['full_name'=>'required|string|max:255','phone_number'=>'required|string|max:40','email'=>'required|email|max:255','shipping_address'=>'required|string|max:500','notes'=>'nullable|string|max:1000']);
  $cart=$service->getCart()->load('items.product'); if($cart->items->isEmpty()){ $this->addError('cart','Your cart is empty.'); return; }
  $order=Order::create(['cart_id'=>$cart->id,'code'=>'OR-'.Str::upper(Str::random(9)),'full_name'=>$this->full_name,'phone_number'=>$this->phone_number,'email'=>$this->email,'shipping_address'=>$this->shipping_address,'notes'=>$this->notes ?: null]);
  Log::info('New order placed',['order_id'=>$order->id,'code'=>$order->code,'email'=>$order->email]);
  OrderCreated::dispatch($order);
  return $this->redirect($order->getCheckoutConfirmationPath(), navigate: true);
 }
 public function render(){return view('livewire.checkout.checkout-screen')->layout('layouts.app',['title'=>__('Checkout')]);}
}

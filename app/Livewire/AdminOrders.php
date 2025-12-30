<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class AdminOrders extends Component
{

    public $updatingOrderId;
    public $newStatus;

    public function updateStatus($orderId, $status)
    {
        if(!Auth::user()->is_admin) abort(403);

        $order = Order::findOrFail($orderId);
        if(in_array($status, array_keys(Order::STATUSES))) {
            $order->update(['status' => $status]);
            $this->dispatch('alert', type: 'success', message: 'Status updated!');
        }
    }

    public function render()
    {
        if(!Auth::user()->is_admin) abort(403);

        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(10);

        $statuses = Order::STATUSES;

        return view('livewire.admin-orders', compact('orders', 'statuses'));
    }
}

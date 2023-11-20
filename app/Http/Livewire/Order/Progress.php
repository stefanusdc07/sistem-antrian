<?php

namespace App\Http\Livewire\Order;
use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;

class Progress extends Component
{
    public function render()
    {
    
        $onProgress = Order::where('status', 1)->where('day', Carbon::now()->format('Y-m-d'))->take(2)->get();


        $next = Order::where('status', 0)
            ->where('day', Carbon::now()->format('Y-m-d'))
            ->orderBy('daily_slot_id', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->take(3)->get();

    return view('livewire.order.progress', compact('onProgress' , 'next'));
    }
}

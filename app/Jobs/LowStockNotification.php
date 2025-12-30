<?php

namespace App\Jobs;

use App\Models\Product;
use App\Mail\LowStockAlertMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class LowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Product $product) {}

    public function handle()
    {
        $adminEmail = 'admin@example.com'; // dummy admin
        Mail::to($adminEmail)->send(new LowStockAlertMail($this->product));
    }
}

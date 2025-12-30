<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
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

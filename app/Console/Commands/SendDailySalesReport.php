<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReportMail;
use App\Models\OrderItem;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $start = today();
        $end = today()->endOfDay();

        $orderItems = OrderItem::with('product')
            ->whereHas('order', fn($q) => $q->whereBetween('placed_at', [$start, $end]))
            ->get();

        if ($orderItems->isEmpty()) {
            // Optionally send "no sales" email or skip
            return;
        }

        Mail::to('admin@example.com')->send(new DailySalesReportMail($orderItems));
    }
}

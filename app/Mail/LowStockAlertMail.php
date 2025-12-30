<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class LowStockAlertMail extends Mailable
{
    public function __construct(public Product $product)
    {
    }

    public function build()
    {
        return $this->subject('Low Stock Alert')
            ->view('emails.low-stock')
            ->with('product', $this->product);
    }
}

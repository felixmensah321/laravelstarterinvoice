<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class InvoiceNumberGenerator
{
    public function generate(Setting $setting): string
    {
        return $setting->generateInvoiceNumber();
    }
}

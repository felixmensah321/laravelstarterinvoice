<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('recurring_enabled')->default(false)->after('notes');
            $table->enum('recurring_frequency', ['monthly', 'quarterly', 'semi_annual', 'annual'])->nullable()->after('recurring_enabled');
            $table->unsignedTinyInteger('recurring_frequency_months')->nullable()->after('recurring_frequency');
            $table->date('business_start_date')->nullable()->after('recurring_frequency_months');
            $table->date('next_invoice_date')->nullable()->after('business_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'recurring_enabled',
                'recurring_frequency',
                'recurring_frequency_months',
                'business_start_date',
                'next_invoice_date',
            ]);
        });
    }
};

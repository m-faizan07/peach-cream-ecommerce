<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('fallback_quantity')->default(99);
            $table->decimal('fallback_original_price', 10, 2)->default(60.00);
            $table->decimal('fallback_sale_price', 10, 2)->default(50.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

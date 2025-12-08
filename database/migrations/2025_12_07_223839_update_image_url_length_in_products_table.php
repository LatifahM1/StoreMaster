<?php
// database/migrations/2025_12_07_xxxxxx_update_image_url_length_in_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // غير النوع من string إلى text ليستوعب روابط طويلة
            $table->text('image_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_url', 255)->nullable()->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->decimal('price_adult', 10, 2)->default(0)->after('description');
            $table->decimal('price_child', 10, 2)->default(0)->after('price_adult');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['price_adult', 'price_child']);
            $table->decimal('price', 10, 2)->default(0)->after('description');
        });
    }
};

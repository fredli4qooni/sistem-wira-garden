<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('description');
            $table->string('category')->nullable()->after('price');
            $table->json('facilities')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['price', 'category', 'facilities']);
        });
    }
};

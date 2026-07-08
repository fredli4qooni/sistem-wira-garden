<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete()->after('order_id');
        });

        // Pindahkan data dari orders ke order_items
        DB::statement('UPDATE order_items JOIN orders ON orders.id = order_items.order_id SET order_items.destination_id = orders.destination_id');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete()->after('id');
        });

        DB::statement('UPDATE orders JOIN order_items ON orders.id = order_items.order_id SET orders.destination_id = order_items.destination_id');

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }
};

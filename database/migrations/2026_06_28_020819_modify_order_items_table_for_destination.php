<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('ticket_type_id')->nullable()->change();
            $table->string('ticket_name')->nullable()->after('ticket_type_id');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('ticket_name');
            $table->foreignId('ticket_type_id')->nullable(false)->change();
        });
    }
};

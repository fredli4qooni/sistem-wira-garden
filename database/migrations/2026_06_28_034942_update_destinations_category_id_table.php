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
        Schema::table('destinations', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('price_child')->constrained('categories')->nullOnDelete();
        });

        // Migrate existing category string data to Category models
        $destinations = DB::table('destinations')->whereNotNull('category')->get();
        foreach ($destinations as $dest) {
            $categoryName = $dest->category;
            // Check if category already exists
            $category = DB::table('categories')->where('name', $categoryName)->first();
            if (!$category) {
                // Insert new category
                $categoryId = DB::table('categories')->insertGetId([
                    'name' => $categoryName,
                    'icon_type' => 'svg',
                    'icon_value' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $categoryId = $category->id;
            }
            // Update destination with category_id
            DB::table('destinations')->where('id', $dest->id)->update(['category_id' => $categoryId]);
        }

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('category')->nullable()->after('price_child');
        });
        
        $destinations = DB::table('destinations')->whereNotNull('category_id')->get();
        foreach ($destinations as $dest) {
            $category = DB::table('categories')->where('id', $dest->category_id)->first();
            if ($category) {
                DB::table('destinations')->where('id', $dest->id)->update(['category' => $category->name]);
            }
        }

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

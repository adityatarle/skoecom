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
        Schema::table('product_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->tinyInteger('level')->default(1)->after('parent_id'); // 1=Top, 2=Parent, 3=Child
            $table->string('slug')->nullable()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->boolean('is_active')->default(true)->after('description');
            $table->integer('sort_order')->default(0)->after('is_active');
            
            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->index(['parent_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id', 'level']);
            $table->dropColumn(['parent_id', 'level', 'slug', 'description', 'is_active', 'sort_order']);
        });
    }
};

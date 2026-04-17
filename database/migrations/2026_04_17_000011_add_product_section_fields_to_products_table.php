<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'tagline')) {
                $table->string('tagline')->nullable()->after('title');
            }
            if (! Schema::hasColumn('products', 'review_count')) {
                $table->unsignedInteger('review_count')->default(0)->after('discount');
            }
            if (! Schema::hasColumn('products', 'original_price')) {
                $table->decimal('original_price', 10, 2)->nullable()->after('price');
            }
            if (! Schema::hasColumn('products', 'badges_json')) {
                $table->json('badges_json')->nullable()->after('main_image');
            }
            if (! Schema::hasColumn('products', 'gallery_images_json')) {
                $table->json('gallery_images_json')->nullable()->after('badges_json');
            }
            if (! Schema::hasColumn('products', 'tabs_json')) {
                $table->json('tabs_json')->nullable()->after('gallery_images_json');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['tagline', 'review_count', 'original_price', 'badges_json', 'gallery_images_json', 'tabs_json'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

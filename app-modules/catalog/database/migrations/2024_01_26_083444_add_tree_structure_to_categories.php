<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->string('url_key')->nullable();
            $table->string('url_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('show_in_menu')->default(false);

            $table->string('seo_name')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('include_in_sitemap')->default(true);

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories');

            $table->smallInteger('level')->default(1);
            $table->string('xpath')->nullable();
        });

        // DB::table('categories')->insert([
        //     [
        //         'id' => 1,
        //         'name' => 'Каталог',
        //         'parent_id' => null,
        //         'level' => 0,
        //         'xpath' => 1,
        //     ],
        // ]);
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'url_key',
                'url_path',
                'description',
                'is_popular',
                'show_in_menu',
                'seo_name',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'include_in_sitemap',
                'parent_id',
                'level',
                'xpath'
            ]);
        });
    }
};

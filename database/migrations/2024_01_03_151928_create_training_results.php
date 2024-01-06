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
        Schema::create('training_results', function (Blueprint $table) {
            $table->uuid('id',36)->primary();
            // トレーニング実績は、必ずユーザーがいるので、外部キー制約
            //user_idはuuidなので、foreignUuIdを使用。
            $table->foreignUuId('user_id')->constrained()->onDelete('cascade');
            // トレーニング実績は、必ずカテゴリに紐づくので、外部キー制約
            // カテゴリは、普通のidなのでforeignIdを使用。
            // $table->foreignId('category_id')->constrained();
            $table->foreignId('training_areas_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('deleted_at')->nullable();
            //ソフトデリートを定義
            $table->softDeletes();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_results');
    }
};

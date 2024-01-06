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
        Schema::create('training_equipments', function (Blueprint $table) {
            $table->id();
            //training_resultsがないのに、器具だけあるのはあり得ないので、training_results_idを外部キー制約としている。
            $table->foreignUuId('training_results_id')->constrained()->onDelete('cascade');
            $table->string('name');
            // $table->string('quantity');
            $table->string('weight');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_equipments');
    }
};

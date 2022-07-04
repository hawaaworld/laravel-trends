<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('energies', static function (Blueprint $table) {
            $table->id();
            $table->string('energiser_type');
            $table->unsignedBigInteger('energiser_id');
            $table->unique(['energiser_type', 'energiser_id']);
            $table->float('amount')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('energies');
    }
};

<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

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
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->text('cards');
            $table->unsignedBigInteger('user_id')->comment('Owner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @codeCoverageIgnore
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboards');
    }
};

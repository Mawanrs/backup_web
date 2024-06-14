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
        Schema::create('homes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_1')->nullable();
            $table->longText('description')->nullable();
            $table->longText('layanan')->nullable();
            $table->longText('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};

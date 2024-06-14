<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('icon')->nullable();
            $table->string('layanan')->nullable();
            $table->string('detail_layanan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


};

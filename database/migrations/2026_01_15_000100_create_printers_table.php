<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip')->nullable();
            $table->string('model')->nullable();
            $table->enum('status', ['online', 'offline', 'maintenance'])->default('offline');
            $table->boolean('is_available')->default(false);
            $table->unsignedInteger('queue_length')->default(0);
            $table->boolean('color_support')->default(true);
            $table->boolean('duplex_support')->default(true);
            $table->unsignedTinyInteger('priority')->default(5);
            $table->timestamp('last_checked')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};


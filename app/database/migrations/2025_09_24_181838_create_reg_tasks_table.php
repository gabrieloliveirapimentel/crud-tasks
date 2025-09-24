<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reg_tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(DB::raw('gen_random_uuid()'));
            $table->timestamps();
            $table->softDeletes();
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('id_status');
            $table->foreign('id_status')->references('id')->on('inf_tasks_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reg_tasks');
    }
};

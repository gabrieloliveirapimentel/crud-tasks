<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inf_tasks_status', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(DB::raw('gen_random_uuid()'));
            $table->timestamps();
            $table->softDeletes();
            $table->string('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inf_tasks_status');
    }
};

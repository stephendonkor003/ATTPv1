<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('myb_projects', function (Blueprint $table) {
            $table->string('project_id', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('myb_projects', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->change();
        });
    }
};

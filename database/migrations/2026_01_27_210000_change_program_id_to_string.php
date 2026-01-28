<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `myb_programs` MODIFY `program_id` VARCHAR(50) NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `myb_programs` MODIFY `program_id` BIGINT UNSIGNED NULL");
    }
};

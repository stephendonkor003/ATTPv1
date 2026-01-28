<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('myb_governance_levels', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('myb_governance_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')
                ->constrained('myb_governance_levels')
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('effective_start')->nullable();
            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->index(['level_id', 'status']);
        });

        Schema::create('myb_governance_reporting_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_node_id')
                ->constrained('myb_governance_nodes')
                ->cascadeOnDelete();
            $table->foreignId('parent_node_id')
                ->constrained('myb_governance_nodes')
                ->cascadeOnDelete();
            $table->string('line_type')->default('primary');
            $table->date('effective_start')->nullable();
            $table->date('effective_end')->nullable();
            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->index(['child_node_id', 'line_type']);
        });

        Schema::create('myb_governance_node_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')
                ->constrained('myb_governance_nodes')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('role_title')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->date('effective_start')->nullable();
            $table->date('effective_end')->nullable();
            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->index(['node_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('myb_governance_node_assignments');
        Schema::dropIfExists('myb_governance_reporting_lines');
        Schema::dropIfExists('myb_governance_nodes');
        Schema::dropIfExists('myb_governance_levels');
    }
};

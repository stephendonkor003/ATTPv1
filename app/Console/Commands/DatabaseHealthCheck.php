<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:health-check
                            {--detailed : Show detailed information}
                            {--fix : Attempt to fix common issues}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database health and identify potential issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏥 Running Database Health Check...');
        $this->newLine();

        $issues = 0;
        $warnings = 0;

        // 1. Check database connection
        if (!$this->checkDatabaseConnection()) {
            $this->error('❌ Database connection failed!');
            return 1;
        }

        // 2. Get all tables
        $tables = $this->getAllTables();
        $this->info("✅ Found {$tables->count()} tables in database");
        $this->newLine();

        // 3. Check each table
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_" . config('database.connections.mysql.database')};

            if ($this->option('detailed')) {
                $this->line("📋 Checking table: <comment>{$tableName}</comment>");
            }

            // Check for timestamps
            if (!$this->hasTimestamps($tableName)) {
                $warnings++;
                $this->warn("⚠️  Table '{$tableName}' missing created_at/updated_at timestamps");
            }

            // Check for indexes on foreign keys
            $missingIndexes = $this->checkForeignKeyIndexes($tableName);
            if (!empty($missingIndexes)) {
                $issues++;
                $this->error("❌ Table '{$tableName}' missing indexes: " . implode(', ', $missingIndexes));
            }

            // Check for orphaned records
            $orphaned = $this->checkOrphanedRecords($tableName);
            if ($orphaned > 0) {
                $issues++;
                $this->error("❌ Table '{$tableName}' has {$orphaned} orphaned records");
            }
        }

        $this->newLine();

        // 4. Summary
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('📊 Database Health Check Summary');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line("Total Tables: <info>{$tables->count()}</info>");
        $this->line("Issues Found: " . ($issues > 0 ? "<error>{$issues}</error>" : "<info>0</info>"));
        $this->line("Warnings: " . ($warnings > 0 ? "<comment>{$warnings}</comment>" : "<info>0</info>"));

        if ($issues === 0 && $warnings === 0) {
            $this->newLine();
            $this->info('✨ Database is healthy! No issues found.');
        }

        $this->newLine();

        return $issues > 0 ? 1 : 0;
    }

    /**
     * Check database connection
     */
    private function checkDatabaseConnection(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all tables in database
     */
    private function getAllTables()
    {
        return DB::select('SHOW TABLES');
    }

    /**
     * Check if table has timestamps
     */
    private function hasTimestamps(string $table): bool
    {
        try {
            return Schema::hasColumn($table, 'created_at') && Schema::hasColumn($table, 'updated_at');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check for indexes on foreign key columns
     */
    private function checkForeignKeyIndexes(string $table): array
    {
        $missing = [];

        try {
            $columns = DB::select("SHOW COLUMNS FROM {$table}");

            foreach ($columns as $column) {
                // Check if column name ends with _id (potential foreign key)
                if (str_ends_with($column->Field, '_id')) {
                    // Check if it has an index
                    $indexes = DB::select("SHOW INDEXES FROM {$table} WHERE Column_name = ?", [$column->Field]);

                    if (empty($indexes)) {
                        $missing[] = $column->Field;
                    }
                }
            }
        } catch (\Exception $e) {
            // Table might not exist or error accessing it
        }

        return $missing;
    }

    /**
     * Check for orphaned records (records with foreign keys pointing to non-existent records)
     */
    private function checkOrphanedRecords(string $table): int
    {
        $orphaned = 0;

        try {
            // Get foreign key constraints
            $foreignKeys = DB::select("
                SELECT
                    COLUMN_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                FROM
                    information_schema.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = ? AND
                    TABLE_NAME = ? AND
                    REFERENCED_TABLE_NAME IS NOT NULL
            ", [config('database.connections.mysql.database'), $table]);

            foreach ($foreignKeys as $fk) {
                // Check for orphaned records
                $count = DB::select("
                    SELECT COUNT(*) as count
                    FROM {$table} t
                    LEFT JOIN {$fk->REFERENCED_TABLE_NAME} ref
                        ON t.{$fk->COLUMN_NAME} = ref.{$fk->REFERENCED_COLUMN_NAME}
                    WHERE t.{$fk->COLUMN_NAME} IS NOT NULL
                        AND ref.{$fk->REFERENCED_COLUMN_NAME} IS NULL
                ");

                if (isset($count[0]) && $count[0]->count > 0) {
                    $orphaned += $count[0]->count;

                    if ($this->option('detailed')) {
                        $this->warn("  ⚠️  {$count[0]->count} orphaned records in {$table}.{$fk->COLUMN_NAME}");
                    }
                }
            }
        } catch (\Exception $e) {
            // Error checking orphaned records
        }

        return $orphaned;
    }
}

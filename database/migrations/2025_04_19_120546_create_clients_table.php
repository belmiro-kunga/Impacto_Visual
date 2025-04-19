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
        // Only run if the table exists
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                // Add email column if it doesn't exist
                if (!Schema::hasColumn('clients', 'email')) {
                    $table->string('email')->nullable()->after('name');
                }
                
                // Add website column if it doesn't exist
                if (!Schema::hasColumn('clients', 'website')) {
                    $table->string('website')->nullable()->after('logo');
                }
                
                // Add active column if it doesn't exist
                if (!Schema::hasColumn('clients', 'active')) {
                    $table->boolean('active')->default(true)->after('order');
                }
            });
        } else {
            // Create the table if it doesn't exist
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('logo')->nullable();
                $table->string('website')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table, just remove the added columns
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                if (Schema::hasColumn('clients', 'email')) {
                    $table->dropColumn('email');
                }
            });
        }
    }
};

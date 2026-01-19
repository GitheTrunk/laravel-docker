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
        Schema::table('comments', function (Blueprint $table) {
            // Add commentable columns if they don't exist
            if (!Schema::hasColumn('comments', 'commentable_id')) {
                $table->unsignedBigInteger('commentable_id')->after('user_id');
            }
            if (!Schema::hasColumn('comments', 'commentable_type')) {
                $table->string('commentable_type')->after('commentable_id');
            }
            
            // Rename 'name' to 'content' for better clarity
            if (Schema::hasColumn('comments', 'name')) {
                $table->renameColumn('name', 'content');
            }
            
            // Add index for polymorphic relationship
            $table->index(['commentable_id', 'commentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['commentable_id', 'commentable_type']);
            
            if (Schema::hasColumn('comments', 'content')) {
                $table->renameColumn('content', 'name');
            }
            
            $table->dropColumn(['commentable_id', 'commentable_type']);
        });
    }
};

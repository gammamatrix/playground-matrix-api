<?php

declare(strict_types=1);
/**
 * Playground
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matrix_teams', function (Blueprint $table) {
            // Primary key

            $table->uuid('id')->primary();

            // IDs

            $table->uuid('created_by_id')->nullable()->index();
            $table->uuid('modified_by_id')->nullable()->index();
            $table->uuid('owned_by_id')->nullable()->index();
            $table->uuid('parent_id')->nullable()->index();
            $table->string('team_type')->nullable()->index();
            $table->uuid('backlog_id')->nullable()->index();
            $table->uuid('board_id')->nullable()->index();
            $table->uuid('epic_id')->nullable()->index();
            $table->uuid('flow_id')->nullable()->index();
            $table->uuid('milestone_id')->nullable()->index();
            $table->uuid('note_id')->nullable()->index();
            $table->uuid('project_id')->nullable()->index();
            $table->uuid('release_id')->nullable()->index();
            $table->uuid('roadmap_id')->nullable()->index();
            $table->uuid('source_id')->nullable()->index();
            $table->uuid('sprint_id')->nullable()->index();
            $table->uuid('tag_id')->nullable()->index();
            $table->uuid('ticket_id')->nullable()->index();
            $table->uuid('version_id')->nullable()->index();

            // Dates

            $table->timestamps();

            $table->softDeletes();

            $table->dateTime('start_at')->nullable()->index();
            $table->dateTime('planned_start_at')->nullable();
            $table->dateTime('end_at')->nullable()->index();
            $table->dateTime('planned_end_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('closed_at')->nullable()->index();
            $table->dateTime('embargo_at')->nullable();
            $table->dateTime('fixed_at')->nullable();
            $table->dateTime('postponed_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('released_at')->nullable();
            $table->dateTime('resumed_at')->nullable();
            $table->dateTime('resolved_at')->nullable()->index();
            $table->dateTime('suspended_at')->nullable();

            // Permissions

            $table->bigInteger('gids')->default(0)->unsigned();
            $table->tinyInteger('po')->default(0)->unsigned();
            $table->tinyInteger('pg')->default(0)->unsigned();
            $table->tinyInteger('pw')->default(0)->unsigned();
            $table->boolean('only_admin')->default(0);
            $table->boolean('only_user')->default(0);
            $table->boolean('only_guest')->default(0);
            $table->boolean('allow_public')->default(0);

            // Status

            $table->bigInteger('status')->default(0)->unsigned();
            $table->bigInteger('rank')->default(0);
            $table->bigInteger('size')->default(0);

            // Matrix

            $table->string('matrix')->default('');
            $table->bigInteger('x')->nullable();
            $table->bigInteger('y')->nullable();
            $table->bigInteger('z')->nullable();
            $table->decimal('r', 65, 10)->nullable()->default(null);
            $table->decimal('theta', 10, 6)->nullable()->default(null);
            $table->decimal('rho', 10, 6)->nullable()->default(null);
            $table->decimal('phi', 10, 6)->nullable()->default(null);
            $table->decimal('elevation', 65, 10)->nullable()->default(null);
            $table->decimal('latitude', 8, 6)->nullable()->default(null);
            $table->decimal('longitude', 9, 6)->nullable()->default(null);

            // Flags

            $table->boolean('active')->default(1)->index();
            $table->boolean('canceled')->default(0);
            $table->boolean('closed')->default(0);
            $table->boolean('completed')->default(0);
            $table->boolean('duplicate')->default(0);
            $table->boolean('fixed')->default(0);
            $table->boolean('flagged')->default(0);
            $table->boolean('internal')->default(0);
            $table->boolean('locked')->default(0);
            $table->boolean('pending')->default(0);
            $table->boolean('planned')->default(0);
            $table->boolean('problem')->default(0);
            $table->boolean('published')->default(0);
            $table->boolean('released')->default(0);
            $table->boolean('retired')->default(0);
            $table->boolean('resolved')->default(0);
            $table->boolean('suspended')->default(0);
            $table->boolean('unknown')->default(0);

            // Strings

            $table->string('label')->default('');
            $table->string('title')->default('');
            $table->string('byline')->default('');
            $table->string('slug')->nullable()->default(null)->index();
            $table->string('url')->default('');
            $table->string('description')->default('');
            $table->string('introduction')->default('');
            $table->mediumText('content')->nullable();
            $table->mediumText('summary')->nullable();

            // UI

            $table->string('icon')->default('');
            $table->string('image')->default('');
            $table->string('avatar')->default('');
            $table->json('ui')->nullable()->default(new Expression('(JSON_OBJECT())'));

            // JSON

            $table->json('assets')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('backlog')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('board')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('flow')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('meta')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('notes')->nullable()->default(new Expression('(JSON_ARRAY())'))->comment('Array of note objects');
            $table->json('options')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('roadmap')->nullable()->default(new Expression('(JSON_OBJECT())'));
            $table->json('sources')->nullable()->default(new Expression('(JSON_OBJECT())'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_teams');
    }
};

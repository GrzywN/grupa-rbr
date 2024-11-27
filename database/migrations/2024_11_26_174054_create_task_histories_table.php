<?php

use App\Enums\TaskHistoryEvent;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_histories', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('title', Task::MAX_TITLE_LENGTH);
            $table->text('description')->nullable();
            $table->enum('priority', TaskPriority::values());
            $table->enum('status', TaskStatus::values());
            $table->date('deadline');
            $table->foreignIdFor(Task::class)->constrained()->cascadeOnDelete();
            $table->enum('event', TaskHistoryEvent::values());
            $table->json('diff')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_histories');
    }
};

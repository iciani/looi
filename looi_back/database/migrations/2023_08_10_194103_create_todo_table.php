<?php

use App\Enums\ToDoPriorities;
use App\Enums\ToDoStates;
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
        Schema::create('to_do', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->enum('state', ToDoStates::states())->default(ToDoStates::NOT_STARTED_STATE->value);
            $table->string('thumbnail', 256)->nullable();
            $table->date('committed_due_date')->nullable();
            $table->enum('priority', ToDoPriorities::priorities())->default(ToDoPriorities::PRIORITY_ONE->value);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_do');
    }
};

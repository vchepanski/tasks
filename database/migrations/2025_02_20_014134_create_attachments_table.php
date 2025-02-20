<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Relaciona com a tarefa
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que fez o upload
            $table->string('file_path'); // Caminho do arquivo armazenado
            $table->string('original_name')->nullable(); // Nome original do arquivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};

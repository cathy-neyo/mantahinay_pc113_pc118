<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->tinyInteger('role')->default(1); // 0=admin, 1=coordinator, 2=evaluator
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};


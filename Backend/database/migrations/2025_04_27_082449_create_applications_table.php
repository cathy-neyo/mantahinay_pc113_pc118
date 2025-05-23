<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
   Schema::create('applications', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('scholarship_title');
    $table->date('date_applied');
    $table->string('status')->default('pending');
    $table->string('phone_number');
    $table->timestamps();
});

}


    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

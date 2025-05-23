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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('amount', 10, 2); // Scholarship amount
            $table->date('start_date');
            $table->date('end_date');
            $table->string('requirements'); // Criteria for eligibility
            $table->string('image')->nullable(); 
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('scholarships');
    }
};    
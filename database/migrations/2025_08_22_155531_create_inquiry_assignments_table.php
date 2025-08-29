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
        Schema::create('inquiry_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inquiry_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->timestamps();
            $table->foreign('inquiry_id')->references('id')->on('inquiries')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('it_departments')->cascadeOnDelete();
     } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_assignments');
    }
};

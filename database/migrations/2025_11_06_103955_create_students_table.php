<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->string('name');
            $table->string('father');
            $table->date('dob');
            $table->integer('age');
            $table->enum('grade', ['8', '9','10']);
            $table->enum('gender', ['male']);
            $table->string('contact')->nullable();
            $table->string('participation_id')->unique();
            $table->string('payment_receipt')->nullable();
            $table->string('student_image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

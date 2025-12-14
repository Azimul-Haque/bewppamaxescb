<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(0);
            $table->integer('type')->default(1); // 1 = Course, 2 = BJS MT, 3 = Bar MT, 4 = Free MT
            $table->integer('priority')->default(3);
            $table->integer('category')->default(0); // 1 = BCS, 2 = Primary, 3 = Bank, 4 = NTRCS, 5 = NSI/DGFI and Others
            $table->integer('live')->default(0);
            $table->integer('serial')->default(0);
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
        Schema::dropIfExists('courses');
    }
}

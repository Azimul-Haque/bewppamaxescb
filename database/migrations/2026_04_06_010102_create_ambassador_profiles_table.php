<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbassadorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambassador_profiles', function (Blueprint $table) {
            $table->id();
            
            // ইউজারের সাথে রিলেশন (Foreign Key)
            // onDelete('cascade') দিলে ইউজার ডিলেট হলে অটোমেটিক প্রোফাইল ডিলেট হবে
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // বর্তমান ব্যালেন্স (যা সে দাবি করতে পারবে)
            $table->decimal('balance', 10, 2)->default(0.00);

            // সর্বমোট আয় (আজ পর্যন্ত কত টাকা ইনকাম করেছে - Track Record এর জন্য)
            $table->decimal('total_earned', 10, 2)->default(0.00);

            // ক্যাম্পাস বা কলেজের নাম (অপশনাল)
            $table->string('college_name')->nullable();

            // স্ট্যাটাস (অ্যাক্টিভ না কি ডিজেবল)
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('ambassador_profiles');
    }
}

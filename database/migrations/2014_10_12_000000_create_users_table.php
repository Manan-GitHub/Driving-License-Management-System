<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('father_husband_name');
            $table->string('cnic')->unique();
            $table->integer('age');
            $table->string('gender');
            $table->string('city');
            $table->string('state');
            $table->text('permanent_address');
            $table->text('temporary_address');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->boolean('isAdmin')->default(0);
            $table->boolean('isLicensed')->default(0);
            $table->boolean('hasApplied')->default(0);
            
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //สร้าง fieldใหม่ที่ 'user_id' เป็น fk และกำหนด
            //cascade คือเมื่อข้อมูลในตาราง users ถูกลบออก ข้อมูลที่เกี่ยวข้องในตารางที่เชื่อมโยงกับ user_id
            //ในตารางที่คุณกำลังสร้างนี้จะถูกลบออกทั้งหมด
            $table->string('title');
            $table->string('logo')->nullable(); //nullable แปลว่าสามารถเป็น null ได้
            $table->string('tag');
            $table->string('company');
            $table->string('location');
            $table->string('email');
            $table->string('website');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};

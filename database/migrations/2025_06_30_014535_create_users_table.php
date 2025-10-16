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
        Schema::create('users', function (Blueprint $table) {
            // tạo ra cột id tự tăng - primary key - kiểu unsigned big integer
            $table->id();
            // tạo ra cột username - kiểu string - độ dài 255 ký tự
            // ràng buộc unique (không được trùng lặp) và not null (không được để trống)
            $table->string('username')->unique();
            // tạo ra cột password - kiểu string - độ dài 255 ký tự
            // ràng buộc not null (không được để trống)
            $table->string('password');
            // tạo ra cột fullname - kiểu string - độ dài 255 ký tự
            // Not null (không được để trống)
            $table->string('fullname');
            // tạo ra cột email - kiểu string - độ dài 255 ký tự
            // ràng buộc unique (không được trùng lặp) và not null (không được để trống)
            $table->string('email')->unique();
            // tạo ra cột role - kiểu tiny integer - lưu trữ vai trò của người dùng
            // 0: user người dùng bình thường // 1: admin - quản trị viên
            $table->tinyInteger('role');
            // tạo ra cột remember_token
            // để lưu trữ token khi người dùng chọn nhớ tài khoản
            $table->rememberToken();
            // tao ra 2 cột created_at và updated_at - kiểu timestamp
            // để lưu trữ thời gian tạo và cập nhật bản ghi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

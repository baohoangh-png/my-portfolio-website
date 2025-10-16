<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceColumnInOrderitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderitems', function (Blueprint $table) {
            // Thay đổi kiểu dữ liệu của cột 'price'
            // Chọn một trong hai dòng dưới đây, tùy thuộc vào nhu cầu của bạn
            // Nếu giá chỉ là số nguyên lớn:
            // $table->bigInteger('price')->change();

            // Nếu giá có thể có số thập phân (tổng 10 chữ số, 2 chữ số sau dấu phẩy):
            $table->decimal('price', 10, 2)->change();

            // Nếu cột 'price' không cho phép NULL, thêm ->nullable(false)
            // hoặc đảm bảo nó không được là NULL trong bảng ban đầu.
            // $table->decimal('price', 10, 2)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderitems', function (Blueprint $table) {
            // Đảo ngược thay đổi trong phương thức down().
            // Đưa về kiểu dữ liệu ban đầu nếu bạn nhớ. Ví dụ:
            $table->integer('price')->change();
            // Nếu bạn không chắc kiểu dữ liệu cũ là gì,
            // bạn có thể bỏ qua hoặc để mặc định như Laravel tạo ra
            // (thường là xóa cột hoặc chuyển về integer chung chung).
            // Quan trọng là không được để Schema::create() ở đây.
        });
    }
}

<?php

use App\Enums\Database\TableNames;
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
        Schema::create(TableNames::BOOKINGS, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('sales_price', 8, 2);
            $table->decimal('purchase_price', 8, 2);
            $table->date('arrival_date');
            $table->date('purchase_date'); // @todo purchase_day regarding task requirements ..
            $table->integer('nights');
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableNames::BOOKINGS);
    }
};

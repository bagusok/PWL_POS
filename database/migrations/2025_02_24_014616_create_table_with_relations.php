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
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('level_id')->index();
            $table->string('username', 20);
            $table->string('nama', 100);
            $table->string('password', 255);
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('m_level');
        });

        Schema::create('m_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('pembeli', 50);
            $table->string('penjualan_kode', 20);
            $table->dateTime('penjualan_tanggal');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user');
        });

        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('kategori_id')->index();
            $table->string('barang_kode', 20)->unique();
            $table->string('barang_nama', 100);
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
        });

        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('penjualan_id')->index();
            $table->unsignedBigInteger('barang_id',)->index();
            $table->integer('harga');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('penjualan_id')->references('penjualan_id')->on('m_penjualan');

            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
        });

        Schema::create('t_stock', function (Blueprint $table) {
            $table->id('stock_id');
            $table->unsignedBigInteger('supplier_id')->index();
            $table->unsignedBigInteger('barang_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('stock_jumlah');
            $table->dateTime('stock_tanggal');
            $table->timestamps();

            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier');

            $table->foreign('barang_id')->references('barang_id')->on('m_barang');


            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stock');
        Schema::dropIfExists('t_penjualan_detail');
        Schema::dropIfExists('m_barang');
        Schema::dropIfExists('m_penjualan');
        Schema::dropIfExists('m_user');
    }
};

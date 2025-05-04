<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'kategori_id',
        'image',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    public function stock()
    {
        return $this->hasMany(StockModel::class, 'barang_id', 'barang_id');
    }

    public function getTotalStockAttribute()
    {
        return $this->stock()->sum('stock_jumlah');
    }

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'barang_id', 'barang_id');
    }

    public function getTotalPenjualanAttribute()
    {
        return $this->penjualan_detail()->sum('jumlah');
    }

    public function getStockAvailableAttribute()
    {
        return $this->total_stock - $this->total_penjualan;
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/images/barang/' . ltrim($image, '/')),
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;
class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'hari_tanggal',
        'categories_id',
        'bidang',
        'nominal',
        'total',
        'member_id',
        'bukti_transaksi',
        'spj',
    ];
    public function getNominalFormattedAttribute()
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    return $formatter->format($this->nominal);
}

// Accessor untuk memformat total

protected static function booted()
    {
        static::saving(function ($transaction) {
            // Ambil data kategori terkait
            $categories = $transaction->categories;

            // Periksa jenis categories dan hitung total
            if ($categories->jenis === 'pemasukan') {
                $transaction->total += $transaction->nominal; 
            } elseif ($categories->jenis === 'pengeluaran') {
                $transaction->total -= $transaction->nominal; 
            }
        });
    }

public function getTotalFormattedAttribute()
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    return $formatter->format($this->total);
}

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }
}


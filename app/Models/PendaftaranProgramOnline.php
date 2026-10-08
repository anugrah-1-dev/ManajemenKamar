<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftaranProgramOnline extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran_program_online';

    protected $fillable = [
        'trx_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'program_id',
        'period_id',
        'bukti_pembayaran',
        'status',
        'bank_id',       // sudah ada
        'payment_type',  // tambahkan agar bisa diisi massal
        'subtotal',
        'akomodasi_tipe',   // <--- baru
        'akomodasi_harga',  // <--- baru
    ];

    public function program()
    {
        return $this->belongsTo(ProgramOnline::class, 'program_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }

    public function programOnline()
    {
        return $this->belongsTo(ProgramOnline::class, 'program_online_id');
    }
}

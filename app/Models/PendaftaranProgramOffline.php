<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PendaftaranProgramOffline extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran_program_offline';

    protected $fillable = [
        'trx_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'no_wali',
        'program_id',
        'period_id',
        'period_nhc_id', // jika kamu pakai
        'transport_id',
        'bank_id',
        'payment_type',
        'bukti_pembayaran',
        // 'bukti_dp',
        'bukti_pelunasan',
        'status',
        'subtotal',
        'akomodasi_tipe',
        'ukuran_seragam',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'akomodasi_harga',
        'payment_method',   // full | cicilan \ Dp
        'dp_amount',
        'remaining_amount',
        'is_fully_paid',
        'dp_paid',
        'ukuran_seragam', // jika ada
    ];


    // Relasi ke program offline
    public function program()
    {
        return $this->belongsTo(ProgramOffline::class, 'program_id');
    }

    // Relasi ke periode umum
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    // Relasi ke periode khusus NHC
    public function periodNHC()
    {
        return $this->belongsTo(PeriodNHC::class, 'period_nhc_id');
    }

    // Relasi ke transportasi
    public function transport()
    {
        return $this->belongsTo(Transports::class, 'transport_id');
    }

    // Relasi ke bank
    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }

    public function cicilan()
    {
        return $this->hasMany(CicilanProgramOffline::class, 'pendaftaran_program_offline_id');
    }
        // app/Models/PendaftaranProgramOffline.php
    public function getCicilanLunasAttribute()
    {
        // Hitung cicilan pending, kalau 0 berarti lunas
        return $this->cicilan()->where('status', 'pending')->count() === 0;
    }

    public function getPeriodeAttribute()
    {
        // kalau ada period_nhc_id -> ambil dari PeriodNHC
        if (!empty($this->period_nhc_id)) {
            return PeriodNHC::find($this->period_nhc_id);
        }

        // kalau ada period_id -> ambil dari relasi period biasa
        return $this->period;
    }


    public function getSubtotalAttribute($value)
    {
        return (float) $value;
    }


    
    // Hitung total harga (program + transport + akomodasi)
    public function getTotalHargaAttribute()
    {
        $hargaProgram   = $this->program->harga ?? 0;
        $hargaTransport = $this->transport->price ?? 0;
        $hargaAkomodasi = $this->akomodasi_harga ?? 0;

        return $hargaProgram + $hargaTransport + $hargaAkomodasi;
    }
    public function getAmountToPayAttribute()
    {
        // returns integer/numeric amount due now
        if ($this->payment_method === 'cicilan') {
            // if DP belum dibayar => dp_amount, else if not fully paid => remaining_amount else 0
            if (!$this->dp_paid) return $this->dp_amount;
            if (!$this->is_fully_paid) return $this->remaining_amount;
            return 0;
        }
        return $this->subtotal; // full
    }
    public function Dp()
    {
        return $this->hasOne(Dp::class, 'pendaftaran_program_offline_id');
    }
    

}

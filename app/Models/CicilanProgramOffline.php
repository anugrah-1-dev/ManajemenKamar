<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilanProgramOffline extends Model
{
    use HasFactory;

    protected $table = 'cicilan_program_offline';

    protected $fillable = [
        'pendaftaran_program_offline_id',
        'bulan_ke',
        'jumlah',
        'status',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tanggal_jatuh_tempo',
        'tanggal_dibayar',
    ];

    /**
     * Relasi ke pendaftaran program offline
     */
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_program_offline_id');
    }

    /**
     * Helper untuk cek status
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue';
    }
    public function markAsPaid($filePath = null)
    {
        $this->status = 'paid';
        $this->tanggal_dibayar = now();
        if ($filePath) {
            $this->bukti_pembayaran = $filePath;
        }
        $this->save();
    }
}

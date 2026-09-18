<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOnline; // 1. Ganti Model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


// 2. Tambahkan kembali WithMapping dan WithDrawings
class PendaftaranOnlineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings
{
    protected $pendaftarans;
    // --- PENGATURAN TAMPILAN ---
    protected $row_height = 80;
    protected $column_H_width = 20; // Kolom gambar sekarang H

    // Terima parameter dari controller
    public function __construct($startDate, $endDate, $programBahasa = null)
    {
        $query = PendaftaranProgramOnline::with(['program', 'period', 'bank'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        // filter program_bahasa kalau dipilih
        if ($programBahasa) {
            $query->whereHas('program', function ($q) use ($programBahasa) {
                $q->where('program_bahasa', $programBahasa);
            });
        }

        $this->pendaftarans = $query->get();
    }


    /**
     * 4. Method collection() sekarang hanya mengembalikan data yang sudah diambil.
     */
    public function collection()
    {
        return $this->pendaftarans;
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Lengkap',
            'Email',
            'No HP',
            'Asal Kota',
            'Nama Program',
            'Tanggal Periode',
            'Bukti Pembayaran',
            'Status',
            'Tipe Pembayaran',
            'Subtotal',
            'Akomodasi Tipe',
            'Akomodasi Harga',
        ];
    }

    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->program ? $pendaftaran->program->nama : 'N/A',
            $pendaftaran->period ? $pendaftaran->period->date->format('d F Y') : 'N/A',
            '', // Kolom Bukti Pembayaran dikosongkan (gambar di drawings)
            $pendaftaran->status,
            $pendaftaran->payment_type,
            $pendaftaran->subtotal ? $pendaftaran->subtotal : 0,   // pastikan field subtotal ada
            $pendaftaran->akomodasi_tipe ?? '-',                   // pastikan field ini ada di model
            $pendaftaran->akomodasi_harga ? $pendaftaran->akomodasi_harga : 0,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $columnWidthInPixels = $this->column_H_width * 7.5;

        foreach ($this->pendaftarans as $key => $pendaftaran) {
            if ($pendaftaran->bukti_pembayaran) {
                $pathToFile = public_path('storage/' . $pendaftaran->bukti_pembayaran);
                if (!file_exists($pathToFile)) {
                    continue;
                }

                $drawing = new Drawing();
                $drawing->setName('Bukti Pembayaran');
                $drawing->setDescription($pendaftaran->nama_lengkap);
                $drawing->setPath($pathToFile);

                // Index 8 berarti kolom H (urutan ke-8 di headings)
                $drawing->setCoordinates(Coordinate::stringFromColumnIndex(8) . ($key + 2));

                // Logika untuk posisi tengah
                [$originalWidth, $originalHeight] = getimagesize($pathToFile);
                $newHeight = $this->row_height - 10;
                $drawing->setHeight($newHeight);
                $newWidth = ($originalWidth / $originalHeight) * $newHeight;
                $drawing->setOffsetX(($columnWidthInPixels - $newWidth) / 2);
                $drawing->setOffsetY(($this->row_height - $newHeight) / 2);

                $drawings[] = $drawing;
            }
        }
        return $drawings;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getDelegate()->getHighestRow();
                $highestColumn = $sheet->getDelegate()->getHighestColumn();
                $cellRange = 'A1:' . $highestColumn . $highestRow;

                $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);

                foreach ($this->pendaftarans as $key => $pendaftaran) {
                    $rowNumber = $key + 2;
                    if ($pendaftaran->bukti_pembayaran && file_exists(public_path('storage/' . $pendaftaran->bukti_pembayaran))) {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight($this->row_height);
                    } else {
                        $sheet->getDelegate()->getRowDimension($rowNumber)->setRowHeight(25);
                    }
                }

                // Pengaturan lebar kolom disesuaikan untuk versi Online
                foreach (range('A', 'G') as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
                $sheet->getDelegate()->getColumnDimension('I')->setAutoSize(true);
                $sheet->getDelegate()->getColumnDimension('H')->setWidth($this->column_H_width);

                $sheet->getStyle($cellRange)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
            },
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\PendaftaranProgramCamp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;

class PendaftaranCampExport implements FromCollection, WithHeadings, WithEvents, WithDrawings
{
    protected $pendaftar;

    public function __construct($startDate, $endDate)
    {
        $this->pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
    }

    public function collection()
    {
        return $this->pendaftar->map(function ($item) {
            return [
                'nama_lengkap'     => $item->nama_lengkap,
                'email'            => $item->email,
                'no_hp'            => $item->no_hp,
                'asal_kota'        => $item->asal_kota,
                'program_camp'     => $item->programCamp->nama ?? '-',
                'periode'          => $item->period && $item->period->date
                    ? $item->period->date->format('d-m-Y')
                    : 'Tidak ada',
                'durasi_paket'     => $item->durasi_paket,
                'nama_kamar'       => $item->nama_kamar,
                'payment_type'     => $item->payment_type === 'tunai' ? 'Tunai' : 'Non Tunai',
                'bukti_pembayaran' => $item->payment_type === 'tunai' ? 'Tunai / Cash' : '',
                'status'           => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'No HP',
            'Asal Kota',
            'Program Camp',
            'Periode',
            'Durasi Paket',
            'Nama Kamar',
            'Tipe Pembayaran',
            'Bukti Pembayaran',
            'Status',
        ];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $cellRange = 'A1:' . $highestColumn . $highestRow;

            // Styling umum
            $sheet->getStyle($cellRange)->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);

            // Header bold & ukuran baris header
            $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
            $sheet->getRowDimension(1)->setRowHeight(30);

            // Set tinggi baris data (sesuaikan jika ingin lebih tinggi)
            for ($row = 2; $row <= $highestRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(60); // tinggi dalam poin — diperlakukan sebagai px di offset
            }

            // Auto size kolom lain
            foreach (range('A', $highestColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Pastikan kolom J (Bukti Pembayaran) punya lebar tetap supaya perhitungan offset konsisten
            $sheet->getColumnDimension('J')->setWidth(18); // ubah angka jika perlu

            // Hitung lebar kolom J dalam pixel (estimasi Excel -> pixel)
            $colWidth = $sheet->getColumnDimension('J')->getWidth(); // 18
            $columnWidthInPixels = (int) floor($colWidth * 7) + 5; // formula pendekatan

            // Pastikan teks pada kolom J rata tengah
            $sheet->getStyle('J2:J' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J2:J' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Sisipkan gambar per baris dan hitung scale + offset agar CENTERED
            foreach ($this->pendaftar as $index => $item) {
                if ($item->bukti_pembayaran && Storage::disk('public')->exists($item->bukti_pembayaran)) {
                    $pathToFile = storage_path('app/public/' . $item->bukti_pembayaran);

                    if (@getimagesize($pathToFile)) {
                        list($origW, $origH) = getimagesize($pathToFile);

                        $rowNum = $index + 2; // baris di excel (header di baris 1)
                        $cellHeightPx = 60; // sama dengan rowHeight di atas (adjust jika perlu)

                        // ruang maksimum di cell (sedikit padding agar tidak nempel border)
                        $maxW = $columnWidthInPixels - 10;
                        $maxH = $cellHeightPx - 10;

                        // scale proporsional sehingga tidak melebihi cell
                        $scale = min($maxW / $origW, $maxH / $origH, 1);

                        $newW = (int) round($origW * $scale);
                        $newH = (int) round($origH * $scale);

                        $drawing = new Drawing();
                        $drawing->setName('Bukti');
                        $drawing->setDescription('Bukti Pembayaran');
                        $drawing->setPath($pathToFile);
                        $drawing->setResizeProportional(true);
                        $drawing->setWidth($newW); // gunakan width agar proporsional terjaga

                        // hitung offset untuk memposisikan di tengah cell
                        $offsetX = max((int) (($columnWidthInPixels - $newW) / 2), 0);
                        $offsetY = max((int) (($cellHeightPx - $newH) / 2), 0);

                        $drawing->setOffsetX($offsetX);
                        $drawing->setOffsetY($offsetY);
                        $drawing->setCoordinates('J' . $rowNum);

                        // tambahkan langsung ke worksheet
                        $drawing->setWorksheet($sheet);
                    }
                }
            }
        },
    ];
}

// kembalikan drawings kosong supaya tidak duplicate
public function drawings()
{
    return [];
}
}
<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $owner
 * @property string $number
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Banks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banks onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banks query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banks withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banks withoutTrashed()
 */
	class Banks extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $nomor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer_Service whereUpdatedAt($value)
 */
	class Customer_Service extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GalleryImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereUpdatedAt($value)
 */
	class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $gallery_id
 * @property string $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Gallery $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GalleryImage whereUpdatedAt($value)
 */
	class GalleryImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_lengkap
 * @property string $email
 * @property string $no_hp
 * @property string $asal_kota
 * @property int $program_camp_id
 * @property int|null $period_id
 * @property string $durasi_paket
 * @property string $nama_kamar
 * @property string|null $bukti_pembayaran
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Period|null $period
 * @property-read \App\Models\ProgramCamp $programCamp
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp query()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereAsalKota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereBuktiPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereDurasiPaket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereNamaKamar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereProgramCampId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramCamp whereUpdatedAt($value)
 */
	class PendaftaranProgramCamp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $trx_id
 * @property string $nama_lengkap
 * @property string|null $no_hp
 * @property string $email
 * @property string|null $asal_kota
 * @property string|null $no_wali
 * @property int|null $program_id
 * @property int|null $period_id
 * @property int|null $transport_id
 * @property string|null $bukti_pembayaran
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Period|null $period
 * @property-read \App\Models\ProgramOffline|null $program
 * @property-read \App\Models\Transports|null $transport
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline query()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereAsalKota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereBuktiPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereNoWali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOffline withoutTrashed()
 */
	class PendaftaranProgramOffline extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $trx_id
 * @property string $nama_lengkap
 * @property string $email
 * @property string|null $no_hp
 * @property string|null $asal_kota
 * @property int|null $program_id
 * @property int|null $period_id
 * @property string|null $bukti_pembayaran
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Period|null $period
 * @property-read \App\Models\ProgramOnline|null $program
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline query()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereAsalKota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereBuktiPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PendaftaranProgramOnline withoutTrashed()
 */
	class PendaftaranProgramOnline extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendaftaranProgramOffline> $pendaftaranOffline
 * @property-read int|null $pendaftaran_offline_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendaftaranProgramOnline> $pendaftaranOnline
 * @property-read int|null $pendaftaran_online_count
 * @method static \Illuminate\Database\Eloquent\Builder|Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Period withoutTrashed()
 */
	class Period extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $judul
 * @property string $status
 * @property string $deskripsi
 * @property string $keunggulan
 * @property string $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereKeunggulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 */
	class Program extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $slug
 * @property string|null $kategori
 * @property int|null $stok
 * @property int|null $harga_perhari
 * @property int|null $harga_satu_minggu
 * @property int|null $harga_dua_minggu
 * @property int|null $harga_tiga_minggu
 * @property int|null $harga_satu_bulan
 * @property int|null $harga_dua_bulan
 * @property int|null $harga_tiga_bulan
 * @property int|null $harga_enam_bulan
 * @property int|null $harga_satu_tahun
 * @property string|null $fasilitas
 * @property string|null $thumbnail
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereFasilitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaDuaBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaDuaMinggu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaEnamBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaPerhari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaSatuBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaSatuMinggu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaSatuTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaTigaBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereHargaTigaMinggu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCamp withoutTrashed()
 */
	class ProgramCamp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $slug
 * @property string|null $lama_program
 * @property string|null $kategori
 * @property int|null $harga
 * @property string|null $features_program
 * @property string|null $lokasi
 * @property string|null $jadwal_mulai
 * @property string|null $jadwal_selesai
 * @property int|null $kuota
 * @property int $is_active
 * @property string|null $thumbnail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereFeaturesProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereJadwalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereJadwalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereKuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereLamaProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOffline whereUpdatedAt($value)
 */
	class ProgramOffline extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $slug
 * @property string|null $lama_program
 * @property string|null $kategori
 * @property int|null $harga
 * @property array|null $features_program
 * @property bool $is_active
 * @property string|null $thumbnail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereFeaturesProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereLamaProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramOnline whereUpdatedAt($value)
 */
	class ProgramOnline extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $url
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $thumbnail_url
 * @property-read mixed $youtube_id
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sosmed whereUrl($value)
 */
	class Sosmed extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transports query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transports whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transports whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transports whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transports wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transports whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transports whereUpdatedAt($value)
 */
	class Transports extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $program_camp_id
 * @property string $nama
 * @property string $gender
 * @property string $kategori
 * @property int $kapasitas
 * @property int $penghuni
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $status
 * @property-read \App\Models\ProgramCamp $programCamp
 * @method static \Illuminate\Database\Eloquent\Builder|rooms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|rooms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|rooms query()
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereKapasitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms wherePenghuni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereProgramCampId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|rooms whereUpdatedAt($value)
 */
	class rooms extends \Eloquent {}
}


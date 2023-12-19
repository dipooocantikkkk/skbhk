<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Tetapkan nilai default untuk bagian 11-14 jika kosong
        $nama = $row['nama'] ?? null;
        $tempat_lahir = $row['tempat_lahir'] ?? null;
        $tanggal_lahir = $row['tanggal_lahir'] ?? null;
        $pendidikan = $row['pendidikan'] ?? null;
        $jabatan = $row['jabatan'] ?? null;
        $group_employee = $row['branch'] ?? null;
        $no_surat = $row['no_surat'] ?? null;
        $tgl_awal_hubker = $row['tgl_awal_hubker'] ?? null;
        $tgl_akhir_hubker = $row['tgl_akhir_hubker'] ?? null;
        $jenis_pkwt = $row['jenis_pkwt'] ?? null;
        $no_pkwt = $row['no_pkwt'] ?? null;
        $tgl_pkwt = $row['tgl_pkwt'] ?? null;
        $nama_pt = $row['nama_pt'] ?? null;
        $nama_toko = $row['nama_toko'] ?? null;

        // Periksa keberadaan "nik" dalam array $row
        $nik = $row['nik'] ?? null;

        // Jika "nik" tidak ada, Anda mungkin perlu mengembalikan atau mengabaikan data ini
        if ($nik === null) {
            Log::error("Baris tidak memiliki kolom 'nik'. Data dilewati: " . json_encode($row));
            return null;
        }

        // Format data
        $data = [
            'nama' =>  $nama,
            'tempat_lahir' =>  $tempat_lahir,
            'tanggal_lahir' => ($tanggal_lahir) ? Carbon::parse($tanggal_lahir)->format('Y-m-d') : null,
            'pendidikan' => $pendidikan,
            'jabatan' =>  $jabatan,
            'group_employee' =>  $group_employee,
            'no_surat' =>  $no_surat,
            'tgl_awal_hubker' => isset($tgl_awal_hubker) ? Carbon::parse($tgl_awal_hubker)->format('Y-m-d') : null,
            'tgl_akhir_hubker' => isset($tgl_akhir_hubker) ? Carbon::parse($tgl_akhir_hubker)->format('Y-m-d') : null,
            'jenis_pkwt' => $jenis_pkwt,
            'no_pkwt' => $no_pkwt,
            'tgl_pkwt' => isset($tgl_pkwt) ? Carbon::parse($tgl_pkwt)->format('Y-m-d') : null,
            'nama_pt' => $nama_pt,
            'nama_toko' => $nama_toko,
        ];

        // Gunakan updateOrInsert untuk memeriksa dan mengganti data berdasarkan NIK
        Karyawan::updateOrInsert(['nik' => $nik], $data);
    }
}

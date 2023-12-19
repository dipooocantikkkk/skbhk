<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table ='surat';
    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'jabatan',
        'group_employee',
        'no_surat',
        'tgl_awal_hubker',
        'tgl_akhir_hubker',
        'jabatan_ttd',
        'jenis_surat',
        'alasan',
        'jenis_pkwt',
        'no_pkwt',
        'tgl_pkwt',
        'nama_pt',
        'nama_toko',
        'editor_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function editor()
{
    return $this->belongsTo(User::class, 'editor_id');
}
    public function jabatanSurat()
    {
        return $this->belongsTo(MasterTtd::class, 'jabatan_ttd', 'jabatan');
    }
    public function branch()
    {
        return $this->belongsTo(MasterBranchReguler::class, 'group_employee', 'branch');
    }
    public function namattd()
    {
        return $this->belongsTo(MasterTtd::class, 'jabatan_ttd', 'id');
    }
    public function ptcv()
    {
        return $this->belongsTo(MasterBranchFranchise::class, 'nama_pt', 'nama_pt');
    }
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'nama_pt', 'nama_pt');
    }
  
    
}


<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table ='karyawan';
    protected $fillable = [
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
        'jenis_pkwt',
        'no_pkwt',
        'tgl_pkwt',
        'nama_pt',
        'nama_toko'
        
        
    ];
    public function masteruser()
    {
        return $this->belongsTo(User::class,'masteruser_id','id');
    }
    public function branch()
    {
        return $this->belongsTo(MasterBranchReguler::class, 'group_employee', 'branch');
    }
    public function status()
    {
        return $this->belongsTo(MasterBranchReguler::class, 'group_employee', 'branch');
    }
    

}

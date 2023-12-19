<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBranchReguler extends Model
{
    protected $table ='master_branch_regulers';
    protected $fillable =[
        'branch',
        'alamat',
        'no_telp',
        'no_fax',
        'kota',
    
    ];
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'branch_id');
    }
    public function masterttd()
    {
        return $this->hasMany(MasterTtd::class, 'branch_id');
    }
}

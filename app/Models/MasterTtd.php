<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTtd extends Model
{
    protected $table ='master_ttd';
    protected $fillable =[
        'branch',
        'nama',
        'jabatan',
    ];

    public function branch()
    {
        return $this->belongsTo(MasterBranchReguler::class, 'branch', 'branch');
    }
    public function status()
    {
        return $this->belongsTo(MasterBranchReguler::class, 'branch', 'branch');
    }
    public function masterjabatan()
    {
        return $this->hasMany(Surat::class, 'jabatan_id');
    }
}


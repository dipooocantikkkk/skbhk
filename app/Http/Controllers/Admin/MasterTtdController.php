<?php

namespace App\Http\Controllers\Admin;

use App\Models\MasterTtd;
use Illuminate\Http\Request;
use App\Models\MasterBranchReguler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MasterTtdRequest;
use App\Models\MasterBranchFranchise;

class MasterTtdController extends Controller
{
   
    public function index(){
        $masterttd = MasterTtd::with('branch')->get();
        return view('admin.masterttd.index', compact('masterttd'));
    }    
    public function create()
    {
        $masterBranchRegulers = MasterBranchReguler::where('status', 1)->get();
        return view('admin.masterttd.create', compact('masterBranchRegulers'));

    }
    public function store(MasterTtdRequest $request)
    
    {
        $data = $request->validated();
        $masterttd = new MasterTtd();
        $masterttd->branch = $data['branch'];
        $masterttd->nama = $data['nama'];
        $masterttd->jabatan = $data['jabatan'];
        $masterttd->save();
        return redirect('admin/masterttd')->with('success','Data TTD Berhasil Ditambahkan');
    }
    public function edit($masterttd_id){
        $masterttd = MasterTtd::find($masterttd_id);
        $masterbranchregulers = MasterBranchReguler::where('status', 1)->get();
        return view('admin.masterttd.edit', compact('masterttd','masterbranchregulers'));
    }
    public function update (MasterTtdRequest $request, $masterttd_id){
        $data = $request->validated();
        $masterttd = MasterTtd::find($masterttd_id);
        $masterttd->branch = $data['branch'];
        $masterttd->nama = $data['nama'];
        $masterttd->jabatan = $data['jabatan'];
        $masterttd->update();
        return redirect('admin/masterttd')->with('success','Data TTD Berhasil Diedit');
    }
    public function destroy ($masterttd_id)
    {
        $masterttd = MasterTtd::find($masterttd_id);
        if($masterttd)
        {
            $masterttd->delete();
            return redirect('admin/masterttd')->with('success', 'User Berhasil Dihapus');
        }
        else
        {
            return redirect('admin/masterttd')->with('succes', 'User tidak ditemukan');
        }
    }
}

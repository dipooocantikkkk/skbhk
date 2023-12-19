<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\MasterBranchReguler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchRegulerRequest;

class MasterBranchRegulerController extends Controller
{
    public function index(){
        $masterbranchreguler = MasterBranchReguler::all();
        return view('admin.masterbranchreguler.index', compact('masterbranchreguler'));
    }
    public function updateStatus(Request $request, $id)
    {
        // Validasi input jika diperlukan
        $request->validate([
        'status' => 'required|boolean',
    ]);
         // Ubah status di database
    $item = MasterBranchReguler::findOrFail($id);
    $item->status = $request->input('status');
    $item->save();
        // $item = MasterBranchReguler::find($id);

        // if (!$item) {
        //     return response()->json(['message' => 'Catatan tidak ditemukan'], 404);
        // }

        // // Update status berdasarkan nilai checkbox
        // $item->status = $request->input('status');
        // $item->save();

        // return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    public function create()
    {
        $masterBranchRegulers = MasterBranchReguler::where('status', 1)->get();
        return view('admin.masterbranchreguler.create');

    }
    public function store(BranchRegulerRequest $request)
    
    {
        $data = $request->validated();
        $masterbranchregulers = new MasterBranchReguler();
        $masterbranchregulers->branch = $data['branch'];
        $masterbranchregulers->alamat = $data['alamat'];
        $masterbranchregulers->no_telp = $data['no_telp'];
        $masterbranchregulers->no_fax = $data['no_fax'];
        $masterbranchregulers->kota = $data['kota'];
        $masterbranchregulers->save();
        return redirect('admin/masterbranchreguler')->with('success','Data Branch Reguler Berhasil Ditambahkan');
    }
    public function edit($masterbranchreguler_id){
        $masterbranchreguler = MasterBranchReguler::find($masterbranchreguler_id);
        return view('admin.masterbranchreguler.edit', compact('masterbranchreguler'));
    }
    public function update(BranchRegulerRequest $request, $masterbranchreguler_id)
    
    {
        $data = $request->validated();
        $masterbranchreguler = MasterBranchReguler::find($masterbranchreguler_id);
        $masterbranchreguler->branch = $data['branch'];
        $masterbranchreguler->alamat = $data['alamat'];
        $masterbranchreguler->no_telp = $data['no_telp'];
        $masterbranchreguler->no_fax = $data['no_fax'];
        $masterbranchreguler->kota = $data['kota'];
        $masterbranchreguler->update();
        return redirect('admin/masterbranchreguler')->with('success','Data Branch Reguler Berhasil Diedit');
    }
    public function destroy($masterbranchreguler_id)
    {
        $masterbranchreguler = MasterBranchReguler::find($masterbranchreguler_id);
        if($masterbranchreguler)
        {
            $masterbranchreguler->delete();
            return redirect('admin/masterbranchreguler')->with('success', 'Data Branch Reguler Berhasil Dihapus');
        }
        else
        {
            return redirect('admin/masterbranchreguler')->with('success', 'Data Branch Reguler Berhasil tidak ditemukan');
        }
    }
}
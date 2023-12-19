<?php

namespace App\Http\Controllers\Admin;

use PDF;
use data;
use App\Models\User;
use App\Models\Surat;
use App\Models\Karyawan;
use App\Models\MasterTtd;
use Illuminate\Http\Request;
use App\Models\MasterBranchReguler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterBranchFranchise;
use App\Http\Requests\Admin\SuratRequest;
use Illuminate\Contracts\Validation\Rule;

class SuratController extends Controller
{
    public function infosurat()
    {
        $surat = Surat::all();
        return view('admin.surat.infosurat', compact('surat'));
    }
    public function index(Request $request)
    {
       
        $userBranch = auth()->user()->branch;
        $masterTtd = MasterTtd::where('branch', $userBranch)->get();
        $employees = [];
        if ($request->has('karyawan_nik')) {
            $karyawan_nik = $request->input('karyawan_nik');
            $employees = Karyawan::where('nik', $karyawan_nik)->get();
        }

        return view('admin.surat.index', compact('employees', 'masterTtd'));
    }
    public function search(Request $request)
    {
        // Mengambil branch dari user saat ini
        $userBranch = auth()->user()->branch;
    
        // Debugging untuk memeriksa nilai branch yang diambil
        dd($userBranch);
    
        $employee = null;
    
        if ($request->has('karyawan_nik')) {
            $karyawan_nik = $request->input('karyawan_nik');
    
            // Menambahkan kondisi where untuk memfilter berdasarkan branch
            $employee = Karyawan::where('nik', $karyawan_nik)
                ->where('group_employee', $userBranch)
                ->first();
        }
    
        return view('admin.surat.index', compact('employee'));
    }
    

    
    public function store(Request $request)
    {
       
    //    dd($request->all());

        // Validasi data yang masuk di sini jika diperlukan
        $validatedData = $request->validate([
            'nik'=>[
                'required',
                'string',
                'max:8'
            ],
            'nama'=>[
                'required',
                'string',
                'max:100'
            ],
            'tempat_lahir'=>[
                'required',
                'string',
            ],
            'tanggal_lahir'=>[
                'required',
                'date',
            ],
            'pendidikan'=>[
                'required',
                'string',
            ],
            'jabatan'=>[
                'required',
                'string',
            ],
            'group_employee'=>[
                'required',
                'string',
            ],
            'no_surat'=>[
                'required',
                'string',
            ],
            'tgl_awal_hubker'=>[
                'required',
                'date'
            ],
            'tgl_akhir_hubker'=>[
                'nullable',
                'date',
            ], 
            'alasan'=>[
                'required',
                'string',
            ],    
            'jabatan_ttd'=>[
                'required',
                'string',
            ],  
            'jenis_surat'=>[
                'required',
                'string',
            ],
            'jenis_pkwt'=>[
                'nullable',
                'string',  
            ],  
            'no_pkwt'=>[
                'nullable',
                'string',
            ], 
            'tgl_pkwt'=>[
                'nullable',
                'string',
            ],
            'nama_pt'=>[
                'nullable',
                'string'
            ],
            'nama_toko'=>[
                'nullable',
                'string'
            ]
        ]);


        // Simpan data surat ke database
        $data = $validatedData;  
        $user_id = auth()->user()->id;
        $surat = new Surat;
        $surat->nik = $data['nik'];
        $surat->nama = $data['nama'];
        $surat->tempat_lahir = $data['tempat_lahir'];
        $surat->tanggal_lahir= $data['tanggal_lahir'];
        $surat->pendidikan = $data['pendidikan'];
        $surat->jabatan = $data['jabatan'];
        $surat->group_employee = $data['group_employee'];
        $surat->nama_pt = $data['nama_pt'];
        $surat->no_surat = $data['no_surat'];
        $surat->tgl_awal_hubker = $data['tgl_awal_hubker'];
        $surat->tgl_akhir_hubker= $data['tgl_akhir_hubker'];
        $surat->alasan = $data['alasan'];
        $surat->jenis_surat= $data['jenis_surat'];
        $surat->user_id = $user_id; 
        $surat->jabatan_ttd= $data['jabatan_ttd'];
        $surat->jenis_pkwt = $data['jenis_pkwt'];
        $surat->no_pkwt= $data['no_pkwt'];
        $surat->tgl_pkwt= $data['tgl_pkwt'];
        $surat->nama_toko= $data['nama_toko'];
        
        if ($surat->save()) {
            return redirect('admin/infosurat')->with('success', 'SKBHK Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }
    public function generatePDF($surat_id)
    {
        $surat = Surat::find($surat_id);

        if ($surat) {
            $data = [
                'title' => 'Surat SKBHK',
                'surat' => $surat
            ];

            $pdf = null;
            $fileName = "";

            if ($surat->jenis_surat === 'Choice 1' || $surat->jenis_surat === 'Choice 3') {
                    $pdf = PDF::loadView('admin.surat.myPDF', $data);
                    $fileName = "Surat SKBHK $surat->nama.pdf";
                // Tambahkan kondisi lain berdasarkan jenis surat dan alasan yang sesuai
            }
            elseif ($surat->jenis_surat === 'Choice 2' || $surat->jenis_surat === 'Choice 4') {
                    // Logika untuk jenis surat pertama dan alasan pertama
                    $pdf = PDF::loadView('admin.surat.myPDF2', $data);
                    $fileName = "Surat SKBHK $surat->nama.pdf";
                }
            if ($pdf) {
                return $pdf->download($fileName);
            } else {
                return redirect('admin/infosurat')->with('error', 'Tidak ada PDF yang sesuai untuk jenis surat ini.');
            }
        } else {
            return redirect('admin/infosurat')->with('error', 'Surat tidak ditemukan.');
        }
    }
    public function printPDF($surat_id)
    {
   
        $surat = Surat::find($surat_id);
        $surat = Surat::with('ptcv')->find($surat_id);
        $surat = Surat::with('toko')->find($surat_id);
        

        if ($surat) {
            $surat->load('branch');
            $surat->load('namattd');  
            $surat->load('ptcv');
            $surat->load('toko');
            $data = [
                'title' => 'Surat SKBHK',
                'surat' => $surat
            ];

            $pdf = null;
            $fileName = "";

            if ($surat->jenis_surat === 'Choice 1' || $surat->jenis_surat === 'Choice 3') {
                $pdf = PDF::loadView('admin.surat.myPDF', $data);
                $fileName = "Surat SKBHK $surat->nama.pdf";
                // Tambahkan kondisi lain berdasarkan jenis surat dan alasan yang sesuai
            } elseif ($surat->jenis_surat === 'Choice 2' || $surat->jenis_surat === 'Choice 4') {
                // Logika untuk jenis surat pertama dan alasan pertama
                $pdf = PDF::loadView('admin.surat.myPDF2', $data);
                $fileName = "Surat SKBHK $surat->nama.pdf";
            }

            if ($pdf) {
                // Menampilkan tampilan PDF langsung
                 return view('admin.surat.print', compact('pdf', 'fileName'));
            } else {
                return redirect('admin/infosurat')->with('error', 'Tidak ada PDF yang sesuai untuk jenis surat ini.');
            }
        } else {
            return redirect('admin/infosurat')->with('error', 'Surat tidak ditemukan.');
        }
    }

    public function edit ($surat_id)
    {
        $surat =  Surat::find($surat_id);
        $masterTtd = MasterTtd::all();
        $masterbranchregulers = MasterBranchReguler::where('status', 1)->get();
        $masterbranchfranchise = MasterBranchFranchise::all();
        return view('admin.surat.edit', compact('surat', 'masterTtd' ,'masterbranchregulers', 'masterbranchfranchise'));
    }
    public function update( Request $request, $surat_id){
        {
            $validatedData = $request->validate([
                'nik'=>[
                    'required',
                    'string',
                    'max:8'
                ],
                'nama'=>[
                    'required',
                    'string',
                    'max:100'
                ],
                'tempat_lahir'=>[
                    'required',
                    'string',
                ],
                'tanggal_lahir'=>[
                    'required',
                    'date',
                ],
                'pendidikan'=>[
                    'required',
                    'string',
                ],
                'jabatan'=>[
                    'required',
                    'string',
                ],
                'group_employee'=>[
                    'required',
                    'string',
                ],
                'nama_pt'=>[
                    'nullable',
                    'string'
                ],
                'no_surat'=>[
                    'required',
                    'string',
                ],
                'tgl_awal_hubker'=>[
                    'required',
                    'date'
                ],
                'tgl_akhir_hubker'=>[
                    'nullable',
                    'date',
                ], 
                'alasan'=>[
                    'required',
                    'string',
                ],    
                'jabatan_ttd'=>[
                    'required',
                    'string',
                ],  
                'jenis_surat'=>[
                    'required',
                    'string',
                ],
                'jenis_pkwt'=>[
                    'nullable',
                    'string',
                ],  
                'no_pkwt'=>[
                    'nullable',
                    'string',
                ], 
                'tgl_pkwt'=>[
                    'nullable',
                    'string',
                ],
                'nama_toko'=>[
                    'nullable',
                    'string'
                ]
                
            ]);
    
    
            // Simpan data surat ke database
            $data = $validatedData;  
            $user_id = auth()->user()->id;
            $surat = Surat::find($surat_id);
            $surat->editor_id = auth()->user()->id;
            $surat->nik = $data['nik'];
            $surat->nama = $data['nama'];
            $surat->tempat_lahir = $data['tempat_lahir'];
            $surat->tanggal_lahir= $data['tanggal_lahir'];
            $surat->pendidikan = $data['pendidikan'];
            $surat->jabatan = $data['jabatan'];
            $surat->nama_pt = $data['nama_pt'];
            $surat->group_employee = $data['group_employee'];
            $surat->no_surat = $data['no_surat'];
            $surat->tgl_awal_hubker = $data['tgl_awal_hubker'];
            $surat->tgl_akhir_hubker= $data['tgl_akhir_hubker'];
            $surat->alasan = $data['alasan'];
            $surat->jenis_surat= $data['jenis_surat'];
            $surat->user_id = $user_id; 
            $surat->jabatan_ttd= $data['jabatan_ttd'];
            $surat->jenis_pkwt= $data['jenis_pkwt'];
            $surat->no_pkwt= $data['no_pkwt'];
            $surat->tgl_pkwt= $data['tgl_pkwt'];
            $surat->nama_toko= $data['nama_toko'];
            if ($surat->update()) {
                return redirect('admin/infosurat')->with('success', 'Surat Berhasil Diedit');

                $editor = $surat->editor;

                // Ambil nama pengedit
                $editorName = $editor ? $editor->name : 'Tidak ada informasi pengedit';
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data.');
            }
        }
    }
    public function destroy ($surat_id)
    {
        $surat = Surat::find($surat_id);
        if($surat)
        {
            $surat->delete();
            return redirect('admin/infosurat')->with('success', 'Surat Berhasil Dihapus');
        }
        else
        {
            return redirect('admin/infosurat')->with('success', 'Surat tidak ditemukan');
        }
    }
    public $delete_id;
    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

}
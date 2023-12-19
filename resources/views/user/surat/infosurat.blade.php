@section ('title', 'Surat SKBHK')
@section ('pages1', 'Admin')
@section ('pages2', 'Surat SKBHK')
@extends('/layoutsuser/master')
@section ('content')
@if (session('status'))
<div class="alert alert-success" role="alert">{{session('status')}}</div>
@endif
<div class="col-12">
    <div class="card">
       <!-- Card header -->
       <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">Data Surat SKBHK</h5>
              <p class="text-sm mb-0">
                Informasi terkait Surat SKBHK yang Telah Dibuat
              </p>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                <a href={{url('/surat')}} class="btn bg-gradient-info btn-sm mb-0">+&nbsp; tambah</a>
              </div>
            </div>
          </div>
        </div>
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
          <table class="table table-flush" id="products-list">
            <thead class="thead-light" align="center">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Surat</th>
                <th>Tanggal Surat</th>
                <th>Pembuat Surat</th>
                <th>Editor Surat</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $nourut=1; ?>
                @foreach ($surat->reverse() as $item)
                <tr class="thead-light">
                  <td>{{$nourut++}}</td>
                  <td>{{$item->nama}}</td>
                  <td>
                  @if ($item->jenis_surat == "Choice 1")
                    SKHBK 003
                  @elseif ($item->jenis_surat == "Choice 2")
                    SKHBK 004
                  @elseif ($item->jenis_surat == "Choice 3")
                    SKHBK 005
                  @elseif ($item->jenis_surat == "Choice 4")
                    SKHBK 006
                  @endif
                  </td>
                  <td>{{Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM Y', 'Do MMMM Y')}}</td> 
                  <td>{{ $item->user ? $item->user->name : 'Tidak ada informasi pembuat' }}</td>
                  <td>{{ $item->editor ? $item->editor->name : 'Tidak ada informasi pengedit' }}</td>
                  <td class="text-sm">
                    <a href="{{('/print/'.$item->id) }}"  data-bs-toggle="tooltip" class="badge badge-primary">Print</a>
                    <a href={{('/generate-pdf/'.$item->id)}}  data-bs-toggle="tooltip" class="badge badge-info">Unduh</a> 
                    <a href={{('/editsurat/'.$item->id)}}  data-bs-toggle="tooltip" class="badge badge-success" >Edit</a> 
                    {{-- <a class="badge badge-danger delete-surat" data-id="{{$item->id}}">Hapus</a> --}}
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.5') }}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
            });
        @endif
    });
</script>
  
<script> //sweetalert untuk hapus
  document.addEventListener('DOMContentLoaded', function () {
      const deleteButtons = document.querySelectorAll('.delete-surat');
  
      deleteButtons.forEach(button => {
          button.addEventListener('click', function () {
              const karyawanId = button.getAttribute('data-id');
  
              Swal.fire({
                  title: 'Anda yakin ingin menghapus user ini?',
                  text: 'Aksi ini tidak dapat dibatalkan!',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, Hapus!'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Redirect to the delete route with the user ID
                      window.location.href = `/admin/hapussurat/${karyawanId}`;
                  }
              });
          });
      });
  });
</script>

 
<script>
if (document.getElementById('products-list')) {
  const dataTableSearch = new simpleDatatables.DataTable("#products-list", {
    searchable: true,
    fixedHeight: false,
    perPage: 7
  });

  document.querySelectorAll(".export").forEach(function(el) {
    el.addEventListener("click", function(e) {
      var type = el.dataset.type;

      var data = {
        type: type,
        filename: "soft-ui-" + type,
      };

      if (type === "csv") {
        data.columnDelimiter = "|";
      }

      dataTableSearch.export(data);
    });
  });
};
</script>
<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  var options = {
    damping: '0.5'
  }
  Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../../../assets/js/argon-dashboard.min.js?v=2.0.5"></script>   
@endsection
   
<script> //sweetalert untuk hapus
  document.addEventListener('DOMContentLoaded', function () {
      const deleteButtons = document.querySelectorAll('.delete-user');
  
      deleteButtons.forEach(button => {
          button.addEventListener('click', function () {
              const karyawanId = button.getAttribute('data-id');
  
              Swal.fire({
                  title: 'Anda yakin ingin menghapus user ini?',
                  text: 'Aksi ini tidak dapat dibatalkan!',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, Hapus!'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Redirect to the delete route with the user ID
                      window.location.href = `/admin/hapuskaryawan/${karyawanId}`;
                  }
              });
          });
      });
  });
</script>

  
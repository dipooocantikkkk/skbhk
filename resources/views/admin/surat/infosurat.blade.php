@section ('title', 'Surat SKBHK')
@section ('pages1', 'Admin')
@section ('pages2', 'Surat SKBHK')
@extends('/layouts/master')
@section ('content')
@if (session('status'))
<div class="alert alert-success" role="alert">{{session('status')}}</div>
@endif
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                <a href={{url('admin/surat')}} class="btn bg-gradient-info btn-sm mb-0">+&nbsp; tambah</a>
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
                    <a href="{{('/admin/print/'.$item->id) }}" data-id="{{ $item->id }}" data-bs-toggle="tooltip" class="badge badge-primary reprint-link">Print</a>
                    <a href={{('/admin/generate-pdf/'.$item->id)}}  data-bs-toggle="tooltip" class="badge badge-info">Unduh</a> 
                    <a href={{('/admin/editsurat/'.$item->id)}}  data-bs-toggle="tooltip" class="badge badge-success" >Edit</a> 
                    <a class="badge badge-danger delete-surat" data-id="{{$item->id}}">Hapus</a>
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.5') }}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk menampilkan SweetAlert
    function showSweetAlert(icon, title, text) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
        });
    }

    // Fungsi untuk menangani logika reprint
    function handleReprint(target) {
        const suratId = target.getAttribute('data-id');
        var reprintStatus = localStorage.getItem('reprintStatus') ? JSON.parse(localStorage.getItem('reprintStatus')) : {};

        // Jika suratId tidak ada dalam reprintStatus, atur statusnya menjadi 'Print'
        if (!reprintStatus.hasOwnProperty(suratId) || typeof reprintStatus[suratId] !== 'boolean') {
            reprintStatus[suratId] = false;
        }

        // Perbarui teks tautan berdasarkan status saat ini
        target.textContent = reprintStatus[suratId] ? 'Reprint' : 'Print';

        // Jika belum pernah diklik, atur ke 'Reprint'
        if (!reprintStatus[suratId]) {
            reprintStatus[suratId] = true;
        } else {
            // Jika sudah pernah diklik, atur ke 'Print'
            reprintStatus[suratId] = false;
        }

        // Simpan status yang diperbarui ke sessionStorage
        sessionStorage.setItem('reprintStatus', JSON.stringify(reprintStatus));

        // Alihkan ke halaman href setelah reprint
        window.location.href = target.getAttribute('href');
    }

    // Mendengarkan acara untuk tombol hapus dan reprint
    document.getElementById('products-list').addEventListener('click', function (event) {
        const target = event.target;

        if (target.classList.contains('delete-surat')) {
            const suratId = target.getAttribute('data-id');

            Swal.fire({
                title: 'Anda yakin ingin menghapus surat ini?',
                text: 'Aksi ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/hapussurat/${suratId}`;
                }
            });
        }

        if (target.classList.contains('reprint-link')) {
            event.preventDefault();
            handleReprint(target);
        }
    });

    // Periksa status di sessionStorage ketika halaman dimuat ulang
    var allReprintLinks = document.querySelectorAll('.reprint-link');
    allReprintLinks.forEach(function (link) {
        const suratId = link.getAttribute('data-id');
        var reprintStatus = sessionStorage.getItem('reprintStatus') ? JSON.parse(sessionStorage.getItem('reprintStatus')) : {};

        // Jika suratId tidak ada dalam reprintStatus, atur statusnya menjadi 'Print'
        if (!reprintStatus.hasOwnProperty(suratId) || typeof reprintStatus[suratId] !== 'boolean') {
            reprintStatus[suratId] = false;
        }

        // Perbarui teks tautan berdasarkan status saat ini
        link.textContent = reprintStatus[suratId] ? 'Reprint' : 'Print';
    });
});
</script>


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

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-surat');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const suratId = button.getAttribute('data-id');

                Swal.fire({
                    title: 'Anda yakin ingin menghapus surat ini?',
                    text: 'Aksi ini tidak dapat dibatalkan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/hapussurat/${suratId}`;
                    }
                });
            });
        });
    });
</script> --}}

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
    }
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

<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="../../../assets/js/argon-dashboard.min.js?v=2.0.5"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
{{-- <script>
  document.addEventListener('DOMContentLoaded', function () {
      var reprintStatus = JSON.parse(localStorage.getItem('reprintStatus')) || {};

      document.querySelectorAll('.reprint-link').forEach(function(link) {
          var suratId = link.getAttribute('data-id');

          // Jika suratId belum ada dalam reprintStatus, atur statusnya menjadi 'Print'
          if (!reprintStatus.hasOwnProperty(suratId) || typeof reprintStatus[suratId] !== 'boolean') {
              reprintStatus[suratId] = false;
          }

          // Ubah teks tautan berdasarkan status saat ini
          link.textContent = reprintStatus[suratId] ? 'Reprint' : 'Print';

          link.addEventListener('click', function(event) {
              // Pengecekan apakah dokumen sedang dalam mode cetak
              if (window.matchMedia && window.matchMedia('print').matches) {
                  // Biarkan tautan bekerja seperti biasa dalam mode cetak
                  return;
              }

              event.preventDefault();

              // Jika belum pernah diklik, setel ke 'Reprint'
              if (!reprintStatus[suratId]) {
                  link.textContent = 'Reprint';
                  reprintStatus[suratId] = true;
              } else {
                  // Jika sudah pernah diklik, setel ke 'Print'
                  link.textContent = 'Print';
                  // Tidak perlu mengubah nilai reprintStatus karena sudah 'true'
              }

              // Simpan status baru ke Local Storage
              localStorage.setItem('reprintStatus', JSON.stringify(reprintStatus));

              // Redirect ke halaman yang dihref setelah melakukan reprint
              window.location.href = link.getAttribute('href');
          });
      });
  });
</script> --}}

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-user');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = button.getAttribute('data-id');

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
                        window.location.href = `/admin/hapuskaryawan/${userId}`;
                    }
                });
            });
        });
    });
</script> --}}
@endsection
@extends("template.main")

@section("content")
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">E SCH Pay</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">{{ $title }}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div class="modal fade" id="addUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                role="dialog" aria-labelledby="addUserlTitleId" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable modal-dialog-centered"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserlTitleId">
                                Buat User Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" action="{{ Route('user.store') }}" method="POST">

                                @csrf

                                <div class="col-md-4">
                                    <label for="nisn" class="form-label">nisn</label>
                                    <input type="text" class="form-control" id="nisn" placeholder="nisn" required
                                        name="nisn">
                                </div>
                                <div class="col-md-4">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap"
                                        required name="name">
                                </div>
                                <div class="col-md-4">
                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jk" required name="jk">
                                        <option value="L">Laki - Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="nomerHP" class="form-label">Nomer HP</label>
                                    <input type="number" class="form-control" id="nomerHP" required name="nomerHP">
                                </div>
                                <div class="col-md-4">
                                    <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempatLahir" required
                                        name="tempatLahir">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggalLahir" required
                                        name="tanggalLahir">
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required name="email"
                                        placeholder="E-Mail">
                                </div>

                                <div class="col-md-4">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select name="kelas_id" id="kelas" class="form-control select2"
                                        data-toggle="select2" placeholder="Kelas">
                                        <option value="isAdmin">Administrator</option>
                                        @forelse (App\Models\Kelas::all() as $value )
                                        <option value="{{ $value->rombongan_belajar_id }}">{{ $value->kelas }}</option>
                                        @empty
                                        <option value="null">Kelas Belum ada</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="Password" class="form-label">Password</label>
                                    <input type="Password" class="form-control" id="Password" required name="password"
                                        placeholder="password">
                                </div>
                                <div class="col-md-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="10" placeholder="Alamat"
                                        class="form-control"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Tambahkan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-5">
                                    <a data-bs-toggle="modal" href="#addUser" class="btn btn-primary mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add
                                        Users</a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-secondary mb-2 me-1" id="importDapodik">
                                            <i class="mdi mdi-account-arrow-down-outline" id="importIcon"></i>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true" id="importSpinner"></span>
                                            import from dapodik
                                        </button>
                                        {{-- <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                        <button type="button" class="btn btn-light mb-2">Export</button> --}}
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                    id="dataUser">
                                    <thead class="table-light">
                                        <tr>
                                            <th>nama</th>
                                            <th>Kelas</th>
                                            <th>Jumlah Tanggungan</th>
                                            <th>Terbayar</th>
                                            <th style="width: 75px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <script>
                        document.write(new Date().getFullYear())

                    </script> © SCH Palyment - Ksoft
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>
@endsection

@section("pluginsCSS")
<!-- Datatable css -->
<link href="{{ url("/") }}/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
    type="text/css" />
<link href="{{ url("/") }}/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
    rel="stylesheet" type="text/css" />

<!-- Select2 css -->
<link href="{{ url('/') }}/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("pluginsJS")
<!-- Datatable js -->
<script src="{{ url('/') }}/assets/vendor/datatables.net/js/jquery.dataTables.min.js">
</script>
<script src="{{ url('/') }}/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js">
</script>
<script src="{{ url('/') }}/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script src="{{ url('/') }}/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
</script>
<script src="{{ url('/') }}/assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js">
</script>

<!--  Select2 Js -->
<script src="{{ url('/') }}/assets/vendor/select2/js/select2.min.js"></script>

<!-- sellers Demo App js -->
<script>
    $(document).ready(function () {

        var table = $("#dataUser").DataTable({
            ajax: "{{ route('apiUser','getUser') }}",
            processing: true,
            //    serverSide: true,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
            },
            pageLength: 10,
            columns: [{
                orderable: !0
            }, {
                orderable: !0
            }, {
                orderable: !0
            }, {
                orderable: !0
            }, {
                orderable: !0,
            }],
            order: [
                [1, "desc"]
            ],
        })


        $("#importDapodik").on("click", (e) => {
            Toast.fire({
            icon: "warning",
            title: "Mengambil data dari dapodik"
            });
            $("#importDapodik").toggleClass("disabled");
            $("#importIcon").toggleClass("d-none");
            $("#importSpinner").toggleClass("d-none");
            $.getJSON("{{ route('apiUser','import') }}", function () {

            }).done(function(){
                table.ajax.reload()
                $("#importDapodik").toggleClass("disabled");
                $("#importIcon").toggleClass("d-none");
                $("#importSpinner").toggleClass("d-none");
                Toast.fire({
                icon: "success",
                title: "Berhasil Ambil data dari dapodik"
                });
            })
        })
    })

</script>
@endsection

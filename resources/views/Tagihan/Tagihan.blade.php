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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tagihan</a></li>
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
            <div class="modal fade" id="buatTagihan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                role="dialog" aria-labelledby="buatTagihanlTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="buatTagihanlTitleId">
                                Buat Tagihan Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" action="{{ Route('daftarTagihan.store') }}"
                                method="POST">

                                @csrf

                                <div class="col-md-12">
                                    <label for="nama" class="form-label">nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="nama" required
                                        name="nama" value="{{ old('nama')? old('nama'):'' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="jeni">Jenis Pembayaran</label>
                                    <div class="form-check">
                                        <input type="radio" id="satukali" name="jenis" value="satukali"
                                            class="form-check-input" {{ old("jenis")==="satukali" ? "checked" :"" }}>
                                        <label class="form-check-label" for="satukali">Satu kali Pembayran</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="berulang" name="jenis" value="berulang"
                                            class="form-check-input" {{ old("jenis")==="berulang" ? "checked" :"" }}>
                                        <label class="form-check-label" for="berulang">Pembayaran Berulang</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Nominal</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="nominal">Rp.</span>
                                        <input type="number" class="form-control" placeholder="Nominal"
                                            aria-label="Nominal" aria-describedby="nominal" name="nominal"
                                            value="{{ old('nominal')? old('nominal'):'' }}">
                                    </div>
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
                                    <a data-bs-toggle="modal" href="#buatTagihan" class="btn btn-primary mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Tambah
                                        Tagihan</a>
                                    <a href="{{ route('kelompok.index') }}" class="btn btn-secondary mb-2"><i
                                            class="mdi mdi-set-merge me-2"></i> Kelompokan Tagihan</a>
                                </div>
                                <div class="col-sm-7">
                                </div>

                                <div class="table-responsive">
                                    <table
                                        class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                        id="dataTagihan">
                                        <thead class="table-light">
                                            <tr>
                                                <th>nama</th>
                                                <th>Jenis</th>
                                                <th>Nominal</th>
                                                <th>satus</th>
                                                <th style="width: 75px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Tagihan as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->nama }}
                                                </td>
                                                <td>
                                                    {{ $item->satukali?"Satu Kali Pembayaran":"" }}
                                                    {{ $item->berulang?"Pembayaran Berulang":"" }}
                                                </td>
                                                <td>
                                                    {{ Number::currency($item->nominal,"IDR") }}
                                                </td>
                                                <td>
                                                    {!! $item->trashed()? "<span class='badge bg-danger text-bold'>
                                                        Tidak Aktif</span>":"<span
                                                        class='badge bg-success text-bold'>Aktif</span>" !!}
                                                </td>
                                                <td class="d-flex">
                                                    <a data-bs-toggle="modal" href="#editTagihan-{{ $loop->iteration }}"
                                                        class="action-icon"> <i class="uil-edit"></i></a>

                                                    <!-- Modal Body -->
                                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                                    <div class="modal fade" id="editTagihan-{{ $loop->iteration }}"
                                                        tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                                        role="dialog"
                                                        aria-labelledby="editTagihan-{{ $loop->iteration }}lTitleId"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editTagihan-{{ $loop->iteration }}lTitleId">
                                                                        Edit Tagihan {{ $item->nama }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form class="row g-3 needs-validation"
                                                                        action="{{ Route('daftarTagihan.update', $item->id) }}"
                                                                        method="POST">

                                                                        @method("PUT")
                                                                        @csrf

                                                                        <div class="col-md-12">
                                                                            <label for="nama"
                                                                                class="form-label">nama</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama" placeholder="nama" required
                                                                                name="nama" value="{{ $item->nama }}">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="jeni">Jenis Pembayaran</label>
                                                                            <div class="form-check">
                                                                                <input type="radio" id="satukali"
                                                                                    name="jenis" value="satukali"
                                                                                    class="form-check-input" {{
                                                                                    $item->satukali?"checked":"" }}>
                                                                                <label class="form-check-label"
                                                                                    for="satukali">Satu kali
                                                                                    Pembayran</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="radio" id="berulang"
                                                                                    name="jenis" value="berulang"
                                                                                    class="form-check-input" {{
                                                                                    $item->berulang?"checked":"" }}>
                                                                                <label class="form-check-label"
                                                                                    for="berulang">Pembayaran
                                                                                    Berulang</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label class="form-label">Nominal</label>
                                                                            <div class="input-group flex-nowrap">
                                                                                <span class="input-group-text"
                                                                                    id="nominal">Rp.</span>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    placeholder="Nominal"
                                                                                    aria-label="Nominal"
                                                                                    aria-describedby="nominal"
                                                                                    name="nominal"
                                                                                    value="{{ $item->nominal }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <button class="btn btn-primary"
                                                                                type="submit">Simpan</button>
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($item->trashed())
                                                    <a href="{{ route('daftarTagihan.restore',$item->id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-delete-restore"></i></a>
                                                    @else
                                                    <form action="{{ route('daftarTagihan.destroy',$item->id) }}"
                                                        method="post">
                                                        @method("DELETE")
                                                        @csrf
                                                        <button type="submit" class="action-icon btn d-block">
                                                            <i class="uil-trash"></i></button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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

        var table = $("#dataTagihan").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
            },
            pageLength: 10,
            columns: [ {
                orderable: !0
            }, {
                orderable: !0
            }, {
                orderable: !0
            }, {
                orderable: !0,
            }, {
                orderable: !0,
            }],
            order: [
                [0, "desc"]
            ],
        })
    })

    </script>
    @endsection

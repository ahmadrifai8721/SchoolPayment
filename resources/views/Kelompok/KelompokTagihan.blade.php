@extends('template.main')

@section('content')
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
                <div class="modal fade" id="buatkelompok" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                    role="dialog" aria-labelledby="buatkelompoklTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buatkelompoklTitleId">
                                    Buat kelompok Baru
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3 needs-validation" action="{{ Route('kelompok.store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">nama</label>
                                        <input type="text" class="form-control" id="nama" placeholder="nama"
                                            required name="nama" value="{{ old('nama') ? old('nama') : '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="Kelas" class="form-label">Kelas</label>
                                        <select name="kelas_id" id="Kelas" class="form-control select2"
                                            data-toggle="select2">
                                            @foreach ($Kelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->kelas }}</option>
                                            @endforeach
                                        </select>
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
                                        <a data-bs-toggle="modal" href="#buatkelompok" class="btn btn-primary mb-2"><i
                                                class="mdi mdi-plus-circle me-2"></i> Tambah
                                            kelompok</a>
                                    </div>
                                    <div class="col-sm-7">
                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                            id="datakelompok">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>nama</th>
                                                    <th>Kelas</th>
                                                    <th>nominal</th>
                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kelompokTagihan as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->nama }}
                                                        </td>
                                                        <td>
                                                            {{ $item->Kelas->kelas }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $total = 0;
                                                            @endphp
                                                            @foreach ($item->DetailsKelompokTagihan as $detailKelompok)
                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $detailKelompok->DaftarTagihan->nominal;
                                                                @endphp
                                                            @endforeach
                                                            {{ Number::currency($total, 'IDR') }}
                                                        </td>
                                                        <td>
                                                            <!-- Modal Body -->
                                                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                                            <div class="modal fade" id="editkelompok{{ $item->id }}"
                                                                tabindex="-1" data-bs-backdrop="static"
                                                                data-bs-keyboard="false" role="dialog"
                                                                aria-labelledby="editkelompok{{ $item->id }}lTitleId"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editkelompok{{ $item->id }}lTitleId">
                                                                                Buat kelompok Baru
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <form class="row g-3 needs-validation"
                                                                                action="{{ Route('kelompok.update', $item->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <input type="hidden" name="lastName"
                                                                                    value="{{ $item->nama }}">
                                                                                <div class="col-md-12">
                                                                                    <label for="nama"
                                                                                        class="form-label">nama</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama" placeholder="nama"
                                                                                        required name="nama"
                                                                                        value="{{ $item->nama }}">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <button class="btn btn-primary"
                                                                                        type="submit">save</button>
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
                                                            <a data-bs-toggle="modal"
                                                                href="#editkelompok{{ $item->id }}"
                                                                class="action-icon">
                                                                <i class="uil-edit"></i></a>
                                                            <a href="{{ route('kelompok.show', $item->id) }}"
                                                                class="action-icon">
                                                                <i class="uil-file-edit-alt"></i></a>
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

    @section('pluginsCSS')
        <!-- Datatable css -->
        <link href="{{ url('/') }}/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css"
            rel="stylesheet" type="text/css" />
        <link href="{{ url('/') }}/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
            rel="stylesheet" type="text/css" />

        <!-- Select2 css -->
        <link href="{{ url('/') }}/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    @endsection

    @section('pluginsJS')
        <!-- Datatable js -->
        <script src="{{ url('/') }}/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ url('/') }}/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{ url('/') }}/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('/') }}/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="{{ url('/') }}/assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js"></script>

        <!--  Select2 Js -->
        <script src="{{ url('/') }}/assets/vendor/select2/js/select2.min.js"></script>

        <!-- sellers Demo App js -->
        <script>
            $(document).ready(function() {

                var table = $("#datakelompok").DataTable({
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
                        orderable: !0,
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

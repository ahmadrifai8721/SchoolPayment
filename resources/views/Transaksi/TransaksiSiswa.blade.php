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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Transaksi</a></li>
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
                <div class="modal fade" id="buatTransaksi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                    role="dialog" aria-labelledby="buatTransaksilTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buatTransaksilTitleId">
                                    Buat Tagihan Baru
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3 needs-validation" action="{{ Route('Transaksi.store') }}"
                                    method="POST">

                                    @csrf

                                    <div class="col-md-12">
                                        <label for="namaSiswa" class="form-label">Nama Siswa</label>
                                        <!-- Multiple Select -->
                                        <select class="select2 form-control" data-toggle="select2"
                                            data-placeholder="Choose ..." name="user_id" id="namaSiswa">
                                            <option disabled selected> Pilih Nama Siswa</option>
                                            @foreach ($AnggotaKelas as $key => $item)
                                                <optgroup
                                                    label="{{ $Kelas->where('rombongan_belajar_id', $key)->first()->kelas }}">
                                                    @foreach ($item as $siswa)
                                                        <option value="{{ $siswa->user_id }}">{{ $siswa->User->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Tagihan</label>
                                        <select class="select2 form-control select2-multiple" data-toggle="select2"
                                            multiple="multiple" data-placeholder="Choose ..." name="daftar_tagihan_id[]"
                                            id="tagihan">

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Metode Pembayran</label>
                                        <select class="select2 form-control" data-toggle="select2"
                                            data-placeholder="Choose ..." name="methode_pembayaran_id" id="MetodePembayran">
                                            @foreach ($MethodePembayaran as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="total" class="form-label">Nominal</label>
                                        <input type="text" class="form-control" name="total" id="total" required>

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
                                        <a data-bs-toggle="modal" href="#buatTransaksi" class="btn btn-primary mb-2"><i
                                                class="mdi mdi-plus-circle me-2"></i> Tambah
                                            Transaksi Siswa</a>
                                    </div>
                                    <div class="col-sm-7">
                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                            id="dataTransaksi">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama Tagihan</th>
                                                    <th>Methode Pembayaran</th>
                                                    <th>Nominal</th>
                                                    <th>satus</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Transaksi as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->User->name }}
                                                        </td>
                                                        <td>
                                                            {{ $item->Tagihan->DaftarTagihan->nama }}
                                                        </td>
                                                        <td>
                                                            {{ $item->MethodePembayaran->nama }}
                                                        </td>
                                                        <td>
                                                            {{ Number::currency($item->total, 'IDR') }}
                                                        </td>
                                                        <td>
                                                            @switch($item->status)
                                                                @case(1)
                                                                    <span class='badge bg-success text-bold'> Berhasil</span>
                                                                @break

                                                                @case(2)
                                                                    <span class='badge bg-warning text-bold'> Menunggu
                                                                        Pembayaran</span>
                                                                @break

                                                                @case(3)
                                                                    <span class='badge bg-warning text-bold'> Nomer VA Sudah Di
                                                                        Buat</span>
                                                                @break

                                                                @default
                                                                    <span class='badge bg-danger text-bold'> Di Batalkan /
                                                                        expaier</span>
                                                            @endswitch
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

                $(".select3").select2({
                    dropdownParent: $("#buatTransaksi")
                });
                var table = $("#dataTransaksi").DataTable({
                    language: {
                        paginate: {
                            previous: "<i class='mdi mdi-chevron-left'>",
                            next: "<i class='mdi mdi-chevron-right'>"
                        },
                    },
                    pageLength: 10,
                    columns: [{
                            orderable: !0
                        },
                        {
                            orderable: !0
                        },
                        {
                            orderable: !0
                        },
                        {
                            orderable: !0
                        },
                        {
                            orderable: !0,
                        },
                    ],
                    order: [
                        [1, "desc"]
                    ],
                })
            })
        </script>
    @endsection

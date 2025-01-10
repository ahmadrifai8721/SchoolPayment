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
                                <ol class="m-0 breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">E SCH Pay</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Methode Pembayaran</a></li>
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
                <div class="modal fade" id="buatMethodePembayaran" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="buatMethodePembayaranlTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buatMethodePembayaranlTitleId">
                                    Buat Methode Pembayaran Baru
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Nama Pembayaran Online Wajib sama</h5>
                                <ul>
                                    <li> credit_card</li>
                                    <li>gopay</li>
                                    <li>shopeepay</li>
                                    <li>permata_va</li>
                                    <li>bca_va</li>
                                    <li>bni_va</li>
                                    <li>bri_va</li>
                                    <li>echannel</li>
                                    <li>other_va</li>
                                    <li>Indomaret</li>
                                    <li>alfamart</li>
                                    <li>akulaku</li>
                                </ul>

                                <form class="row g-3 needs-validation" action="{{ Route('MethodePembayaran.store') }}"
                                    method="POST">

                                    @csrf

                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">nama</label>
                                        <input type="text" class="form-control" id="nama" placeholder="nama"
                                            required name="nama" value="{{ old('nama') ? old('nama') : '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Biaya Transaksi</label>
                                        <div class="input-group flex-nowrap">
                                            <span class=" spn-bt input-group-text" id="biayaTransaksi">Rp.</span>
                                            <input type="number" class="form-control" placeholder="biayaTransaksi"
                                                aria-label="biayaTransaksi" aria-describedby="biayaTransaksi"
                                                name="biayaTransaksi"
                                                value="{{ old('biayaTransaksi') ? old('biayaTransaksi') : '' }}">
                                            <span class="spn-bt input-group-text d-none" id="biayaTransaksi">%</span>
                                            <input class="form-check-input m-2" name="percent" type="checkbox"
                                                value="1" id="percent" />
                                            <label class="form-check-label" for="percent"> Biaya Transaksi Dalam Percent
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-12 d-inline-flex">
                                        <label class="form-label">Type Pembayaran</label>

                                        <div class="form-check m-3">
                                            <input class="form-check-input" name="type" type="radio" value="online"
                                                id="online" />
                                            <label class="form-check-label" for="online"> Online </label>
                                        </div>
                                        <div class="form-check m-3">
                                            <input class="form-check-input" name="type" type="radio" value="offline"
                                                id="offline" checked />
                                            <label class="form-check-label" for="offline"> Offline</label>
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
                                <div class="mb-2 row">
                                    <div class="col-sm-5">
                                        <a data-bs-toggle="modal" href="#buatMethodePembayaran"
                                            class="mb-2 btn btn-soft-info"><i class="mdi mdi-plus-circle me-2"></i> Tambah
                                            Methode Pembayaran</a>
                                    </div>
                                    <div class="col-sm-7">
                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                            id="dataMethodePembayaran">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Type</th>
                                                    <th>Biaya Transaksi</th>
                                                    <th>Status</th>
                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($MethodePembayaran as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->nama }}
                                                        </td>
                                                        <td>
                                                            {{ $item->type }}
                                                        </td>

                                                        <td>
                                                            @if ($item->percent)
                                                                {{ $item->biayaTransaksi ? $item->biayaTransaksi : 0 }}%
                                                            @else
                                                                {{ Number::currency($item->biayaTransaksi ? $item->biayaTransaksi : 0, 'IDR') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {!! $item->trashed()
                                                                ? "<span class='badge bg-danger text-bold'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Tidak Aktif</span>"
                                                                : "<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    class='badge bg-success text-bold'>Aktif</span>" !!}
                                                        </td>
                                                        <td class="d-flex">
                                                            <a data-bs-toggle="modal"
                                                                href="#editMethodePembayaran-{{ $loop->iteration }}"
                                                                class="action-icon"> <i class="uil-edit"></i></a>

                                                            <!-- Modal Body -->
                                                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                                            <div class="modal fade"
                                                                id="editMethodePembayaran-{{ $loop->iteration }}"
                                                                tabindex="-1" data-bs-backdrop="static"
                                                                data-bs-keyboard="false" role="dialog"
                                                                aria-labelledby="editMethodePembayaran-{{ $loop->iteration }}lTitleId"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editMethodePembayaran-{{ $loop->iteration }}lTitleId">
                                                                                Edit Methode Pembayaran {{ $item->nama }}
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <form class="row g-3 needs-validation"
                                                                                action="{{ Route('MethodePembayaran.update', $item->id) }}"
                                                                                method="POST">

                                                                                @method('PUT')
                                                                                @csrf

                                                                                <div class="col-md-12">
                                                                                    <label for="nama"
                                                                                        class="form-label">nama</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="nama" placeholder="nama"
                                                                                        required name="nama"
                                                                                        value="{{ $item->nama }}">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label class="form-label">Biaya
                                                                                        Transaksi</label>
                                                                                    <div class="input-group flex-nowrap">
                                                                                        <span class="input-group-text"
                                                                                            id="biayaTransaksi">Rp.</span>
                                                                                        <input type="number"
                                                                                            class="form-control"
                                                                                            placeholder="biayaTransaksi"
                                                                                            aria-label="biayaTransaksi"
                                                                                            aria-describedby="biayaTransaksi"
                                                                                            name="biayaTransaksi"
                                                                                            value="{{ $item->biayaTransaksi }}">
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
                                                                <a href="{{ route('MethodePembayaran.restore', $item->id) }}"
                                                                    class="action-icon">
                                                                    <i class="mdi mdi-delete-restore"></i></a>
                                                            @else
                                                                <form
                                                                    action="{{ route('MethodePembayaran.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="action-icon btn d-block">
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
                        <div class="text-center col-md-12">
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

                $('#percent').change(function() {
                    if ($(this).is(':checked')) {
                        $('.spn-bt').toggleClass('d-none');
                    } else {
                        $('.spn-bt').toggleClass('d-none');
                    }
                });

                var table = $("#dataMethodePembayaran").DataTable({
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

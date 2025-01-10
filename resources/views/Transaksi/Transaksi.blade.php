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
                                        <select class="select2 form-control"
                                            data-toggle="select2"data-placeholder="Choose ..." name="daftar_tagihan_id[]"
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
                                <div class="mb-2 row">
                                    <div class="col-sm-5">
                                        <a data-bs-toggle="modal" href="#buatTransaksi" class="mb-2 btn btn-primary"><i
                                                class="mdi mdi-cash me-2"></i> Bayar Tagihan</a>

                                    </div>
                                    <div class="col-sm-7">
                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                            id="dataTagihan">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama Tagihan</th>
                                                    <th>Methode Pembayaran</th>
                                                    <th>Nominal</th>
                                                    <th>satus</th>
                                                    <th>Payment</th>
                                                </tr>
                                            </thead>
                                            {{-- @dd($Transaksi) --}}
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
                                                        @switch($item->status)
                                                            @case(1)
                                                                <td>
                                                                    <span class='badge bg-success text-bold'> Berhasil</span>
                                                                </td>
                                                                <td></td>
                                                            @break

                                                            @case(2)
                                                                <td>

                                                                    <span class='badge bg-warning text-bold'> Menunggu
                                                                        Pembayaran</span>
                                                                </td>
                                                                <td></td>
                                                                @if ($item->MethodePembayaran->type == 'online')
                                                                    <td>
                                                                        <button id="pay-button" class="btn btn-warning"><i
                                                                                class="mdi mdi-cash-100"></i>Pay!</button>


                                                                    </td>
                                                                @else
                                                                    <td></td>
                                                                @endif
                                                            @break

                                                            @case(3)
                                                                <td>

                                                                    <span class='badge bg-warning text-bold'> Nomer VA Sudah Di
                                                                        Buat</span>
                                                                </td>
                                                                @if ($item->MethodePembayaran->type == 'online')
                                                                    <td>

                                                                        <button id="pay-button" class="btn btn-warning"><i
                                                                                class="mdi mdi-cash-100"></i>Pay!</button>
                                                                        <!-- @TODO: You can add the desired ID as a reference for the embedId parameter. -->
                                                                        <div id="snap-container"></div>

                                                                        <script type="text/javascript">
                                                                            // For example trigger on button clicked, or any time you need
                                                                            var payButton = document.getElementById('pay-button');
                                                                            payButton.addEventListener('click', function() {
                                                                                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
                                                                                // Also, use the embedId that you defined in the div above, here.
                                                                                window.snap.embed('{{ $item->snapToken }}', {
                                                                                    embedId: 'snap-container'
                                                                                });
                                                                            });
                                                                        </script>
                                                                    </td>
                                                                @else
                                                                    <td></td>
                                                                @endif
                                                            @break

                                                            @default
                                                                <td>
                                                                    <span class='badge bg-danger text-bold'> Di Batalkan /
                                                                        expaier</span>
                                                                </td>
                                                                <td></td>
                                                        @endswitch

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

        <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_TOKEN_KEY') }}"></script>

        <!-- @TODO: You can add the desired ID as a reference for the embedId parameter. -->
        <div id="snap-container"></div>

        <script type="text/javascript">
            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
                // Also, use the embedId that you defined in the div above, here.
                window.snap.embed('{{ $item->snapToken }}', {
                    embedId: 'snap-container'
                });
            });
        </script>
        <!-- sellers Demo App js -->
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    dropdownParent: $('#buatTransaksi')
                });
                $('#namaSiswa').change(function(e) {
                    e.preventDefault();

                    $.getJSON("{{ route('apiTagihanSiswa', '') }}/" + $('#namaSiswa').val(), function(data,
                        textStatus, jqXHR) {
                        // console.log(data);
                        $('#tagihan').empty();
                        $.each(data, function(index, value) {
                            $('#tagihan').append('<option value="' + value.id + '">' + value
                                .nama + '(' + value.nominal + ')</option>');
                        });
                    });

                });


                var table = $("#dataTagihan").DataTable({
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

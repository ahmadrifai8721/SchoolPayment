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


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('kelompok.tambahTagihan') }}" method="post">

                                    @csrf

                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control disabled" id="nama"
                                                    placeholder="Nama Kelompok" value="{{ $kelompokTagihan->nama }}"
                                                    readonly name="nama" />
                                                <input type="hidden" name="kelompok_tagihan_id"
                                                    value="{{ $kelompokTagihan->id }}">
                                                <label for="nama">Nama Kelompok Tagihan</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control disabled" id="kelas"
                                                    placeholder="Nama Kelompok" value="{{ $kelompokTagihan->Kelas->kelas }}"
                                                    readonly name="kelas" />
                                                <input type="hidden" name="kelas_id"
                                                    value="{{ $kelompokTagihan->Kelas->id }}">
                                                <label for="kelas">Kelas</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="DaftarTagihan">Pilih Tagihan</label>
                                            <select class="form-select select2" data-toggle="select2" id="DaftarTagihan"
                                                name="daftar_tagihan_id" aria-label="Pilih Tagihan">
                                                @forelse ($DaftarTagihan as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }} (
                                                        {{ Number::currency($item->nominal, 'idr') }}
                                                        )</option>
                                                @empty
                                                    <option disabled selected>Daftar Tagihan Masih Kosong</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="d-grid mt-1">
                                                <button type="submit" class="btn btn-primary align-items-center"><i
                                                        class="uil-plus"></i></button>
                                            </div>
                                            <!-- end d-grid -->
                                        </div>
                                </form>

                                <p>Dafatar Tagihan Kelompok {{ $kelompokTagihan->nama }}</p>
                                <div class="table-responsive">
                                    <table
                                        class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                        id="datakelompok">
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
                                            {{-- @dd($kelompokTagihan->DetailsKelompokTagihan) --}}
                                            @foreach ($kelompokTagihan->DetailsKelompokTagihan as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->DaftarTagihan->nama }}
                                                    </td>
                                                    <td>
                                                        {{ $item->DaftarTagihan->satukali ? 'Satu Kali Pembayaran' : '' }}
                                                        {{ $item->DaftarTagihan->berulang ? 'Pembayaran Berulang' : '' }}
                                                    </td>
                                                    <td>
                                                        {{ Number::currency($item->DaftarTagihan->nominal, 'IDR') }}
                                                    </td>
                                                    <td>
                                                        {!! $item->DaftarTagihan->trashed()
                                                            ? "<span
                                                                                                                                                                                                                                                                                                                                            class='badge bg-danger text-bold'>
                                                                                                                                                                                                                                                                                                                                            Tidak Aktif</span>"
                                                            : "<span
                                                                                                                                                                                                                                                                                                                                            class='badge bg-success text-bold'>Aktif</span>" !!}
                                                    </td>
                                                    <td class="d-flex">
                                                        <form action="{{ route('kelompok.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="nama"
                                                                value="{{ $kelompokTagihan->nama }}">
                                                            <input type="hidden" name="DaftarTagihanID"
                                                                value="{{ $item->DaftarTagihan->id }}">
                                                            <input type="hidden" name="kelas_id"
                                                                value="{{ $kelompokTagihan->Kelas->id }}">
                                                            <input type="hidden" name="kelas"
                                                                value="{{ $kelompokTagihan->Kelas->kelas }}">
                                                            <button type="submit" class="action-icon btn d-block">
                                                                <i class="uil-trash"></i></button>
                                                        </form>
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
    <link href="{{ url('/') }}/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
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

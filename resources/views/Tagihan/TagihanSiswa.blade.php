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
                <div class="modal fade" id="buatTagihanSiswa" data-bs-backdrop="static" data-bs-keyboard="false"
                    role="dialog" aria-labelledby="buatTagihanSiswalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buatTagihanSiswalTitleId">
                                    Buat Tagihan Siswa
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3 needs-validation" action="{{ Route('tagihanSiswa.store') }}"
                                    method="POST">

                                    @csrf

                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama Tagihan</label>
                                        <input type="text" class="form-control" id="nama" placeholder="nama"
                                            required name="nama" value="{{ old('nama') ? old('nama') : '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Nama siswa</label>
                                        <select name="user_id" id="namaSiswa" class="form-control select3">
                                            @forelse ($dataSiswa as $item)
                                                <optgroup label="{{ $item->kelas }}">
                                                    @foreach ($item->User()->get() as $siswa)
                                                        <option value="{{ $siswa->id }}">{{ $siswa->name }} (
                                                            {{ $item->kelas }}
                                                            )
                                                    @endforeach
                                                    </option>
                                                </optgroup>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- @dump($daftarTagihan) --}}
                                        <label class="form-label">tagihan</label>
                                        <table class="table table-light">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Nominal</th>
                                                    <th>pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($daftarTagihan as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->nominal }}</td>
                                                        <td>
                                                            <div class="form-check form-checkbox-primary">
                                                                <input type="checkbox" class="form-check-input"
                                                                    value="{{ $item->id }}" name="daftar_tagihan_id">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td colspan="4" class="text-warning">Daftar Tagihan Belum Di buat
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Nominal</th>
                                                    <th>pilih</th>
                                                </tr>
                                            </tfoot>
                                        </table>

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
                                        <a data-bs-toggle="modal" href="#buatTagihanSiswa" class="btn btn-primary mb-2"><i
                                                class="mdi mdi-plus-circle me-2"></i> Tambah
                                            Tagihan Siswa</a>
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
                                                    <th>Kelas</th>
                                                    <th>Nama Tagihan</th>
                                                    <th>Nominal</th>
                                                    <th>satus</th>
                                                    <th style="width: 75px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Tagihan as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->User->name }}
                                                        </td>
                                                        <td>
                                                            {{ $item->User->Kelas->kelas }}
                                                        </td>
                                                        <td>
                                                            {{ $item->nama }}
                                                        </td>
                                                        <td>
                                                            {{ Number::currency($item->nominal, 'IDR') }}
                                                        </td>
                                                        <td>
                                                            {!! $item->trashed()
                                                                ? "<span class='badge bg-danger text-bold'> Tidak Aktif</span>"
                                                                : "<span class='badge bg-success text-bold'>Aktif</span>" !!}
                                                        </td>
                                                        <td class="d-flex">
                                                            <a href="{{ route('tagihanSiswa.show', $item->id) }}"
                                                                class="action-icon"> <i class="uil-invoice"></i></a>
                                                            @if ($item->trashed())
                                                                <a href="{{ route('tagihanSiswa.restore', $item->id) }}"
                                                                    class="action-icon">
                                                                    <i class="mdi mdi-delete-restore"></i></a>
                                                            @else
                                                                <form
                                                                    action="{{ route('tagihanSiswa.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @method('DELETE')
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
                    dropdownParent: $("#buatTagihanSiswa")
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
                        {
                            orderable: !0,
                        }
                    ],
                    order: [
                        [1, "desc"]
                    ],
                })
            })
        </script>
    @endsection

@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Data Pasien</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tampilan Data Pasien</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>No.Hp</th>
                        <th>Agama</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Pekerjaan</th>
                        <th>Golongan Darah</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasien as $p)
                    <tr>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->tempat_lahir }}</td>
                        <td>{{ $p->tanggal_lahir }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->agama }}</td>
                        <td>{{ $p->pendidikan_terakhir }}</td>
                        <td>{{ $p->pekerjaan }}</td>
                        <td>{{ $p->golongan_darah }}</td>
                        <td>
                            <a href="{{ route('pasien.edit', $p->nik) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pasien.destroy', $p->nik) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah anda ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
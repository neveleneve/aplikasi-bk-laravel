@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="card">
                    <div class="card-header text-center">Bimbingan</div>
                    <div class="card-body">
                        @if (session('msg'))
                            <div class="alert alert-{{ session('color') }} alert-dismissible fade show" role="alert">
                                {!! session('msg') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12 col-xl-4 mb-2 mb-xl-0">
                                <a href="{{ url('/record/create') }}" class="btn btn-primary btn-block font-weight-bold"
                                    role="button">
                                    Tambah Bimbingan
                                </a>
                            </div>
                            <div class="col-0 col-xl-4"></div>
                            <div class="col-12 col-xl-4 my-mr-bottom">
                                <form action="/record">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search dengan nis atau nama siswa" value="{{ $search }}">
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Kegiatan</th>
                                        <th scope="col">Tempat</th>
                                        <th scope="col">Uraian</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Siswa yang bersangkutan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($records as $record)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ date('d-m-Y', strtotime($record->date)) }}</td>
                                            <td>{{ $record->subservice->name }}</td>
                                            <td>{{ $record->place }}</td>
                                            <td>{{ $record->desc }}</td>
                                            <td>{{ $record->info }}</td>
                                            <td>
                                                @foreach ($record->students as $student)
                                                    <a href="/students/{{ $student->id }}">
                                                        {{ $student->name }}
                                                    </a>,&nbsp;
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                    aria-label="Button group with nested dropdown">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button"
                                                            class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item"
                                                                href="{{ route('record.show', ['record' => $record->id]) }}">
                                                                Lihat Data
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('record.edit', ['record' => $record->id]) }}">
                                                                Ubah Data
                                                            </a>
                                                            <form id="delete-record-form"
                                                                action="{{ route('record.destroy', ['record' => $record->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="submit" value="Hapus Data"
                                                                    class="dropdown-item">
                                                            </form>
                                                            <a class="dropdown-item" target="__blank"
                                                                href="/record/{{ $record->id }}/pdf">Cetak Bimbingan</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <h3 class="text-center font-weight-bold">Data Kosong</h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('msg'))
        <script>
            setTimeout(() => {
                window.close();
            }, 1000);
        </script>
    @endif
@endsection

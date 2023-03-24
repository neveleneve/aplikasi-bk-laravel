@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header text-center font-weight-bold">Tambah Guru</div>
                    <div class="card-body">
                        <form action="{{ route('teachers.update', ['id' => $teacher['id']]) }}" method="POST">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="font-weight-bold" for="nama">Nama Guru Mata Pelajaran</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required
                                        placeholder="Nama Guru Mata Pelajaran" value="{{ $teacher['name'] }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="font-weight-bold" for="mapel">Nama Mata Pelajaran</label>
                                    <select name="mapel" id="mapel" class="form-control" required>
                                        <option selected hidden>Pilih Mata Pelajaran</option>
                                        @foreach ($study as $item)
                                            <option {{ $teacher['mapel_id'] == $item->id ? 'selected' : null }}
                                                value="{{ $item->id }}">
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-right" role="group">
                                <a href="{{ route('teachers.index') }}" class="btn btn-danger" role="button">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header text-center font-weight-bold">Tambah Siswa</div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('students.store') }}" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold" for="code">NIS</label>
                                    <input name="code" type="text" class="form-control"
                                        placeholder="Nomor Induk Siswa" value="{{ old('code') }}">
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="font-weight-bold" for="name">Nama</label>
                                    <input name="name" type="text" class="form-control" placeholder="Nama Siswa"
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold" for="level">Tingkat Kelas</label>
                                    <select name="level" class="form-control">
                                        <option selected disabled hidden>Pilih Tingkat Kelas</option>
                                        @for ($i = 10; $i <= 12; $i++)
                                            <option {{ old('level') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold" for="program">Jurusan</label>
                                    <select name="program" class="form-control">
                                        <option selected disabled hidden>Pilih Jurusan</option>
                                        @foreach ($programs as $program)
                                            <option {{ old('program') == $program ? 'selected' : '' }}>{{ $program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold" for="room">Ruangan Kelas</label>
                                    <select name="room" class="form-control">
                                        <option selected disabled hidden>Pilih Ruangan Kelas</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option {{ old('room') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="text-right" role="group">
                                <a href="{{ route('students.index') }}" class="btn btn-danger" role="button">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

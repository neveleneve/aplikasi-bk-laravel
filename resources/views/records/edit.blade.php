@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/students.js') }}"></script>
    <script src="{{ asset('js/my-bootstrap.js') }}"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">Edit Bimbingan</div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </div>
                        @endif
                        <form action="/record/{{ $record->id }}" method="POST" class="row">
                            <div class="col-md-6">
                                <div class="card-header text-center">Rincian Kegiatan</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="date">Tanggal</label>
                                        <input name="date" type="date" class="form-control"
                                            value="{{ old('date') ? old('date') : $record->date }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="subservice_id">Kegiatan</label>
                                        <select name="subservice_id" class="form-control">
                                            <option></option>
                                            @foreach ($services as $service)
                                                <optgroup label="{{ $service->name }}">
                                                    @foreach ($service->subservices as $subservice)
                                                        <option value="{{ $subservice->id }}"
                                                            @if (old('subservice_id')) {{ old('subservice_id') == $subservice->id ? 'selected' : '' }} 
                                                    @else
                                                        {{ $record->subservice_id == $subservice->id ? 'selected' : '' }} @endif>
                                                            {{ $subservice->name }}</option>
                                                    @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="place">Tempat</label>
                                        <input name="place" type="text" class="form-control"
                                            value="{{ old('place') ? old('place') : $record->place }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="guru">Guru yang Terlibat</label>
                                        <select name="guru" id="guru" class="form-control">
                                            <option selected hidden>Pilih Guru</option>
                                            <option {{ $record->teacher_id == 0 ? 'selected' : null }} value="0">Tidak
                                                Melibatkan Guru</option>
                                            @foreach ($teachers as $item)
                                                <option {{ $item->id == $record->teacher_id ? 'selected' : null }}
                                                    value="{{ $item->id }}">{{ $item->name }} |
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Uraian Kegiatan</label>
                                        <textarea name="desc" rows="4" class="form-control">{{ old('desc') ? old('desc') : $record->desc }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="info">Keterangan</label>
                                        <textarea name="info" rows="2" class="form-control">{{ old('info') ? old('info') : $record->info }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-header text-center">Siswa yang Bersangkutan</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="search">Cari Siswa</label>
                                        <input name="search" id="search" type="text" class="form-control"
                                            autocomplete="off" placeholder="S e a r c h  .  .  ." data-toggle="tooltip"
                                            data-placement="top" title="Cari NIS / Nama / Kelas">
                                    </div>
                                    <div id="table_container"></div>
                                    <br>
                                    <div id="table_added_container">
                                        @if (old('students'))
                                            @php
                                                foreach (old('students') as $key => $value) {
                                                    foreach ($value as $keyy => $valuee) {
                                                        $students[$keyy][$key] = $valuee;
                                                    }
                                                }
                                            @endphp
                                        @else
                                            @php
                                                $students = $record->students;
                                                foreach ($students as $student) {
                                                    $student['clas'] = $student['class'];
                                                }
                                            @endphp
                                        @endif
                                        <label>Siswa yang sudah ditambahkan</label>
                                        <table id="table_added" class="table table-striped">
                                            <tr>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <input type="hidden" name="students[id][]"
                                                        value="{{ $student['id'] }}">
                                                    <input type="hidden" name="students[code][]"
                                                        value="{{ $student['code'] }}">
                                                    <input type="hidden" name="students[name][]"
                                                        value="{{ $student['name'] }}">
                                                    <input type="hidden" name="students[clas][]"
                                                        value="{{ $student['clas'] }}">
                                                    <td>{{ $student['code'] }}</td>
                                                    <td>{{ $student['name'] }}</td>
                                                    <td>{{ $student['clas'] }}</td>
                                                    <td>
                                                        <a href="#" class="delete btn btn-outline-danger btn-sm"
                                                            role="button">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="col-md-12 text-right" role="group">
                                <br>
                                <a href="/record" class="btn btn-danger btn-lg" role="button">Batal</a>
                                <button type="submit" class="btn btn-primary btn-lg">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

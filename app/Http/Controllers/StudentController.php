<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class StudentController extends Controller
{
    // Untuk diakses di tambah dan edit
    public $programs = array("IPA", "IPS", "Bahasa");

    // Fungsi untuk mendapatkan kelas siswa
    public function getClass($level, $program, $room)
    {
        return $level . ' ' . $program . ' ' . $room;
    }

    // Fungsi untuk pesan
    public function getMessage($code, $type, $name = null)
    {
        $msg = 'Siswa dengan Nama <strong>' . $name . '</strong> dan NIS <strong>' . $code . '</strong> berhasil di <strong>' . $type . '</strong>';
        return $msg;
    }

    public function index(Request $request)
    {
        $search   = $request->search;
        $students = new Student;
        if ($search) {
            $students = $students->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orWhere('class', 'like', '%' . $search . '%');
        }
        $students = $students->paginate(10);
        return view('students.index', compact('students', 'search'));
    }

    public function create()
    {
        $programs = $this->programs;
        return view('students.create', compact('programs'));
    }

    public function store(Request $request)
    {
        if ($request->tipe == 0) {
            $this->validate($request, [
                'code'    => 'required|digits_between:9,10',
                'name'    => 'required',
                'level'   => 'required',
                'program' => 'required',
                'room'    => 'required'
            ]);

            $class = $this->getClass($request->level, $request->program, $request->room);

            Student::create([
                'code'    => $request->code,
                'name'    => $request->name,
                'level'   => $request->level,
                'program' => $request->program,
                'room'    => $request->room,
                'class'   => $class
            ]);

            $msg = $this->getMessage($request->code, 'Tambah', $request->name);
        } elseif ($request->tipe == 1) {
            $this->validate($request, [
                'file_csv'    => 'required'
            ]);

            $namafile = 'DataSiswa.csv';
            $file = $request->file('file_csv');
            $destination = public_path('csv');
            $file->move($destination, $namafile);
            $datacsv = $this->csvtoarray(public_path('csv/DataSiswa.csv'));
            $datax = $datacsv;

            for ($i = 0; $i < count($datax); $i++) {
                $cekdata = Student::where('code', $datacsv[$i]['nim'])->count();
                if ($cekdata > 0) {
                    Student::where('code', $datacsv[$i]['nim'])->update([
                        'name'    => ucwords(strtolower($datacsv[$i]['name'])),
                        'level'   => $datacsv[$i]['kelas'],
                        'program' => ucfirst(strtolower($datacsv[$i]['jurusan'])),
                        'room'    => $datacsv[$i]['ruangan'],
                        'class'   => $datacsv[$i]['kelas'] . ' ' . ucfirst(strtolower($datacsv[$i]['jurusan'])) . ' ' . $datacsv[$i]['ruangan'],
                    ]);
                } else {
                    Student::insert([
                        'code'    => $datacsv[$i]['nim'],
                        'name'    => ucwords(strtolower($datacsv[$i]['name'])),
                        'level'   => $datacsv[$i]['kelas'],
                        'program' => ucfirst(strtolower($datacsv[$i]['jurusan'])),
                        'room'    => $datacsv[$i]['ruangan'],
                        'class'   => $datacsv[$i]['kelas'] . ' ' . ucfirst(strtolower($datacsv[$i]['jurusan'])) . ' ' . $datacsv[$i]['ruangan'],
                    ]);
                }
            }
            File::delete('csv/DataMahasiswa.csv');
            $msg = "Data siswa berhasil ditambah!";
        }
        return redirect(route('students.index'))->with('msg', $msg);
    }

    public function show($id)
    {
        $student = Student::with('records')->findOrFail($id);
        return view('students.single', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $programs = $this->programs;
        return view('students.edit', compact('student', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code'    => 'required|digits_between:9,10',
            'name'    => 'required',
            'level'   => 'required',
            'program' => 'required',
            'room'    => 'required'
        ]);

        $class = $this->getClass($request->level, $request->program, $request->room);

        $student = Student::findOrFail($id);
        $code    = $student->code;

        $student->update([
            'code'    => $request->code,
            'name'    => $request->name,
            'level'   => $request->level,
            'program' => $request->program,
            'room'    => $request->room,
            'class'   => $class
        ]);

        $msg = $this->getMessage($code, 'Edit');

        return redirect('students')->with('msg', $msg);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $code    = $student->code;
        $student->delete();

        $msg = $this->getMessage($code, 'Hapus');

        return redirect('students')->with('msg', $msg);
    }

    public function api($search = null)
    {
        if ($search != null) {
            $students = Student::where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orWhere('class', 'like', '%' . $search . '%')->get();
            return $students;
        }
    }

    public function rekap($id)
    {
        $data = Student::with('records', 'records.subservice')
            ->findOrFail($id);
        // dd($data);
        // return view('records.rekap', [
        //     'data' => $data
        // ]);
        return PDF::loadView('records.rekap', [
            'data' => $data
        ])->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true])
            ->stream('LaporanKegiatan-1-' . now()->format('dmY') . '.pdf');
    }

    public function csvtoarray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }
        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Record;
use App\Teacher;
use Illuminate\Support\Facades\DB;
use PDF;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search  = $request->search;
        $records = Record::with('subservice', 'students');
        if ($search) {
            $records = $records->where(function ($query) use ($search) {
                $query->where('date', 'like', '%' . $search . '%');
                $columns = ['place', 'desc', 'info'];
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }

                $query->orWhereHas('subservice', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });

                $query->orWhereHas('students', function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%');
                    $q->orWhere('name', 'like', '%' . $search . '%');
                });
            });
        }
        $records = $records->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(3);
        return view('records.index', compact('records', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::with('subservices')->get();
        $teachers = DB::table('teachers')
            ->join('mapels', 'teachers.mapel_id', '=', 'mapels.id')
            ->select([
                'teachers.id',
                'teachers.name',
                'mapels.nama',
            ])
            ->get();
        return view('records.create', compact('services', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'guru' => 'required',
            'subservice_id' => 'required',
            'place' => 'required',
            'desc' => 'required',
            'info' => 'required',
            'students.id.0' => 'required'
        ]);
        // dd($request->all());
        // Save to record
        $record = Record::create([
            'date' => $request->date,
            'subservice_id' => $request->subservice_id,
            'place' => $request->place,
            'desc' => $request->desc,
            'teacher_id' => $request->guru,
            'info' => $request->info
        ]);

        // Save to record_student
        $record->students()->attach($request->students['id']);

        return redirect('record')->with([
            'msg' => 'Bimbingan berhasil di <strong>Submit</strong>',
            'color' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::with('subservice', 'students')->findOrFail($id);
        return view('records.single', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record   = Record::with('students')->findOrFail($id);
        $services = Service::with('subservices')->get();
        $teachers = DB::table('teachers')
            ->join('mapels', 'teachers.mapel_id', '=', 'mapels.id')
            ->select([
                'teachers.id',
                'teachers.name',
                'mapels.nama',
            ])
            ->get();
        return view('records.edit', compact('record', 'services', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date'          => 'required',
            'subservice_id' => 'required',
            'guru'          => 'required',
            'place'         => 'required',
            'desc'          => 'required',
            'info'          => 'required',
            'students.id.0' => 'required'
        ]);

        $record = Record::findOrFail($id);

        // Update record
        $record->update([
            'date'          => $request->date,
            'teacher_id'    => $request->guru,
            'subservice_id' => $request->subservice_id,
            'place'         => $request->place,
            'desc'          => $request->desc,
            'info'          => $request->info
        ]);

        // Update record_student
        $record->students()->sync($request->students['id']);

        return redirect('record')->with('msg', 'Bimbingan berhasil di <strong>Update</strong>');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        Record::findOrFail($id)->delete();
        return redirect('record')->with('msg', 'Bimbingan berhasil di <strong>Hapus</strong>');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $record = Record::with('subservice.service', 'students')
            ->findOrFail($id);
        // dd($record);
        // return view('records.pdf', compact('record'));
        return PDF::loadView('records.pdf', compact('record'))
            ->setPaper('a4', 'potrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true])
            ->stream('LaporanKegiatan-' . $record->id . '-' . now()->format('dmY') . '.pdf');
    }

    public static function namaGuru($id)
    {
        $guru = Teacher::where('teachers.id', $id)->join('mapels', 'teachers.mapel_id', '=', 'mapels.id')
            ->select([
                'teachers.id',
                'teachers.name',
                'mapels.nama',
            ])
            ->get();
        return $guru[0]->name . ' - ' . $guru[0]->nama;
    }
}

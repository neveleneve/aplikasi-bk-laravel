<?php

namespace App\Http\Controllers;

use App\Mapel;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function getMessage($code, $type)
    {
        $msg = 'Guru dengan Nama <strong>' . $code . '</strong> berhasil di <strong>' . $type . '</strong>';
        return $msg;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = DB::table('teachers')
            ->join('mapels', 'teachers.mapel_id', '=', 'mapels.id')
            ->select([
                'teachers.id',
                'teachers.name',
                'mapels.nama',
            ])->orderBy('teachers.name')
            ->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $study = Mapel::get();
        return view('teachers.create', compact('study'));
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
            'nama'    => 'required',
            'mapel'   => 'required'
        ]);

        Teacher::insert([
            'name' => $request->nama,
            'mapel_id' => $request->mapel,
        ]);
        $msg = $this->getMessage(ucwords(strtolower($request->nama)), 'Tambah');

        return redirect(route('teachers.index'))->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $study = Mapel::get();
        $teacher = Teacher::find($id);
        // dd($teacher);
        return view('teachers.edit', compact('study', 'teacher'));
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
            'nama'    => 'required',
            'mapel'   => 'required'
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update([
            'name' => $request->nama,
            'mapel_id' => $request->mapel,
        ]);
        $msg = $this->getMessage(ucwords(strtolower($request->nama)), 'Edit');

        return redirect(route('teachers.index'))->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect(route('teachers.index'));
    }
}

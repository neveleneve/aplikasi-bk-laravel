<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements ToModel
{
    // public function startRow(): int
    // {
    //     return 2;
    // }

    // public function getCsvSettings(): array
    // {
    //     return [
    //         'delimiter' => ';'
    //     ];
    // }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row[0]);
        return new Student([
            'code'    => $row['code'],
            'name'    => ucwords(strtolower($row['name'])),
            'level'   => $row['kelas'],
            'program' => ucfirst(strtolower($row['jurusan'])),
            'room'    => $row['ruangan'],
            'class'   => $row['kelas'] . ' ' . ucfirst(strtolower($row['jurusan'])) . ' ' . $row['ruangan'],
        ]);
    }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}

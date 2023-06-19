<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Data Bimbingan Konseling</title>
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png">
    <style>
        table {
            width: 100%;
        }

        .report {
            /*font-family: arial;*/
            font-size: 15px;
            /*background-color: red;
            border: 1px solid green;*/
        }

        .report-header {
            border-bottom: 2px solid black;
            width: 100%;
        }

        .report-header td {
            text-align: center;
            /*border: 1px solid green;*/
        }

        .head1 {
            font-size: 20px;
            letter-spacing: 2px;
        }

        .head2 {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .head3 {
            font-size: 12px;
            letter-spacing: 1px;
            /*font-size: 11px;*/
        }

        .report-rincian td {
            height: 26px;
            /*line-height: 1px;*/
            vertical-align: top;
            text-align: justify;
        }

        .report-siswa {
            border-collapse: collapse;
        }

        .report-siswa td,
        .report-siswa th {
            text-align: center;
            /* height: 30px; */
            padding: 5px 10px;
            border: 1px solid #333;
        }

        .text-right {
            text-align: right;
        }

        .text-left,
        td.text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="report report-header">
        <tr>
            <td style="width: 15%;">
                <img src="{{ asset('images/logo.png') }}" style="width: 70px;">
            </td>
            <td style="width: 85%;">
                <div class="head1">REKAP KEGIATAN BIMBINGAN KONSELING</div>
                <div class="head2">SMA NEGERI 4 Tanjungpinang</div>
                <div class="head3">Jl. Pemuda No. 30 Kota Tanjungpinang Telp. (0771) 21717</div>
            </td>
        </tr>
    </table>
    <br>
    <h2 class="text-center">REKAP BIMBINGAN KONSELING</h2>
    <table class="report report-rincian">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->name }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $data->class }}</td>
        </tr>
    </table>
    <br>
    <table class="report-siswa">
        <tr>
            <td>No</td>
            <td>Tanggal</td>
            <td>Nama Kegiatan</td>
            <td>Tempat</td>
            <td>Uraian</td>
            <td>Keterangan</td>
        </tr>
        @forelse ($data->records as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                <td>{{ $item->subservice->name }}</td>
                <td>{{ $item->place }}</td>
                <td>{{ $item->desc }}</td>
                <td>{{ $item->info }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <h2 class="text-center">Data Kosong</h2>
                </td>
            </tr>
        @endforelse
    </table>
    <br>
    <table>
        <tbody>

            <tr>
                <td>Tanggal,.............................</td>
            </tr>
            <tr>
                <td>Tertanda,</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>[..............................................]</td>
            </tr>
        </tbody>
    </table>
</body>

</html>

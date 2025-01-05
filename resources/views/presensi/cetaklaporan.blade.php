<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
            text-align: right; /* Mengatur teks agar berada di sebelah kanan */
            margin-left: auto; /* Mengatur margin kiri otomatis */
            margin-right: 0; /* Mengatur margin kanan menjadi 0 */
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;

        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logo_skm/logo_skm.png') }}" width="120" height="120" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT. SINDUE KARYA MANDIRI<br>
                    </span>
                    <span><i>Jalan. MH Thamrin No.63, Besusu Tim., Kec. Palu Tim., Kota Palu, Sulawesi Tengah</i></span>
                </td>
            </tr>
        </table>
        <table style="width: 100%" class="tabeldatakaryawan">
            <tr>
                <td style="text-align: left; width: 5%">Nama Karyawan</td>
                <td style="width: 1%">:</td>
                <td style="text-align: left; width: 30%">{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td style="text-align: left">Jabatan</td>
                <td>:</td>
                <td style="text-align: left">{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td style="text-align: left">Departemen</td>
                <td>:</td>
                <td style="text-align: left">{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td style="text-align: left">No. HP</td>
                <td>:</td>
                <td style="text-align: left">{{ $karyawan->no_hp }}</td>
            </tr>
            <tr>
                <td style="text-align: left">Bulan</td>
                <td>:</td>
                <td style="text-align: left">{{ $namabulan[$bulan] }} {{ $tahun }}</td>
            </tr>
        </table>
       
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                {{-- <th>Status</th> --}}
                <th>Keterangan</th>
                {{-- <th>Jml Jam</th> --}}
            </tr>

            @foreach ($presensi as $d)
                @if ($d->status == 'h')
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                        $terlambat = hitungjamterlambat($d->jam_masuk, $d->jam_in);
                        $terlambat_desimal = hitungjamterlambatdesimal_text($d->jam_masuk, $d->jam_in);
                        // dd($d->jam_masuk, $d->jam_in);
                        $j_terlambat = explode(':', $terlambat);
                        $jam_terlambat = intVal($j_terlambat[0]);
                        if ($jam_terlambat < 1) {
                            $jam_mulai = $d->jam_masuk;
                        } else {
                            $jam_mulai = $d->jam_in > $d->jam_masuk ? $d->jam_in : $d->jam_masuk;
                        }
                        $jam_berakhir = $d->jam_out > $d->jam_pulang ? $d->jam_pulang : $d->jam_out;
                        $total_jam = hitungjamkerja(
                            $d->tgl_presensi,
                            date('H:i', strtotime($jam_mulai)),
                            date('H:i', strtotime($jam_berakhir)),
                            $d->total_jam,
                            $d->lintashari,
                            date('H:i', strtotime($d->awal_jam_istirahat)),
                            date('H:i', strtotime($d->akhir_jam_istirahat)),
                        );
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->jam_out != null)
                                <img src="{{ url($path_out) }}" alt="" class="foto">
                            @else
                                <img src="{{ asset('assets/img/camera.jpg') }}" alt="" class="foto">
                            @endif
                        </td>
                        <td>
                            @if ($d->jam_in > $d->jam_masuk)
                                {{ $terlambat_desimal }}
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        {{-- <td style="text-align: center">{{ $d->status }}</td> --}}
                        <td>{{ $d->keterangan }}</td>
                        {{-- <td></td> --}}
                    </tr>
                @endif
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td colspan="2" style="text-align: right">Palu, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="150px">
                    @if ($ttd1)
                        @if ($ttd1->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd1->image) }}" alt="TTD 1" style="max-height: 100px;">
                        @endif
                        <br>
                        <u>{{ $ttd1->name }}</u><br>
                        <i><b>{{ $ttd1->position }}</b></i>
                    @else
                        <span class="text-muted">Tidak ada TTD</span>
                    @endif
                </td>
                <td style="text-align: right; vertical-align:bottom" height="150px">
                    @if ($ttd2)
                        @if ($ttd2->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd2->image) }}" alt="TTD 2" style="max-height: 100px;">
                        @endif
                        <br>
                        <u>{{ $ttd2->name }}</u><br>
                        <i><b>{{ $ttd2->position }}</b></i>
                    @else
                        <span class="text-muted">Tidak ada TTD</span>
                    @endif
                </td>
            </tr>
        </table>
    </section>


    {{-- Aktivitas --}}
    <section class="sheet padding-10mm">
        <h2>
            Laporan Aktivitas Karyawan
        </h2>
       
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Keterangan</th>
                <th>Foto</th>

            @foreach ($aktivitas as $d)
                    @php
                        $path_in = Storage::url('uploads/aktivitas/' . $d->foto);
                    @endphp 
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal_aktivitas)) }}</td>
                        <td>{{ $d->waktu_aktivitas }}</td>
                        <td>{{ $d->deskripsi}}</td>
                        <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                    </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td colspan="2" style="text-align: right">Palu, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="150px">
                    @if ($ttd1)
                        @if ($ttd1->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd1->image) }}" alt="TTD 1" style="max-height: 100px;">
                        @endif
                        <br>
                        <u>{{ $ttd1->name }}</u><br>
                        <i><b>{{ $ttd1->position }}</b></i>
                    @else
                        <span class="text-muted">Tidak ada TTD</span>
                    @endif
                </td>
                <td style="text-align: right; vertical-align:bottom" height="150px">
                    @if ($ttd2)
                        @if ($ttd2->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd2->image) }}" alt="TTD 2" style="max-height: 100px;">
                        @endif
                        <br>
                        <u>{{ $ttd2->name }}</u><br>
                        <i><b>{{ $ttd2->position }}</b></i>
                    @else
                        <span class="text-muted">Tidak ada TTD</span>
                    @endif
                </td>
            </tr>
        </table>
        
        
    </section>

</body>

</html>

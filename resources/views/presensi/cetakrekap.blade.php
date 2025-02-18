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
        /* @page {
            size: A4,
            
        } */

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
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
            padding: 5px;
            background-color: #dbdbdb;
            font-size: 10px
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

        body.A4.landscape .sheet {
            width: 297mm !important;
            height: auto !important;
        }
        @media print {
            body.A4.landscape .sheet {
                width: 297mm;
                height: 210mm;
                margin: 2mm 2mm
            }
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%;">
            <tr>
                {{-- <td style="width: 30px; border: 1px solid #131212; text-align: center; vertical-align: middle;">
                </td> --}}
                <td style="text-align: center; vertical-align: middle;">
                    <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        {{-- <img src="{{ asset('assets/img/logo_skm/logo_skm.png') }}" width="70" height="70" alt=""> --}}
                        <span id="title">
                            REKAP PRESENSI KARYAWAN<br>
                            PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                            PT. SINDUE KARYA MANDIRI<br>
                        </span>
                        <span><i>JL. MH. Thamrin No. 62, Besusu Timur, Palu Timur </i></span>
                    </div>
                </td>
            </tr>
        </table>

        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">Cabang</th>
                <th rowspan="2">Jabatan</th>
                <th rowspan="2">Nama Karyawan</th>
                <th style="width: 0.5%" colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                <th rowspan="2" style="border-left: 2px solid black;">H</th>
                <th rowspan="2">L</th>
                <th rowspan="2">S</th>
                <th rowspan="2">I</th>
                <th rowspan="2">TL</th>
                <th rowspan="2">CT</th>
                <th rowspan="2">SD</th>
                <th rowspan="2">A</th>
            </tr>
            <tr>
                @foreach ($rangetanggal as $d)
                    @if ($d != null)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endif
                @endforeach

            </tr>
            @foreach ($rekap as $r)
                <tr>
                    <td>{{ $r->cabang->nama_cabang }}</td>
                    <td>{{ $r->jabatan }}</td>
                    <td>{{ $r->nama_lengkap }}</td>
                    <?php
                    $turlap = $r->tl;
                    $jml_hadir = 0;
                    $jml_izin = 0;
                    $jml_sakit = 0;
                    $jml_cuti = 0;
                    $jml_alpa = 0;
                    $jml_libut = 0;
                    $jml_tl = 0;
                    $color = "";
                    for($i=1; $i<=$jmlhari; $i++){
                        $tgl = "tgl_" . $i;
                        $tgl_presensi = $rangetanggal[$i - 1];
                        $current_date = date('Y-m-d'); // Ambil tanggal hari ini

                        $search_items = [
                            'nik' => $r->nik,
                            'tanggal_libur' => $tgl_presensi,
                        ];
                        $ceklibur = cekkaryawanlibur($datalibur, $search_items);

                        $datapresensi = explode("|", $r->$tgl);
                        if ($r->$tgl != null) {
                            $status = $datapresensi[2];
                            $tl = $datapresensi[12];
                            // echo "<pre>";
                            //     var_dump($tl);
                            // echo "</pre>";
                        } else {
                            $status = "";
                            $tl = "";
                        }

                        $cekhari = gethari(date('D', strtotime($tgl_presensi)));

                        // Inisialisasi warna default
                        $color = "white";

                        // Tanggal lebih besar dari hari ini
                        if ($status == "h") {
                            $jml_hadir += 1;
                            $color = "#00ff4c"; // Hijau untuk hadir
                        }elseif (strtotime($tgl_presensi) > strtotime($current_date)) {
                            $color = "white"; // Tanggal di masa depan (belum tercatat)
                        } elseif ($cekhari == "Minggu") {
                            $jml_libut += 1;
                            $color = "orange"; // Oranye untuk Minggu
                        } elseif ($status == "i" && $tl == "Tidak") {
                            $jml_izin += 1;
                            $color = "#ffe600"; // Kuning untuk izin
                        } elseif ($status == "i" && $tl == "Ya") {
                            $jml_tl += 1;
                            $color = "#34efff";
                        } elseif ($status == "s") {
                            $jml_sakit += 1;
                            $color = "#34a1eb"; // Biru untuk sakit
                        } elseif ($status == "c") {
                            $jml_cuti += 1;
                            $color = "#a600ff"; // Ungu untuk cuti
                        } elseif (empty($status) && empty($ceklibur) && $cekhari != 'Minggu') {
                            $jml_alpa += 1;
                            $color = "red"; // Merah untuk alpa
                        } elseif (!empty($ceklibur)) {
                            $color = "#bb00ff"; // Magenta untuk libur
                        }

                        // Output kolom dengan warna yang sesuai
                        // echo "<td style=\"background-color: $color\"></td>";

                ?>
                    <td style="background-color: {{ $color }}">

                        {{-- {{ $status }} --}}

                    </td>
                    <?php
                    }
                ?>
                    <td style="border-left: 2px solid black;">{{ !empty($jml_hadir) ? $jml_hadir : '' }}</td>
                    <td>{{ !empty($jml_libut) ? $jml_libut : '' }}</td>
                    <td>{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                    <td>{{ !empty($jml_izin) ? $jml_izin : '' }}</td>
                    <td>{{ !empty($jml_tl) ? $jml_tl : '' }}</td>
                    <td>{{ !empty($jml_cuti) ? $jml_cuti : '' }}</td>
                    <td>{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                    <td>{{ !empty($jml_alpa) ? $jml_alpa : '' }}</td>
                </tr>
            @endforeach
        </table>
        <h4>Keterangan Libur :</h4>
        <ol>
            @foreach ($harilibur as $d)
                <li>{{ date('d-m-Y', strtotime($d->tanggal_libur)) }} - {{ $d->keterangan }}</li>
            @endforeach
        </ol>
        <table width="100%" style="margin-top:100px">
            <tr>
                <td></td>
                <td style="text-align: center">Palu, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="150px">
                    @if ($ttd1)
                        @if ($ttd1->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd1->image) }}" alt="TTD 1" height="100px" style="max-height: 100px;">
                        @endif
                        <br>
                        <u>{{ $ttd1->name }}</u><br>
                        <i><b>{{ $ttd1->position }}</b></i>
                    @else
                        <span class="text-muted">Tidak ada TTD</span>
                    @endif
                </td>
                <td style="text-align: center; vertical-align:bottom" height="150px">
                    @if ($ttd2)
                        @if ($ttd2->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $ttd2->image) }}" alt="TTD 2" height="100px" style="max-height: 100px;">
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
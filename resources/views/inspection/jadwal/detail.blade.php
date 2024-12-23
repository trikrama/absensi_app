{{-- @extends('layouts.admin.tabler')
@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">Pemeriksaan Karyawan</h3>
    <h4 class="text-center text-primary">{{ $data->karyawan->nama_lengkap }}</h4>
    <p class="lead text-center">Unit Kerja: <strong>{{ $data->departemen->nama_dept }}</strong></p>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Jawaban</th>
                <th>Keterangan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedDetails as $detail) --}}
            {{-- @foreach ($data_detail as $detail) --}}
                {{-- <tr>
                    <td>{{ $detail->indikator }}</td>
                    <td>{{ $detail->jawaban }}</td>
                    <td>{{ $detail->keterangan }}</td>
                    <td>
                        @if($detail->foto)
                            <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto Pemeriksaan" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
    <!-- Tombol Kembali -->
    {{-- <div class="mb-3">
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Inspeksi
        </a>
    </div>
</div>
@endsection --}}
@extends('layouts.admin.tabler')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Pemeriksaan Karyawan</h1>
    <h2 class="text-center text-primary">{{ $data->karyawan->nama_lengkap }}</h2>
    <p class="lead text-center">Unit Kerja: <strong>{{ $data->departemen->nama_dept }}</strong></p>

    @foreach ($groupedDetails as $title => $details)
        <h3 class="mt-4 text-primary">{{ $title }}</h3> <!-- Menampilkan judul instrument_title -->

        {{-- <table class="table table-responsive"> --}}
        <table class="table table-responsive" style="table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th class="text-center">Jawaban</th>
                    <th class="text-center">Keterangan</th>
                    {{-- <th>Foto</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td>{{ $detail->indikator }}</td>
                        <td class="text-center">{{ $detail->jawaban }}</td>
                        <td class="text-center">{{ $detail->keterangan }}</td>
                        {{-- <td>
                            @if($detail->foto)
                                <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto Pemeriksaan" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Inspeksi
        </a>
        <button id="downloadPdf" class="btn btn-primary" >Download PDF</button>
    </div>
</div>
<script>
    // function downloadPdf() {
    //     console.log('Download PDF');
    // }
    document.getElementById('downloadPdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            format: "a4", // Ukuran kertas A4
            unit: "mm",   // Satuan dalam milimeter
        });

        const pageHeight = doc.internal.pageSize.height; // Tinggi halaman A4 dalam milimeter
        let currentY = 10; // Posisi Y awal
        const marginLeft = 20; // Margin kiri untuk semua teks

        // Fungsi untuk menambah teks dengan memeriksa tinggi halaman
        const addText = (text, x, yIncrement) => {
            if (currentY + yIncrement > pageHeight - 10) {
                doc.addPage(); // Tambahkan halaman baru jika melebihi batas
                currentY = 10; // Reset posisi Y
            }
            doc.text(text, x, currentY);
            currentY += yIncrement; // Tingkatkan posisi Y
        };

        // Judul PDF
        doc.setFontSize(16);
        addText("Detail Pemeriksaan", 10, 10);

        // Informasi Nama dan Penempatan
        doc.setFontSize(12);
        addText("Nama   \t\t\t: {{ $data->karyawan->nama_lengkap }}", 10, 10);
        addText("Penempatan\t\t: {{ $data->departemen->nama_dept }}", 10, 10);

       // Tabel Indikator Penilaian
        const tableBody = [];
        @foreach($groupedDetails as $title => $details)
            // Tambahkan baris untuk Title dengan gaya khusus
            tableBody.push([
                { content: {!! json_encode($loop->iteration) !!}, styles: { fontStyle: 'bold', halign: 'center' } }, 
                { content: '{{ $title }}', styles: { fontStyle: 'bold' } },
                { content: '', styles: { fontStyle: 'bold' } }
            ]);

            @foreach($details as $detail)
                // Tambahkan baris untuk indikator
                tableBody.push([
                    '', // Kolom pertama kosong untuk indikator
                    '{{ $detail->indikator }}', 
                    '{{ $detail->jawaban }}'
                ]);
            @endforeach
        @endforeach

        // Mulai Tabel
        doc.autoTable({
            head: [['No', 'Indikator Penilaian', 'Nilai']],
            body: tableBody,
            startY: currentY, // Gunakan posisi Y saat ini
            margin: { top: 4, bottom: 10 },
            didDrawPage: function (data) {
                currentY = data.cursor.y + 10; // Perbarui posisi Y berdasarkan akhir tabel
            },
        });

        // Tambahkan Catatan dalam Kotak dengan Label
        const addDynamicBoxedText = (label, text) => {
            // Lebar Maksimum Teks
            const maxWidth = 170; // Lebar maksimum kotak
            const marginLeft = 10; // Margin kiri
            const padding = 5; // Padding dalam kotak
            
            // Ukuran teks "Catatan:"
            const labelWidth = doc.getTextWidth(label) + padding;
            const textLines = doc.splitTextToSize(text, maxWidth - padding * 2); // Pisahkan teks jika melebihi lebar kotak
            const textHeight = textLines.length * 6; // Tinggi teks (6mm per baris, bisa disesuaikan)

            // Total tinggi kotak
            const boxHeight = textHeight + padding * 2;

            // Pindah ke halaman baru jika melebihi batas
            if (currentY + boxHeight > pageHeight - 10) {
                doc.addPage();
                currentY = 10;
            }

            doc.setFontSize(10);

            // Gambar kotak luar untuk label "Catatan:"
            doc.rect(marginLeft, currentY, labelWidth, boxHeight);

            // Tambahkan label "Catatan:"
            doc.text(label, marginLeft + padding / 2, currentY + 6);

            // Gambar kotak luar untuk isi teks
            doc.rect(marginLeft + labelWidth, currentY, maxWidth - labelWidth, boxHeight);

            // // Tambahkan teks dalam kotak
            // doc.text(textLines, marginLeft + labelWidth + padding / 2, currentY + padding + 6);
            // Tambahkan teks dalam kotak
            doc.text(textLines, marginLeft + labelWidth + padding / 2, currentY + padding + 0);


            // Perbarui posisi Y
            currentY += boxHeight + 10;
        };

        // Penggunaan Fungsi
        addDynamicBoxedText("Catatan:", "{{ $data->keterangan }}");

        
        doc.setFontSize(8);
        addText("Range Nilai :", 10, 5);
        addText("- Sangat Baik : 81-100", 10, 5);
        addText("- Baik : 61-80", 10, 5);
        addText("- Cukup  : 41-60", 10, 5);
        addText("- Kurang : 21-40", 10, 5);
        addText("- Sangat Kurang : 0-20", 10, 5);

        // Unduh PDF
        doc.save("Detail_Pemeriksaan.pdf");
    });

</script>

@endsection

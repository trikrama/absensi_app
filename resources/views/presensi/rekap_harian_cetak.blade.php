<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Rekap Presensi</title>
    
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    
    <!-- Paper.css for printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    
    <!-- Tambahkan pustaka html2canvas -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <!-- Tambahkan pustaka jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.min.js"></script>

    <!-- Custom Styles -->
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm; /* Margin dari ujung halaman */
        }

        body.A4.landscape {
            padding: 20mm; /* Padding di dalam margin */
            box-sizing: border-box; /* Pastikan padding dihitung dengan benar */
        }

        .sheet {
            width: 100%;
            height: auto;
            padding: 10mm;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: Arial, sans-serif;
        }

        #header-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        #header-subtitle {
            text-align: center;
            font-size: 12px;
            font-style: italic;
            margin-bottom: 20px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
        }

        .tabelpresensi thead th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
        }

        .tabelpresensi tbody td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .signature-section {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }

        .signature-box {
            display: inline-block;
            width: 200px;
            margin: 0 50px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
        }

        .sheet {
            margin: 10mm;  /* Menambahkan margin untuk mencetak */
        }

    </style>
</head>

<body class="A4 landscape">

    <section class="sheet">
        <!-- Header Section -->
        <div id="header-title">REKAP PRESENSI KARYAWAN</div>
        <div id="header-title">PERIODE: {{ $tanggal }}</div>
        <div id="header-title">PT. SINDUE KARYA MANDIRI</div>
        <div id="header-subtitle">Jalan. MH Thamrin No.63, Besusu Tim., Kec. Palu Tim., Kota Palu, Sulawesi Tengah</div>

        <!-- Table Section -->
        @if($rekapHarian->count() > 0)
        <table class="tabelpresensi">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Departemen</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapHarian as $index => $rekap)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rekap->nik }}</td>
                    <td>{{ $rekap->nama_lengkap }}</td>
                    <td>{{ $rekap->kode_dept }}</td>
                    <td>{{ $rekap->jam_in ?? '-' }}</td>
                    <td>{{ $rekap->jam_out ?? '-' }}</td>
                    <td>{{ $rekap->status ?? 'Tidak Hadir' }}</td>
                    <td>{{ $rekap->alasan_izin ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="text-align: center; margin-top: 30px;">Tidak ada data absensi untuk tanggal <strong>{{ $tanggal }}</strong>.</p>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                Palu, {{ date('d-m-Y') }}<br>
                <span>HRD Manager</span>
                <div class="signature-line">Andika</div>
            </div>
            <div class="signature-box">
                <br>
                <span>Direktur</span>
                <div class="signature-line">Tri Krama</div>
            </div>
        </div>
        <button id="downloadBtn" style="margin-top: 20px; padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            Download Rekap Presensi
        </button>
    </section>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", async () => {
            const { PDFDocument, rgb } = PDFLib;
    
            // Buat PDF baru dengan orientasi lanskap
            const pdfDoc = await PDFDocument.create();
            const page = pdfDoc.addPage([800, 600]); // Ukuran halaman lanskap 800x600
            const { width, height } = page.getSize();
    
            // Tentukan margin
            const marginLeft = 50;
            const marginRight = 30;
            const pageWidth = width - marginRight; // Lebar halaman dikurangi margin kanan
    
            // Ambil data dari server
            const headerTitle = "REKAP PRESENSI KARYAWAN";
            const headerPeriod = "PERIODE: {{ $tanggal }}"; // Ganti dengan data yang sesuai
            const company = "PT. SINDUE KARYA MANDIRI";
            const address = "Jalan. MH Thamrin No.63, Besusu Tim., Kec. Palu Tim., Kota Palu, Sulawesi Tengah";
    
            // Tambahkan teks header
            page.drawText(headerTitle, {
                x: marginLeft,
                y: height - 50,
                size: 20,
                color: rgb(0, 0, 0),
            });
            page.drawText(headerPeriod, {
                x: marginLeft,
                y: height - 70,
                size: 12,
                color: rgb(0, 0, 0),
            });
            page.drawText(company, {
                x: marginLeft,
                y: height - 90,
                size: 12,
                color: rgb(0, 0, 0),
            });
            page.drawText(address, {
                x: marginLeft,
                y: height - 110,
                size: 12,
                color: rgb(0, 0, 0),
            });
    
            // Tambahkan tabel
            const startY = height - 150; // Y awal untuk tabel
            const rowHeight = 20;
            const tableTopY = startY;
    
            // Header tabel
            const headers = ["#", "NIK", "Nama Lengkap", "Departemen", "Jam Masuk", "Jam Keluar", "Status", "Keterangan"];
            const columnWidths = [30, 70, 120, 170, 70, 70, 80, 100]; // Lebar kolom
    
            // Gambar header tabel
            const columnSpacing = 10; // Jarak antar kolom dalam piksel

            // Gambar header tabel
            headers.forEach((header, index) => {
                const xPosition = marginLeft + columnWidths.slice(0, index).reduce((a, b) => a + b, 0);
                page.drawText(header, {
                    x: xPosition,
                    y: startY,
                    size: 10,
                    color: rgb(0, 0, 0),
                });
            });
    
            // Gambar garis bawah header
            page.drawLine({
                start: { x: marginLeft, y: startY - 5 },
                end: { x: pageWidth, y: startY - 5 },
                color: rgb(0, 0, 0),
                thickness: 2,
            });
    
            // Ambil data rekap
            const rekapHarian = @json($rekapHarian);
            const tanggal = @json($tanggal);
    
            // Tambahkan data rekap ke tabel
            // const columnSpacing = 10; // Jarak antar kolom dalam piksel

            rekapHarian.forEach((rekap, index) => {
                const yPosition = startY - (rowHeight * (index + 1)); // Y posisi setiap baris
                let xPosition = marginLeft; // Mulai dari margin kiri

                // Gambar data dengan jarak antar kolom
                const safeText = (text) => (text ? text.toString() : '-');
                page.drawText((index + 1).toString(), { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[0]; // Posisi x setelah kolom pertama

                page.drawText(rekap.nik.toString(), { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[1]; // Posisi x setelah kolom kedua

                page.drawText(rekap.nama_lengkap, { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[2]; // Posisi x setelah kolom ketiga

                page.drawText(rekap.kode_dept, { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[3]; // Tambahkan jarak setelah kolom "Departemen"

                page.drawText((rekap.jam_in || '-').toString(), { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[4]; // Posisi x setelah kolom "Jam Masuk"

                page.drawText((rekap.jam_out || '-').toString(), { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[5]; // Posisi x setelah kolom "Jam Keluar"

                page.drawText((rekap.status || 'Tidak Hadir').toString(), { x: xPosition, y: yPosition, size: 10 });
                xPosition += columnWidths[6]; // Posisi x setelah kolom "Status"

                page.drawText((rekap.alasan_izin || '-').toString(), { x: xPosition, y: yPosition, size: 10 });

                // Gambar garis bawah setiap baris
                page.drawLine({
                    start: { x: marginLeft, y: yPosition - 3 },
                    end: { x: pageWidth, y: yPosition - 3 },
                    color: rgb(0, 0, 0),
                    thickness: 1,
                });
            });
    
            // Tambahkan bagian tanda tangan
            const signatureY = startY - (rowHeight * (rekapHarian.length + 2));
            page.drawText(`Palu, ${new Date().toLocaleDateString()}`, {
                x: marginLeft,
                y: signatureY,
                size: 10,
                color: rgb(0, 0, 0),
            });
            page.drawText("HRD Manager", { x: marginLeft, y: signatureY - 20, size: 10 });
            page.drawText("Andika", { x: marginLeft, y: signatureY - 40, size: 10 });
            page.drawText("Direktur", { x: marginLeft + 250, y: signatureY - 20, size: 10 });
            page.drawText("Tri Krama", { x: marginLeft + 250, y: signatureY - 40, size: 10 });
    
            // Simpan PDF sebagai blob
            const pdfBytes = await pdfDoc.save();
    
            // Unduh PDF
            const blob = new Blob([pdfBytes], { type: "application/pdf" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = `rekap_presensi-${tanggal}.pdf`;
            link.click();
        });
    </script>

</body>

</html>

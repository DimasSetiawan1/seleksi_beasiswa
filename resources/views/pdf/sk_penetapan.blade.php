<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keputusan Penetapan Penerima Beasiswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header h3 { margin: 5px 0 0 0; font-size: 14px; font-weight: normal; }
        .header p { margin: 0; font-size: 10px; color: #555; }
        .title { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 20px; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 40px; float: right; width: 220px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMK TINTA EMAS INDONESIA</h2>
        <h3>SURAT KEPUTUSAN KEPALA SEKOLAH</h3>
        <p>Jl. Pendidikan No. 1, Kota Bekasi, Jawa Barat | Email: info@smktintaemas.sch.id</p>
    </div>

    <div class="title">
        PENETAPAN PENERIMA BEASISWA SELEKSI TERPADU<br>
        <small style="font-size:11px; font-weight:normal;">Periode: {{ $period->nama_periode }} ({{ $period->tahun_ajaran }})</small>
    </div>

    <p>Berdasarkan hasil evaluasi tingkat kepentingan kriteria dan perangkingan skor pendaftar, Kepala Sekolah menetapkan nama-nama siswa di bawah ini sebagai penerima beasiswa:</p>

    <table>
        <thead>
            <tr>
                <th style="width: 40px; text-align:center;">Peringkat</th>
                <th>NIK</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th style="width: 100px; text-align:center;">Skor Akhir Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mooraResults as $res)
                <tr>
                    <td style="text-align:center; font-weight:bold;">#{{ $res->rank }}</td>
                    <td>{{ $res->applicant->nik }}</td>
                    <td><strong>{{ $res->applicant->nama_lengkap }}</strong></td>
                    <td>{{ $res->applicant->kelas }}</td>
                    <td style="text-align:center;">{{ number_format($res->nilai_optimasi_yi, 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Bekasi, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Kepala SMK Tinta Emas Indonesia</p>
        <br><br><br>
        <p><strong>( <u>. . . . . . . . . . . . . . . . . . . . .</u> )</strong><br>NIP. 19780812 200501 1 002</p>
    </div>

</body>
</html>

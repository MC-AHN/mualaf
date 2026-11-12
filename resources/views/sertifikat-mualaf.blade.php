<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Syahadat - {{ $mualaf->nama_lengkap }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; text-align: center; padding: 40px; border: 10px double #1b4332; }
        h1 { font-size: 24px; margin-bottom: 5px; color: #1b4332; }
        h3 { font-size: 16px; font-weight: normal; margin-top: 0; }
        .content { margin-top: 30px; font-size: 15px; line-height: 1.8; text-align: left; padding: 0 40px; }
        .nama { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin: 15px 0; }
        .footer { margin-top: 60px; float: right; width: 250px; text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <h1>KEMENTERIAN AGAMA KERAJAAN ARAB SAUDI</h1>
    <h3>{{ strtoupper($mualaf->tenant->name ?? 'KEMENAG DAERAH') }}</h3>
    <hr>
    <h2 style="margin-top: 20px;">SURAT KETERANGAN PENGISLAMAN</h2>
    <p>Nomor Registrasi: <b>{{ $mualaf->nomor_registrasi }}</b></p>

    <div class="content">
        <p>Dengan ini menerangkan bahwa:</p>
        <div class="nama">{{ strtoupper($mualaf->nama_lengkap) }}</div>
        @if($mualaf->nama_hijrah)
            <p style="text-align: center;"><i>( Nama Hijrah: {{ $mualaf->nama_hijrah }} )</i></p>
        @endif
        <table style="width: 100%; margin-top: 15px;">
            <tr><td width="30%">NIK / No. Paspor</td><td>: {{ $mualaf->nik_paspor }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>: {{ $mualaf->tempat_lahir }}, {{ \Carbon\Carbon::parse($mualaf->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $mualaf->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
            <tr><td>Agama Asal</td><td>: {{ $mualaf->agama_asal }}</td></tr>
            <tr><td>Alamat Domisili</td><td>: {{ $mualaf->alamat_domisili }}</td></tr>
        </table>
        <p style="margin-top: 20px;">
            Telah secara sadar dan tanpa paksaan dari pihak manapun mengucapkan **Dua Kalimat Syahadat** pada tanggal <b>{{ \Carbon\Carbon::parse($mualaf->tanggal_syahadat)->translatedFormat('d F Y') }}</b> dengan dibimbing oleh <b>{{ $mualaf->nama_pembimbing ?? '-' }}</b>.
        </p>
    </div>

    <div class="footer">
        <p>Kepala Kemenag Daerah</p>
        <br><br><br><br>
        <p><b>( _________________________ )</b></p>
    </div>
</body>
</html>
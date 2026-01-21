@extends('surat.layout')

@section('content')
    <h3 style="text-align: center; text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN USAHA</h3>
    <p style="text-align: center; margin-top: 0;">Nomor: {{ $pengajuan->nomor_surat ?? '.../SKU/...' }}</p>

    <p>Yang bertanda tangan di bawah ini Kepala {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}, Kecamatan Sejahtera, Kabupaten Makmur, menerangkan dengan sebenarnya bahwa:</p>

    <table style="margin-left: 20px; width: auto;">
        <tr>
            <td style="width: 150px;">Nama Lengkap</td>
            <td>:</td>
            <td><strong>{{ $penduduk->nama }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $penduduk->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $penduduk->alamat }} RT {{ $penduduk->rt }} RW {{ $penduduk->rw }}, Desa {{ $penduduk->desa_kelurahan }}, Kec. {{ $penduduk->kecamatan }}</td>
        </tr>
    </table>

    <p>Orang tersebut di atas adalah benar-benar warga {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} dan berdasarkan pengamatan kami yang bersangkutan benar-benar memiliki usaha:</p>

    <table style="margin-left: 20px; width: auto;">
        <tr>
            <td style="width: 150px;">Nama Usaha</td>
            <td>:</td>
            <td><strong>{{ $pengajuan->data_pemohon['nama_usaha'] ?? '....................' }}</strong></td>
        </tr>
        <tr>
            <td>Jenis Usaha</td>
            <td>:</td>
            <td>{{ $pengajuan->data_pemohon['jenis_usaha'] ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Alamat Usaha</td>
            <td>:</td>
            <td>{{ $pengajuan->data_pemohon['alamat_usaha'] ?? '....................' }}</td>
        </tr>
    </table>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection

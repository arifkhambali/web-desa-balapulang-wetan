<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Desa</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            margin: 2cm;
        }
        .header {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            float: left;
            width: 70px;
            height: auto;
        }
        .header h2, .header h3, .header p {
            margin: 0;
        }
        .header h2 {
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            font-size: 11pt;
            font-style: italic;
        }
        .content {
            margin-top: 20px;
            text-align: justify;
        }
        .ttd {
            float: right;
            width: 250px;
            margin-top: 50px;
            text-align: center;
        }
        .clear {
            clear: both;
        }
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Desa</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            margin: 2cm;
        }
        .header {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            float: left;
            width: 70px;
            height: auto;
        }
        .header h2, .header h3, .header p {
            margin: 0;
        }
        .header h2 {
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            font-size: 11pt;
            font-style: italic;
        }
        .content {
            margin-top: 20px;
            text-align: justify;
        }
        .ttd {
            float: right;
            width: 250px;
            margin-top: 50px;
            text-align: center;
        }
        .clear {
            clear: both;
        }
        table {
            width: 100%;
        }
        table td {
            vertical-align: top;
        }
    </style>
    <div class="signature">
        <p>Ditetapkan di: {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</p>
        <p>Pada tanggal: {{ date('d F Y') }}</p>
        <br>
        <p>Kepala {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</p>
        <br><br><br>
        <p><strong>BAPAK KEPALA DESA</strong></p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        body { background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        table { border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; }
        table td { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; vertical-align: top; }
        .container { display: block; margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px; }
        .content { box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px; }
        .main { background: #ffffff; border-radius: 8px; width: 100%; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .wrapper { box-sizing: border-box; padding: 20px; }
        .footer { clear: both; margin-top: 10px; text-align: center; width: 100%; }
        .footer td, .footer p, .footer span, .footer a { color: #9ca3af; font-size: 12px; text-align: center; }
        h1, h2, h3, h4 { color: #111827; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 700; line-height: 1.4; margin: 0; margin-bottom: 20px; }
        h1 { font-size: 20px; text-transform: capitalize; }
        p, ul, ol { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; color: #374151; }
        .btn { box-sizing: border-box; width: 100%; }
        .btn > tbody > tr > td { padding-bottom: 15px; }
        .btn table { width: auto; }
        .btn table td { background-color: #ffffff; border-radius: 5px; text-align: center; }
        .btn a { background-color: #ffffff; border: solid 1px #2563eb; border-radius: 5px; box-sizing: border-box; color: #2563eb; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; }
        .btn-primary table td { background-color: #2563eb; }
        .btn-primary a { background-color: #2563eb; border-color: #2563eb; color: #ffffff; }
        .logo-container { text-align: center; margin-bottom: 20px; }
        .logo-img { max-height: 80px; width: auto; margin-bottom: 10px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-info { background-color: #dbeafe; color: #1e40af; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-default { background-color: #f3f4f6; color: #374151; }
        .info-table td { padding: 5px 0; border-bottom: 1px solid #f3f4f6; }
        .info-table td:first-child { font-weight: bold; width: 140px; color: #4b5563; }
        .note-box { background-color: #f9fafb; border-left: 4px solid #9ca3af; padding: 15px; margin-bottom: 15px; font-style: italic; color: #4b5563; }
    </style>
</head>
<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    
                    <!-- Header with Logo -->
                    <div class="logo-container">
                        @php
                            $logoPath = $identitasDesa && $identitasDesa->logo ? storage_path('app/public/' . $identitasDesa->logo) : null;
                        @endphp
                        
                        @if($logoPath && file_exists($logoPath))
                            <img src="{{ $message->embed($logoPath) }}" alt="Logo Desa" class="logo-img">
                        @endif
                        <h2 style="margin:0; color: #1e3a8a;">{{ $identitasDesa->nama_desa ?? 'Pemerintah Desa' }}</h2>
                        <p style="margin:0; font-size: 12px; color: #6b7280;">{{ $identitasDesa->alamat ?? '' }}</p>
                    </div>

                    <!-- Main Content -->
                    <table role="presentation" class="main">
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <p>Halo, <strong>{{ $nama_pemohon }}</strong>!</p>
                                            <p>{{ $intro_line }}</p>

                                            <div style="margin: 20px 0;">
                                                <table class="info-table" width="100%">
                                                    <tr>
                                                        <td>Jenis Surat</td>
                                                        <td>{{ $jenis_surat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Surat</td>
                                                        <td>{{ $nomor_surat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Terbaru</td>
                                                        <td>
                                                            <span class="badge {{ $badge_class }}">
                                                                {{ $status_label }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            @if($catatan)
                                            <p><strong>Catatan dari Petugas:</strong></p>
                                            <div class="note-box">
                                                "{{ $catatan }}"
                                            </div>
                                            @endif

                                            @if($action_url)
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td> <a href="{{ $action_url }}" target="_blank">{{ $action_text }}</a> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endif

                                            <p>Terima kasih telah menggunakan layanan digital kami.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Footer -->
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <span class="apple-link">{{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} &copy; {{ date('Y') }}</span>
                                    <br> Sistem Informasi Desa Digital
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
</html>

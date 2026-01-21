<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terlalu Banyak Permintaan - WebDesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center">
        <div class="p-8 md:p-12">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Terlalu Banyak Percobaan</h1>
            <p class="text-gray-500 mb-8 text-lg">
                Maaf, kami mendeteksi terlalu banyak permintaan dari perangkat Anda dalam waktu singkat.
            </p>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-8">
                <p class="text-blue-800 text-sm font-medium">
                    Silakan tunggu sekitar <span class="font-bold">1 menit</span> sebelum mencoba kembali.
                </p>
            </div>

            <a href="/" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto">
                Kembali ke Beranda
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
            <p class="text-xs text-gray-400">Error Code: 429 | Too Many Requests</p>
        </div>
    </div>
</body>
</html>

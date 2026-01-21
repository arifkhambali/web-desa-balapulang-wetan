<?php

namespace App\Filament\Admin\Pages;

use App\Models\Penduduk;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BuatSuratWargaPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static?string $navigationIcon = 'heroicon-o-document-plus';

    protected static string $view = 'filament.admin.pages.buat-surat-warga-page';

    protected static ?string $navigationLabel = 'Buat Surat Warga';

    protected static ?string $title = 'Buat Surat untuk Warga';

    protected static ?string $navigationGroup = 'Administrasi & Layanan';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];
    public ?Penduduk $selectedPenduduk = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cari Data Warga')
                    ->description('Pilih warga yang akan dibuatkan surat')
                    ->schema([
                        Forms\Components\Select::make('penduduk_id')
                            ->label('Pilih Penduduk')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array =>
                                Penduduk::where('nama_lengkap', 'like', "%{$search}%")
                                    ->orWhere('nik', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($penduduk) => [
                                        $penduduk->id => "{$penduduk->nama_lengkap} ({$penduduk->nik})"
                                    ])
                                    ->toArray()
                            )
                            ->getOptionLabelUsing(function ($value): string {
                                $penduduk = Penduduk::find($value);
                                if (!$penduduk) return '';
                                return "{$penduduk->nama_lengkap} ({$penduduk->nik})";
                            })
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $penduduk = Penduduk::find($state);
                                    $this->selectedPenduduk = $penduduk;
                                    
                                    if ($penduduk) {
                                        $set('nik', $penduduk->nik);
                                        $set('nama_lengkap', $penduduk->nama_lengkap);
                                        $set('tempat_lahir', $penduduk->tempat_lahir);
                                        $set('tanggal_lahir', $penduduk->tanggal_lahir?->format('d-m-Y'));
                                        $set('jenis_kelamin', $penduduk->jenis_kelamin);
                                        $set('agama', $penduduk->agama);
                                        $set('pekerjaan', $penduduk->pekerjaan);
                                        $set('alamat', $penduduk->alamat);
                                        $set('rt', $penduduk->rt);
                                        $set('rw', $penduduk->rw);
                                        $set('desa_kelurahan', $penduduk->desa_kelurahan);
                                        $set('kecamatan', $penduduk->kecamatan);
                                        $set('kabupaten_kota', $penduduk->kabupaten_kota);
                                        $set('provinsi', $penduduk->provinsi);
                                    }
                                }
                            })
                            ->placeholder('Ketik nama atau NIK untuk mencari...'),
                    ])->columns(1),

                Forms\Components\Section::make('Data Warga')
                    ->description('Data akan terisi otomatis setelah memilih penduduk')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('agama')
                            ->label('Agama')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->label('Pekerjaan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('rt')
                            ->label('RT')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('rw')
                            ->label('RW')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('desa_kelurahan')
                            ->label('Desa/Kelurahan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('kabupaten_kota')
                            ->label('Kabupaten/Kota')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('provinsi')
                            ->label('Provinsi')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(3),

                Forms\Components\Section::make('Detail Surat')
                    ->schema([
                        Forms\Components\Select::make('jenis_surat_id')
                            ->label('Jenis Surat')
                            ->options(JenisSurat::where('aktif', true)->pluck('nama_surat', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        Forms\Components\Group::make()
                            ->schema(function (Forms\Get $get) {
                                $jenisSuratId = $get('jenis_surat_id');
                                if (!$jenisSuratId) return [];

                                $jenisSurat = JenisSurat::find($jenisSuratId);
                                if (!$jenisSurat || empty($jenisSurat->form_schema)) return [];

                                $fields = [];
                                foreach ($jenisSurat->form_schema as $field) {
                                    $component = match ($field['type']) {
                                        'text' => Forms\Components\TextInput::make('dynamic_' . $field['name']),
                                        'number' => Forms\Components\TextInput::make('dynamic_' . $field['name'])->numeric(),
                                        'date' => Forms\Components\DatePicker::make('dynamic_' . $field['name']),
                                        'textarea' => Forms\Components\Textarea::make('dynamic_' . $field['name']),
                                        'select' => Forms\Components\Select::make('dynamic_' . $field['name'])
                                            ->options(array_combine(
                                                explode(',', $field['options'] ?? ''),
                                                explode(',', $field['options'] ?? '')
                                            )),
                                        default => Forms\Components\TextInput::make('dynamic_' . $field['name']),
                                    };

                                    $component->label($field['label'])
                                        ->required($field['required'] ?? false);
                                    
                                    $fields[] = $component;
                                }
                                return $fields;
                            })
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('keperluan')
                            ->label('Keperluan Surat')
                            ->required()
                            ->rows(3)
                            ->placeholder('Contoh: Untuk melamar pekerjaan, mendaftar sekolah, dll.')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('lampiran')
                            ->label('Upload Lampiran (Opsional)')
                            ->multiple()
                            ->maxFiles(4)
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'])
                            ->directory('lampiran-surat')
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        if (!isset($data['penduduk_id'])) {
            Notification::make()
                ->title('Error')
                ->body('Anda harus memilih penduduk terlebih dahulu')
                ->danger()
                ->send();
            return;
        }

        $penduduk = Penduduk::find($data['penduduk_id']);

        if (!$penduduk) {
            Notification::make()
                ->title('Error')
                ->body('Data penduduk tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        try {
            // Generate nomor surat
            $bulanRomawi = array("", "I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
            $jenisSurat = JenisSurat::find($data['jenis_surat_id']);
            $kodeSurat = $jenisSurat->kode ?? 'SKD';
            
            // Logic Anti-Duplikat: Cek apakah nomor sudah dipakai, jika ya, increment terus sampai unique
            $year = date('Y');
            $noUrut = PengajuanSurat::whereYear('created_at', $year)->count() + 1;
            
            do {
                $nomorSurat = sprintf("%03d/%s/%s/%s", $noUrut, $kodeSurat, $bulanRomawi[date('n')], $year);
                $exists = PengajuanSurat::where('nomor_surat', $nomorSurat)->exists();
                if ($exists) {
                    $noUrut++;
                }
            } while ($exists);

            // Buat data pemohon
            $dataPemohon = [
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama_lengkap,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir?->format('d-m-Y'),
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'agama' => $penduduk->agama,
                'pekerjaan' => $penduduk->pekerjaan,
                'alamat' => $penduduk->alamat,
                'rt' => $penduduk->rt,
                'rw' => $penduduk->rw,
                'desa_kelurahan' => $penduduk->desa_kelurahan,
                'kecamatan' => $penduduk->kecamatan,
                'kabupaten_kota' => $penduduk->kabupaten_kota,
                'provinsi' => $penduduk->provinsi,
                'provinsi' => $penduduk->provinsi,
                'keperluan' => $data['keperluan'],
            ];

            // Tambahkan dynamic fields ke data pemohon
            if ($jenisSurat && !empty($jenisSurat->form_schema)) {
                foreach ($jenisSurat->form_schema as $field) {
                    $key = 'dynamic_' . $field['name'];
                    if (isset($data[$key])) {
                        $dataPemohon[$field['name']] = $data[$key];
                    }
                }
            }

            // Assign to Penduduk's User if exists, otherwise fallback to Admin
            $userId = $penduduk->user ? $penduduk->user->id : auth()->id();

            // Create pengajuan
            $pengajuan = PengajuanSurat::create([
                'user_id' => $userId,
                'sumber_pengajuan' => 'admin',
                'jenis_surat_id' => $data['jenis_surat_id'],
                'nomor_surat' => $nomorSurat,
                'data_pemohon' => $dataPemohon,
                'lampiran' => $data['lampiran'] ?? null,
                'status' => 'selesai',
                'tanggal_pengajuan' => now(),
                'tanggal_selesai' => now(),
                'catatan_admin' => "Dibuat oleh admin untuk warga {$penduduk->nama_lengkap}",
            ]);

            // Generate PDF - gunakan template dari database jika ada
            if (!empty($jenisSurat->template_html)) {
                // Template dari database
                $html = \Illuminate\Support\Facades\Blade::render($jenisSurat->template_html, [
                    'pengajuan' => $pengajuan,
                    'penduduk' => $penduduk
                ]);
                $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            } else {
                // Fallback ke blade file
                $viewName = 'surat.' . $kodeSurat;
                if (!view()->exists($viewName)) {
                    $viewName = 'surat.SKD';
                }
                $pdf = Pdf::loadView($viewName, [
                    'pengajuan' => $pengajuan,
                    'penduduk' => $penduduk
                ])->setPaper('a4', 'portrait');
            }

            $filename = 'surat-' . $pengajuan->id . '-' . time() . '.pdf';
            Storage::disk('public')->put('surat/' . $filename, $pdf->output());

            // Update pengajuan with file
            $pengajuan->update([
                'file_surat' => 'surat/' . $filename,
            ]);

            // Reset form
            $this->form->fill();
            $this->selectedPenduduk = null;

            // Redirect to pengajuan surat list with success message
            session()->flash('success', 'Surat berhasil dibuat! File: ' . $filename);
            
            $this->redirect(route('filament.admin.resources.pengajuan-surats.index'));

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Membuat Surat')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }
}

<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengajuanSuratResource\Pages;
use App\Filament\Admin\Resources\PengajuanSuratResource\RelationManagers;
use App\Models\PengajuanSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Administrasi & Layanan';

    protected static ?string $navigationLabel = 'Pengajuan Surat';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pemohon')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pemohon')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(),

                        Forms\Components\Select::make('jenis_surat_id')
                            ->label('Jenis Surat')
                            ->relationship('jenisSurat', 'nama_surat')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pemohon')
                    ->schema([
                        Forms\Components\Placeholder::make('identitas_diri')
                            ->label('Identitas Diri')
                            ->content(function ($record) {
                                if (!$record || !$record->data_pemohon) {
                                    return '-';
                                }

                                $data = $record->data_pemohon;
                                $html = '<div class="grid grid-cols-2 gap-3">';

                                $identitas = ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pekerjaan'];
                                foreach ($identitas as $key) {
                                    if (isset($data[$key])) {
                                        $label = ucwords(str_replace('_', ' ', $key));
                                        $html .= "<div><span class='text-gray-500 text-sm'>{$label}:</span><br><strong>{$data[$key]}</strong></div>";
                                    }
                                }

                                $html .= '</div>';
                                return new \Illuminate\Support\HtmlString($html);
                            }),

                        Forms\Components\Placeholder::make('alamat_lengkap')
                            ->label('Alamat Lengkap')
                            ->content(function ($record) {
                                if (!$record || !$record->data_pemohon) {
                                    return '-';
                                }

                                $data = $record->data_pemohon;
                                $html = '<div class="space-y-2">';

                                if (isset($data['alamat'])) {
                                    $html .= "<div><span class='text-gray-500 text-sm'>Alamat:</span><br><strong>{$data['alamat']}</strong></div>";
                                }

                                $html .= '<div class="grid grid-cols-3 gap-3 mt-2">';
                                $alamat = ['rt', 'rw', 'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi'];
                                foreach ($alamat as $key) {
                                    if (isset($data[$key])) {
                                        $label = strtoupper($key) === 'RT' || strtoupper($key) === 'RW' ? strtoupper($key) : ucwords(str_replace('_', ' ', $key));
                                        $html .= "<div><span class='text-gray-500 text-sm'>{$label}:</span><br><strong>{$data[$key]}</strong></div>";
                                    }
                                }
                                $html .= '</div></div>';

                                return new \Illuminate\Support\HtmlString($html);
                            }),

                        Forms\Components\Textarea::make('data_pemohon.keperluan')
                            ->label('Keperluan Surat')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Lampiran & File')
                    ->schema([
                        Forms\Components\Placeholder::make('lampiran_display')
                            ->label('Lampiran Dokumen')
                            ->content(function ($record) {
                                if (!$record || !$record->lampiran) {
                                    return 'Tidak ada lampiran';
                                }

                                $files = is_array($record->lampiran) ? $record->lampiran : [$record->lampiran];
                                $html = '<div class="space-y-2">';

                                $index = 1;
                                foreach ($files as $file) {
                                    $url = asset('storage/' . $file);
                                    $extension = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
                                    $displayName = "Lampiran {$index} ({$extension})";
                                    $html .= "<div><a href='{$url}' target='_blank' class='text-primary-600 hover:underline flex items-center gap-2'>";
                                    $html .= "<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'></path></svg>";
                                    $html .= "{$displayName}</a></div>";
                                    $index++;
                                }

                                $html .= '</div>';
                                return new \Illuminate\Support\HtmlString($html);
                            }),


                        Forms\Components\Placeholder::make('file_surat_display')
                            ->label('File Surat (Generated)')
                            ->content(function ($record) {
                                if (!$record || !$record->file_surat) {
                                    return 'Belum ada file surat';
                                }

                                $filename = basename($record->file_surat);
                                $url = asset('storage/' . $record->file_surat);

                                $html = "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline flex items-center gap-2'>";
                                $html .= "<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'></path></svg>";
                                $html .= "{$filename}</a>";

                                return new \Illuminate\Support\HtmlString($html);
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Catatan')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->disabled(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'diproses' => 'Diproses',
                                'menunggu_persetujuan' => 'Menunggu Persetujuan',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\DateTimePicker::make('tanggal_pengajuan')
                            ->label('Tanggal Pengajuan')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Warga Pengaju')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('sumber_pengajuan')
                    ->label('Sumber')
                    ->colors([
                        'primary' => 'warga',
                        'success' => 'admin',
                    ])
                    ->icons([
                        'heroicon-o-user' => 'warga',
                        'heroicon-o-user-group' => 'admin',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'diproses',
                        'primary' => 'menunggu_persetujuan',
                        'success' => 'selesai',
                        'danger' => 'ditolak',
                    ]),
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true, true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true, true),
            ])
            ->defaultSort('tanggal_pengajuan', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('proses')
                    ->label('Teruskan ke Kades')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Teruskan ke Kepala Desa')
                    ->modalDescription('Apakah data sudah benar? Surat akan diteruskan ke Kepala Desa untuk disetujui.')
                    ->action(function (PengajuanSurat $record) {
                        $record->update(['status' => 'menunggu_persetujuan']);

                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil Diteruskan')
                            ->body('Surat menunggu persetujuan Kepala Desa. Notifikasi email telah dikirim ke warga.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(PengajuanSurat $record) => in_array($record->status, ['pending', 'diproses']) && auth()->user()->role === 'admin'),

                Tables\Actions\Action::make('approve_kades')
                    ->label('Setujui & Tanda Tangan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Pengajuan Surat')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui dan menerbitkan surat ini?')
                    ->action(function (PengajuanSurat $record) {
                        try {
                            // 1. Ambil data penduduk
                            $nik = $record->data_pemohon['nik'] ?? null;
                            $penduduk = null;

                            if ($nik) {
                                $penduduk = \App\Models\Penduduk::where('nik', $nik)->first();
                            }

                            // Fallback: Buat object dummy dari data_pemohon
                            if (!$penduduk) {
                                $penduduk = new \App\Models\Penduduk([
                                    'nama_lengkap' => $record->data_pemohon['nama'] ?? 'Nama Tidak Diketahui',
                                    'nik' => $nik ?? '-',
                                    'alamat' => $record->data_pemohon['alamat'] ?? '-',
                                    'tempat_lahir' => '-',
                                    'tanggal_lahir' => now(),
                                    'jenis_kelamin' => '-',
                                    'pekerjaan' => '-',
                                    'agama' => '-',
                                    'rt' => '-',
                                    'rw' => '-',
                                    'desa_kelurahan' => 'Maju Jaya',
                                    'kecamatan' => 'Sejahtera'
                                ]);
                            }

                            // 2. Tentukan View/Template
                            $jenisSurat = \App\Models\JenisSurat::find($record->jenis_surat_id);
                            $kodeSurat = $jenisSurat->kode ?? 'SKD';

                            // 4. Render PDF
                            // Jika ada template_html di database, gunakan itu. Jika tidak, gunakan blade.
                            if (!empty($jenisSurat->template_html)) {
                                // Generate dari template HTML database
                                $html = \Illuminate\Support\Facades\Blade::render($jenisSurat->template_html, [
                                    'pengajuan' => $record,
                                    'penduduk' => $penduduk
                                ]);
                                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
                            } else {
                                // Fallback ke blade file existing
                                $viewName = 'surat.' . $kodeSurat;
                                if (!view()->exists($viewName)) {
                                    $viewName = 'surat.SKD';
                                }
                                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, [
                                    'pengajuan' => $record,
                                    'penduduk' => $penduduk
                                ])->setPaper('a4', 'portrait');
                            }

                            // 3. Generate Nomor Surat
                            if (empty($record->nomor_surat)) {
                                $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
                                $noUrut = PengajuanSurat::whereYear('created_at', date('Y'))->count() + 1;
                                $record->nomor_surat = sprintf("%03d/%s/%s/%s", $noUrut, $kodeSurat, $bulanRomawi[date('n')], date('Y'));
                            }

                            // 5. Simpan File (Private Storage)
                            $filename = 'surat-' . $record->id . '-' . time() . '.pdf';
                            \Illuminate\Support\Facades\Storage::disk('local')->put('surat/' . $filename, $pdf->output());

                            // 6. Update Record
                            $record->update([
                                'status' => 'selesai',
                                'file_surat' => 'surat/' . $filename,
                                'nomor_surat' => $record->nomor_surat,
                                'tanggal_selesai' => now(),
                                'catatan_admin' => 'Surat telah disetujui dan diterbitkan oleh Kepala Desa.'
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Surat Berhasil Diterbitkan')
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal Memproses Surat')
                                ->body('Error: ' . $e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    })
                    ->visible(fn(PengajuanSurat $record) => $record->status === 'menunggu_persetujuan' && auth()->user()->role === 'kades'),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak Pengajuan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengajuan Surat')
                    ->modalDescription('Silakan berikan alasan penolakan.')
                    ->form([
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (PengajuanSurat $record, array $data) {
                        $record->update([
                            'status' => 'ditolak',
                            'catatan_admin' => $data['catatan_admin'],
                            'tanggal_selesai' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Pengajuan Ditolak')
                            ->body('Status pengajuan telah diubah menjadi ditolak.')
                            ->danger()
                            ->send();
                    })
                    ->visible(
                        fn(PengajuanSurat $record) =>
                        (in_array($record->status, ['pending', 'diproses']) && auth()->user()->role === 'admin') ||
                        ($record->status === 'menunggu_persetujuan' && auth()->user()->role === 'kades')
                    ),

                Tables\Actions\Action::make('preview_admin')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn(PengajuanSurat $record) => route('surat.preview', $record->id))
                    ->openUrlInNewTab()
                    ->visible(fn(PengajuanSurat $record) => $record->status === 'selesai'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuanSurats::route('/'),
            // 'create' => Pages\CreatePengajuanSurat::route('/create'), // Disabled - gunakan "Buat Surat Warga"
            'edit' => Pages\EditPengajuanSurat::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Warga\Resources;

use App\Filament\Warga\Resources\PengajuanSuratResource\Pages;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Pengajuan Surat';

    protected static ?string $pluralModelLabel = 'Riwayat Pengajuan';

    // Filter agar warga hanya melihat surat miliknya sendiri
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Pengajuan Surat')
                    ->description('Silakan lengkapi data pengajuan surat Anda')
                    ->schema([
                        Forms\Components\Select::make('jenis_surat_id')
                            ->label('Jenis Surat')
                            ->options(JenisSurat::where('aktif', true)->pluck('nama_surat', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $jenisSurat = JenisSurat::find($state);
                                if ($jenisSurat) {
                                    $set('persyaratan_text', $jenisSurat->persyaratan);
                                }
                            }),

                        Forms\Components\Placeholder::make('persyaratan_info')
                            ->label('Persyaratan Dokumen')
                            ->content(function (Forms\Get $get) {
                                $jenisSuratId = $get('jenis_surat_id');
                                if (!$jenisSuratId) return 'Pilih jenis surat untuk melihat persyaratan.';
                                
                                $jenisSurat = JenisSurat::find($jenisSuratId);
                                $persyaratan = $jenisSurat->persyaratan;
                                
                                // Pastikan array
                                if (is_string($persyaratan)) {
                                    $persyaratan = json_decode($persyaratan, true);
                                }

                                if (!is_array($persyaratan)) return '-';

                                $list = '<ul>';
                                foreach ($persyaratan as $syarat) {
                                    $list .= "<li>• $syarat</li>";
                                }
                                $list .= '</ul>';
                                
                                return new \Illuminate\Support\HtmlString($list);
                            }),

                        Forms\Components\Group::make()
                            ->schema(function (Forms\Get $get) {
                                $jenisSuratId = $get('jenis_surat_id');
                                if (!$jenisSuratId) return [];

                                $jenisSurat = JenisSurat::find($jenisSuratId);
                                if (!$jenisSurat || empty($jenisSurat->form_schema)) return [];

                                $fields = [];
                                foreach ($jenisSurat->form_schema as $field) {
                                    $fieldName = 'data_pemohon.' . $field['name'];
                                    
                                    $component = match ($field['type']) {
                                        'text' => Forms\Components\TextInput::make($fieldName),
                                        'number' => Forms\Components\TextInput::make($fieldName)->numeric(),
                                        'date' => Forms\Components\DatePicker::make($fieldName),
                                        'textarea' => Forms\Components\Textarea::make($fieldName),
                                        'select' => Forms\Components\Select::make($fieldName)
                                            ->options(array_combine(
                                                explode(',', $field['options'] ?? ''),
                                                explode(',', $field['options'] ?? '')
                                            )),
                                        default => Forms\Components\TextInput::make($fieldName),
                                    };

                                    $component->label($field['label'])
                                        ->required($field['required'] ?? false);
                                    
                                    $fields[] = $component;
                                }
                                return $fields;
                            })
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('catatan_penolakan')
                            ->label('')
                            ->content(function ($record) {
                                if (!$record || $record->status !== 'ditolak' || !$record->catatan_admin) {
                                    return null;
                                }
                                
                                $html = '<div class="p-4 bg-red-50 border-l-4 border-red-500 rounded">';
                                $html .= '<div class="flex items-start">';
                                $html .= '<svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                                $html .= '<div>';
                                $html .= '<h3 class="text-red-800 font-bold text-lg mb-2">Pengajuan Ditolak - Harap Perbaiki</h3>';
                                $html .= '<p class="text-red-700"><strong>Alasan Penolakan:</strong></p>';
                                $html .= '<p class="text-red-900 mt-1">' . nl2br(e($record->catatan_admin)) . '</p>';
                                $html .= '<p class="text-red-600 text-sm mt-3 italic">Silakan perbaiki sesuai catatan di atas, lalu klik "Simpan" untuk mengajukan ulang.</p>';
                                $html .= '</div></div></div>';
                                
                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->visibleOn('edit'),

                        Forms\Components\Textarea::make('data_pemohon.keperluan')
                            ->label('Keperluan Surat')
                            ->placeholder('Contoh: Untuk melamar pekerjaan, mendaftar sekolah, dll.')
                            ->required()
                            ->rows(3),

                        Forms\Components\CheckboxList::make('lampiran_hapus')
                            ->label('Lampiran Saat Ini (Centang untuk menghapus)')
                            ->options(function ($record) {
                                if (!$record || !$record->lampiran) {
                                    return [];
                                }
                                
                                // Pastikan array di-reindex
                                $files = is_array($record->lampiran) ? array_values($record->lampiran) : [$record->lampiran];
                                $options = [];
                                
                                $index = 1;
                                foreach ($files as $file) {
                                    if (empty($file)) continue; // Skip empty values
                                    $extension = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
                                    $displayName = "Lampiran {$index} ({$extension})";
                                    $options[$file] = $displayName;
                                    $index++;
                                }
                                
                                return $options;
                            })
                            ->descriptions(function ($record) {
                                if (!$record || !$record->lampiran) {
                                    return [];
                                }
                                
                                // Pastikan array di-reindex
                                $files = is_array($record->lampiran) ? array_values($record->lampiran) : [$record->lampiran];
                                $descriptions = [];
                                
                                foreach ($files as $file) {
                                    if (empty($file)) continue; // Skip empty values
                                    $url = asset('storage/' . $file);
                                    $descriptions[$file] = new \Illuminate\Support\HtmlString(
                                        "<a href='{$url}' target='_blank' class='text-primary-600 hover:underline text-sm'>Lihat File</a>"
                                    );
                                }
                                
                                return $descriptions;
                            })
                            ->helperText('Centang file yang ingin dihapus, lalu klik Simpan.')
                            ->visibleOn('edit'),

                        Forms\Components\FileUpload::make('lampiran')
                            ->label('Upload Dokumen Persyaratan')
                            ->helperText('Upload KTP, KK, atau dokumen pendukung lainnya (PDF/JPG/PNG). Maksimal 4 file.')
                            ->multiple()
                            ->maxFiles(4)
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'])
                            ->directory('lampiran-surat')
                            ->preserveFilenames()
                            ->maxSize(5120) // 5MB per file
                            ->required()
                            ->visibleOn('create'),

                        Forms\Components\FileUpload::make('lampiran_baru')
                            ->label('Upload Dokumen Persyaratan Baru (Opsional)')
                            ->helperText('Biarkan kosong jika tidak ingin mengubah lampiran. Upload file baru jika ingin mengganti lampiran (PDF/JPG/PNG). Maksimal 4 file.')
                            ->multiple()
                            ->maxFiles(4)
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'])
                            ->directory('lampiran-surat')
                            ->preserveFilenames()
                            ->maxSize(5120) // 5MB per file
                            ->visibleOn('edit'),

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
                                    $extension = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
                                    $displayName = "Lampiran {$index} ({$extension})";
                                    $url = route('surat.download-lampiran', ['id' => $record->id, 'filename' => basename($file)]);
                                    $html .= "<div><a href='{$url}' target='_blank' class='text-primary-600 hover:underline flex items-center gap-2'>";
                                    $html .= "<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'></path></svg>";
                                    $html .= "{$displayName}</a></div>";
                                    $index++;
                                }
                                
                                $html .= '</div>';
                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->visibleOn('view'),

                        Forms\Components\Section::make('Hasil Surat')
                            ->schema([
                                Forms\Components\Placeholder::make('status_surat')
                                    ->label('Status Pengajuan')
                                    ->content(function (PengajuanSurat $record) {
                                        $colors = [
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            'diproses' => 'bg-blue-100 text-blue-800',
                                        ];
                                        $color = $colors[$record->status] ?? 'bg-yellow-100 text-yellow-800';
                                        return new \Illuminate\Support\HtmlString(
                                            '<span class="px-2 py-1 rounded text-sm font-bold ' . $color . '">' . ucfirst($record->status) . '</span>'
                                        );
                                    })
                                    ->visible(fn ($record) => $record !== null),

                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('download_hasil')
                                        ->label('Download Surat Selesai')
                                        ->icon('heroicon-o-document-arrow-down')
                                        ->color('success')
                                        ->url(fn (PengajuanSurat $record) => route('surat.download', $record))
                                        ->openUrlInNewTab()
                                        ->visible(fn (PengajuanSurat $record) => $record->status === 'selesai' && $record->file_surat)
                                ])->fullWidth(),
                                
                                Forms\Components\Placeholder::make('catatan')
                                    ->label('Catatan Admin')
                                    ->content(fn (PengajuanSurat $record) => $record->catatan_admin ?? '-')
                                    ->visible(fn (PengajuanSurat $record) => $record->catatan_admin),
                            ])
                            ->visible(fn ($record) => $record !== null && $record->status !== 'pending'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->placeholder('Belum Terbit')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'diproses',
                        'success' => 'selesai',
                        'danger' => 'ditolak',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Perbaiki & Ajukan Ulang')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->visible(fn (PengajuanSurat $record) => $record->status === 'ditolak'),
                
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('preview')
                    ->label('Preview Surat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (PengajuanSurat $record) => route('surat.preview', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (PengajuanSurat $record) => $record->status === 'selesai' && $record->file_surat)
                    ->tooltip('Lihat Preview Surat'),
            ])
            ->bulkActions([
                // Tidak ada bulk action untuk warga
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
            'create' => Pages\CreatePengajuanSurat::route('/create'),
            'edit' => Pages\EditPengajuanSurat::route('/{record}/edit'),
            'view' => Pages\ViewPengajuanSurat::route('/{record}'),
        ];
    }
}

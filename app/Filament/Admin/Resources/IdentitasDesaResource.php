<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\IdentitasDesaResource\Pages;
use App\Models\IdentitasDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IdentitasDesaResource extends Resource
{
    protected static ?string $model = IdentitasDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Identitas Desa';

    protected static ?string $navigationGroup = 'Pemerintahan & Pengaturan';
    
    protected static ?int $navigationSort = 1; // Tampil paling atas di grup Profil Desa

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('nama_desa')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->directory('identitas-desa')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeMode('contain')
                            ->maxSize(1024)
                            ->helperText('Logo desa (max 1MB). Otomatis di-resize.')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Jam Pelayanan')
                    ->schema([
                        Forms\Components\RichEditor::make('jam_pelayanan')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('facebook')
                            ->prefix('https://facebook.com/')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('instagram')
                            ->prefix('https://instagram.com/')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('youtube')
                            ->prefix('https://youtube.com/')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('twitter')
                            ->prefix('https://twitter.com/')
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Hero Images')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image_beranda')
                            ->label('Hero Image Beranda')
                            ->image()
                            ->directory('identitas-desa')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Gambar banner beranda (max 2MB). Otomatis di-resize ke lebar 1920px.')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('hero_image_umkm')
                            ->label('Hero Image UMKM')
                            ->image()
                            ->directory('identitas-desa')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Gambar banner UMKM (max 2MB). Otomatis di-resize ke lebar 1920px.')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('hero_image_pemerintahan')
                            ->label('Hero Image Pemerintahan')
                            ->image()
                            ->directory('identitas-desa')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Gambar banner Pemerintahan (max 2MB). Otomatis di-resize ke lebar 1920px.')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Informasi Geografis')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->label('Latitude')
                                    ->helperText('Contoh: -6.200000 (gunakan Google Maps untuk mendapatkan koordinat)'),
                                    
                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->label('Longitude')
                                    ->helperText('Contoh: 106.816666'),
                            ]),
                            
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('batas_utara')
                                    ->label('Batas Wilayah Utara')
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('batas_timur')
                                    ->label('Batas Wilayah Timur')
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('batas_selatan')
                                    ->label('Batas Wilayah Selatan')
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('batas_barat')
                                    ->label('Batas Wilayah Barat')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make('Pengaturan WhatsApp Notifikasi')
                    ->description('Konfigurasi API WhatsApp dan template pesan otomatis.')
                    ->schema([
                        Forms\Components\TextInput::make('wa_api_url')
                            ->label('WhatsApp API URL')
                            ->url()
                            ->placeholder('https://api.whatsapp.com/send')
                            ->helperText('URL endpoint API WhatsApp (misal: Fonnte, Ruangguru, dll)'),
                        Forms\Components\TextInput::make('wa_api_key')
                            ->label('WhatsApp API Key')
                            ->password()
                            ->helperText('API/Token key untuk autentikasi'),
                        Forms\Components\TextInput::make('wa_sender_number')
                            ->label('Nomor Pengirim')
                            ->placeholder('628123456789')
                            ->helperText('Nomor WhatsApp yang digunakan untuk mengirim pesan'),
                        Forms\Components\Textarea::make('wa_template_pengajuan')
                            ->label('Template Pengajuan Baru')
                            ->rows(5)
                            ->helperText('Gunakan variabel: {nama}, {jenis_surat}, {tanggal}, {status}, {url}'),
                        Forms\Components\Textarea::make('wa_template_update_status')
                            ->label('Template Update Status')
                            ->rows(5)
                            ->helperText('Gunakan variabel: {nama}, {jenis_surat}, {status_baru}, {catatan}, {url}'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_desa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListIdentitasDesas::route('/'),
            'create' => Pages\CreateIdentitasDesa::route('/create'),
            'edit' => Pages\EditIdentitasDesa::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        // Only allow creation if no record exists
        return IdentitasDesa::count() === 0;
    }
}

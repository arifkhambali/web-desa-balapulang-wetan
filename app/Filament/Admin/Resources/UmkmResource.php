<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UmkmResource\Pages;
use App\Filament\Admin\Resources\UmkmResource\RelationManagers;
use App\Models\Umkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationGroup = 'Potensi Desa';
    
    protected static ?string $navigationLabel = 'Produk UMKM';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama_produk')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique('umkms', 'slug', fn ($record) => $record)
                            ->helperText('URL-friendly version dari nama produk (otomatis terisi)'),

                        Forms\Components\Select::make('kategori_umkm_id')
                            ->label('Kategori')
                            ->relationship('kategoriUmkm', 'nama_kategori', fn ($query) => $query->where('aktif', true))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama_kategori')
                                    ->label('Nama Kategori')
                                    ->required(),
                                Forms\Components\Toggle::make('aktif')
                                    ->label('Aktif')
                                    ->default(true),
                            ])
                            ->helperText('Pilih kategori atau buat baru'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Harga & Stok')
                    ->schema([
                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),

                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'tersedia' => 'Tersedia',
                                'habis' => 'Habis',
                                'tidak_aktif' => 'Tidak Aktif',
                            ])
                            ->default('tersedia'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Gambar Produk')
                    ->schema([
                        Forms\Components\Placeholder::make('gambar_preview')
                            ->label('Gambar Saat Ini')
                            ->content(function ($record) {
                                if (!$record || !$record->gambar) {
                                    return 'Belum ada gambar';
                                }
                                
                                $url = asset('storage/' . $record->gambar);
                                $html = "<div class='space-y-2'>";
                                $html .= "<img src='{$url}' alt='Gambar Produk' class='max-w-sm rounded-lg shadow-md' />";
                                $html .= "<div><a href='{$url}' target='_blank' class='text-primary-600 hover:underline text-sm'>Lihat Gambar Penuh</a></div>";
                                $html .= "</div>";
                                
                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->visibleOn('edit'),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar')
                            ->image()
                            ->directory('umkm')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('800')
                            ->maxSize(2048)
                            ->helperText('Upload gambar produk (max 2MB). Gambar akan otomatis di-crop menjadi kotak 800x800px.')
                            ->columnSpanFull()
                            ->visibleOn('create'),

                        Forms\Components\FileUpload::make('gambar_baru')
                            ->label('Upload Gambar Baru (Opsional)')
                            ->image()
                            ->directory('umkm')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('800')
                            ->maxSize(2048)
                            ->helperText('Upload gambar baru untuk mengganti gambar lama (max 2MB). Gambar akan otomatis di-crop menjadi kotak 800x800px.')
                            ->columnSpanFull()
                            ->visibleOn('edit'),
                    ]),

                Forms\Components\Section::make('Informasi Penjual')
                    ->schema([
                        Forms\Components\TextInput::make('nama_penjual')
                            ->label('Nama Penjual')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kontak')
                            ->label('Kontak')
                            ->required()
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('08xxxxxxxxxx'),
                    ])
                    ->columns(2),

                Forms\Components\Toggle::make('aktif')
                    ->label('Produk Aktif')
                    ->default(true)
                    ->helperText('Nonaktifkan untuk menyembunyikan produk dari halaman depan'),
                
                Forms\Components\Toggle::make('featured')
                    ->label('Produk Unggulan')
                    ->default(false)
                    ->helperText('Maksimal 5 produk unggulan akan ditampilkan di halaman utama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->square(),
                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategoriUmkm.nama_kategori')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(function ($state) {
                        if ($state === 'tersedia') return 'success';
                        if ($state === 'habis') return 'danger';
                        return 'secondary';
                    }),
                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\IconColumn::make('featured')
                    ->label('Unggulan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'habis' => 'Habis',
                        'tidak_aktif' => 'Tidak Aktif',
                    ]),
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Produk Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}

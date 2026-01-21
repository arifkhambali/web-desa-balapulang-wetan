<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KategoriUmkmResource\Pages;
use App\Models\KategoriUmkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KategoriUmkmResource extends Resource
{
    protected static ?string $model = KategoriUmkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Kategori UMKM';
    
    protected static ?string $modelLabel = 'Kategori UMKM';
    
    protected static ?string $pluralModelLabel = 'Kategori UMKM';
    
    protected static ?string $navigationGroup = 'Potensi Desa';
    
    protected static ?int $navigationSort = 2;
    
    // Sembunyikan dari navigation sidebar (tetap bisa diakses via URL)
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique()
                            ->helperText('URL-friendly version dari nama kategori'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Kategori yang tidak aktif tidak akan muncul di pilihan'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('umkms_count')
                    ->label('Jumlah UMKM')
                    ->counts('umkms')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKategoriUmkms::route('/'),
            'create' => Pages\CreateKategoriUmkm::route('/create'),
            'edit' => Pages\EditKategoriUmkm::route('/{record}/edit'),
        ];
    }
}

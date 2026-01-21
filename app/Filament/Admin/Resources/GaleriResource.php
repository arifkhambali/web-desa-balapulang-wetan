<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GaleriResource\Pages;
use App\Filament\Admin\Resources\GaleriResource\RelationManagers;
use App\Models\Galeri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GaleriResource extends Resource
{
    protected static ?string $model = Galeri::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationGroup = 'Potensi Desa';
    
    protected static ?string $navigationLabel = 'Galeri';
    
    protected static ?int $navigationSort = 2; // Setelah Berita dan Kategori Berita

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Galeri')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'Kegiatan' => 'Kegiatan',
                                'Infrastruktur' => 'Infrastruktur',
                                'Budaya' => 'Budaya',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_kegiatan')
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Gambar Galeri')
                    ->schema([
                        Forms\Components\Placeholder::make('gambar_preview')
                            ->label('Gambar Saat Ini')
                            ->content(function ($record) {
                                if (!$record || !$record->gambar) {
                                    return 'Belum ada gambar';
                                }

                                $url = asset('storage/' . $record->gambar);
                                $html = "<div class='space-y-2'>";
                                $html .= "<img src='{$url}' alt='Gambar Galeri' class='max-w-sm rounded-lg shadow-md border' />";
                                $html .= "<div><a href='{$url}' target='_blank' class='text-primary-600 hover:underline text-sm'>Lihat Gambar Penuh</a></div>";
                                $html .= "</div>";

                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->visibleOn('edit'),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Upload Gambar')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->imageResizeTargetWidth('1280')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Max 2MB. Otomatis di-resize ke lebar 1280px.')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Keterangan Lainnya')
                    ->schema([
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->disk('public')
                    ->visibility('public')
                    ->square(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->colors([
                        'primary' => 'Kegiatan',
                        'success' => 'Infrastruktur',
                        'warning' => 'Budaya',
                        'gray' => 'Lainnya',
                    ]),
                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true, true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Kegiatan' => 'Kegiatan',
                        'Infrastruktur' => 'Infrastruktur',
                        'Budaya' => 'Budaya',
                        'Lainnya' => 'Lainnya',
                    ]),
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
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
        ];
    }
}

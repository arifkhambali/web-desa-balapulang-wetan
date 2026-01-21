<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProfilDesaResource\Pages;
use App\Models\ProfilDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilDesaResource extends Resource
{
    protected static ?string $model = ProfilDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationGroup = 'Pemerintahan & Pengaturan';

    protected static ?string $navigationLabel = 'Profil Desa';

    protected static ?string $pluralModelLabel = 'Profil Desa';
    
    protected static ?int $navigationSort = 2; // Tampil setelah Identitas Desa

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Profil')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Bagian')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('icon')
                            ->label('Icon')
                            ->options([
                                'fa-solid fa-clock-rotate-left' => 'Sejarah (Clock)',
                                'fa-solid fa-bullseye' => 'Visi (Target)',
                                'fa-solid fa-map-location-dot' => 'Geografis (Map)',
                                'fa-solid fa-users' => 'Demografi (Users)',
                                'fa-solid fa-wheat-awn' => 'Potensi (Wheat)',
                                'fa-solid fa-trophy' => 'Prestasi (Trophy)',
                                'fa-solid fa-building-columns' => 'Pemerintahan (Building)',
                                'fa-solid fa-file-lines' => 'Dokumen (File)',
                            ])
                            ->searchable()
                            ->helperText('Pilih icon yang sesuai untuk bagian ini'),

                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan di halaman depan'),

                        Forms\Components\RichEditor::make('konten')
                            ->label('Isi Konten')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('aktif')
                            ->label('Tampilkan di Website')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true, true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListProfilDesas::route('/'),
            'create' => Pages\CreateProfilDesa::route('/create'),
            'edit' => Pages\EditProfilDesa::route('/{record}/edit'),
        ];
    }
}

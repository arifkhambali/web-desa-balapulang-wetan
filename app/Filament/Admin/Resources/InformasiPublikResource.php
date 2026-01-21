<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InformasiPublikResource\Pages;
use App\Models\InformasiPublik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InformasiPublikResource extends Resource
{
    protected static ?string $model = InformasiPublik::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Publikasi';

    protected static ?string $navigationLabel = 'Informasi Publik';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Informasi Publik')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\DatePicker::make('tgl_terbit')
                            ->required()
                            ->default(now()),

                        Forms\Components\TextInput::make('unit_pengelola')
                            ->required()
                            ->maxLength(255)
                            ->default('Superadmin'),

                        Forms\Components\FileUpload::make('file_path')
                            ->label('File (PDF / Gambar)')
                            ->required()
                            ->directory('informasi-publik')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(10240) // 10MB
                            ->helperText('Upload file PDF atau Gambar (Max 10MB)'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_terbit')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_pengelola')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListInformasiPubliks::route('/'),
            'create' => Pages\CreateInformasiPublik::route('/create'),
            'edit' => Pages\EditInformasiPublik::route('/{record}/edit'),
        ];
    }
}

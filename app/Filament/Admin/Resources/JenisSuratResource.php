<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JenisSuratResource\Pages;
use App\Filament\Admin\Resources\JenisSuratResource\RelationManagers;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Administrasi & Layanan';
    
    protected static ?string $navigationLabel = 'Jenis Surat';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_surat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icon')
                    ->placeholder('fa-file-lines')
                    ->helperText('FontAwesome class name (e.g., fa-file-lines)'),
                Forms\Components\Select::make('color')
                    ->options([
                        'blue' => 'Blue',
                        'green' => 'Green',
                        'orange' => 'Orange',
                        'purple' => 'Purple',
                        'indigo' => 'Indigo',
                        'red' => 'Red',
                        'slate' => 'Slate',
                        'yellow' => 'Yellow',
                        'teal' => 'Teal',
                        'cyan' => 'Cyan',
                    ]),
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('persyaratan'),
                Forms\Components\Textarea::make('template_html')
                    ->label('Template HTML Surat')
                    ->helperText('Template HTML untuk PDF. Gunakan {{ $pengajuan->data_pemohon[\'nama\'] }} untuk field dinamis. Kosongkan untuk pakai default blade.')
                    ->rows(15)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('aktif')
                    ->required(),

                Forms\Components\Section::make('Dynamic Form Fields')
                    ->description('Konfigurasi field tambahan khusus untuk jenis surat ini')
                    ->schema([
                        Forms\Components\Repeater::make('form_schema')
                            ->label('Form Fields')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Field Name (Key)')
                                    ->required()
                                    ->helperText('Gunakan huruf kecil dan underscore, contoh: nama_usaha, alamat_usaha'),
                                Forms\Components\TextInput::make('label')
                                    ->label('Label (Tampilan)')
                                    ->required()
                                    ->helperText('Label yang muncul di form'),
                                Forms\Components\Select::make('type')
                                    ->label('Tipe Input')
                                    ->options([
                                        'text' => 'Text',
                                        'number' => 'Number',
                                        'date' => 'Date',
                                        'textarea' => 'Text Area',
                                        'select' => 'Select Option',
                                    ])
                                    ->required(),
                                Forms\Components\Toggle::make('required')
                                    ->label('Wajib Diisi')
                                    ->default(true),
                                Forms\Components\Textarea::make('options')
                                    ->label('Opsi (Khusus tipe Select)')
                                    ->helperText('Pisahkan dengan koma, contoh: Islam,Kristen,Hindu,Budha')
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'select'),
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListJenisSurats::route('/'),
            'create' => Pages\CreateJenisSurat::route('/create'),
            'edit' => Pages\EditJenisSurat::route('/{record}/edit'),
        ];
    }
}

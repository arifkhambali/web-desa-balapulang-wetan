<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AparaturDesaResource\Pages;
use App\Models\AparaturDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AparaturDesaResource extends Resource
{
    protected static ?string $model = AparaturDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Aparatur Desa';
    
    protected static ?string $modelLabel = 'Aparatur Desa';
    
    protected static ?string $pluralModelLabel = 'Aparatur Desa';
    
    protected static ?string $navigationGroup = 'Pemerintahan & Pengaturan';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('jabatan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kepala Desa, Sekretaris Desa, Kaur Keuangan'),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan di website (semakin kecil semakin atas)'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->disk('public')
                            ->directory('aparatur-desa')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '3:4',
                            ])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('3:4')
                            ->imageResizeTargetWidth('600')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Upload foto formal aparatur desa (max 2MB). Otomatis di-resize ke lebar 600px.'),
                    ]),
                
                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('alamat')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biodata / Singkatan Profil')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Akan digunakan sebagai sambutan jika data Sambutan di Profil Desa kosong.'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Masa Jabatan')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_mulai_jabatan')
                            ->label('Mulai Jabatan'),
                        
                        Forms\Components\DatePicker::make('tanggal_selesai_jabatan')
                            ->label('Selesai Jabatan'),
                        
                        Forms\Components\Toggle::make('aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk menyembunyikan dari website'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(function () {
                        return 'https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF';
                    }),
                
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(function ($state) {
                        if (stripos($state, 'kepala') !== false) return 'success';
                        if (stripos($state, 'sekretaris') !== false) return 'info';
                        return 'gray';
                    }),
                
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->toggleable(true),
                
                Tables\Columns\TextColumn::make('urutan')
                    ->sortable()
                    ->toggleable(true),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(true),
                
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable()
                    ->toggleable(true),
                
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->defaultSort('urutan', 'asc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('aktif')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListAparaturDesas::route('/'),
            'create' => Pages\CreateAparaturDesa::route('/create'),
            'edit' => Pages\EditAparaturDesa::route('/{record}/edit'),
        ];
    }
}

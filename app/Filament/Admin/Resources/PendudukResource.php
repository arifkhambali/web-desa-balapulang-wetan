<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PendudukResource\Pages;
use App\Filament\Admin\Resources\PendudukResource\RelationManagers;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administrasi & Layanan';
    
    protected static ?string $navigationLabel = 'Data Penduduk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('no_kk')
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('agama')
                    ->required(),
                Forms\Components\TextInput::make('pendidikan_terakhir')
                    ->required(),
                Forms\Components\TextInput::make('pekerjaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('golongan_darah')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        'O' => 'O',
                        '-' => '-',
                    ]),
                Forms\Components\Select::make('kewarganegaraan')
                    ->options([
                        'WNI' => 'WNI',
                        'WNA' => 'WNA',
                    ])
                    ->default('WNI')
                    ->required(),
                Forms\Components\TextInput::make('status_perkawinan')
                    ->required(),
                Forms\Components\TextInput::make('status_keluarga')
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rt')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('rw')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('desa_kelurahan')
                    ->required()
                    ->maxLength(255)
                    ->default('Maju Jaya'),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(255)
                    ->default('Sejahtera'),
                Forms\Components\TextInput::make('kabupaten_kota')
                    ->required()
                    ->maxLength(255)
                    ->default('Makmur'),
                Forms\Components\TextInput::make('provinsi')
                    ->required()
                    ->maxLength(255)
                    ->default('Jawa Tengah'),
                Forms\Components\TextInput::make('status_hidup')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('agama'),
                Tables\Columns\TextColumn::make('pendidikan_terakhir'),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('golongan_darah'),
                Tables\Columns\TextColumn::make('kewarganegaraan'),
                Tables\Columns\TextColumn::make('status_perkawinan'),
                Tables\Columns\TextColumn::make('status_keluarga'),
                Tables\Columns\TextColumn::make('rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa_kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten_kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_hidup'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }
}

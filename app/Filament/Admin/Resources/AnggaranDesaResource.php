<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnggaranDesaResource\Pages;
use App\Filament\Admin\Resources\AnggaranDesaResource\RelationManagers;
use App\Models\AnggaranDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggaranDesaResource extends Resource
{
    protected static ?string $model = AnggaranDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Anggaran Desa';
    protected static ?string $modelLabel = 'Anggaran';
    protected static ?string $navigationGroup = 'Pemerintahan & Pengaturan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Anggaran')
                    ->schema([
                        Forms\Components\Select::make('tahun')
                            ->options(array_combine(range(2000, 2050), range(2000, 2050)))
                            ->default(date('Y'))
                            ->required()
                            ->searchable() // Agar mudah cari tahun
                            ->native(false),
                        Forms\Components\Select::make('jenis')
                            ->options([
                                'pendapatan' => 'Pendapatan',
                                'belanja' => 'Belanja',
                                'pembiayaan' => 'Pembiayaan',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('kategori')
                            ->label('Uraian / Kategori')
                            ->required()
                            ->placeholder('Contoh: Dana Desa, Belanja Pegawai, dll')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nominal')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->maxValue(999999999999) // Trillion limit
                            ->live(onBlur: true)
                            ->mask(fn ($state) => \Filament\Support\RawJs::make('$money($input, \'.\', \',\', 0)'))
                            ->stripCharacters(['.', ','])
                            ->helperText(fn ($get) => $get('nominal') 
                                ? '💰 ' . ucwords(\App\Helpers\NumberHelper::terbilang($get('nominal'))) . ' Rupiah'
                                : 'Masukkan nominal anggaran'),
                        Forms\Components\Textarea::make('rincian')
                            ->label('Rincian / Keterangan')
                            ->placeholder('Contoh: Untuk Pembangunan Jalan RW 01 (Opsional)')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendapatan' => 'success',
                        'belanja' => 'danger',
                        'pembiayaan' => 'info',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rincian')
                    ->label('Rincian')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tahun', 'desc')
            ->groups([
                Tables\Grouping\Group::make('tahun')
                    ->label('Tahun Anggaran')
                    ->collapsible(),
                Tables\Grouping\Group::make('jenis')
                    ->label('Jenis Anggaran')
                    ->collapsible(),
            ])
            ->defaultGroup('tahun')
            ->filters([
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(array_combine(range(date('Y') - 5, date('Y') + 5), range(date('Y') - 5, date('Y') + 5))),
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja',
                        'pembiayaan' => 'Pembiayaan',
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
            'index' => Pages\ListAnggaranDesas::route('/'),
            'create' => Pages\CreateAnggaranDesa::route('/create'),
            'edit' => Pages\EditAnggaranDesa::route('/{record}/edit'),
        ];
    }
}

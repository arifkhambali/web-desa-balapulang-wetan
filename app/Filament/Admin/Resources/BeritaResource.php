<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BeritaResource\Pages;
use App\Filament\Admin\Resources\BeritaResource\RelationManagers;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use FilamentTiptapEditor\TiptapEditor;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Publikasi';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?int $navigationSort = 1; // Tampil paling atas

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique('beritas', 'slug', fn($record) => $record)
                            ->helperText('URL-friendly version dari judul (otomatis terisi)'),

                        Forms\Components\Select::make('kategori_berita_id')
                            ->label('Kategori')
                            ->relationship('kategoriBerita', 'nama_kategori', fn($query) => $query->where('aktif', true))
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

                        TiptapEditor::make('konten')
                            ->label('Konten')
                            ->required()
                            ->profile('default')
                            ->tools([
                                'heading',
                                'bullet-list',
                                'ordered-list',
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'align-left',
                                'align-center',
                                'align-right',
                                'align-justify',
                                'blockquote',
                                'code-block',
                                'hr',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Gambar Berita')
                    ->schema([
                        Forms\Components\Placeholder::make('gambar_preview')
                            ->label('Gambar Saat Ini')
                            ->content(function ($record) {
                                if (!$record || !$record->gambar) {
                                    return 'Belum ada gambar';
                                }

                                $url = asset('storage/' . $record->gambar);
                                $html = "<div class='space-y-2'>";
                                $html .= "<img src='{$url}' alt='Gambar Berita' class='max-w-sm rounded-lg shadow-md' />";
                                $html .= "<div><a href='{$url}' target='_blank' class='text-primary-600 hover:underline text-sm'>Lihat Gambar Penuh</a></div>";
                                $html .= "</div>";

                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->visibleOn('edit'),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar')
                            ->image()
                            ->directory('berita')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->imageResizeTargetWidth('1280')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Upload gambar berita (max 2MB). Otomatis di-resize ke lebar 1280px.')
                            ->columnSpanFull()
                            ->visibleOn('create'),

                        Forms\Components\FileUpload::make('gambar_baru')
                            ->label('Upload Gambar Baru (Opsional)')
                            ->image()
                            ->directory('berita')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->imageResizeTargetWidth('1280')
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->helperText('Biarkan kosong jika tidak ingin mengubah gambar (max 2MB). Otomatis di-resize ke lebar 1280px.')
                            ->columnSpanFull()
                            ->visibleOn('edit'),
                    ]),

                Forms\Components\Section::make('Publikasi')
                    ->schema([
                        Forms\Components\TextInput::make('penulis')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255)
                            ->default('Admin'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->helperText('Kosongkan untuk publish sekarang'),

                        Forms\Components\TextInput::make('views')
                            ->label('Views')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori'),
                Tables\Columns\ImageColumn::make('gambar')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('penulis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true, true),
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}

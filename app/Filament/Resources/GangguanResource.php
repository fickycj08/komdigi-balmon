<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GangguanResource\Pages;
use App\Models\Gangguan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

class GangguanResource extends Resource
{
    protected static ?string $model = Gangguan::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';
    protected static ?string $navigationGroup = 'Monitoring';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Laporan Gangguan';
    protected static ?string $pluralModelLabel = 'Daftar Gangguan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Data Terganggu')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Section::make('Identifikasi Gangguan')
                                ->description('Informasi dasar tentang gangguan yang terjadi')
                                ->collapsible()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Select::make('location_id')
                                                ->relationship('location', 'kota')
                                                ->required()
                                                ->label('Lokasi Kejadian')
                                                ->searchable()
                                                ->preload()
                                                ->columnSpan(1)
                                                ->hint('Pilih Kota/Kabupaten'),

                                            TextInput::make('kecamatan')
                                                ->label('Kecamatan')
                                                ->required()
                                        ]),

                                    Grid::make(3)
                                        ->schema([
                                            DatePicker::make('waktu_kejadian')
                                                ->label('Waktu Kejadian')
                                                ->required()
                                                ->native(false)
                                                ->displayFormat('d M Y')
                                                ->closeOnDateSelection()
                                                ->columnSpan(2),

                                            Select::make('severity')
                                                ->options([
                                                    'low' => 'Rendah',
                                                    'medium' => 'Sedang',
                                                    'high' => 'Tinggi',
                                                ])
                                                ->label('Level Gangguan')
                                                ->required()
                                                ->native(false)
                                                ->selectablePlaceholder(false)
                                                ->columnSpan(1),
                                        ]),
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('no_st')
                                                ->label('No. ST')
                                                ->required(),

                                            TextInput::make('vic')
                                                ->label('PIC')
                                                ->required(),

                                            TextInput::make('no_laporan')
                                                ->label('Nodin. Laporan')
                                                ->required(),
                                        ]),
                                ]),

                            Section::make('Klasifikasi')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('nama_client')
                                        ->label('Nama Client')
                                        ->required()
                                        ->maxLength(100)
                                        ->columnSpanFull(),
                                    TextInput::make('jenis_gangguan')
                                        ->label('Jenis Gangguan')
                                        ->required()
                                        ->maxLength(50)
                                        ->hint('Masukkan jenis gangguan'),

                                    TextInput::make('sifat_gangguan')
                                        ->label('Sifat Gangguan')
                                        ->required()
                                        ->maxLength(30)
                                        ->datalist([
                                            'Temporary',
                                            'Permanent',
                                            'Intermittent',
                                        ]),
                                ]),

                            Section::make('Parameter Teknis')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('frekuensi')
                                        ->label('Frekuensi (MHz)')
                                        ->numeric()
                                        ->step(0.0001)
                                        ->suffix('MHz')
                                        ->minValue(0)
                                        ->required(),

                                    Select::make('band_frekuensi')
                                        ->label('Band Frekuensi')
                                        ->required()
                                        ->options([
                                            'HF' => 'HF',
                                            'VHF' => 'VHF',
                                            'UHF' => 'UHF',
                                            'SHF' => 'SHF',
                                        ])
                                        ->placeholder('Pilih Band Frekuensi'),

                                    Select::make('service')
                                        ->label('Service')
                                        ->required()
                                        ->options([
                                            'Aeronautical' => 'Aeronautical',
                                            'Broadcast' => 'Broadcast',
                                            'Fixed Service' => 'Fixed Service',
                                            'Land Mobile (private)' => 'Land Mobile (private)',
                                            'Land Mobile (public)' => 'Land Mobile (public)',
                                            'Maritime' => 'Maritime',
                                            'Satellite' => 'Satellite',
                                            'Other Services' => 'Other Services',
                                        ])
                                        ->reactive()
                                        ->afterStateUpdated(fn(callable $set) => $set('sub_service', null)),

                                    Select::make('sub_service')
                                        ->label('Sub-Service')
                                        ->required()
                                        ->options(function (callable $get) {
                                            $service = $get('service');
                                            return match ($service) {
                                                'Aeronautical' => [
                                                    'Ground-To-Air' => 'Ground-To-Air',
                                                ],
                                                'Broadcast' => [
                                                    'AM' => 'AM',
                                                    'DAB' => 'DAB',
                                                    'DVB-T' => 'DVB-T',
                                                    'FM' => 'FM',
                                                ],
                                                'Fixed Service' => [
                                                    'PMP' => 'PMP',
                                                    'PP' => 'PP',
                                                    'PP Private' => 'PP Private',
                                                ],
                                                'Land Mobile (private)' => [
                                                    'Standard' => 'Standard',
                                                    'Trunking' => 'Trunking',
                                                ],
                                                'Land Mobile (public)' => [
                                                    'LM Registered Stations' => 'LM Registered Stations',
                                                    'Trunking' => 'Trunking',
                                                    'Wireless Data' => 'Wireless Data',
                                                ],
                                                'Maritime' => [
                                                    'Coast Station' => 'Coast Station',
                                                ],
                                                'Satellite' => [
                                                    'Earth Fixed' => 'Earth Fixed',
                                                    'Earth Mobile' => 'Earth Mobile',
                                                    'VSAT' => 'VSAT',
                                                ],
                                                'Other Services' => [
                                                    'Radio Location' => 'Radio Location',
                                                    'Meteorological' => 'Meteorological',
                                                ],

                                                default => [],
                                            };
                                        })
                                        ->disabled(fn(callable $get) => $get('service') === null),

                                ]),

                            Section::make('Koordinat')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('latitude')
                                        ->label('Latitude')
                                        ->numeric()
                                        ->step('any')
                                        ->suffix('°')
                                        ->required(),


                                    TextInput::make('longitude')
                                        ->label('longitude')
                                        ->numeric()
                                        ->step('any')
                                        ->suffix('°')
                                        ->required(),

                                ]),

                            Section::make('Upload PDF')
                                ->columns(1)
                                ->schema([
                                    FileUpload::make('file_path')
                                        ->label('Upload Dokumen')
                                        ->directory('gangguans')
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->maxSize(10240)
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Step::make('Identifikasi Pengganggu')
                        ->icon('heroicon-o-user-minus')
                        ->schema([
                            Repeater::make('pengganggu')
                                ->relationship('pengganggu')
                                ->label('Daftar Pengganggu')
                                ->addActionLabel('Tambah Pengganggu')
                                ->collapsible()
                                ->cloneable()
                                ->itemLabel(fn(array $state): string => $state['nama'] ?? 'Pelaku Baru')
                                ->schema([
                                    Section::make('Identifikasi Pengganggu')
                                        ->columns(3)
                                        ->schema([
                                            TextInput::make('nama')
                                                ->label('Pihak Penganggu')
                                                ->required()
                                                ->columnSpan(2),

                                            Select::make('jenis_organisasi')
                                                ->options([
                                                    'Perusahaan' => 'Perusahaan',
                                                    'Pemerintah' => 'Pemerintah',
                                                    'Individu' => 'Individu',
                                                ])
                                                ->required()
                                                ->native(false),
                                        ]),

                                    Section::make('Alamat')
                                        ->columns(2)
                                        ->schema([
                                            Select::make('location_id')
                                                ->relationship('location', 'kota')
                                                ->required()
                                                ->label('Lokasi Penganggu')
                                                ->searchable()
                                                ->preload()
                                                ->columnSpan(1)
                                                ->hint('Pilih Kota/Kabupaten')
                                                ->columnSpan(1),

                                            TextInput::make('kecamatan')
                                                ->label('Kecamatan')
                                                ->required()
                                                ->columnSpan(1),

                                            TextInput::make('jalan')
                                                ->label('Jalan')
                                                ->required()
                                                ->columnSpan(1),

                                            TextInput::make('alamat_lengkap')
                                                ->label('Alamat Lengkap')
                                                ->required()
                                                ->columnSpan(1),
                                        ]),

                                    Section::make('Parameter Teknis')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('frekuensi')
                                                ->label('Frekuensi (MHz)')
                                                ->numeric()
                                                ->step(0.0001)
                                                ->suffix('MHz')
                                                ->required(),

                                            TextInput::make('band_frekuensi')
                                                ->label('Band Frekuensi')
                                                ->required()
                                                ->maxLength(20),

                                            TextInput::make('service')
                                                ->label('Service')
                                                ->required()
                                                ->maxLength(50)
                                                ->columnSpan(1),

                                            TextInput::make('sub_service')
                                                ->label('Sub-Service')
                                                ->required()
                                                ->maxLength(50)
                                                ->columnSpan(1),

                                            Select::make('status_pelanggaran')
                                                ->options([
                                                    'Belum Dikonfirmasi' => 'Belum Dikonfirmasi',
                                                    'Terkonfirmasi' => 'Terkonfirmasi',
                                                    'Ditindaklanjuti' => 'Ditindaklanjuti',
                                                ])
                                                ->native(false)
                                                ->required()
                                                ->columnSpanFull(),
                                        ]),

                                    Section::make('Koordinat')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('latitude')
                                                ->label('Latitude')
                                                ->numeric()
                                                ->step('any')
                                                ->suffix('°')
                                                ->required(),


                                            TextInput::make('longitude')
                                                ->label('longitude')
                                                ->numeric()
                                                ->step('any')
                                                ->suffix('°')
                                                ->required(),

                                        ]),
                                ])
                                ->columns(1)
                                ->columnSpanFull(),
                        ]),

                    Step::make('Narasi Gangguan')
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            Textarea::make('uraian_gangguan')
                                ->label('Deskripsi Lengkap Gangguan')
                                ->required()
                                ->rows(10)
                                ->columnSpanFull()
                                ->placeholder('Deskripsikan secara detail:'
                                    . "\n- Kronologi kejadian"
                                    . "\n- Dampak yang ditimbulkan"
                                    . "\n- Langkah awal yang telah dilakukan")
                                ->extraInputAttributes(['style' => 'resize: vertical; min-height: 150px']),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_laporan')
                    ->label('No. Laporan')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->description(fn($record) => $record->no_st),

                BadgeColumn::make('severity')
                    ->label('Tingkat')
                    ->formatStateUsing(fn($state) => Str::upper($state))
                    ->colors([
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                    ])
                    ->sortable()
                    ->icon('heroicon-o-signal')
                    ->iconPosition('after'),

                TextColumn::make('location.kota')
                    ->label('Lokasi')
                    ->formatStateUsing(fn($state, $record) => "{$state} - {$record->kecamatan}")
                    ->searchable()
                    ->sortable(),

                TextColumn::make('frekuensi')
                    ->label('Frekuensi')
                    ->formatStateUsing(fn($state) => "{$state} MHz")
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('service')
                    ->label('Service/Sub-Service')
                    ->formatStateUsing(fn($state, $record) => "{$state} ({$record->sub_service})")
                    ->wrap()
                    ->limit(30),

                IconColumn::make('pengganggu.status_pelanggaran')
                    ->label('Status')
                    ->options([
                        'heroicon-o-check-circle' => 'Ditindaklanjuti',
                        'heroicon-o-x-circle' => 'Belum Dikonfirmasi',
                    ])
                    ->colors([
                        'success' => 'Ditindaklanjuti',
                        'danger' => 'Belum Dikonfirmasi',
                    ])
                    ->size(IconColumn\IconColumnSize::Medium),

                IconColumn::make('file_path')
                    ->label('Dokumen')
                    ->icon(fn($state) => $state ? 'heroicon-o-document' : 'heroicon-o-document-text')
                    ->color(fn($state) => $state ? 'success' : 'gray')
                    ->tooltip(fn($state) => $state ? 'Ada lampiran' : 'Tidak ada lampiran'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('severity')
                    ->label('Level Gangguan')
                    ->options([
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                    ])
                    ->indicator('Severity'),

                Tables\Filters\SelectFilter::make('sifat_gangguan')
                    ->options([
                        'Temporary' => 'Sementara',
                        'Permanent' => 'Permanen',
                    ])
                    ->label('Sifat Gangguan'),

                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Filter Tahun')
                    ->options(
                        fn() => Gangguan::query()
                            ->selectRaw('YEAR(waktu_kejadian) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                    )
                    ->query(function ($query, $data) {
                        if (!empty($data['value'])) {
                            $query->whereYear('waktu_kejadian', $data['value']);
                        }
                    })
                    ->indicator('Tahun'),

                Tables\Filters\SelectFilter::make('location_id')
                    ->label('Lokasi Kejadian')
                    ->relationship('location', 'kota')
                    ->searchable()
                    ->preload()
                    ->indicator('Lokasi'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon('heroicon-o-eye')
                        ->color('success'),
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ])
                    ->button()
                    ->tooltip('Aksi')
                    ->color('primary'),
            ])
            ->defaultSort('waktu_kejadian', 'desc')
            ->striped()
            ->deferLoading()
            ->paginated([10, 25, 50, 'all'])
            ->emptyStateHeading('Tidak ada gangguan tercatat 🎉')
            ->emptyStateDescription('Mulai dengan membuat laporan gangguan baru')
            ->emptyStateIcon('heroicon-o-beaker')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Laporan Baru')
                    ->icon('heroicon-o-plus-circle')
                    ->button(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGangguans::route('/'),
            'create' => Pages\CreateGangguan::route('/create'),
            'edit' => Pages\EditGangguan::route('/{record}/edit'),
        ];
    }
}
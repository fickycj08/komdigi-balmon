<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitoringResource\Pages;
use App\Filament\Resources\MonitoringResource\RelationManagers;
use App\Models\Monitoring;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Wizard;
use App\Models\Location;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonitoringResource extends Resource
{
    protected static ?string $model = Monitoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';
    protected static ?string $navigationLabel = 'Monitoring Stasiun';
    protected static ?string $navigationGroup = 'Operasional';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'stasiun_monitor';
    protected static ?string $modelLabel = 'Data Monitoring';
    protected static ?string $pluralModelLabel = 'Data Monitoring';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Informasi Umum')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make('Detail Lokasi')
                                ->description('Informasi tentang lokasi monitoring')
                                ->icon('heroicon-o-map-pin')
                                ->collapsible()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('upt_select')
                                                ->label('UPT')
                                                ->options([
                                                    'Balai Monitor SFR Kelas I Bandung' => 'Balai Monitor SFR Kelas I Bandung',
                                                    'manual' => 'Lainnya (Isi Manual)'
                                                ])
                                                ->required()
                                                ->live() // Ganti dari reactive() ke live()
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    if ($state !== 'manual') {
                                                        $set('upt', $state);
                                                    } else {
                                                        $set('upt', ''); // Ganti null jadi string kosong
                                                    }
                                                })
                                                ->afterStateHydrated(function ($set, $get) {
                                                    $upt = $get('upt');
                                                    if (in_array($upt, ['Balai Monitor SFR Kelas I Bandung'])) {
                                                        $set('upt_select', $upt);
                                                    } else {
                                                        $set('upt_select', 'manual');
                                                    }
                                                })
                                                ->dehydrated(false),

                                            Forms\Components\Hidden::make('upt') // Ganti TextInput jadi Hidden
                                                ->dehydrated(true)
                                                ->default(''),

                                            Forms\Components\TextInput::make('upt_manual') // Buat field baru untuk input manual
                                                ->label('UPT (Manual)')
                                                ->maxLength(100)
                                                ->placeholder('Isi manual jika tidak ada di daftar')
                                                ->required(fn($get) => $get('upt_select') === 'manual')
                                                ->visible(fn($get) => $get('upt_select') === 'manual') // Ganti hidden jadi visible
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    if ($get('upt_select') === 'manual') {
                                                        $set('upt', $state); // Set nilai manual ke field upt
                                                    }
                                                })
                                                ->helperText('Akan otomatis terisi jika memilih dari daftar.'),



                                            Forms\Components\Select::make('stasiun_monitor')
                                                ->label('Stasiun Monitor')
                                                ->required()
                                                ->options([
                                                    'Bergerak' => 'Bergerak',
                                                    'Tetep Cileunyi' => 'Tetep Cileunyi',
                                                    'Tetap Cigondewah' => 'Tetap Cigondewah',
                                                    'Tetap Lembang' => 'Tetap Lembang',
                                                    'Transportable Indramayu' => 'Transportable Indramayu',
                                                    'Transportable Karawang' => 'Transportable Karawang',
                                                    'Trasportable Cirebon' => 'Trasportable Cirebon',
                                                    'Transportable Tasikmalaya' => 'Transportable Tasikmalaya',
                                                ])
                                                ->searchable()
                                                ->preload(), // opsional, biar dropdown langsung tampil semua

                                        ]),

                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('tanggal')
                                                ->label('Tanggal Monitoring')
                                                ->required()
                                                ->default(now()),
                                            Forms\Components\TextInput::make('no_spt')
                                                ->label('Nomor SPT')
                                                ->maxLength(100),
                                        ]),
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('location_id')
                                                ->label('Kabupaten/Kota')
                                                ->options(
                                                    Location::query()->whereNotNull('kota')->pluck('kota', 'id')
                                                )
                                                ->searchable()
                                                ->required(),

                                            Forms\Components\TextInput::make('alamat')
                                                ->label('Alamat Lengkap')
                                                ->maxLength(100),
                                        ]),
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('lat')
                                                ->label('Latitude')
                                                ->numeric()
                                                ->required()
                                                ->placeholder('-6.2088')
                                                ->helperText('Format koordinat desimal'),
                                            Forms\Components\TextInput::make('lng')
                                                ->label('Longitude')
                                                ->numeric()
                                                ->required()
                                                ->placeholder('106.8456')
                                                ->helperText('Format koordinat desimal'),
                                        ]),
                                ]),
                        ]),
                    
                    Wizard\Step::make('Data ISR Monitoring')
                        ->icon('heroicon-o-signal')
                        ->schema([
                            Section::make('ISR Monitoring')
                                ->description('Data monitoring ISR')
                                ->icon('heroicon-o-chart-bar')
                                ->collapsible()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('isrmon_jumlah_isr')
                                                ->label('Jumlah ISR')
                                                ->numeric()
                                                ->default(0)
                                                ->reactive(),

                                            Forms\Components\TextInput::make('isrmon_target')
                                                ->label('Target ISR')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $target = $state ?? 0;
                                                    $termonitor = $get('isrmon_termonitor') ?? 0;
                                                    $isrCapaian = ($target == 0) ? 0 : min(round(($termonitor / $target) * 100, 2), 100);
                                                    $set('isrmon_capaian', $isrCapaian);
                                                    // Update capaian_pk_obs
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                            Forms\Components\TextInput::make('isrmon_termonitor')
                                                ->label('Termonitor')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $termonitor = $state ?? 0;
                                                    $target = $get('isrmon_target') ?? 0;
                                                    $isrCapaian = ($target == 0) ? 0 : min(round(($termonitor / $target) * 100, 2), 100);
                                                    $set('isrmon_capaian', $isrCapaian);
                                                    // Update capaian_pk_obs
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                            Forms\Components\TextInput::make('isrmon_capaian')
                                                ->label('Capaian (%)')
                                                ->disabled()
                                                ->dehydrated(true)
                                                ->numeric()
                                                ->default(0)
                                                ->reactive()
                                                ->dehydrateStateUsing(function ($state, $get) {
                                                    $target = $get('isrmon_target') ?? 0;
                                                    $termonitor = $get('isrmon_termonitor') ?? 0;
                                                    if ($target == 0)
                                                        return 0;
                                                    return min(round(($termonitor / $target) * 100, 2), 100); // Maks 100%
                                                })
                                                ->afterStateHydrated(function ($state, $set, $get) {
                                                    $target = $get('isrmon_target') ?? 0;
                                                    $termonitor = $get('isrmon_termonitor') ?? 0;
                                                    if ($target == 0)
                                                        $set('isrmon_capaian', 0);
                                                    else
                                                        $set('isrmon_capaian', min(round(($termonitor / $target) * 100, 2), 100));
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                        ]),
                                ]),
                        ]),

                    Wizard\Step::make('Data Target Pita')
                        ->icon('heroicon-o-chart-pie')
                        ->schema([
                            Section::make('Target Pita')
                                ->description('Data Target Pita')
                                ->icon('heroicon-o-presentation-chart-line')
                                ->collapsible()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('target_pita')
                                                ->label('Target Pita')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $target = $state ?? 0;
                                                    $occ = $get('occ_target_pita') ?? 0;
                                                    $occCapaian = ($target == 0) ? 0 : min(round(($occ / $target) * 100, 2), 100);
                                                    $set('occ_capaian', $occCapaian);
                                                    // Update capaian_pk_obs
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                            Forms\Components\TextInput::make('occ_target_pita')
                                                ->label('Occ Target Pita')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $occ = $state ?? 0;
                                                    $target = $get('target_pita') ?? 0;
                                                    $occCapaian = ($target == 0) ? 0 : min(round(($occ / $target) * 100, 2), 100);
                                                    $set('occ_capaian', $occCapaian);
                                                    // Update capaian_pk_obs
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                            Forms\Components\TextInput::make('occ_capaian')
                                                ->label('OCC Capaian (%)')
                                                ->disabled()
                                                ->dehydrated(true)
                                                ->numeric()
                                                ->default(0)
                                                ->reactive()
                                                ->dehydrateStateUsing(function ($state, $get) {
                                                    // Hitung ulang setiap submit/save
                                                    $target = $get('target_pita') ?? 0;
                                                    $occ = $get('occ_target_pita') ?? 0;
                                                    if ($target == 0) {
                                                        return 0;
                                                    }
                                                    return min(round(($occ / $target) * 100, 2), 100);
                                                })
                                                ->afterStateHydrated(function ($state, $set, $get) {
                                                    // Hitung ulang setelah di-load atau diubah
                                                    $target = $get('target_pita') ?? 0;
                                                    $occ = $get('occ_target_pita') ?? 0;
                                                    $value = ($target == 0) ? 0 : min(round(($occ / $target) * 100, 2), 100);
                                                    $set('occ_capaian', $value);

                                                    // Panggil juga updateCapaianPkObs untuk update PK rata-rata
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                        ]),
                                ]),
                        ]),

                    Wizard\Step::make('Data Identifikasi')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Section::make('Identifikasi')
                                ->description('Data identifikasi')
                                ->icon('heroicon-o-finger-print')
                                ->collapsible()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('iden_jumlah_termonitor')
                                                ->label('Jumlah Termonitor')
                                                ->numeric()
                                                ->default(0),

                                            Forms\Components\TextInput::make('iden_target')
                                                ->label('Target')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $target = $state ?? 0;
                                                    $teridentifikasi = $get('iden_teridentifikasi') ?? 0;
                                                    $idenCapaian = ($target == 0) ? 0 : min(round(($teridentifikasi / $target) * 100, 2), 100);
                                                    $set('iden_capaian', $idenCapaian);
                                                    // Update capaian_pk_obs juga
                                                    self::updateCapaianPkObs($set, $get);
                                                }),
                                        ]),
                                    Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('iden_teridentifikasi')
                                                ->label('Teridentifikasi')
                                                ->numeric()
                                                ->default(0)
                                                ->live(debounce: 500)
                                                ->afterStateUpdated(function ($state, $set, $get) {
                                                    $teridentifikasi = $state ?? 0;
                                                    $target = $get('iden_target') ?? 0;
                                                    $idenCapaian = ($target == 0) ? 0 : min(round(($teridentifikasi / $target) * 100, 2), 100);
                                                    $set('iden_capaian', $idenCapaian);
                                                    // Update capaian_pk_obs juga
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                            Forms\Components\TextInput::make('iden_capaian')
                                                ->label('Capaian (%)')
                                                ->disabled()
                                                ->dehydrated(true)
                                                ->numeric()
                                                ->default(0)
                                                ->reactive()
                                                ->dehydrateStateUsing(function ($state, $get) {
                                                    // Pastikan perhitungan konsisten pada saat submit
                                                    $target = $get('iden_target') ?? 0;
                                                    $teridentifikasi = $get('iden_teridentifikasi') ?? 0;
                                                    if ($target == 0) {
                                                        return 0;
                                                    }
                                                    return min(round(($teridentifikasi / $target) * 100, 2), 100);
                                                })
                                                ->afterStateHydrated(function ($state, $set, $get) {
                                                    // Saat form dibuka/diupdate, isi ulang nilainya
                                                    $target = $get('iden_target') ?? 0;
                                                    $teridentifikasi = $get('iden_teridentifikasi') ?? 0;
                                                    $value = ($target == 0) ? 0 : min(round(($teridentifikasi / $target) * 100, 2), 100);
                                                    $set('iden_capaian', $value);

                                                    // Selalu update capaian_pk_obs biar konsisten
                                                    self::updateCapaianPkObs($set, $get);
                                                }),

                                        ]),
                                ]),
                        ]),

                    Wizard\Step::make('Kesimpulan')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Section::make('Kesimpulan')
                                ->description('Kesimpulan monitoring')
                                ->icon('heroicon-o-clipboard-document-check')
                                ->collapsible()
                                ->schema([
                                    Grid::make(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('capaian_pk_obs')
                                                ->label('Capaian PK OBS (%)')
                                                ->disabled()
                                                ->dehydrated(true)
                                                ->numeric()
                                                ->default(0)
                                                ->reactive()
                                                ->dehydrateStateUsing(function ($state, $get) {
                                                    $isr = $get('isrmon_capaian') ?? 0;
                                                    $occ = $get('occ_capaian') ?? 0;
                                                    $iden = $get('iden_capaian') ?? 0;
                                                    $total = ($isr + $occ + $iden) / 3;
                                                    return min(round($total, 2), 100); // Maks 100%
                                                })
                                                ->afterStateHydrated(function ($state, $set, $get) {
                                                    $isr = $get('isrmon_capaian') ?? 0;
                                                    $occ = $get('occ_capaian') ?? 0;
                                                    $iden = $get('iden_capaian') ?? 0;
                                                    $total = ($isr + $occ + $iden) / 3;
                                                    $set('capaian_pk_obs', min(round($total, 2), 100));
                                                }),

                                            Forms\Components\Textarea::make('catatan')
                                                ->label('Catatan')
                                                ->maxLength(500)
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('upt')->searchable(),
                Tables\Columns\TextColumn::make('stasiun_monitor'),
                Tables\Columns\TextColumn::make('tanggal')->date(),
                Tables\Columns\TextColumn::make('location.kota')->label('Kabupaten/Kota')->searchable(),

                Tables\Columns\TextColumn::make('alamat')->limit(20),
                Tables\Columns\TextColumn::make('lat'),
                Tables\Columns\TextColumn::make('lng'),
                Tables\Columns\TextColumn::make('no_spt')->limit(20),

                Tables\Columns\TextColumn::make('isrmon_jumlah_isr'),
                Tables\Columns\TextColumn::make('isrmon_target'),
                Tables\Columns\TextColumn::make('isrmon_termonitor'),
                Tables\Columns\TextColumn::make('isrmon_capaian'),

                Tables\Columns\TextColumn::make('target_pita'),
                Tables\Columns\TextColumn::make('occ_target_pita'),
                Tables\Columns\TextColumn::make('occ_capaian'),

                Tables\Columns\TextColumn::make('iden_jumlah_termonitor'),
                Tables\Columns\TextColumn::make('iden_target'),
                Tables\Columns\TextColumn::make('iden_teridentifikasi'),
                Tables\Columns\TextColumn::make('iden_capaian'),

                Tables\Columns\TextColumn::make('capaian_pk_obs'),
                Tables\Columns\TextColumn::make('catatan')->limit(15),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),   // Opsional, kalau mau ada tombol "Lihat"
                Tables\Actions\EditAction::make(),   // Default: tombol edit
                Tables\Actions\DeleteAction::make(), // Ini tombol hapus
            ])
            ->defaultSort('tanggal', 'desc');
    }

    private static function updateCapaianPkObs($set, $get)
    {
        $isr = $get('isrmon_capaian') ?? 0;
        $occ = $get('occ_capaian') ?? 0;
        $iden = $get('iden_capaian') ?? 0;
        $total = ($isr + $occ + $iden) / 3;
        $set('capaian_pk_obs', min(round($total, 2), 100));
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
            'index' => Pages\ListMonitorings::route('/'),
            'create' => Pages\CreateMonitoring::route('/create'),
            'edit' => Pages\EditMonitoring::route('/{record}/edit'),
        ];
    }
}

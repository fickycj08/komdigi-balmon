<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengukuranResource\Pages;
use App\Filament\Resources\PengukuranResource\RelationManagers;
use App\Models\Pengukuran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengukuranResource extends Resource
{
    protected static ?string $model = Pengukuran::class;

    protected static ?string $navigationLabel = 'Data Pengukuran';

    protected static ?string $navigationGroup = 'Manajemen Pengukuran';

    protected static ?string $modelLabel = 'Data Pengukuran';
    protected static ?string $pluralModelLabel = 'Data Pengukuran';

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Data ISR')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\Section::make()
                                ->relationship('data_isr')
                                ->schema([
                                    TextInput::make('no_isr')
                                        ->label('Nomor ISR')
                                        ->required()
                                        ->maxLength(50),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Select::make('location_id')
                                                ->label('Lokasi (Kota)')
                                                ->relationship('location', 'kota')
                                                ->searchable()
                                                ->preload()
                                                ->required(),

                                            DatePicker::make('tanggal')
                                                ->label('Tanggal Pengukuran')
                                                ->required(),
                                        ]),
                                ]),
                        ]),

                    Step::make('Stasiun Radio')
                        ->icon('heroicon-o-radio')
                        ->schema([
                            Section::make('Stasiun Radio (Studio)')
                                ->relationship('stasiunRadio')
                                ->schema([
                                    TextInput::make('nama_penyelenggara')
                                        ->label('Nama Penyelenggara'),
                                    Textarea::make('alamat')
                                        ->label('Alamat'),
                                    TextInput::make('kelurahan')
                                        ->label('Kelurahan'),
                                    TextInput::make('kecamatan')
                                        ->label('Kecamatan'),
                                    Select::make('location_id')
                                        ->label('Lokasi (Kota)')
                                        ->relationship('location', 'kota')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    TextInput::make('telp_fax')
                                        ->label('Telp/Fax'),
                                    TextInput::make('email')
                                        ->label('Email'),
                                ])
                        ]),

                    Step::make('Lokasi Pemancar')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            Section::make('Lokasi Baru')
                                ->relationship('lokasiPemancar')
                                ->schema([
                                    TextInput::make('latitude')
                                        ->label('Latitude')
                                        ->numeric()
                                        ->required(),

                                    TextInput::make('longitude')
                                        ->label('Longitude')
                                        ->numeric()
                                        ->required(),

                                    Textarea::make('alamat')
                                        ->label('Alamat')
                                        ->required(),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('kelurahan')
                                            ->label('Kelurahan')
                                            ->required()
                                            ->maxLength(100),

                                        TextInput::make('kecamatan')
                                            ->label('Kecamatan')
                                            ->required()
                                            ->maxLength(100),
                                    ]),

                                    Select::make('location_id')
                                        ->label('Kota (Location)')
                                        ->relationship('location', 'kota')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->name('location_id'),

                                    TextInput::make('telp_fax')
                                        ->label('Telepon / Fax')
                                        ->maxLength(50),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('tinggi_lokasi_mdpl')
                                            ->label('Tinggi Lokasi (mdpl)')
                                            ->numeric()
                                            ->required(),

                                        TextInput::make('tinggi_gedung_m')
                                            ->label('Tinggi Gedung (m)')
                                            ->numeric()
                                            ->required(),

                                        TextInput::make('tinggi_menara_m')
                                            ->label('Tinggi Menara (m)')
                                            ->numeric()
                                            ->required(),
                                    ]),
                                ])
                        ]),

                    Step::make('Perangkat Pemancar')
                        ->icon('heroicon-o-cpu-chip')
                        ->schema([
                            Section::make('Perangkat Baru')
                                ->relationship('perangkatPemancar')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('merk')->required()->label('Merk'),
                                        TextInput::make('jenis_type')->label('Jenis / Type'),
                                    ]),

                                    TextInput::make('nomor_seri')->label('Nomor Seri')->maxLength(50),
                                    TextInput::make('negara_pembuat')->label('Negara Pembuat'),
                                    TextInput::make('tahun_pembuat')->label('Tahun Pembuatan')->numeric()->minValue(1900)->maxValue(2100),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('frekuensi_mhz')->label('Frekuensi (MHz)')->numeric(),
                                        TextInput::make('kelas_emisi')->label('Kelas Emisi')->maxLength(20),
                                        TextInput::make('bandwidth_khz')->label('Bandwidth (kHz)')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('kedalaman_modulasi_percent')->label('Kedalaman Modulasi (%)')->numeric(),
                                        TextInput::make('max_power_dbm')->label('Max Power (dBm)')->numeric(),
                                        TextInput::make('gain_db')->label('Gain (dB)')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('jenis_antena')->label('Jenis Antena'),
                                        TextInput::make('polarisasi')->label('Polarisasi'),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('jumlah_elemen_bay')->label('Jumlah Elemen (Bay)')->numeric(),
                                        TextInput::make('beam_apr')->label('Beam Antena / Arah')->numeric(),
                                        TextInput::make('panjang_kabel_m')->label('Panjang Kabel (m)')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('jenis_kabel_feeder')->label('Jenis Kabel / Feeder'),
                                        TextInput::make('tipe_kabel')->label('Tipe Kabel'),
                                    ]),
                                ])
                        ]),

                    Step::make('Pengukuran Frekuensi')
                        ->icon('heroicon-o-chart-bar')
                        ->schema([
                            Section::make('Pengukuran Frekuensi')
                                ->relationship('pengukuranFrekuensi')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('kanal')->numeric()->required(),
                                        TextInput::make('frekuensi_terukur_mhz')->label('Frekuensi Terukur (MHz)')->numeric()->required(),
                                        TextInput::make('level_dbm')->label('Level (dBm)')->numeric()->required(),
                                    ]),

                                    Select::make('location_id')
                                        ->label('Lokasi (Kota)')
                                        ->relationship('location', 'kota')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('bandwidth_khz')->label('Bandwidth (kHz)')->numeric(),
                                        TextInput::make('field_strength_dbuvm')->label('Field Strength (dBµV/m)')->numeric(),
                                        TextInput::make('deviasi_frekuensi_khz')->label('Deviasi Frekuensi (kHz)')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('kedalaman_modulasi_percent')->label('Kedalaman Modulasi (%)')->numeric(),
                                        TextInput::make('output_power_tx')->label('Output Power TX')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('cable_loss')->label('Cable Loss')->numeric(),
                                        TextInput::make('alamat')->label('Alamat')->required(),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('latitude')->numeric()->required(),
                                        TextInput::make('longitude')->numeric()->required(),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('frekuensi_h1_mhz')->label('Frekuensi H1 (MHz)')->numeric(),
                                        
                                        TextInput::make('frekuensi_h2_mhz')->label('Frekuensi H2 (MHz)')->numeric(),
                                        TextInput::make('frekuensi_h3_mhz')->label('Frekuensi H3 (MHz)')->numeric(),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('level_h1_dbm')->label('Level H1 (dBm)')->numeric(),
                                        TextInput::make('level_h2_dbm')->label('Level H2 (dBm)')->numeric(),
                                        
                                        TextInput::make('level_h3_dbm')->label('Level H3 (dBm)')->numeric(),
                                    ]),
                                ])
                        ]),

                    Step::make('Pengukuran Studio')
                        ->icon('heroicon-o-microphone')
                        ->schema([
                            Section::make('Studio to Transmitter Link (STL)')
                                ->relationship('pengukuranStudio')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('jenis_stl')
                                            ->label('Jenis STL')
                                            ->maxLength(100),

                                        TextInput::make('no_spt')
                                            ->label('Nomor SPT')
                                            ->required()
                                            ->maxLength(50),
                                    ]),

                                    DatePicker::make('tgl_spt')
                                        ->label('Tanggal SPT')
                                        ->required(),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('jenis_sbk')
                                            ->label('Jenis SBK')
                                            ->maxLength(100),

                                        TextInput::make('kecamatan')
                                            ->label('Kecamatan')
                                            ->maxLength(100),
                                    ]),

                                    Textarea::make('jalan')
                                        ->label('Alamat / Jalan'),

                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('merk_alat_ukur')
                                            ->label('Merk Alat Ukur')
                                            ->maxLength(100),

                                        TextInput::make('tipe_alat_ukur')
                                            ->label('Tipe Alat Ukur')
                                            ->maxLength(100),
                                    ]),
                                ])
                        ])
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('data_isr.no_isr')
                    ->label('No. ISR')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('stasiunRadio.nama_penyelenggara')
                    ->label('Penyelenggara')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('lokasiPemancar.alamat')
                    ->label('Alamat Pemancar')
                    ->searchable(),

                Tables\Columns\TextColumn::make('perangkatPemancar.merk')
                    ->label('Merk Pemancar'),

                Tables\Columns\TextColumn::make('pengukuranFrekuensi.frekuensi_terukur_mhz')
                    ->label('Frekuensi Terukur (MHz)'),

                Tables\Columns\TextColumn::make('pengukuranStudio.jenis_stl')
                    ->label('Jenis STL'),

                Tables\Columns\TextColumn::make('data_isr.tanggal')
                    ->label('Tanggal Pengukuran')
                    ->date('d-m-Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->since(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since(),
            ])
            ->filters([
                // tambahkan filter jika butuh
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
            'index' => Pages\ListPengukurans::route('/'),
            'create' => Pages\CreatePengukuran::route('/create'),
            'edit' => Pages\EditPengukuran::route('/{record}/edit'),
        ];
    }
}

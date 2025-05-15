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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengukuranResource extends Resource
{
    protected static ?string $model = Pengukuran::class;


    protected static ?string $navigationLabel = 'Pengukuran test';

    protected static ?string $navigationGroup = 'Manajemen Pengukuran';

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Form Pengukuran')
                    ->tabs([
                        Tab::make('Data ISR')->schema([
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
                                                ->label('Tanggal ISR')
                                                ->required(),


                                        ]),
                                ]),
                        ]),



                        Tab::make('Stasiun Radio')->schema([
                            
                        
                            Section::make('Stasiun Radio Baru')
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
                        
                        Tab::make('Lokasi Pemancar')->schema([
                           
                        
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
                                    ->relationship('location', 'kota') // opsional, hanya jika mau dari relasi
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->name('location_id'), // ini wajib biar Filament tahu field relasinya
                                
                        
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
                        
                        
                                Tab::make('Perangkat Pemancar')->schema([
                                    
                                
                                    Section::make('Perangkat Baru')
                                        ->relationship('perangkatPemancar')
                                        ->schema([
                                            Forms\Components\Grid::make(2)->schema([
                                                TextInput::make('merk')->required()->label('Merk'),
                                                TextInput::make('jenis_type')->required()->label('Jenis / Type'),
                                            ]),
                                
                                            TextInput::make('nomor_seri')->label('Nomor Seri')->maxLength(50)->required(),
                                            TextInput::make('negara_pembuat')->label('Negara Pembuat')->required(),
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
                                                TextInput::make('jenis_antena')->label('Jenis Antena'), // pastikan ini sesuai DB (antenna, bukan antena)
                                                TextInput::make('polarisasi')->label('Polarisasi'),
                                            ]),
                                
                                            Forms\Components\Grid::make(3)->schema([
                                                TextInput::make('jumlah_elemen_bay')->label('Jumlah Elemen (Bay)')->numeric(),
                                                TextInput::make('beam_apr')->label('Beam Antena / Arah')->numeric(), // pastikan ini sesuai nama kolom DB
                                                TextInput::make('panjang_kabel_m')->label('Panjang Kabel (m)')->numeric(),
                                            ]),
                                
                                            Forms\Components\Grid::make(2)->schema([
                                                TextInput::make('jenis_kabel_feeder')->label('Jenis Kabel / Feeder'),
                                                TextInput::make('tipe_kabel')->label('Tipe Kabel'),
                                            ]),
                                        ])
                                        
                                        ]),
                                
                        
                        Tab::make('Pengukuran Frekuensi')->schema([
                            Section::make('Pengukuran Frekuensi')
                                ->relationship('pengukuranFrekuensi')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('kanal')->numeric()->required(),
                                        TextInput::make('frekuensi_terukur_mhz')->label('Frekuensi Terukur (MHz)')->numeric()->required(),
                                        TextInput::make('level_dbm')->label('Level (dBm)')->numeric()->required(),
                                    ]),
                        
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
                                        TextInput::make('level_h1_dbm')->label('Level H1 (dBm)')->numeric(),
                                        TextInput::make('frekuensi_h2_mhz')->label('Frekuensi H2 (MHz)')->numeric(),
                                    ]),
                        
                                    Forms\Components\Grid::make(3)->schema([
                                        TextInput::make('level_h2_dbm')->label('Level H2 (dBm)')->numeric(),
                                        TextInput::make('frekuensi_h3_mhz')->label('Frekuensi H3 (MHz)')->numeric(),
                                        TextInput::make('level_h3_dbm')->label('Level H3 (dBm)')->numeric(),
                                     ]),
                                ])
                                ]),
                        
                        Tab::make('Pengukuran Studio')->schema([
                            Section::make('Studio to Transmitter Link (STL)')
                                ->relationship('pengukuranStudio')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('jenis_stl')
                                            ->label('Jenis STL')
                                            ->required()
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
                                            ->required()
                                            ->maxLength(100),
                        
                                        TextInput::make('kecamatan')
                                            ->label('Kecamatan')
                                            ->required()
                                            ->maxLength(100),
                                    ]),
                        
                                    Textarea::make('jalan')
                                        ->label('Alamat / Jalan')
                                        ->required(),
                        
                                    Forms\Components\Grid::make(2)->schema([
                                        TextInput::make('merk_alat_ukur')
                                            ->label('Merk Alat Ukur')
                                            ->maxLength(100)
                                            ->required(),
                        
                                        TextInput::make('tipe_alat_ukur')
                                            ->label('Tipe Alat Ukur')
                                            ->maxLength(100)
                                            ->required(),
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
                //
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
            'index' => Pages\ListPengukurans::route('/'),
            'create' => Pages\CreatePengukuran::route('/create'),
            'edit' => Pages\EditPengukuran::route('/{record}/edit'),
        ];
    }
}

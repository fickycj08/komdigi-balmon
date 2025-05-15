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
use Filament\Forms\Components\Tabs;
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
                Tabs::make('Monitoring')
                    ->tabs([
                        Tabs\Tab::make('Informasi Umum')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Detail Lokasi')
                                    ->description('Informasi tentang lokasi monitoring')
                                    ->icon('heroicon-o-map-pin')
                                    ->collapsible()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('upt')
                                                    ->label('UPT')
                                                    ->required()
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('stasiun_monitor')
                                                    ->label('Stasiun Monitor')
                                                    ->required()
                                                    ->maxLength(50),
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
                                                Forms\Components\TextInput::make('kab_kota')
                                                    ->label('Kabupaten/Kota')
                                                    ->required()
                                                    ->maxLength(100),
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
                        Tabs\Tab::make('Data ISR Monitoring')
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
                                                    ->default(0),
                                                Forms\Components\TextInput::make('isrmon_target')
                                                    ->label('Target ISR')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('isrmon_termonitor')
                                                    ->label('Termonitor')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('isrmon_capaian')
                                                    ->label('Capaian (%)')
                                                    ->numeric()
                                                    ->default(0)
                                                    
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Data Target Pita')
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
                                                    ->default(0),
                                                Forms\Components\TextInput::make('occ_target_pita')
                                                    ->label('Occ Target Pita')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('occ_capaian')
                                                    ->label('OCC Capaian')
                                                    ->numeric() 
                                                    ->default(0),
                                            ]),
                                                    
                                    ]),
                            ]),
                        Tabs\Tab::make('Data Identifikasi')
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
                                                    ->default(0),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('iden_teridentifikasi')
                                                    ->label('Teridentifikasi')
                                                    ->numeric()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('iden_capaian')
                                                    ->label('Capaian')
                                                    ->numeric()
                                                    ->default(0),
                                                    
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Kesimpulan')
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
                                                    ->label('Capaian PK OBS')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->suffix('%'),
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
                Tables\Columns\TextColumn::make('kab_kota'),
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
            ->defaultSort('tanggal', 'desc');
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

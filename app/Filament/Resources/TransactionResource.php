<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('hari_tanggal')
                ->label('Hari Tanggal')
                ->required()
                ->displayFormat('Y-m-d') 
                ->format('Y-m-d'),       

                Forms\Components\Select::make('categories_id')
                ->label('Uraian')
                ->relationship('categories', 'uraian')
                ->searchable()
                ->preload()
                ->required(),       

            TextInput::make('bidang')
                ->label('Bidang')
                ->required()
                ->maxLength(255),


            TextInput::make('nominal')
                ->label('Nominal')
                ->numeric()             
                ->default(0)
                ->required(),

            TextInput::make('total')
                ->label('Total')
                ->disabled() 
                ->numeric()
                ->default(0),

            Forms\Components\Select::make('member_id')
            ->label('PJ')
            ->relationship('member', 'nama')
            ->searchable()
            ->preload()
            ->required(),

            FileUpload::make('bukti_transaksi')
                ->label('Bukti Transaksi')
                ->nullable()            
                ->directory('bukti_transaksi') 

                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf']) 
                ->maxSize(2048),        

            FileUpload::make('spj')
                ->label('SPJ')
                ->nullable()
                ->directory('spj')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hari_tanggal'),
                Tables\Columns\TextColumn::make('categories.uraian') ->label('Uraian'),
                Tables\Columns\TextColumn::make('bidang'),
                Tables\Columns\TextColumn::make('categories.jenis') ->label('Jenis'),
                Tables\Columns\TextColumn::make('nominal'),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\TextColumn::make('member.nama') ->label('PJ'),
                Tables\Columns\TextColumn::make('bukti_transaksi'),
                Tables\Columns\TextColumn::make('spj'),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}

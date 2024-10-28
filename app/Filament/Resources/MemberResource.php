<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama'),
                Forms\Components\TextInput::make('npm'),
                Forms\Components\Select::make('gender')
                    ->options([
                        'laki-laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                    ]),
                Forms\Components\Select::make('bidang')
                    ->options([
                        'inti' => 'Inti',
                        'psdm' => 'Pemberdayaan Sumber Daya Manusia (PSDM)',
                        'kerohanian' => 'Kerohanian',   
                        'humas' => 'Hubungan Masyarakat (Humas)',
                        'kominfo' => 'Komunikasi Media Informasi (Kominfo)',   
                        'danus' => 'Dana Usaha (Danus)',
                        'minbak' => 'Minat Bakat (Minbak)',
                ]),
                Forms\Components\TextInput::make('jabatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('npm'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('bidang'),
                Tables\Columns\TextColumn::make('jabatan'),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}

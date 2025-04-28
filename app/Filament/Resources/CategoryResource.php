<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // 👈 Agregado
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput; // asegurate de importar esto
use Filament\Forms\Components\Select;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->label('Nombre'),
                Select::make('status') // Aquí se usa Select para el campo 'status'
                ->label('Estado') // Etiqueta que aparecerá al lado del select
                ->required() // Hace que el campo sea obligatorio
                ->options([ // Opciones que se desplegarán en el select
                    1 => 'Activo',  // El valor 1 será tratado como 'Activo' en la base de datos
                    0 => 'Inactivo', // El valor 0 será tratado como 'Inactivo' en la base de datos
                ])
                ->native(false), // Esto evita que se utilice un <select> HTML normal, usando las características personalizadas de Filament
    
          
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([ 
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nombre'),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable()
                    ->label('Estado')
                    ->formatStateUsing(function (string $state): string {
                        return $state === '1' ? 'Activo' : 'Inactivo';
                    })
                  
                    
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

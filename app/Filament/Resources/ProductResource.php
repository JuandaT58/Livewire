<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;



class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->placeholder('Nombre del producto')
                ->maxLength(100),
                TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->placeholder('Descripción del producto')
                ->maxLength(255),
             TextInput::make('price')
                ->label('Precio')
                ->required()
                ->placeholder('Precio del producto')
                ->prefix('$')
                ->numeric(),
                FileUpload::make('image')
                ->label('Imagen')
                ->required()
                ->placeholder('Imagen del producto')
                ->image()
                ->directory('products'),
                Select::make('category_id')
                 ->label('Categoría del producto')
                 ->required() // Asegura que se seleccione una categoría
                  ->relationship('category', 'name')
                  ->placeholder('Seleccione una categoría'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->searchable()
                    ->prefix('$')
                    ->formatStateUsing(function (string $state): string {
                        return number_format((float) $state, 2, ',', '.');
                    })
                    ->sortable(),                    
                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Imagen')
                    ->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

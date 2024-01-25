<?php

namespace Modules\Catalog\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Filament\Resources\ProductResource\Pages;
use Modules\Catalog\Filament\Resources\ProductResource\RelationManagers;
use Modules\Catalog\Models\Product;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Product Name'))
                    ->autofocus()
                    ->placeholder(__('Product Name')),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label(__('Product Price'))
                    ->placeholder(__('Product Price')),
                // Forms\Components\Select::make('status')
                //     ->label(__('Status'))
                //     ->options(ProductStatus::class),
                Forms\Components\Radio::make('status')
                    ->label(__('Status'))
                    ->options(ProductStatus::class)
                    ->default(ProductStatus::SoldOut),
                Forms\Components\Select::make('category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name'),
                // Forms\Components\Select::make('tags')
                //     ->relationship('tags', 'name')
                //     ->preload()
                //     ->multiple(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Product Name'))
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Product Price'))
                    ->money('usd')
                    ->getStateUsing(fn (Product $record): float => $record->price / 100)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->limit(15)
                    ->sortable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label(__('Tags')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ProductStatus::class)
                    ->label(__('Status')),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label(__('Category')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\TagsRelationManager::class,
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

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Catalog');
    }
}

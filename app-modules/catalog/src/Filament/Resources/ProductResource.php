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
                Forms\Components\Fieldset::make('Main data')
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
                    ])
                    ->columns(2),
                Forms\Components\Fieldset::make('Additional data')
                    ->schema([
                        Forms\Components\Radio::make('status')
                            ->label(__('Status'))
                            ->options(ProductStatus::class)
                            ->default(ProductStatus::SoldOut),
                        Forms\Components\Select::make('category_id')
                            ->label(__('Category'))
                            ->relationship('category', 'name'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Product Name'))
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable()
                    ->url(fn(Product $product): string => self::getUrl('edit', ['record' => $product->id])),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Product Price'))
                    ->money('usd')
                    ->getStateUsing(fn (Product $record): float => $record->price / 100)
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('Is Active')),
                // Tables\Columns\CheckboxColumn::make('is_active')
                //     ->label(__('Is Active')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    // ->dateTime('d.m.Y H:i')
                    ->since() // This will run "diffForHumans" under the hood
                    ->sortable(),
                // Tables\Columns\TextColumn::make('status')
                //     ->label(__('Status'))
                //     ->badge()
                //     ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label(__('Status'))
                    ->options(ProductStatus::class),
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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('Created From'))
                            ->seconds(false)
                            ->displayFormat('d/m/Y'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('Created Until'))
                            ->seconds(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'view' => Pages\ViewProduct::route('/{record}'),
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

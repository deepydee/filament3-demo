<?php

namespace Modules\Catalog\Filament\Resources;

use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Catalog\Filament\Resources\CategoryResource\Pages;
use Modules\Catalog\Filament\Resources\CategoryResource\RelationManagers;
use Modules\Catalog\Models\Category;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active'),
                Forms\Components\Toggle::make('is_popular'),
                Forms\Components\Toggle::make('show_in_menu'),
                 Forms\Components\TextInput::make('url_key')
                    ->maxLength(255),
                Forms\Components\TextInput::make('url_path')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(10)
                    ->cols(20),
                Forms\Components\TextInput::make('seo_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('meta_title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('meta_keywords')
                    ->maxLength(255),
                Forms\Components\Textarea::make('meta_description')
                    ->rows(10)
                    ->cols(20),
                Forms\Components\Toggle::make('include_in_sitemap'),
                SelectTree::make('parent_id')
                    ->relationship('parent', 'name', 'parent_id')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('parent.name'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level'),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label(__('Products')),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\ToggleColumn::make('is_popular',),
                Tables\Columns\ToggleColumn::make('show_in_menu'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Categories');
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

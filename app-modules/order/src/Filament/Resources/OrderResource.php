<?php

namespace Modules\Order\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Modules\Order\Filament\Resources\OrderResource\Pages;
use Modules\Order\Filament\Resources\OrderResource\RelationManagers;
use Modules\Order\Models\Order;

class OrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Order Name'))
                    ->autofocus()
                    ->placeholder(__('Order Name')),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label(__('Product Price'))
                    ->placeholder(__('Product Price')),
                Forms\Components\Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->preload(),
                Forms\Components\Select::make('product_id')
                    ->label(__('Product'))
                    ->relationship('product', 'name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label(__('Product')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User')),
                Tables\Columns\TextColumn::make('price')
                    ->money(currency: 'usd', divideBy: 100)
                    ->label(__('Price'))
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->formatStateUsing(fn ($state) => '$'.number_format($state / 100, 2)),
                        Tables\Columns\Summarizers\Average::make(),
                        Tables\Columns\Summarizers\Range::make(),
                    ]),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label(__('Complete Status'))
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultGroup('product.name')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Mark Completed')
                        ->label(__('Mark Completed'))
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check-badge')
                        ->hidden(fn (Order $record) => $record->is_completed)
                        ->action(fn (Order $record) => $record->update(['is_completed' => true])),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Mark as Completed')
                        ->icon('heroicon-o-check-badge')
                        ->label(__('Mark Completed'))
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_completed' => true]))
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return Order::whereDate('created_at', today())->count() ? __('New') : '';
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}

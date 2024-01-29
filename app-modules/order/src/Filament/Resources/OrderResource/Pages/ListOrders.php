<?php

namespace Modules\Order\Filament\Resources\OrderResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Order\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('Orders');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\TotalOrders::class
        ];
    }
}

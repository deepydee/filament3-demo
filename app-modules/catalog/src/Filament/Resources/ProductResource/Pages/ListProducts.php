<?php

namespace Modules\Catalog\Filament\Resources\ProductResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Catalog\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('Products');
    }
}

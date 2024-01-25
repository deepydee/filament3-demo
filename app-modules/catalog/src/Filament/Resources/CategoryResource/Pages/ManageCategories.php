<?php

namespace Modules\Catalog\Filament\Resources\CategoryResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Catalog\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('Categories');
    }
}

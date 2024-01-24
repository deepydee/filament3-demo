<?php

namespace Modules\Catalog\Filament\Resources\ProductResource\Pages;

use Modules\Catalog\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['price'] = $data['price'] * 100;

        return $data;
    }
}

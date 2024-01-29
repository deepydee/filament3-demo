<?php

namespace Modules\Catalog\Filament\Resources\CategoryResource\Pages;

use Modules\Catalog\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('view-tree')
                ->label(__('Tree view'))
                ->url(fn() => static::$resource::getUrl('tree')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CategoryResource\Widgets\CategoryWidget::class,
            CategoryResource\Widgets\CreateCategoryWidget::class,
        ];
    }

    #[On('contact-created')]
    public function refresh() {}
}

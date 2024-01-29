<?php

namespace Modules\Catalog\Filament\Resources\CategoryResource\Pages;

use Modules\Catalog\Filament\Resources\CategoryResource;
use Filament\Pages\Actions\CreateAction;
use SolutionForest\FilamentTree\Actions;
use SolutionForest\FilamentTree\Concern;
use SolutionForest\FilamentTree\Resources\Pages\TreePage as BasePage;
use SolutionForest\FilamentTree\Support\Utils;

class CategoryTree extends BasePage
{
    protected static string $resource = CategoryResource::class;

    protected static int $maxDepth = 2;

    protected function getActions(): array
    {
        return [
            $this->getCreateAction(),
            // SAMPLE CODE, CAN DELETE
            //\Filament\Pages\Actions\Action::make('sampleAction'),
        ];
    }

    protected function getTreeActions(): array
{
    return [
        Actions\ViewAction::make(),
        Actions\EditAction::make(),
        Actions\DeleteAction::make(),
    ];
}

    protected function hasDeleteAction(): bool
    {
        return true;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return true;
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function getNodeCollapsedState(?\Illuminate\Database\Eloquent\Model $record = null): bool
{
    // All tree nodes will be collapsed by default.
    return true;
}

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        return null;
        // return 'heroicon-o-cake';
    }
}

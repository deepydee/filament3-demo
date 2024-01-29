<?php

namespace Modules\Catalog\Filament\Resources\CategoryResource\Widgets;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Catalog\Models\Category;

class CreateCategoryWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'catalog::filament.resources.category-resource.widgets.create-category-widget';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label(__('Name')),
                Select::make('parent_id')
                    ->options(Category::pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->label(__('Parent')),
                TextInput::make('order')
                    ->label(__('Order')),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        Category::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('contact-created');
    }
}

<?php

declare(strict_types=1);

namespace Modules\Catalog\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductStatus: string implements HasLabel
{
    case InStock = 'in stock';
    case SoldOut = 'sold out';
    case ComingSoon = 'coming_soon';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::InStock => __('In Stock'),
            self::SoldOut => __('Sold Out'),
            self::ComingSoon => __('Coming Soon'),
        };
    }
}

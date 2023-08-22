<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumTrait
{
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArray(): array
    {
        return collect(self::cases())->map(function ($item) {
            return self::itemToArray($item->value, $item->name);
        })->toArray();
    }

    public static function getKeyValues(): array
    {
        return collect(self::cases())->mapWithKeys(function ($item) {
            return [$item->value => $item->name];
        })->toArray();
    }

    public static function itemToArray(int|string $value, string $name = null): array
    {
        return [
            'id' => $value,
            'description' => Str::of($name ?? $value)->replace('_', ' ')->title()->toString()
        ];
    }
}

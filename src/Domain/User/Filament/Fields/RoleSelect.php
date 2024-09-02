<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Fields;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

class RoleSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->relationship = 'roles';

        $this->afterStateHydrated(static function (self $component): void {
            $relationship = $component->getRelationship();

            $role = $relationship->first();

            if (! $role) {
                return;
            }

            $component->state($role->id);
        });

        $model = config('permission.models.role');

        $this->options(
            static fn () => $model::query()
                ->where('guard_name', 'web')
                ->pluck('name', 'id')
                ->map(static fn (string $name) => __($name))
                ->all(),
        );

        $this->saveRelationshipsUsing(static function (Select $component, Model $record, $state): void {
            $component->getRelationship()->sync(($state !== null) ? [$state] : []);
        });

        $this->dehydrated(true);
    }
}

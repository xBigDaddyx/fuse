<?php

declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\System\Filament\Widgets;

use Filament\Widgets\Widget;

class PulseSchedule extends Widget
{
    protected static string $view = 'fuse::widgets.pulse-schedule';

    protected string|int|array $cols;

    protected string $ignoreAfter;

    protected int $rows;

    public function __construct()
    {
//
    }
}

<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::where('role', User::ROLE_USER)->count()),
            Stat::make('Total Admins', User::where('role', User::ROLE_ADMIN)->count()),
            Stat::make('Total Editors', User::where('role', User::ROLE_EDITOR)->count()),
        ];
    }
}

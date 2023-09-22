<?php

namespace Shanerbaner82\PanelRoles;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Event;
use Shanerbaner82\PanelRoles\listeners\AssignRoleListener;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

class PanelRoles implements Plugin
{
    protected string $role;

    public static function make(): PanelRoles
    {

        return new PanelRoles();
    }

    public function role(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getId(): string
    {
        return'shanerbaner82-panel-roles';
    }

    public function register(Panel $panel): void
    {
        $panel->authMiddleware(
            [
                'role:'. $this->role
            ]
        );
    }

    public function boot(Panel $panel): void
    {
        Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            function($event){
                $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $this->role]);
                $event->user->assignRole($role);
            }
        );
    }
}

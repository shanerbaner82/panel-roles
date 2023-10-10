<?php

namespace Shanerbaner82\PanelRoles;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Event;

class PanelRoles implements Plugin
{
    protected string $assignableRole;
    protected array $restrictedRoles;

    public static function make(): PanelRoles
    {

        return new PanelRoles();
    }

    public function roleToAssign(string $role): static
    {
        $this->assignableRole = $role;
        return $this;
    }

    public function restrictedRoles(array $roles): static
    {
        $this->restrictedRoles = $roles;
        return $this;
    }

    public function getRoleToAssign(): string
    {
        return $this->assignableRole;
    }

    public function getRestrictedRoles(): array
    {
        return $this->restrictedRoles;
    }

    public function getId(): string
    {
        return'shanerbaner82-panel-roles';
    }

    public function register(Panel $panel): void
    {
        $panel->authMiddleware(
            [
                'role:'. implode('|', $this->getRestrictedRoles())
            ]
        );
    }

    public function boot(Panel $panel): void
    {
        Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            function($event){
                $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $this->getRoleToAssign()]);
                $event->user->assignRole($role);
            }
        );
    }
}

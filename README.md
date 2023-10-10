![Filament Panel Roles](https://github.com/shanerbaner82/panel-roles/blob/main/images/shanerbaner82-panel-roles.jpg)
## Filament Panel Roles

Filament Panel Roles is an intuitive way to ensure all users of a specified panel within Filament v3 is assigned a role during registration and has a specified role using Laravel Middleware.

### Installation
```bash
  composer require shanerbaner82/panel-roles
```

### Setup
Filament Panel Roles requires you to install [Spatie's Laravel Permissions package](https://spatie.be/docs/laravel-permission).
the minimum setup required is to:

1. Install Spatie's package
2. Add the [RoleMiddleware](https://spatie.be/docs/laravel-permission/v5/basic-usage/middleware) to your`app/Http/Kernel.php`

### Usage
Inside any of your Filament panels add the Panel Roles plugin and specify the role users will be assigned and must have in order to login.

```php
use Shanerbaner82\PanelRoles\PanelRoles;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ... 
            ->plugin(PanelRoles::make()
                ->roleToAssign('developer')
                ->restrictedRoles(['admin', 'developer']),
            )
    }
}
```

Technically you do not need to chain the `registration()` function on your panel, but if you do when a user registers they will be assigned the provided role.

### Bonus
Watch [LaravelOnline](https://www.youtube.com/@LaravelOnline) on YouTube to see how this plugin was created and to learn more about Laravel and Filament!

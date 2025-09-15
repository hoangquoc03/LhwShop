<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Auth\CustomUserProvider;
use App\Models\AclUser;
use App\Models\AclPermission;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         $this->app->auth->provider('custom', function ($app, array $config) {
             new CustomUserProvider($app['hash'], $config['model']);
        });

        Gate::define('shop_posts::view', function(AclUser $user){
            return hasPermission($user,'shop_posts::view');
        });

        Gate::define('shop_posts::create', function(AclUser $user){
            return hasPermission($user,'shop_posts::create');
        });

        Gate::define('shop_posts::update', function(AclUser $user){
            return hasPermission($user,'shop_posts::update');
        });

        Gate::define('shop_posts::delete', function(AclUser $user){
            return hasPermission($user,'shop_posts::delete');
        });

        Gate::define('shop_categories::view', function(AclUser $user){
            return hasPermission($user,'shop_categories::view');
        });

        // ✅ Thêm kiểm tra trước khi truy vấn
        if (Schema::hasTable('acl_permissions')) {
            $allPermissions = AclPermission::all();
            foreach ($allPermissions as $permission) {
                Gate::define($permission->name, function (AclUser $user) use ($permission) {
                    return hasPermission($user, $permission->name);
                });
            }
        }
    }
}
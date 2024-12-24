<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Advert;
use App\Models\Category;
use App\Models\Message;
use App\Policies\AdvertPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\MessagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Advert::class => AdvertPolicy::class,
        Category::class => CategoryPolicy::class,
        Message::class => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}

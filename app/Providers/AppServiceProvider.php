<?php

namespace App\Providers;

use App\Helpers\Assert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Model::shouldBeStrict(! app()->isProduction());
        JsonResource::withoutWrapping();

        Carbon::macro('toDatabaseDate', function (): string {
            Assert::that(is_a($this, Carbon::class));
            /** @var Carbon $this */

            return $this->format('Y-m-d');
        });
    }
}

<?php

namespace Redaelfillali\GoogleAnalyticsEvents;

use Illuminate\Support\ServiceProvider;

class GoogleAnalyticsEventsServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    $this->mergeConfigFrom(__DIR__ . '/../config/google-analytics-events.php', 'google-analytics-events');

    $this->app->singleton(GoogleAnalyticsService::class, function () {
      return new GoogleAnalyticsService();
    });
  }

  public function boot(): void
  {
    $this->publishes([
      __DIR__ . '/../config/google-analytics-events.php' => config_path('google-analytics-events.php'),
    ], 'config');
  }
}

<?php

namespace Redaelfillali\GoogleAnalyticsEvents;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAnalyticsService
{
  protected string $measurementId;
  protected string $apiSecret;

  public function __construct()
  {
    $this->measurementId = config('google-analytics-events.measurement_id');
    $this->apiSecret = config('google-analytics-events.api_secret');
  }

  public function sendEvent(string $eventName, array $params = [], ?string $clientId = null): void
  {
    $clientId = $clientId ?: $this->getClientId();

    if (!$clientId) {
      return;
    }

    $url = "https://www.google-analytics.com/mp/collect?measurement_id={$this->measurementId}&api_secret={$this->apiSecret}";

    Http::post($url, [
      'client_id' => $clientId,
      'events' => [
        [
          'name' => $eventName,
          'params' => $params,
        ],
      ],
    ]);
  }

  protected function getClientId(): string
  {
    $cookie = request()->cookie('_ga');
    if ($cookie && preg_match('/GA\d\.\d\.(\d+\.\d+)/', $cookie, $matches)) {
      return $matches[1];
    }

    return (string) Str::uuid();
  }
}

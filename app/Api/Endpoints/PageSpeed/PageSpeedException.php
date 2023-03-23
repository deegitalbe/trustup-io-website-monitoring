<?php
namespace App\Api\Endpoints\PageSpeed;

use App\Models\Website;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;

class PageSpeedException extends RequestRelatedException
{
  protected Website $website;
  protected $message = "Cannot reach website url.";

  public function setWebsite(Website $website): self
  {
    $this->website = $website;

    return $this;
  }

  public function additionalContext(): array
  {
    return [
      "website" => [
        "url" => $this->website->getUrl(),
        "domain" => $this->website->getDomain(),
        "website_id" => $this->website->getWebsiteId(),
      ]
    ];
  }
}
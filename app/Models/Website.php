<?php

namespace App\Models;

use App\Http\Services\Enums\StrategyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PhpParser\ErrorHandler\Collecting;

class Website 
{
   protected string $url;
   protected int $website_id;
   protected string $domain;


   public function setUrl(string $url): self
   {
    $this->url = $url;

    return $this;
   }

   public function setWebsiteId(int $websiteId): self
   {
    $this->website_id = $websiteId;

    return $this;
   }

   public function setDomain(string $domain): self
   {
    $this->domain = $domain;

    return $this;
   }

   public function getUrl(): string
   {
    return $this->url;
   }

   public function getWebsiteId(): int
   {
    return $this->website_id;
   }

   public function getDomain(): string
   {
    return $this->domain;
   }

   public function getLastReports(int $number,StrategyType $strategyType): Collection
   {
      return Report::where('website_id', $this->getWebsiteId())->where('strategy', $strategyType->value)->orderBy('created_at', 'desc')->take($number)->get();
   }
}

<?php 
namespace App\Api\Response\WebsiteDomains;

use App\Models\Website;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Illuminate\Support\Collection;

class WebsiteDomainResponse{

  protected TryResponseContract $response;
  protected Collection $websites;
  protected Website $website;

  public function __construct(TryResponseContract $response)
  {
    $this->response = $response;
  }


  protected function getData()
  {
    return $this->response->response()->get(true)['data'];
  }

  protected function mapWebsiteToModel()
  {
    $this->websites = collect($this->getData())->map(function($website){
      /** @var Website */
      $websiteModel = app()->make(Website::class);
      $websiteModel->setUrl($website['url'])
                  ->setWebsiteId($website['id'])
                  ->setDomain($website['domain']);
      return $websiteModel;
    });
  }

  protected function websiteToModel()
  {
    $website = $this->getData();

    /** @var Website */
    $websiteModel = app()->make(Website::class);
    $websiteModel->setUrl($website['url'])
                ->setWebsiteId($website['id'])
                ->setDomain($website['domain']);

    $this->website = $websiteModel;
  }

  public function getWebsites(): Collection
  {
    $this->mapWebsiteToModel();
    return $this->websites;
  }

  public function getWebsite(): Website
  {
    $this->websiteToModel();
    return $this->website;
  }
}
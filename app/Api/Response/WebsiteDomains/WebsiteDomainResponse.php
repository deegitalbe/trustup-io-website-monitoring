<?php 
namespace App\Api\Response\WebsiteDomains;

use App\Models\Website;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Illuminate\Support\Collection;

class WebsiteDomainResponse{

  protected TryResponseContract $response;
  protected Collection $websites;

  public function __construct(TryResponseContract $response)
  {
    $this->response = $response;
  }


  protected function getData()
  {
    return collect($this->response->response()->get(true)['data']);
  }

  protected function mapWebsiteToModel()
  {
    $this->websites = $this->getData()->map(function($website){
      /** @var Website */
      $websiteModel = app()->make(Website::class);
      $websiteModel->setUrl($website['url'])
                  ->setWebsiteId($website['id'])
                  ->setDomain($website['domain']);
      return $websiteModel;
    });
  }

  public function getWebsites(): Collection
  {
    $this->mapWebsiteToModel();
    return $this->websites;
  }
}
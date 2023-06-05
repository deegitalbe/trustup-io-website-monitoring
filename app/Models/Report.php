<?php

namespace App\Models;

use App\Builders\ReportBuilder;
use App\Http\Services\Enums\StrategyType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @method static ReportBuilder query() */ 

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'performance_score', 'seo_score', 'strategy', 'first_contentful_paint', 'website_id', 'domain'];


    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getPerformanceScore(): ?float
    {
        return round($this->performance_score * 100);
    }

    public function getSeoScore(): ?float
    {
        return round($this->seo_score * 100);
    }

    public function getStrategy(): ?string
    {
        return $this->strategy;
    }

    public function getFirstContentfulPaint(): ?int
    {
        return $this->first_contentful_paint ?? 0;
    }

    public function getWebsiteId(): ?int
    {
        return $this->website_id;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setPerformanceScore(?float $performanceScore): self
    {
        $this->performance_score = $performanceScore;
        return $this;
    }

    public function setSeoScore(?float $seoScore): self
    {
        $this->seo_score = $seoScore;
        return $this;
    }

    public function setStrategy(?StrategyType $strategy): self
    {
        $this->strategy = $strategy->value ?? null;
        return $this;
    }

    public function setFirstContentfulPaint(?int $firstcontent): self
    {
        $this->first_contentful_paint = $firstcontent;
        return $this;
    }

    public function setWebsiteId(?int $websiteId): self
    {
        $this->website_id = $websiteId;
        return $this;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function newModelQuery(): ReportBuilder
    {
        $eloquentBuilder = new ReportBuilder($this->newBaseQueryBuilder());
        
        return $eloquentBuilder->setModel($this);
    }
}

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


    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPerformanceScore(): float
    {
        return $this->performance_score * 100;
    }

    public function getSeoScore(): float
    {
        return $this->seo_score * 100;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function getFirstContentfulPaint(): int
    {
        return $this->first_contentful_paint;
    }

    public function getWebsiteId(): int
    {
        return $this->website_id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function newModelQuery(): ReportBuilder
    {
        $eloquentBuilder = new ReportBuilder($this->newBaseQueryBuilder());
        
        return $eloquentBuilder->setModel($this);
    }
}

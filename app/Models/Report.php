<?php

namespace App\Models;

use App\Http\Services\Enums\StrategyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->performance_score;
    }

    public function getSeoScore(): float
    {
        return $this->seo_score;
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

    public function scopeWhereStrategy($query, StrategyType $strategyType): Builder
    {
        return $query->where('strategy', $strategyType->value);
    }
}

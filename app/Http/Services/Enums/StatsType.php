<?php 
namespace App\Http\Services\Enums;


enum StatsType: string
{

  case PERFORMANCE = 'performance_score';
  case SEO = 'seo_score';
  case FIRSTCONTENTFULPAINT = 'first_contentful_paint';
}
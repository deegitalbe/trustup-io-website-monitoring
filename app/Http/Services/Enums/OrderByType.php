<?php 
namespace App\Http\Services\Enums;

enum OrderByType: string 
{
  CASE DESKTOP_PERFORMANCE_ASC = 'desktop_performance_asc';

  CASE DESKTOP_PERFORMANCE_DESC = 'desktop_performance_desc';

  CASE MOBILE_PERFORMANCE_ASC ='mobile_performance_asc';

  CASE MOBILE_PERFORMANCE_DESC ='mobile_performance_desc';

  CASE DESKTOP_SEO_ASC ='desktop_seo_asc';

  CASE DESKTOP_SEO_DESC ='desktop_seo_desc';

  CASE MOBILE_SEO_ASC ='mobile_seo_asc';

  CASE MOBILE_SEO_DESC ='mobile_seo_desc';

  CASE DESKTOP_FIRSTCONTENT_ASC ='desktop_firstcontent_asc';

  CASE DESKTOP_FIRSTCONTENT_DESC ='desktop_firstcontent_desc';

  CASE MOBILE_FIRSTCONTENT_ASC ='mobile_firstcontent_asc';
  
  CASE MOBILE_FIRSTCONTENT_DESC ='mobile_firstcontent_desc';
}
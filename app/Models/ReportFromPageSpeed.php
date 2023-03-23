
protected float $performance_score;
    protected float $seo_score;
    protected int $first_contentful_paint;


    public function setPerformanceScore(float $performanceScore): self
    {
        $this->performance_score = $performanceScore;

        return $this;
    }

    public function setSeoScore(float $seoScore): self
    {
        $this->seo_score = $seoScore;

        return $this;
    }

    public function setFirstContentfulPaint(int $firstContentfulPaint): self
    {
        $this->first_contentful_paint = $firstContentfulPaint;

        return $this;
    }

    public function getPerformanceScore(): float
    {
        return $this->performance_score;
    }

    public function getSeoScore(): float
    {
        return $this->seo_score;
    }

    public function getFirstContentfulPaint(): int
    {
        return $this->first_contentful_paint;
    }
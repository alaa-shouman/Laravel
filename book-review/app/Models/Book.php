<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as queryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;

class Book extends Model
{
    use HasFactory;
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {

        return $query->where("title", "like", "%" . $title . "%");
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|queryBuilder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilterIterator($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|queryBuilder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilterIterator($q, $from, $to)
        ], 'rating')->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReview(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', '$minReviews');
    }
    private function dateRangeFilterIterator(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where("created_at", ">=", $from);
        } elseif (!$from && $to) {
            $query->where("created_at", "<=", $to);
        } elseif ($from && $to) {
            $query->whereBetween("created_at", [$from, $to]);
        }
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }
    public function scopeSixLastMonths(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6), now())->highestRated(now()->subMonths(6), now())
            ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestrated(now()->subMonth(), now())->popular(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopeHighestRatedLastSixMonths(Builder $query): Builder|QueryBuilder
    {
        return $query->highestrated(now()->subMonths(6), now())->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }
}
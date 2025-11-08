<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'published_at',
        'featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', Carbon::now());
    }

    public function scopePopular($query)
    {
        return $query->withCount('likes')->orderBy('likes_count', 'desc');
    }

    public function scopeSearch($query, $search = "")
    {
        return $query->where('title', 'like', "%{$search}%");
    }

    public function getReadingTime() {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTimeMinutes = ceil($wordCount / 200); // Assuming an average reading speed of 200 words per minute
        return $readingTimeMinutes;
    }

    public function getExcerpt(int $length): string {
        $excerpt = Str::words(strip_tags($this->content), $length);
        return $excerpt . (Str::length(strip_tags($this->content)) > $length ? '...' : '');
    }

    public function getThumbnailImage() {
        $isUrl = filter_var($this->image, FILTER_VALIDATE_URL);
        return $isUrl ? $this->image : Storage::disk('public')->url($this->image);
    }
}

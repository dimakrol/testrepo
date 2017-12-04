<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\Playlist
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Playlist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Playlist extends Model
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = ['name', 'display'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function videos()
    {
        return $this->belongsToMany(Video::class)->withPivot('order');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Channel
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 * @method static \Illuminate\Database\Query\Builder|\App\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Channel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Channel whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Channel whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Channel whereUpdatedAt($value)
 */
class Channel extends \Eloquent
{
  public function getRouteKeyName() {
    return 'slug';
  }

  public function threads(){
    return $this->hasMany(Thread::class);
  }

}

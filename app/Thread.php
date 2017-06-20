<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Thread
 *
 * @property int $id
 * @property int $user_id
 * @property int $channel_id
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Channel $channel
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @method static \Illuminate\Database\Query\Builder|\App\Thread filter($filters)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereChannelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Thread whereUserId($value)
 * @mixin \Eloquent
 */
class Thread extends \Eloquent
{


  protected $guarded = [];

  /**
   * @return string
   */
  public function path(){
    return "/threads/{$this->channel->slug}/$this->id";
  }

  /**
   * @param string $column
   * @return $this
   */
  public function latestAttribute($column = 'created_at')
  {
		return $this->orderBy($column, 'desc');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function replies(){
    return $this->hasMany(Reply::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function channel(){
    return $this->belongsTo(Channel::class);
  }


  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function creator(){
    return $this->belongsTo(User::class,'user_id');
  }

  /**
   * @param $reply
   */
  public function addReply($reply){
	$this->replies()->create($reply);
  }

  /**
   * @param $query
   * @param $filters
   * @return mixed
   */
  public function scopeFilter($query, $filters){
    return $filters->apply($query);
  }
}

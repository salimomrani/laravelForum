<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reply
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereThreadId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reply whereUserId($value)
 * @mixin \Eloquent
 */
class Reply extends \Eloquent
{

  protected $guarded = [];


	public function owner(){
	  return $this->belongsTo(User::class,'user_id');
	}
}

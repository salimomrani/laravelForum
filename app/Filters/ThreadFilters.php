<?php
/**
 * Created by PhpStorm.
 * User: salim
 * Date: 10/06/17
 * Time: 23:54
 */

namespace App\Filters;


use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters {


  protected $fulters = ['by'];

  /**
   *
   * Filter the query by a given username
   *
   *
   * @param string $username
   * @return mixed
   */
  public function by($username) {
	$user = User::where('name', $username)->firstOrFail();
	return $this->builder->where('user_id', $user->id);
  }
}
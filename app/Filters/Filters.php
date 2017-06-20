<?php
/**
 * Created by PhpStorm.
 * User: salim
 * Date: 18/06/17
 * Time: 23:46
 */

namespace app\Filters;


use Illuminate\Http\Request;

abstract class Filters {
  /**
   * @var \Request
   */
  protected $request,$builder;

  protected $filters = [];

  /**
   * ThreadFilters constructor.
   * @param \Illuminate\Http\Request $request
   */
  public function __construct(Request $request) {
	$this->request = $request;
  }

  public function apply($builder) {

	$this->builder = $builder;
	foreach ($this->getFilters() as $filter=>$value){
	  if (method_exists($this,$filter)){
	    $this->$filter($value);
	  }
	  if (!$this->hasFilter($filter)) return;
	  $this->filters($this->request->$filter);

	}
	if ($this->request->has('by')) {
	  return $this->by($this->request->by);
	}
	return $this->builder;
  }

  public function getFilters(){
    return $this->request->intersect($this->filters);
  }


}
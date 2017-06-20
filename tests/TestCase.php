<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
  use CreatesApplication;

  protected $oldExceptionHandler;

  protected function setUp() {
	  parent::setUp(); // TODO: Change the autogenerated stub
	  $this->disableExceptionHandling();
	}

  /**
   * @param null $user
   * @return $this
   */
  protected function signIn($user = NULL) {
	$user = $user ?: create(User::class);

	$this->actingAs($user);

	return $this;
  }


  protected function disableExceptionHandling(){
    $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

    $this->app->instance(ExceptionHandler::class,new class extends Handler{
      public function __construct() {}
      public function report(Exception $exception) {}
      public function render($request, Exception $exception) {
		throw ($exception); // TODO: Change the autogenerated stub
	  }
	});
  }

  protected function withExceptionHandling(){
    $this->app->instance(ExceptionHandler::class,$this->oldExceptionHandler);

    return $this;
  }

}
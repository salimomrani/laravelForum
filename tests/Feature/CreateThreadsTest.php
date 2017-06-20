<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase {

  use DatabaseMigrations;


  /**
   * @test
   * un utilisateur non auth ne peut pas crée un sujet
   */
  function guest_may_not_create_threads() {
	$this->withExceptionHandling();

	  $this->get('/threads/create')
	  ->assertRedirect('/login');

	$this->post('/threads')
	  ->assertRedirect('/login');


  }


  /**
   * @test
   */
  function an_authenticated_user_can_see_the_create_form() {
	$this->signIn();
	$this->get('/threads/create')
	  ->assertSee('Create a New thread');
  }


  /**
   * @test
   * un auth user peut crée un sujet
   */
  function an_authenticated_user_can_create_a_new_forum_threads() {

    $this->signIn();
	$thread = make(Thread::class);

	$response = $this->post('/threads', $thread->toArray());
	$this->get($response->headers->get('Location'))
	  ->assertSee($thread->title)
	  ->assertSee($thread->body);
  }

  /**
   * @test
   */
  function a_thread_requires_a_title() {
	$this->publishThread(['title'=>null])
	  ->assertSessionHasErrors('title');
  }

  /**
   * @test
   */
  function a_thread_requires_a_body() {
	$this->publishThread(['body'=>null])
	  ->assertSessionHasErrors('body');
  }

  /**
   * @test
   */
  function a_thread_requires_a_valide_channel() {
    factory(Channel::class,2)->create();
	$this->publishThread(['channel_id'=>null])
	  ->assertSessionHasErrors('channel_id');

	$this->publishThread(['channel_id'=>999])
	  ->assertSessionHasErrors('channel_id');
  }


  public function publishThread($overrides = []){
	$this->withExceptionHandling()->signIn();
	$thread = make(Thread::class,$overrides);
	return $this->post('/threads',$thread->toArray());
  }


}

<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase {

  use DatabaseMigrations;


  /**
   * @test
   * un utilisateur non authentifier ne peut pas poster une reponse
   */
  function unauthenticated_users_may_not_add_replies() {
	$this->withExceptionHandling()
	  ->post('/threads/channel/1/replies',[])
	  ->assertRedirect('login');
    }
  /**
   * @test
   * un auth user peut poster une reponse
   */
  function an_authenticated_user_may_participate_in_forum_threads() {

    	$this->signIn();

    	$thread = create(Thread::class);

    	$reply= make(Reply::class);

    	$this->post($thread->path().'/replies',$reply->toArray());

    	$this->get($thread->path())->assertSee($reply->body);

  }

  /**
   * @test
   */
  function a_reply_requires_a_body() {
	$this->publishThread(['body'=>null])
	  ->assertSessionHasErrors('body');
  }

  public function publishThread($overrides = []){
	$this->withExceptionHandling()->signIn();
	$reply= make(Reply::class,$overrides);
	$thread = create(Thread::class);
	return $this->post($thread->path().'/replies',$reply->toArray());

  }


}

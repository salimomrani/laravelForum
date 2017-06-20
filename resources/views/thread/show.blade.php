@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="">{{$thread->creator->name}}</a> posted: {{$thread->title}}</div>

                    <div class="panel-body">
                        <article>
                            <h4>{{$thread->title}}</h4>
                            <div class="body">{{$thread->body}}</div>
                        </article>
                        <hr>
                    </div>
                </div>
                @foreach($thread->replies as $reply)
                    @include('thread.reply')
                @endforeach

                @if(auth()->check())
                    <form action="{{ route('add_reply', [$thread->channel->slug,$thread->id])}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" cols="30" rows="5" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
            </div>
            @else
                <p class="text-center">Please <a href="{{route('login')}}">sign in </a> to participate in this discussion</p>
            @endif

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">

                    <div class="panel-body">
                        <p>This thread was published {{$thread->created_at->diffForHumans()}} by
                            <a href="#">{{$thread->creator()->name}}</a>, and currently has {{$thread->replies->count()}} comments.</p>
                    </div>
                </div>

            </div>
            </div>
        </div>


@endsection

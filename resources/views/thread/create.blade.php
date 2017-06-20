@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New thread</div>

                    <div class="panel-body">
                        <form action="{{route("store_thread")}}" method="post">
                            {{csrf_field()}}
                            <label for="channel_id">Choose a channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose One</option>
                                @foreach($channels as $channel)
                                <option value="{{$channel->id}}" {{old("channel_id")==$channel->id? 'selected':''}}>{{$channel->name}}</option>
                                    @endforeach
                            </select>
                            <div class="form-group">
                                <label for="title">Title:</label><input type="text" name="title" id="title"
                                                                        class="form-control" required value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label for="body">Body:</label><textarea name="body" id="body" cols="30" rows="10"
                                                                         class="form-control" required>{{old('body')}}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
<div id="container" class="">
    <div id="cell cellLeft"></div>

    <div id="cell cellCenter">
        <div class="friendsDiv justify-content-center">
            <form method="post" action="{{ url('/userSubmit') }}" class="form-group row justify-content-center" id="userForm">
                {{ csrf_field() }}
                <div class="col-sm-10">
                    <input type="text" placeholder="Steam Username" id="userInput" class="form-control" name="username"><br>
                    <input type="submit" class="form-control" value="submit">
                </div>
            </form>
        </div>

        <div id="friendsList">
            @isset($friendsData)
                @if(count($friendsData) > 0)
                    @foreach($friendsData as $friendData)
                        <div class="friendContainer">
                            <img src="{{$friendData["avatar"]}}" height="32" width="32">
                            {{$friendData["personaname"]}}
                        </div>
                    @endforeach
                @endif
            @endisset
        </div>
    
    </div>

    <div id="cell cellRight"></div>
</div>
@endsection
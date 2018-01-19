@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="media">
                        <div class="media-left">
                            <img class="media-object"
                                src="https://www.arcgis.com/sharing/rest/community/users/{{Auth::user()->name}}/info/{{$details->thumbnail}}" />
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{$details->fullName}}</h4>
                            <p>
                                <ul class="list-unstyled">
                                    <li>Username: {{Auth::user()->name}}</li>
                                    <li>Email: {{Auth::user()->email}}</li>
                                    <li>Role: {{$details->role}}</li>
                                    <li>Level: {{$details->level}}</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

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

                    @if ($if_exist)
                        <h4>Hello, welcome back!</h4>
                    @else
                        <h4>We already created a new ID for you!</h4>
                    @endif

                    <h5> You are logged in! </h5><br>

                    @foreach ($athlete as $k=>$v)
                        @if (is_array($v))
                            @continue
                        @endif
                            <li><b>{{ $k }}</b> : {{ $v }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

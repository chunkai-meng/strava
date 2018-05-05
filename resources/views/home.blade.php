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

                    You are logged in!
                    <br>

                    <?php
                        echo "<h3>Token :</h3>" . $token . "<br>";
                        echo "<h4>Name: </h4>" . $username . "<br>";
                        echo "<h4>Email: </h4>" . $email . "<br>";
                        echo "<h4>City: </h4>" . $city . "<br>";
                        echo "<h4>Country: </h4>" . $country . "<br>";
                        echo "<h4>Create At: </h4>" . $created_at . "<br>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

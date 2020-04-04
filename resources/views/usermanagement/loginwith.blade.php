@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login User with username/email/both</div>
            <div class="card-body">
                    <div class="input-group">
                    
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <form method="POST" action="{{ route('saveuserloginwith') }}">
                        @csrf
                        <input type="radio" name ="userloginwith" @if( $loginwith[0]->login_with == "username") checked ="checked" @endif id="username" value="username" aria-label="Radio button for following text input">Username<br>
                        <input type="radio" name ="userloginwith" @if( $loginwith[0]->login_with == "email") checked ="checked" @endif id="email"  value="email" aria-label="Radio button for following text input">Email<br>
                        <input type="radio" name ="userloginwith" @if( $loginwith[0]->login_with == "both") checked ="checked" @endif id="both" value="both" aria-label="Radio button for following text input">Both<br>
                        <input class="btn btn-primary" type="submit" value="Submit">
                        </div>
                        </form>
                    </div>
                    
                    </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
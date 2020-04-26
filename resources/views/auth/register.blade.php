@extends('layouts.app')

@section('content')
<div class="container">
@if ($message = Session::get('error'))

<div class="alert alert-danger alert-block">

    <button type="button" class="close" data-dismiss="alert">×</button>

    <strong>{{ $message }}</strong>

</div>

@endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="register_users_form">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{__('UserName')}}</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{old('username')}}" required autocomplete="username">
                            
                            @error("username")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            </div>
                        
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Assign Roles') }}</label>

                            <div class="col-md-6">
                                <div class="selectBox" onclick="showCheckboxes()" >
                                    <select  type="text" class="form-control @error('roles') is-invalid @enderror " required autofocus>
                                        <option value="">Select Roles</option>                                          
                                    </select>
                                     @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    <div class="overSelect "> </div>
                                
                                </div>
                                <div id="checkboxes">
                                    <input id="roles" hidden type="text" name="roles"  required autofocus />
                                    @if(count($roles)>0)
                                    @foreach($roles as $role)
                                    <label class="check_label" for="{{$role}}"  ><input type="checkbox"  id="{{$role}}" class="role_checks"/> {{$role}} </label>

                                @endforeach
                                
                                @endif
                                </div>
                               
                            </div>

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="register();">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>

.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes label {
  display: block;
  margin-left:12px;
}

#checkboxes input {
    margin-right: 11px;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

</style>


<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
<script type="text/javascript" >
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }

  
}

function register(){
    var selected_roles = new Array();
    $("input.role_checks[type=checkbox]:checked").each(function () {
        selected_roles.push($(this).attr('id'));
      
    }); 

    $('#roles').val(selected_roles);
  
    $('#register_users_form').submit();

}


$(document).ready(function() {
    
    console.log("in reafy state");


});



</script>
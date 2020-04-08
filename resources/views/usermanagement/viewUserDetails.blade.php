@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">  {{ __('User Details') }}</div>

                <div class="card-body">


                    <form method="POST" action="{{ route('editUser')}}" id="editUserDetailsForm">
                        @csrf

						<div class="form-group row">
                            <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('ID') }}</label>
                            
                            <div class="col-md-6">
                                <input id="id" readonly type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{empty($res_user->id)? old('id') : $res_user->id }}" required autocomplete="id" autofocus >

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('UserName') }}</label>
                            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{empty($res_user->username)? old('name') : $res_user->username }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value=" {{empty($res_user->email) ?  old('email')  : $res_user->email }}" required autocomplete="email">

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
                            <div class="selectBox" onclick="showCheckboxes()" class="form-control @if($errors->has('roles') == 1) is-invalid @endif">
                                <select  type="text" class="form-control" required autofocus>
                                    <option value="">Select Roles</option>                                          
                                </select>
                                <div class="overSelect"> 
                                </div>

                                
                            </div>
                            <div id="checkboxes">
                                <input id="roles" hidden type="text" name="roles"  required autofocus />
                                @if(count($allRoles)>0)
                                @foreach($allRoles as $role)
                                <label class="check_label" for="{{$role}}"  ><input type="checkbox"  id="{{$role}}" class="role_checks" value="{{$role}}" @if(strpos( $selectedRoles, $role) || strpos($selectedRoles, $role) === 0 || (is_array(old($role) ) && in_array($role, old($role) ))) checked @endif/> {{$role}} </label>

                                @endforeach
                                
                                @endif
                            </div>
                            @if($errors->has('roles') == 1)
                            <span class="text-danger" role="alert">
                                 <strong>{{ $errors->first('roles') }}</strong>
                            </span>
                            @enderror
                            
                        </div>
                    </div>
                    
                  <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            
                                <button type="button" onclick="save();" class="btn btn-primary">
                                   {{ __('Save') }}
                                </button>
                                <a href="/manageusers" class="btn btn-outline-danger float-center " >Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

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

function save(){
    var selected_roles = new Array();
    $("input.role_checks[type=checkbox]:checked").each(function () {
        selected_roles.push($(this).attr('id'));
      
    }); 

    $('#roles').val(selected_roles);
  
    $('#editUserDetailsForm').submit();

}

</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users List</div>

                <div class="card-body">
					@if(count($users)>0)
				 <table class="table table-striped">
					
						<tr>
						<th>users</th>
						<th>roles</th>
						<th colspan=2>Options</th>
						</tr>
				  @foreach($users as $user=> $roles)
						<tr>
						<td>{{$user}}</td>
						<td>{{$roles}}</td>	
						<td><a href="#" onclick="edit('{{$user}}','{{$roles}}');" class="btn btn-outline-danger float-center " >Edit User</a></td>	
						<td>
						{!!Form::open(['action' => ['ManageUsers@destroy', $user],'method'=>'POST', 'class' => 'pull-right' ])!!}
	
	{{Form::hidden('_method','DELETE')}}
	{{Form::submit('Delete',['class'=>'btn btn-outline-danger float-center'])}}
	
	{!!Form::close()!!}
	
						</td>				
					
						</tr>
						
				
				  @endforeach	
				  </table>
				  @else
					  <p>You dont have any posts</p>
				  @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form name="editUser" id="editUser" action="{{ route('edit') }}" method="POST">
@csrf
	<input type='hidden' id='userName' name='userName'>
	<input type='hidden' id='userRoles' name='userRoles'>

</form>
@endsection

@section('script')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
<script type="text/javascript" >

function edit(username, roles){

	console.log("usrname is "+username+" roles are "+roles );
	document.getElementById('userName').value = username;
	document.getElementById('userRoles').value = roles;
	document.editUser.submit();


}


</script>

@endsection

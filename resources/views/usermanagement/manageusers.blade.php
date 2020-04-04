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
				  @foreach($users as $user)
				  
						<tr>
						<td>{{$user->name}}</td>
						<td>{{$user->roles}}</td>
						
						
						
						<td><a href="/manageusers/{{$user->id}}/edit" class="btn btn-outline-danger float-center " >Edit User</a></td>
						<td>
						{!!Form::open(['action' => ['ManageUsers@destroy', $user->id],'method'=>'POST', 'class' => 'pull-right' ])!!}
	
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
@endsection

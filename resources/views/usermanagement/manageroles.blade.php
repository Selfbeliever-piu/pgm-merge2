@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-11">
			<div id="error" class="alert alert-danger" style="display:none">

    			<button type="button" class="close" data-dismiss="alert">×</button>

    			<span id="error_message"></span>

			</div>
            <div class="card">
                <div class="card-header">Dashboard 
				<a href=""  onclick="" class=" allSave btn btn-outline-primary float-right col-md-3" >Save Roles</a>
				 <a href="" class="btn btn-outline-danger float-right col-md-3" onclick="return deleteRole();" >Delete Role</a> 
				   <a href="#" onclick="return addRow();"  class="btn btn-outline-primary float-right col-md-3 addRow" >Add New Role</a></div>
				

                <div class="card-body">
				  
					@php($count=1)  
				  @if(count($permissions)>0 && count($roles)>0)
					
						<table  id="tblPosts" class="table table-striped">
						<tr >
						<th><input  type="checkbox" id="all_Check" name="all_Check" value=""></th><th>Roles</th>@foreach($permissions as $permission)
						
							<th>{{$permission->permission}}</th>
							
						@endforeach 
						<td> </td>
						<td> </td>

						<td> </td>
						</tr>

						@foreach($roles as $role=> $role_permissions)
						<tr id="{{$role}}_row" @if(strcmp($role ,"superadmin") === 0 )style="background: #c8bfbf" @endif>
							@php($permission_count =1)
							
							<td class="selected_row">@if(strcmp($role ,"superadmin") !== 0)<input type="checkbox" class="created_roles"  id="{{$count}}" name="{{$count}}" value ="{{$role}} " @if(strcmp($role ,"superadmin") === 0) disabled @endif  >@endif</td>
							

							<td class= "rolename" style=" text-align: center; vertical-align: middle;" ><span id="role_name_{{$count}}" name="role_name_{{$count}} " @if(strcmp($role ,"superadmin") === 0) disabled @endif >{{$role}}</span></td> 
							
							@foreach($permissions as $permission)
							<td class="role_permissions" contenteditable ='true' style=" text-align: center; "><input type="checkbox"  value="" id="permission_{{$count}}_{{$permission_count}}" name="permission_{{$count}}_{{$permission_count}}" class="form-check-input"  @if(strpos( $role_permissions, $permission->permission) || strpos($role_permissions, $permission->permission) === 0  ) checked @endif @if(strcmp($role ,"superadmin") === 0) disabled @endif></td>
							@php($permission_count++)
							@endforeach
							@if(strcmp($role ,"superadmin") !== 0)
							<td id="edittd"   ><a href="" class="editlink"  >edit</a></td>
							<td id="saveChanges"><a href=""  class="savelink" >save</a></td>
							<td id="deleteRole" ><a href="" class="deletelink" >delete</a></td>
							@else
							<td></td> 
							<td></td> 
							<td></td> 
							@endif
							@php($count++)
						</tr>

						@endforeach
					
					</table>

				  
				  @else
					  <p>You dont have any roles or permissions</p>
				  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript" >

function addRow(){
	var rows= $('#tblPosts tbody .created_roles').length;

	rows+=2;
	console.log("lenght of row "+rows);

	var count=1;


var tr = '<tr id="new_row">'+
	'<td class="selected_row">'+
		'<input type="checkbox" id="'+rows+'" name="" class="created_roles" >'+
	'</td>'+
	'<td class= "rolename" style=" text-align: center; vertical-align: middle;">'+
		'<input type="input" class="editable" id="text_role_name_'+rows+'" name=" ">'+
	'</td>'+
	'@php($permission_count =1)'+
	'@foreach($permissions as $permission)'+
	
	'<td class="role_permissions" style=" text-align: center; vertical-align: middle;">'+
		'<input type="checkbox" id="permission_'+rows+'_{{$permission_count}}" name="permission_'+rows+'_{{$permission_count}}"  value="" >'+
	'</td>'
	+'@php($permission_count++)'
	+'@endforeach'+
	'<td id="edittd"><a href="" class="editlink" >edit</a></td>'+
							'<td id="saveChanges"><a href=""  class="savelink">save</a></td>'+
							'<td id="deleteChanges"><a href=""  class="deletelink">delete</a></td>'+
'</tr>';


$('tbody').append(tr);
}				


// function to save or update the roles in DB.
function save(edit){

	var previous_values={};

	var selected = new Array();
	var selected_id = new Array();
	var newUsersData = new Array(); 

	if(edit!=null){
		// execute on click event of inline save link
		previous_values[edit] = document.getElementById(edit).value ;
		selected_id.push(edit);
		selected.push(document.getElementById('text_role_name_'+edit).value);
	}
	else{
		//execute on click event of save button for multi-selected row
		$("#tblPosts input.created_roles[type=checkbox]:checked").each(function () {
			previous_values[this.id] = document.getElementById(this.id).value ;
			//check for empty role value input
			if(typeof document.getElementById('text_role_name_'+this.id)!== 'undefined' && document.getElementById('text_role_name_'+this.id)!== null){
				this.value = document.getElementById('text_role_name_'+this.id).value;
				if(this.value){
					selected_id.push(this.id);
					selected.push(this.value);
				}
			}
	});
	}
	
	// check for permissions of every selected roles
	
	for (i=0; i<selected.length; i++) {
		
		let role_permissions = new Array();

		if(document.getElementById('permission_'+selected_id[i]+'_1').checked){
			role_permissions.push("create_client");
		}
		
		if(document.getElementById('permission_'+selected_id[i]+'_2').checked)
			role_permissions.push("create_project");
		
		if(document.getElementById('permission_'+selected_id[i]+'_3').checked) 
			role_permissions.push("create_task");
		
		if(document.getElementById('permission_'+selected_id[i]+'_4').checked) 
			role_permissions.push("create_contacts");

		role_permissions = role_permissions.join();
		
		if(role_permissions.length > 0){

			newUsersData.push({
			id: selected_id[i],
			previous_role: previous_values[selected_id[i]],
			role: selected[i],
			permissions: role_permissions
			
		});

		}else{
			var span_error = document.getElementById("error_message");
			span_error.textContent = "Please select atleast one Permission."
			$('#error').show();	
			return false;
		}

	}

	//ajax call to save new role or update role

	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

	$.ajax({
            url: "{{ route('saveRolePermissions') }}",
            type: 'POST',
            dataType: 'json',
            data:  JSON.stringify(newUsersData),
            success: function (data) {
       					location.reload(false);
   			 }
			
		});

		return false;
		

}






$(document).ready(function() {

//To keep superadmin role at top 
$('tr[id="superadmin_row"]').insertAfter('table tr:first');

//func exp for inline edit link

$('#tblPosts').on("click",".editlink",function() {

	$label = $(this).parent().siblings('.rolename').find('span');

	if($($label).length){
	var label = $label.attr('id');
	//added textbox after label to edit
	$label.after("<input type='text' class='editable' style='display:none' />"); 
	var textbox = $label.next();
	textbox[0].id ="text_"+label;
	textbox[0].name = "text_"+label;
	textbox.val($label.html());
	//hide label and show textbox
	$label.hide();
	$label.next().show();
	//enable checkboxes to edit 
	$per_label = $(this).parent().siblings('.role_permissions');
	$per_label.attr('contenteditable','false'); 
	
	}
		return false;
	 
});

// on click of save button

$('.allSave').click(function(){
	save();
	return false;
});

// on click event of inline save link

$('#tblPosts').on("click", ".savelink",function(){

	select_checkbox =  $(this).parent().siblings('.rolename').find('.editable');
	//check for the rolename empty or not
	if($(select_checkbox).val()){
	$selected_role = $(this).parent().siblings('.selected_row').children();
	var id = $selected_role.attr('id');	
	save(id); 
	}
	else{
		var span_error = document.getElementById("error_message");
			span_error.textContent = "Role Name can't be empty."
			$('#error').show();		
	}
	return false;
	
});

// on click event of inline delete link

$('#tblPosts').on("click",".deletelink",function(){
	$select_checkbox =  $(this).parent().siblings('.rolename').find('span');

	if($select_checkbox.html()){
		$selected_checkbox = $(this).parent().siblings('.selected_row').children();
		var id = $selected_checkbox.attr('id');
		deleteRole(id);
	}
	else{
		selected_row =  $(this).parent().parent();
		$(selected_row).remove();
		return false;

	}
	
});

// To select all checkboxes
$('#all_Check').change(function(){
	$(".created_roles").prop('checked', $(this).prop("checked"));
});

});


//function to delete roles from db

  function deleteRole(id){

	var selected = new Array();
	var selected_id = new Array();
	var rolesData = new Array();

	if(id){
		//if delete function called using inline delete link.
		selected_id.push(id);
		selected.push(document.getElementById(id).value);
		
	}
	else{
		// to delete multiple roles using delete button 	
		$("#tblPosts input.created_roles[type=checkbox]:checked").each(function () {

			if($(this).parent().parent().attr('id')!='new_row'){
				selected_id.push(this.id);
				selected.push(this.value);
			}
			else{
				//if user try to remove newly added row
				$(this).parent().parent().remove();
				
			}
		
	}); 
 
	}
	

// ajax call to delete roles

	if(selected.length>0){

		// create object of selected roles to delete
		for (i=0; i<selected.length; i++) {
		
		rolesData.push({
				id: selected_id[i],
				role: selected[i]			
			});
		}
	
	
	
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
	
		$.ajax({
				url: "{{ route('deleteRole') }}",
				type: 'POST',
				dataType: 'json',
				data: JSON.stringify(rolesData)
				
			});
	
	}
	else{
		return false;
	}

	
 }

        
    </script>
	 @endsection
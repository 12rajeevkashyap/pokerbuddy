@extends('layout.admins') 
@section('title', 'User List')
@section('content')

<div class="row">
</div>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    User Management List
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered" id="data">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Host Name
                            </th>
                            <th>
                             Rate
                            </th>
                            <th>
                                Messgae
                            </th>
                           
                            <th>
                                Delete
                            </th>
                        </tr>
                    </thead>
                    @if(!empty($users))
                    <tbody>
                        <?php $i=0;?>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{ ++$i }}
                            </td>
                            <td>
                                {{$user->first_name}} {{$user->last_name}}  
                            </td>
                           <td>
                                {{$user->rate}}
                            </td> 
                            <td>
                                {{$user->review_msg}}
                            </td>                            
                          <td><input type="button" name="Delete" delete_value='{{ $user->id }}' class="btn btn-danger delete_value" value="Delete"></td>
 
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
       
        <!-- END BORDERED TABLE -->
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){

$(".delete_value").click(function() {
  var delete_id = $(this).attr("delete_value");

 if(confirm("Are you sure you want to delete this data?"))
 {
  $.ajax({
     url: 'rating_delete',
     type: 'POST',
     data: {"_token": "{{ csrf_token() }}",delete_id:delete_id},
     success: function(response){
       alert("Data deleted Successfully");       
        location.reload();
    }
   });
  }
});

});
</script>

@endsection
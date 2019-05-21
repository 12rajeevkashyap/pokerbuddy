@extends('layout.admins') 
@section('title', 'User List')
@section('content')

<div class="row">
</div>
    <div class="col-md-12">
        <!-- BORDERED TABLE -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    User Queries
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
                                
                                Name
                            </th>
                            <th>
                                Email
                            </th>

                            <th>
                              
                                Message
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
                             
                              {{$user->email}} 
                            </td>
                            

                            <td>
                                {{$user->message}} 
                            </td>


                            <td>
                              
             <a class="action_an btn btn-danger delete_help"  delete_value="<?php echo $user->help_id ?>" delete_key="delete_key"   href="javascript:void(0)" >
                               <span class="dlt_icon">
                                        Delete
                                         </span>
                                  </a>                        
                                
                            </td>

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
$(".status").click(function() {

    // Assigning Variables to Form Fields
    var ad_value = 'help';
    var id = $(this).attr("title");
    var status = $(this).attr("title1");
   
 $.ajax({
     url: 'fetch_status',
     type: 'POST',
     data: {"_token": "{{ csrf_token() }}",id:id,status:status,ad_value:ad_value},
     success: function(response){
     location.reload();
    }
   });

});
});


$(document).ready(function(){
$(".delete_help").click(function() {

    var id = $(this).attr("delete_value"); 
if(confirm("Are you sure you want to delete this data?"))
 {  
 $.ajax({
     url: 'delete_help',
     type: 'POST',
     data: {"_token": "{{ csrf_token() }}",id:id},
     success: function(response){
     location.reload();
    }
   });
}
});

});



</script>

@endsection
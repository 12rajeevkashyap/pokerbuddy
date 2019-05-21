@extends('layout.admins') 
@section('title', 'User List')
@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'lert alert-success') }}">{{ Session::get('message') }}</p>
@endif
<div class="row">
</div>

    <div class="col-md-12">
        <!-- BORDERED TABLE -->
        <div class="panel">

            <div class="panel-heading">
                <h3 class="panel-title">
                    Newsletter List
                </h3>
                <form method="post" action="https://mobulous.app/pokkerbuddy/export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
    </form>
            </div>
           <!--  <div class="col-md-offset-10">
    <a href="{{url('admin/add_screen')}}"><input type="button" name="button" class=" btn btn-danger" value="add-button"></a> 
            </div> -->
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
                              Age
                            </th>
                             <th>
                              Gender
                            </th>
                              
                              <th>
                              city
                            </th>

                              <th>
                              Country
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
                         <?php echo $user->name;?>   
                            </td> 


                            <td>
                        <?php echo $user->email;?>
                               
                            </td>    
                         

                          <td>
                        <?php echo $user->age;?>
                               
                            </td>   

                          <td>
                        <?php echo $user->gender;?>
                            </td> 
                            
                             <td>
                        <?php echo $user->city;?>
                            </td> 

                            <td>
                        <?php echo $user->country;?>
                            </td> 

                    <!--         <td>
@if($user->status == 'Active')
<a class="action_an btn btn-danger ad"  title='{{$user->id}}' title1="<?php echo "Inactive" ?>" id="status" href="javascript:void(0)" >
                                    <span class="dlt_icon">
                                        <?php echo "Active" ?>
                                         </span>
                                        </a>
                                         @else
                                          <a class="action_an btn btn-success ad"  title='{{$user->id}}' title1="<?php echo "Active" ?>" id="status" href="javascript:void(0)" >
                                    <span class="dlt_icon">
                                        {{$user->status}}
                                         </span>
                                        </a>
                                      @endif
                            </td> -->
<!-- <td>
<a href="edit_ad/{{ $user->id }}"><input type="button" class=" btn btn-danger" name="button" value="Edit"></a>
</td> -->
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
// $(document).ready(function(){
// $(".ad").click(function() {
//     var id = $(this).attr("title");
//     var status = $(this).attr("title1");
//     var ad_value='ad';
//   $.ajax({
//      url: 'delete_newletter',
//      type: 'POST',
//      data: {"_token": "{{ csrf_token() }}",id:id,status:status,ad_value:ad_value},
//      success: function(response){
   
//         location.reload();
     
//     }
//    });
// });
// });
</script>


<script type="text/javascript">
$(document).ready(function(){
$(".delete_value").click(function() {
  var id = $(this).attr("delete_value");
 if(confirm("You want to delete data"))
 {
  $.ajax({
     url: 'delete_newletter',
     type: 'POST',
     data: {"_token": "{{ csrf_token() }}",id:id},
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
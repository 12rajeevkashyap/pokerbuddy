@extends('layout.admins') 
@section('title', 'User List')
@section('content')
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="row">
</div>
    <div class="col-md-12">
        <!-- BORDERED TABLE -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                   Report user
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
                                Reported By
                            </th>
                            
                            <th>
                                Reported To
                            </th>
                            <th>
                              Gender
                            </th>
                            <th>
                                Date    
                            </th>
                           
                           <th>Reason </th>

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
                  <!--         
                              <td><input type="button" name="Delete" delete_value='{{ $user->re_id }}' class="btn btn-danger delete_value" value="Report To"></td> -->
                          <td>
                          <button type="button" class="btn btn-info btn-lg reportto" report_value='{{ $user->reported_to }}' data-toggle="modal" data-target="#myModal">Report To </button>

               
                       </div>
                      </td>

                            <td>
                                {{$user->gender}}
                            </td>
                            <td>
                                {{date('d-m-Y',strtotime($user->created_at))}}
                            </td> 

                             <td>
                                {{$user->reason}}
                            </td> 

                              
    <td><input type="button" name="Delete" delete_value='{{ $user->re_id }}' class="btn btn-danger delete_value" value="Delete"></td>

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


  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content--> 
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button> 
          <h4 class="modal-title">Report To</h4>
        </div>
        <div class="modal-body">
          <p>Name: <span id="userName"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>




<script type="text/javascript">
$(document).ready(function(){
$(".delete_value").click(function() {
  var id = $(this).attr("delete_value");


 if(confirm("Are you sure you want to delete this data?"))
 {
  $.ajax({
     url: 'delete_report',
     type: 'POST',
     data: {"_token": "{{ csrf_token() }}",id:id},
     success: function(response){
       alert("Data deleted Successfully");       
        location.reload();
    }
   });
  }
});

/// report to//

$(".reportto").click(function() {
  var id = $(this).attr("report_value");

 $.ajax({
            type:'POST',
            url:'show_report',
            dataType: "json",
            data: {"_token": "{{ csrf_token() }}",id:id},
            success:function(data){
                if(data.status == 'ok'){
                    $('#userName').text(data.result[0].name);
                    $('.user-content').slideDown();
                }
                else{
                    $('.user-content').slideUp();
                    alert("User not found...");
                } 
            }
        });
     });

 });
</script>

@endsection
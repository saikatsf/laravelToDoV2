{{---------- For Links ----------}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <input type="hidden" value="{{ Auth::user()->id }}" id="hidden_user_id">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <button class="btn btn-info m-2" data-bs-toggle="modal" data-bs-target="#inputModal">Add New Task</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group col-md-6 m-2">
                    <label for="inputTask">Task</label>
                    <input type="text" class="form-control" id="inputTask" placeholder="Enter Task" required>
                    </div>
                    <div class="form-group col-md-4 m-2">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" class="form-control" required>
                        <option selected disabled>Choose...</option>
                        <option value="pending">Pending</option>
                        <option value="done">Done</option>
                    </select>
                    </div>
                    <div class="text-center m-2">
                    <button type="submit" id="addTask" name="addTask" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <div class="p-6 bg-white border-b border-gray-200 text-center">
        <h3>MY TASKS</h3>
    </div>
    <div class="container text-center">
        <table class="table table-striped table-boredered text-center">
           <thead>
               <th>Sl No.</th>
               <th>Task</th>
               <th>Status</th>
               <th>Change Status</th>
     
           </thead>
           <tbody id="tableBody">
           
           </tbody>
        </table>
     </div>
</x-app-layout>

<script>

    $(document).ready(function(){
         tableLoad();
    });

    function tableLoad(){
    
      var id = $('#hidden_user_id').val();
      $.ajax({
         url : 'getTable/'+id,
         type : 'get',
         dataType: 'json',

         success : function(response){
            var len = response['record'].length;
            $("#tableBody").empty();
            
            if(len > 0){
              for(var i=0; i<len; i++){
                 var id = response['record'][i].id;
                 var task = response['record'][i].task;
                 var status = response['record'][i].status;

                 var tr_str = "<tr>" +
                   "<td align='center'>" + (i+1) + "</td>" +
                   "<td align='center'>" + task + "</td>" +
                   "<td align='center'>" + status + "</td>" +
                   '<td><button class="btn btn-warning" onclick="changeStatus('+id+')">Change</button></td>' +
                 "</tr>";

                 $("#tableBody").append(tr_str);
              }
           }else{
              var tr_str = "<tr>" +
                  "<td align='center' colspan='4'>No record found.</td>" +
              "</tr>";

              $("#tableBody").append(tr_str);
           }
         }
      });
   }
   $('#addTask').click(function(){
      var task = $('#inputTask').val();
      var status = $('#inputStatus').val();

      $.ajax({
         url : 'http://127.0.0.1:8000/api/todo/add',
         type : 'post',
         headers: {
               APIKEY: 'helloatg'
         },
         data: {
            user_id : $('#hidden_user_id').val(),
            task : task,
            status : status,
         },
         success : function(response){
            alert(response["message"]);
            window.location.replace("/");            
         }
      });
      

   });

   function changeStatus(id) {
      $.ajax({
         url : 'http://127.0.0.1:8000/api/todo/status',
         type : 'post',
         headers: {
               APIKEY: 'helloatg'
         },
         data: {
            taskId : id,
         },
         success : function(response){
            alert(response["message"]);
            window.location ="/";
         }
      });
   }
</script>

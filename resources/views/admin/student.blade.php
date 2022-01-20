@extends('layouts.master')


@section('title')
    Student | QuanLySinhvien
@endsection

@section('search')
            <form>  
              @csrf
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" id="search" name="search" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
@endsection

@section('content')
<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              
                <h4 class="card-title">Student<button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#studentModal"><i class="now-ui-icons ui-1_simple-add"></i></button></h4>
            
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="studentTable" class="table">
                    <thead class=" text-primary">
                      <th>Frist Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      @foreach($students as $student)
                        <tr id="sid{{$student->id}}">
                          <td>{{$student->firstName}}</td>
                          <td>{{$student->lastName}}</td>
                          <td>{{$student->email}}</td>
                          <td>{{$student->phone}}</td>
                          <td>
                            <a href="javascript:void(0)" onclick="editStudent({{$student->id}})" class="btn btn-info">Edit</a>
                            <a href="javascript:void(0)" onclick="deleteStudent({{$student->id}})" class="btn btn-danger">Delete</a>  
                          </td>
                        </tr>      
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                  </div>
                  <div class="modal-body">
                    <form id="studentForm">
                      @csrf
                      <div class="from-group">
                        <label for="firstname">FirstName</label>
                        <input type="text" name="firstname" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="lastname">LastName</label>
                        <input type="text" name="lastname" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" />
                      </div>
                      <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>

          
<!-- Modal Edit-->
            <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                  </div>
                  <div class="modal-body">
                    <form id="studentEditForm">
                      @csrf
                      <input type="hidden" name="id" id="id"/>
                      <div class="from-group">
                        <label for="firstname">FirstName</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="lastname">LastName</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" />
                      </div>
                      <div class="from-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" />
                      </div>
                      <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
</div>

<!-- create   -->
        <script>
          $('#studentForm').submit(function(e){
            e.preventDefault();
            var firstname=$("input[name=firstname]").val();
            var lastname=$("input[name=lastname]").val();
            var email=$("input[name=email]").val();
            var phone=$("input[name=phone]").val();
            var _token=$("input[name=_token]").val();
            $('.modal-backdrop').remove();

            $.ajax({
              url:"{{route('student.add')}}",
              type:"POST",
              data:{
                firstname:firstname,
                lastname:lastname,
                email:email,
                phone:phone,
                _token:_token
              },
              success:function(response){
                console.log(response)
                $('#studentTable tbody').prepend('<tr><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td>'+phone+
                '</td><td>'+' <a href="javascript:void(0)" onclick="editStudent({{$student->id}})" class="btn btn-info">Edit</a>'+' <a href="javascript:void(0)" onclick="deleteStudent({{$student->id}})" class="btn btn-danger">Delete</a>'+'</td></tr>');
                $('#studentModal').modal('toggle');
                $('#studentForm')[0].reset();
                $('.modal-backdrop').remove();
              }
            })
          })
        </script>
<!-- update   -->
        <script>
          function editStudent(id){
            $.get('/students/'+id,function(student){
              $("#id").val(student.id);
              $("#firstname").val(student.firstName);
              $("#lastname").val(student.lastName);
              $("#email").val(student.email);
              $("#phone").val(student.phone);
              $("#studentEditModal").modal("toggle");
          
            });
          }
          $('#studentEditForm').submit(function(e){
            e.preventDefault();
            var id=$('#id').val();
            var firstname=$('#firstname').val();
            var lastname=$('#lastname').val();
            var email=$('#email').val();
            var phone=$('#phone').val();
            var _token=$("input[name=_token]").val();
            
            $.ajax({
              url:"{{route('student.update')}}",
              type:'PUT',
              data:{
                id:id,
                firstname:firstname,
                lastname:lastname,
                email:email,
                phone:phone,
                _token:_token,
               
              },
              success:function(response){
                $('#sid'+response.id+' td:nth-child(1)').text(response.firstname);
                $('#sid'+response.id+' td:nth-child(2)').text(response.lastname);
                $('#sid'+response.id+' td:nth-child(3)').text(response.email);
                $('#sid'+response.id+' td:nth-child(4)').text(response.phone);
                $("#studentEditModal").modal('toggle');
                $("#studentEditForm")[0].reset();
                // $('.modal-backdrop').remove();

              }
            });
          })
        </script>
<!-- Delete -->
        <script>
          function deleteStudent(id){
            if(confirm("Do you really want to delete this record?")){
              $.ajax({
                url:'/students/'+id,
                type:'DELETE',
                data:{
                  _token:$("input[name=_token]").val()
                },
                success:function(response){
                  $('#sid'+id).remove();
                }
              });
            }
          }
        </script>
<!-- Search -->
        <script>
          $('#search').on('keyup',function(){
            value=$(this).val();
          
            $.ajax({
              url:"{{route('student.search')}}",
              method:'POST',
              data:{
                'search':value,
                _token:$("input[name=_token]").val(),
              },
              success:function(response){
                console.log(response.data);
                const student =response.data
                   $('tbody').empty();
                   student.forEach((data,item)=>{
                    $('#studentTable tbody').append('<tr><td>'+data.firstName+'</td><td>'+data.lastName+'</td><td>'+data.email+'</td><td>'+data.phone+
                '</td><td>'+' <a href="javascript:void(0)" onclick="editStudent({{$student->id}})" class="btn btn-info">Edit</a>'+' <a href="javascript:void(0)" onclick="deleteStudent({{$student->id}})" class="btn btn-danger">Delete</a>'+'</td></tr>');
                   });
                 
                
                
              }   
            })
          });
      
          // $(document).ready(function(){
          //   fetch_data();
          //   function fetch_data(search = '')
          //   {
          //     $.ajax({
          //       url:"{{route('student.search')}}",
          //       method:'GET',
          //       data:{search:search},
          //       dataType:'json',
          //       success:function(response){
          //         $('tbody').html(response.table_data);
          //         $('#studentTable').text(response.total_data);
          //       }
          //     })
          //   }
          // });  
          // $(document).on('keyup','#seach',function(){
          //   var query=$(this).val();
          //   fetch_data(query);
          // });
        </script> 
        
@endsection

@section('scripts')


@endsection

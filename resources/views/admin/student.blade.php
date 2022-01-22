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
                      <th>Edit</th>
                      <th>Delete</th>
                    </thead>
                    <tbody>
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Create -->
          <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <!-- <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="now-ui-icons ui-1_simple-remove"></i></button> -->
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
                      <button id="#submit" class="btn btn-success">Submit</button>
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
                    <!-- <button type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="now-ui-icons ui-1_simple-remove"></i></button> -->
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
                      <button type="submit" class="btn btn-success">Update</button>
                    </form>
                  </div>
                </div>
              </div>
</div>

        
@endsection

@section('scripts')
<script>
  // databases student
var table=$('#studentTable').DataTable( {
            ajax:"{{route('student.getstudent')}}",
            columns: [
                { data: 'firstName' },
                { data: 'lastName' },
                { data: 'email' },
                { data: 'phone' },
                {
                  data:null,
                  render:function(data,type,row){
                    return `<button data-id="${row.id}" class="btn btn-info" id="edit"><i class="fa fa-edit"></i></button>`;
                  }
                },
                {
                  data:null,
                  render:function(data,type,row){
                    return `<button data-id="${row.id}" class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>`;
                  }
                },
            ]
        } );
// create student
  $(document).ready(function(){
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
                console.log(response);
                $('#studentForm')[0].reset();
                $('#studentModal').modal('hide');
                table.ajax.reload();
                $('.modal-backdrop').remove();
                
              }
            })
            
          })

          
  });
// find by id student
  $(document).on('click','#edit',function(){
  
    $.ajax({
       url:"{{route('student.getbyid')}}",
       type:"post",
       dataType:'json',
       data:{
        _token:$("input[name=_token]").val(),
        "id":$(this).data("id"),
       },
       success:function(response){
        console.log(response);
         $('input[name="id"]').val(response.data.id);
         $('input[name="firstname"]').val(response.data.firstName);
         $('input[name="lastname"]').val(response.data.lastName);
         $('input[name="email"]').val(response.data.email);
         $('input[name="phone"]').val(response.data.phone);
         $("#studentEditModal").modal("toggle");
       }
    });
  });
//update student
 $(document).ready(function(){
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
                console.log(response);
                $("#studentEditForm")[0].reset();
                $('#studentEditModal').modal("toggle");
                table.ajax.reload();
                $('.modal-backdrop').remove();
              }
            });
          });    
 });
 //delete student
$(document).on('click','#delete',function(){
  if(confirm("Do you really want to delete this record?")){
    var id=$(this).data("id");
    console.log(id);
              $.ajax({
                url:'/students/'+id,
                type:'DELETE',
                data:{
                  _token:$("input[name=_token]").val()
                },
                success:function(response){
                  table.ajax.reload();
                }
              });
            }
});

</script>

@endsection

@extends('layouts.master')

@section('title')
    Student | QuanLySinhvien
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
                    </thead>
                    <tbody>
                      @foreach($students as $student)
                        <tr>
                          <td>{{$student->firstName}}</td>
                          <td>{{$student->lastName}}</td>
                          <td>{{$student->email}}</td>
                          <td>{{$student->phone}}</td>
                        </tr>      
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Table on Plain Background</h4>
                <p class="category"> Here is a subtitle for this table</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        City
                      </th>
                      <th class="text-right">
                        Salary
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          Dakota Rice
                        </td>
                        <td>
                          Niger
                        </td>
                        <td>
                          Oud-Turnhout
                        </td>
                        <td class="text-right">
                          $36,738
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Minerva Hooper
                        </td>
                        <td>
                          Curaçao
                        </td>
                        <td>
                          Sinaai-Waas
                        </td>
                        <td class="text-right">
                          $23,789
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Sage Rodriguez
                        </td>
                        <td>
                          Netherlands
                        </td>
                        <td>
                          Baileux
                        </td>
                        <td class="text-right">
                          $56,142
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Philip Chaney
                        </td>
                        <td>
                          Korea, South
                        </td>
                        <td>
                          Overland Park
                        </td>
                        <td class="text-right">
                          $38,735
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Doris Greene
                        </td>
                        <td>
                          Malawi
                        </td>
                        <td>
                          Feldkirchen in Kärnten
                        </td>
                        <td class="text-right">
                          $63,542
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Mason Porter
                        </td>
                        <td>
                          Chile
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $78,615
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Jon Porter
                        </td>
                        <td>
                          Portugal
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $98,615
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Button trigger modal -->


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
        <script>
          $('#studentForm').submit(function(e){
            e.preventDefault();
            var firstname=$("input[name=firstname]").val();
            var lastname=$("input[name=lastname]").val();
            var email=$("input[name=email]").val();
            var phone=$("input[name=phone]").val();
            var _token=$("input[name=_token]").val();

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
                $('#studentTable tbody').prepend('<tr><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td>'+phone+'</td></tr>');
                $('#studentModal').modal('toggle');
                $('#studentForm')[0].reset();
                $('.modal-backdrop').remove();
              }
            })
          })
        </script>
       
@endsection

@section('scripts')


@endsection

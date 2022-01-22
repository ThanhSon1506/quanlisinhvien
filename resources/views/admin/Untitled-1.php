<!-- <tbody>
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
                    </tbody> -->



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
      
        </script> 
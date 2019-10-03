@extends('admin.layouts.master')

@section('page')
       DashBoard
    @endsection

@push('css')
    @endpush

@section('content')
  <div class="col-md-12">

      @if (Session::has('flash_message_error'))
          <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>{!! session('flash_message_error') !!}</strong>
          </div>
      @endif

      @if (Session::has('flash_message_success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>{!! session('flash_message_success') !!}</strong>
          </div>
      @endif

      <div class="panel panel-inverse">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <button type="button" class="btn btn-xs btn-primary" style="margin-right:5px" data-toggle="modal" data-target="#addpermission">Add Permission</button>
              </div>
              <h4 class="panel-title">Permission</h4>
          </div>
          <div class="panel-body">
              <table class="table table-bordered">
                  <thead>
                  <tr>
                      <th>Roll Name</th>
                      <th>User</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>{{ $user->type }}</td>
                      <td>{{ $user->uname }}--( {{ $user->email }} ) </td>
                      <td>
                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#editModal_{{ $user->id }}">Edit</button>
                      </td>
                    </tr>

                      <div class="modal fade" id="editModal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h5 class="modal-title" id="editModalLabel">Edit Branch</h5>
                              </div>
                              <form action="{{ url('/permission/insert') }}" method="post" id="branch">
                                  {{ csrf_field() }}
                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" name="role_id" required>
                                              <option {{  $user->type == "admin" ? "selected" : '' }} value="admin">Admin</option>
                                              <option {{  $user->type == "user" ? "selected" : '' }}  value="user">Accountant</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Branch</label>
                                          <select class="form-control" id="branch_id" name="branch_id"  required>
                                            <option>Select...</option>
                                            @foreach ($branches as $branch)
                                              <option {{  $user->branchid == $branch->id ? "selected" : '' }} value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name -- Email</label>
                                            <select class="form-control" name="user_id" id="user_id" required>
                                              @foreach(\App\User::where('branchid', $user->branchid)->get() as $bu )
                                              <option {{ $user->id == $bu->id ? "selected" : '' }} value="">{{ $bu->uname }}--{{ $bu->email }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>


  {{-- add Role modal --}}
  <div class="modal fade" id="addrole" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addModalLabel">Add Role</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="{{ url('/role/insert') }}" method="post">@csrf
                  <div class="modal-body">

                      <div class="form-group">
                          <label for="role_name" class="col-form-label">Add Role</label>
                          <input type="text" name="role_name" class="form-control"  required>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secendary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  {{-- add Role modal end --}}

  {{-- Add permission modal --}}
  <div class="modal fade" id="addpermission" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Permission</h5>
                </div>

              
              <form action="{{ url('/permission/insert') }}" method="post">@csrf
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Type</label>
                          <select class="form-control" name="role_id" required>
                            <option value="admin">Admin</option>
                            <option value="user">Accountant</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Branch</label>
                        <select class="form-control branch_id" name="branch_id"  required>
                          <option>Select...</option>
                          @foreach ($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Name -- Email</label>
                          <select class="form-control" name="user_id" id="addper_user_id" required>
                            <option>Select Branch</option>
                          </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secendary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
          </div>
      </div>
  </div>

@endsection

@push('js')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      
<script>
  $('.branch_id').on('change',function(e){
    var val = $('.branch_id').val();
    console.log(val);
      $.ajax({
        type:'POST',
        url:'/permission/getUser',
        data: {'bid':val, '_token': '<?php echo csrf_token() ?>'},
        success:function(data) {
        var html ='';
        $("#addper_user_id").empty();
        var returnedData = JSON.parse(data);
        if(returnedData.length==0){
          html = '<option>Users not found on this branch</option>';
        }else{
          for(var i =0;i < returnedData.length; i++){
            html += '<option value ="'+returnedData[i].id+'">'+returnedData[i].uname+'--'+returnedData[i].email+'</option>';
          }
        }
        $("#addper_user_id").append(html);
      }
    });
  });

</script>
@endpush

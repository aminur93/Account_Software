@extends('admin.layouts.master')

@section('page')
    Users
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Users</button>
                </div>
                <h4 class="panel-title">Users</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Branch Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Zip Code</th>
                        <th>City</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add User modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Users</h5>
                </div>
                <form action="{{ route('user.store') }}" method="post" id="users" enctype="multipart/form-data">@csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name" class="col-form-label">Branch Name:</label>
                                    <span class="text-danger">*</span>
                                    <select name="user_branch" id="user_branch" class="form-control">
                                        <option value="">Select Branch</option>
                                        @foreach($branch as $b)
                                            <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="user_email" class="form-control" id="user_email">
                                </div>

                                <div class="form-group">
                                    <label for="user_phone" class="col-form-label">Phone:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" name="user_phone" class="form-control" id="user_phone">
                                </div>

                                <div class="form-group">
                                    <label for="user_city" class="col-form-label">City:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_city" class="form-control" id="user_city">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_name" class="col-form-label">Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_name" class="form-control" id="user_name">
                                </div>

                                <div class="form-group">
                                    <label for="user_password" class="col-form-label">Password:</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" name="user_password" class="form-control" id="user_password">
                                </div>

                                <div class="form-group">
                                    <label for="user_address" class="col-form-label">Address:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_address" class="form-control" id="user_address">
                                </div>

                                <div class="form-group">
                                    <label for="user_zcode" class="col-form-label">Zip Code:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_zcode" class="form-control" id="user_zcode">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" name="image" class="form-control" id="user_image">
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

    <!--Edit User modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Users</h5>
                </div>
                <form action="{{ route('user.update') }}" method="post" id="user" enctype="multipart/form-data">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="u_id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name" class="col-form-label">Branch Name:</label>
                                    <span class="text-danger">*</span>
                                    <select name="user_branch" class="form-control" id="u_branch">
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="user_email" class="form-control" id="u_email">
                                </div>
                                <div class="form-group">
                                    <label for="user_phone" class="col-form-label">Phone:</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" name="user_phone" class="form-control" id="u_phone">
                                </div>
                                <div class="form-group">
                                    <label for="user_city" class="col-form-label">City:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_city" class="form-control" id="u_city">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_name" class="col-form-label">Name:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_name" class="form-control" id="u_name">
                                </div>
                                <div class="form-group">
                                    <label for="user_password" class="col-form-label">Password:</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" name="user_password" class="form-control" id="u_password">
                                </div>
                                <div class="form-group">
                                    <label for="user_address" class="col-form-label">Address:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_address" class="form-control" id="u_address">
                                </div>
                                <div class="form-group">
                                    <label for="user_zcode" class="col-form-label">Zip Code:</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="user_zcode" class="form-control" id="u_zcode">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" name="image" class="form-control" id="u_image">
                        </div>
                        <div id="showimage"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('js')
  <script>
      $(document).ready(function(){

          $('#data-table').DataTable({
              //reset auto order
              processing: true,
              responsive: true,
              serverSide: true,
              pagingType: "full_numbers",
              dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
              ajax: {
                  url: '{!!  route('user.getdata') !!}',
                  type: "GET",
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  }
              },
              columns: [

                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'branch_name', name: 'branch_name'},
                  {data: 'uname', name: 'uname'},
                  {data: 'email', name: 'email'},
                  {data: 'phone', name: 'phone'},
                  {data: 'address', name: 'address'},
                  {data: 'zip_code', name: 'zip_code'},
                  {data: 'city', name: 'city'},
                  {data: 'picture', name: 'picture'},
                  {data: 'action', name: 'action', orderable: false, searchable: false}
              ],
              buttons: [
                  {
                      extend: 'copy',
                      className: 'btn-sm btn-info',
                      exportOptions: {
                          columns: ':visible'
                      },
                      header: false
                  },
                  {
                      extend: 'csv',
                      className: 'btn-sm btn-success',
                      exportOptions: {
                          columns: ':visible'
                      },
                      header: false
                  },
                  {
                      extend: 'excel',
                      className: 'btn-sm btn-warning',
                      exportOptions: {
                          columns: ':visible'
                      },
                      header: false
                  },
                  {
                      extend: 'pdf',
                      className: 'btn-sm btn-primary',
                      exportOptions: {
                          columns: ':visible'
                      },
                      header: false
                  },
                  {
                      extend: 'print',
                      autoPrint: true,
                      className: 'btn-sm btn-default',
                      exportOptions: {
                          columns: ':visible'
                      },
                      header: false
                  }
              ]
          });
          
      });
  </script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ud = button.data('uid');
            var bn = button.data('branch_name');
            var branchId = button.data('bid');
            var un = button.data('uname');
            var ue = button.data('uemail');
            var up = button.data('uphone');
            var ua = button.data('uaddress');
            var zc = button.data('uzcode');
            var uc = button.data('ucity');
            var ui = button.data('uimage');
            var modal = $(this);

            modal.find('.modal-body #u_id').val(ud);
            modal.find('.modal-body #u_name').val(un);
            modal.find('.modal-body #u_email').val(ue);
            modal.find('.modal-body #u_phone').val(up);
            modal.find('.modal-body #u_address').val(ua);
            modal.find('.modal-body #u_zcode').val(zc);
            modal.find('.modal-body #u_city').val(uc);
            modal.find('.modal-body #u_branch').val(bn);

            $("#u_branch").html('');
            $("#u_branch").append("<option value='"+branchId+"'>"+bn+"</option>");

            $("#showimage").html('');
            $("#showimage").append("<img src='uimage/"+ui+"' width='50'>");
        })
    </script>

    <script>
        $(document).on('click','.deleteRecord', function(e){
            var id = $(this).attr('rel');
            var deleteFunction = $(this).attr('rel1');
            swal({
                    title: "Are You Sure?",
                    text: "You will not be able to recover this record again",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete It"

                },
                function(){
                    window.location.href="/user/"+deleteFunction+"/"+id;
                });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#users').validate({

                rules: {

                    user_branch: {
                        required: true
                    },
                    user_name: {
                        required: true
                    },
                    user_email: {
                        required: true,
                        email: true
                    },
                    user_password: {
                        required: true,
                        minlength:6,
                        maxlength:20
                    },
                    user_phone: {
                        required: true,
                        number: true
                    },
                    user_address: {
                        required: true
                    },
                    user_zcode: {
                        required: true
                    },
                    user_city: {
                        required: true
                    }
                },

                messages: {

                    user_branch: {
                        required: "<span class='text-danger'>This Branch field is Required</span>"
                    },
                    user_name: {
                        required: "<span class='text-danger'>This Name field is Required</span>"
                    },
                    user_email: {
                        required: "<span class='text-danger'>This Email field is Required</span>"
                    },
                    user_password: {
                        required: "<span class='text-danger'>This Password field is Required</span>"
                    },
                    user_phone: {
                        required: "<span class='text-danger'>This Phone field is Required</span>"
                    },
                    user_address: {
                        required: "<span class='text-danger'>This Address field is Required</span>"
                    },
                    user_zcode: {
                        required: "<span class='text-danger'>This Zip Code field is Required</span>"
                    },
                    user_city: {
                        required: "<span class='text-danger'>This City field is Required</span>"
                    },
                }

            });
        });
    </script>
    @endpush

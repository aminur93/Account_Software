@extends('admin.layouts.master')

@section('page')
  Sub Category
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Sub Category</button>
                </div>
                <h4 class="panel-title">Sub Category</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Sub Category Name</th>
                        <th>Category Name</th>
                        <th>Sqft</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Sub Category modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Sub Category</h5>
                </div>
                <form action="{{ url('/subcategory/store') }}" method="post" id="sub_category">@csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <span class="text-danger">*</span>
                            <button type="button" id="cat_add" class="btn btn-xs btn-primary" style="margin-bottom:4px;" data-toggle="modal" data-target="#exampleModa3"><span  class="fa fa-plus "></span></button>
                            <select class="form-control" name="categoryid">
                              <option value="">Select Category</option>
                              @foreach ($category as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Sub Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="sname" class="form-control" id="category_name">
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Square Fit:</label>
                            <span class="text-danger">*</span>
                            <input type="number" name="sqft" class="form-control" >
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

    <!--edit  Sub Category modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Sub Category Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('subcategory.update') }}" method="post" id="category">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="cat_id" id="cat_id" value="">
                          <div class="form-group">
                            <label for="category_name" class="col-form-label">Category</label>
                            <span class="text-danger">*</span>
                            <select class="form-control" name="categoryid" id="catName">
                              <option value="">Select Category</option>
                                @foreach ($category as $value)
                                    <option  value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory_name" class="col-form-label">Sub Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="sname" class="form-control" id="Subname">
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Square Fit:</label>
                            <span class="text-danger">*</span>
                            <input type="number" name="sqft" class="form-control" id="sqft">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- New Category Insert --}}
    <div class="modal fade" id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Catagory</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ url('/category/store') }}" method="post" id="newcategory">
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="subcategory_name" class="col-form-label">Category Name:</label>
                          <input type="text" name="category_name" class="form-control">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" onclick="window.location.reload(true);" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
            </div>
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
                    url: '{!!  route('subcategory.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sname', name: 'sname'},
                    {data: 'name', name: 'name'},
                    {data: 'sqft', name: 'sqft'},
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
            var sub_id = button.data('subcatid');
            var sub_name = button.data('sname');
            var c_name = button.data('cname');
            var s_sqfit = button.data('sqfit');
            var cid = button.data('catid');
            var c_id = button.data('c_id');
            var modal = $(this);

            modal.find('.modal-body #cat_id').val(sub_id);
            modal.find('.modal-body #Subname').val(sub_name);
            modal.find('.modal-body #catName').val(c_name);
            modal.find('.modal-body #sqft').val(s_sqfit);
            $("#catName").html('');
            $("#catName").append("<option value='"+c_id+"'>"+cid+"</option>");
        })
    </script>

        <script>
        $(document).ready(function () {
            $('#sub_category').validate({

                rules: {
                    sname: {
                        required: true
                    },
                    categoryid: {
                        required: true
                    },
                    sqft: {
                        required: true,
                        number : true
                    }
                },

                messages: {
                    sname: {
                        required: "<span class='text-danger'>This Sub Category field is Required</span>"
                    },
                    categoryid: {
                        required: "<span class='text-danger'>This Category field is Required</span>"
                    },
                    sqft: {
                        required: "<span class='text-danger'>This Sqft field is Required</span>"
                    }
                }
            });
        });
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
                    window.location.href="/subcategory/"+deleteFunction+"/"+id;
                });
        });

        $("#cat_add").click(function(){
          $("#addModal").hide();
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#newcategory').validate({

                rules: {
                    category_name: {
                        required: true
                    },
                    
                },

                messages: {
                    category_name: {
                        required: "<span class='text-danger'>This Category field is Required</span>"
                    },
                    
                }
            });
        });
    </script>
@endpush

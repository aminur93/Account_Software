@extends('admin.layouts.master')

@section('page')
    Category
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
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal">Add Category</button>
                </div>
                <h4 class="panel-title">Category</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Category Name</th>
                        <th>Category Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!--Add Category modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                </div>
                <form action="{{ route('category.store') }}" method="post" id="category">@csrf
                    <div class="modal-body">
                      <div class="form-group">
                          <label for="category_type" class="col-form-label">Type:</label>
                          <span class="text-danger">*</span>
                          <select class="form-control" name="type" id="type">
                            <option value="">Select One</option>
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                            <option value="item">Item</option>
                            <option value="other">Other</option>
                          </select>
                      </div>
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="category_name" class="form-control" id="category_name" required>
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

    <!--edit Category modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                </div>
                <form action="{{ route('category.update') }}" method="post" id="category">
                    {{ csrf_field() }}
                    <div class="modal-body">

                      <div class="form-group">
                          <label for="category_name" class="col-form-label">Type:</label>
                          <span class="text-danger">*</span>
                            <select class="form-control" name="type" id="category_type">
                            </select>
                      </div>
                      @php
                         
                      @endphp
                        <input type="hidden" name="category_id" id="cat_id" value="">
                        <div class="form-group">
                            <label for="category_name" class="col-form-label">Category Name:</label>
                            <span class="text-danger">*</span>
                            <input type="text" name="category_name" class="form-control" id="category_name" required>
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
                    url: '{!!  route('category.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
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
            var cat_name = button.data('catname');
            var cat = button.data('catid');
            var type = button.data('type');        
            var modal = $(this);
            modal.find('.modal-body #category_name').val(cat_name);
            modal.find('.modal-body #cat_id').val(cat);
            modal.find('.modal-body #category_type').val(type);

            $("#category_type").html('');
            $("#category_type").append("<option value='"+type+"'>"+type+"</option>");
            console.log(type);
        });
        
    </script>

    <script>
        $(document).ready(function () {
            $('#category').validate({

                rules: {
                    category_name: {
                        required: true
                    },
                    type: {
                        required: true
                    }
                },

                messages: {
                    category_name: {
                        required: "<span class='text-danger'>This Category field is Required</span>"
                    },
                    type: {
                        required: "<span class='text-danger'>This Category Type field is Required</span>"
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
                    window.location.href="/category/"+deleteFunction+"/"+id;
                });
        });

    </script>
@endpush

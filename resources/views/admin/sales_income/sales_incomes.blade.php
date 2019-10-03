@extends('admin.layouts.master')

@section('page')
Seller Commission 
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
                    <a type="buttaon" class="btn btn-xs btn-primary" href="{{url('/seller/commission/insert')}}">Add Seller Commission</a>
                </div>
                <h4 class="panel-title">Seller Commission Table</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Seller</th>
                        <th>Branch</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Square fit</th>
                        <th>Total</th>
                        <th>Parcentage</th>
                        <th>Seller Commission</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


  <div class="container">
    <div class="row">
      <div class="col-md-12">
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
                        <div class="col-md-6">
                          <div class="modal-body">
                              <input type="hidden" name="cat_id" id="cat_id" value="">

                              <div class="form-group">
                                  <label for="subcategory_name" class="col-form-label">Sub Category Name:</label>
                                  <input type="text" name="sname" class="form-control" id="Subname">
                              </div>
                              <div class="form-group">
                                  <label for="category_name" class="col-form-label">Sqft:</label>
                                  <input type="text" name="sqft" class="form-control" id="sqft">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="modal-body">
                              <input type="hidden" name="cat_id" id="cat_id" value="">

                              <div class="form-group">
                                  <label for="subcategory_name" class="col-form-label">Sub Category Name:</label>
                                  <input type="text" name="sname" class="form-control" id="Subname">
                              </div>
                              <div class="form-group">
                                  <label for="category_name" class="col-form-label">Sqft:</label>
                                  <input type="text" name="sqft" class="form-control" id="sqft">
                              </div>
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
      </div>
    </div>
  </div>
<div class="container">
  <div class="row">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form class="" action="index.html" method="post">

    </form>
    </div>
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
                    url: '{{url('seller/commission/getdata')}}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex',   name: 'DT_RowIndex'},
                    {data: 'seller_name',   name:'seller_name'},
                    {data: 'branch_name',   name: 'branch_name'},
                    {data: 'name',          name: 'name'},
                    {data: 'sname',         name: 'sname'},
                    {data: 'square_fit',    name: 'square_fit'},
                    {data: 'total',         name: 'total'},
                    {data: 'parcentage',    name: 'parcentage'},
                    {data: 'seller_income', name: 'seller_income'},
                    {data: 'date',    name: 'date'},
                    {data: 'action',        name: 'action', orderable: false, searchable: false}
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
                    window.location.href="/saleincome/"+deleteFunction+"/"+id;
                });
        });

      

    </script>
@endpush

@extends('admin.layouts.master')

@section('page')
    Booking
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
                <a href="{{ route('booking.insert') }}" class="btn btn-xs btn-primary">Add Booking</a>
            </div>
            <h4 class="panel-title">Booking</h4>
        </div>
        <div class="panel-body">
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Booking No</th>
                    <th>Customer Name</th>
                    <th>Sales Person</th>
                    <th>Branch</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Square Fit</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
{{-- Get data for datatables --}}
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
                url: '{!!  route('booking.getdata') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'bno', name: 'bno'},
                {data: 'cus', name: 'cus'},
                {data: 'seller_name', name: 'seller_name'},
                {data: 'branch_name', name: 'branch_name'},
                {data: 'name', name: 'name'},
                {data: 'sname', name: 'sname'},
                {data: 'sqfit', name: 'sqfit'},
                {data: 'price', name: 'price'},
                {data: 'total_price', name: 'total_price'},
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

{{-- Script for delete --}}
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
            window.location.href="/booking/"+deleteFunction+"/"+id;
        });
    });

</script>

@endpush

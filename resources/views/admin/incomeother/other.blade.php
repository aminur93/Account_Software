@extends('admin.layouts.master')

@section('page')
    Other Income
    @stop

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
                    <a href="{{ route('other.create') }}" class="btn btn-xs btn-primary">Other Income</a>
                </div>
                <h4 class="panel-title">Other Income</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#Sl No</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Account</th>
                        <th>Source Name</th>
                        <th>Category</th>
                        <th>Branch</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @endsection

@push('js')
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
                    window.location.href="/other/"+deleteFunction+"/"+id;
                });
        });

    </script>
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
                    url: '{!!  route('other.getdata') !!}',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'account_name', name: 'account_name'},
                    {data: 'source_name', name: 'source_name'},
                    {data: 'name', name: 'name'},
                    {data: 'branch_name', name: 'branch_name'},
                    {data: 'payment_name', name: 'payment_name'},
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
    @endpush
@extends('admin.layouts.master')

@section('page')
    Vendor Payment Information
@endsection

@push('css')
    <style>
        .gg{
            text-align: right;
            margin-right: 30px;
        }
    </style>
@endpush

@section('content')
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="{{ route('vendorCreate.create') }}" class="btn btn-xs btn-primary">Add Vendor Payment</a>
                </div>
                <h4 class="panel-title">Vendor Payment Information</h4>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" id="vendor_id" value="{{ $vendor->id }}">
                <table id="data-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>category</th>
                        <th>Branch</th>
                        <th>Amount</th>
                        <th>Account</th>
                        <th>Payment</th>
                    </tr>
                    </thead>
                </table>
                <br>
                <div class="card">
                    <div class="card-body gg">
                        @foreach($vendor_total as $vt)
                            <p> <strong>Total Paid</strong> : Tk {{ $vt->sum }}  </p>
                            <hr style="width:20%; margin-right: -5px;">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){

            var vid = $("#vendor_id").val();
            //console.log(cid);

            $('#data-table').DataTable({
                //reset auto order
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "full_numbers",
                dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
                ajax: {
                    url: '{!!  route('vendorInfo.getVendorData') !!}?id='+vid,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date', name: 'date'},
                    {data: 'name', name: 'name'},
                    {data: 'branch_name', name: 'branch_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'account_name', name: 'account_name'},
                    {data: 'payment_name', name: 'payment_name'},
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
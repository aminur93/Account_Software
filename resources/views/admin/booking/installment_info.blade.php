@extends('admin.layouts.master')

@section('page')
    Customer Installment Information
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
                    <a href="{{ route('installment.insert') }}" class="btn btn-xs btn-primary">Add Installment</a>
                </div>
                <h4 class="panel-title">Customer Installment Information</h4>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" id="booking_id" value="{{ $book->id  }}">
                <table id="data-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Install Name</th>
                        <th>Install Date</th>
                        <th>Booking No</th>
                        <th>Payment</th>
                    </tr>
                    </thead>
                </table>
                <div class="card">
                    <div class="card-body gg">
                        <p> <strong>Total Payable</strong> : Tk {{ $bookings->total_price }}</p>
                        @foreach($booking as $bo)
                            <p> <strong>Total Paid</strong> : Tk {{ $bo->sum }}  </p>
                            <p> <strong>Total Due</strong> : Tk {{ $bookings->total_price -  $bo->sum }}</p>
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

            var bid = $("#booking_id").val();
            //console.log(cid);

            $('#data-table').DataTable({
                //reset auto order
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "full_numbers",
                dom: "<'row'<'col-sm-2'l><'col-sm-4'i><'col-sm-3 text-center'B><'col-sm-3'f>>tp",
                ajax: {
                    url: '{!!  route('bookingInfo.getdata') !!}?id='+bid,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'install_name', name: 'install_name'},
                    {data: 'install_date', name: 'install_date'},
                    {data: 'booking_no', name: 'booking_no'},
                    {data: 'payment', name: 'payment'}
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
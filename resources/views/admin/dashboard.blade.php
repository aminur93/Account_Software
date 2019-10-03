@extends('admin.layouts.master')

@section('page')
       DashBoard

    @endsection

@push('css')
    @endpush

@section('content')
       <!-- begin row -->

       <div class="row">
              <!-- begin col-3 -->
              <div class="col-md-3 col-sm-6">
                     <div class="widget widget-stats bg-green">
                            <div class="stats-icon"><i class="fa fa-money"></i></div>
                            <div class="stats-info">
                                   <h4>TOTAL INCOME</h4>
                                   <p>Tk {{ $total_income }} </p>
                            </div>
                            <div class="stats-link">
                                   <a href="{{ route('report.income') }}">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                     </div>
              </div>
              <!-- end col-3 -->
              <!-- begin col-3 -->
              <div class="col-md-3 col-sm-6">
                     <div class="widget widget-stats bg-red">
                            <div class="stats-icon"><i class="fa fa-money"></i></div>
                            <div class="stats-info">
                                   <h4>TOTAL EXPENSES</h4>
                                   <p>TK {{  $total_expenses }}</p>
                            </div>
                            <div class="stats-link">
                                   <a href="{{ route('report.sales') }}">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                     </div>
              </div>
              <!-- end col-3 -->
              <!-- begin col-3 -->
              <div class="col-md-3 col-sm-6">
                     <div class="widget widget-stats bg-purple">
                            <div class="stats-icon"><i class="fa fa-money"></i></div>
                            <div class="stats-info">
                                   <h4>PROFIT</h4>
                                   <p>Tk {{ $total_profit }}</p>
                            </div>
                            <div class="stats-link">
                                   <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                     </div>
              </div>
              <!-- end col-3 -->
              <!-- begin col-3 -->
              <div class="col-md-3 col-sm-6">
                     <div class="widget widget-stats bg-primary">
                            <div class="stats-icon"><i class="fa fa-users"></i></div>
                            <div class="stats-info">
                                   <h4>TOTAL CUSTOMER</h4>
                                   <p>{{ $total_customer }}</p>
                            </div>
                            <div class="stats-link">
                                   <a href="{{ route('customer.index') }}">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                     </div>
              </div>
              <!-- end col-3 -->
       </div>

       <div class="row">
           <div class="col-md-12">
            <div class="panel panel-inverse" >
                <div class="panel-heading">
                        <h4 class="panel-title"> Summary In Chart </h4>
                </div>

                <div class="panel-body">
                        {!!$pie->html() !!}
                </div>
            </div>
           </div>
       </div>


          <div class="row">
              <div class="col-md-6">
                <div class="panel panel-inverse" >
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title"> Latest Customer </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_customer as $item)
                                <tr>
                                    <td>{{$item->customer_name }}</td>
                                    <td>{{ $item->email }}</td>     
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="table-basic-2">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title"> Latest Booking </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th> Customer Name</th>
                                    <th> Booking Amount </th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    @foreach ($latest_booking as $item)
                                    <tr>
                                      <td> {{ $item->customer_name }}</td>
                                      <td> {{ $item->total_price }}</td>
                                      <td> {{ $item->booking_date }}</td>
                                    </tr>
                                    @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="table-basic-2">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title"> Account Balance </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th> Account Name</th>
                                    <th> Amount </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    @foreach ($accounts as $item)
                                    <tr>
                                      <td> {{ $item->account_name }}</td>
                                      <td> {{ $item->current_balance }}</td>
                                      
                                    </tr>
                                    @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
          </div>
      
          
       <!-- end row -->
       {!! Charts::scripts() !!}

{!! $pie->script() !!}

    @endsection

@push('js')

    @endpush

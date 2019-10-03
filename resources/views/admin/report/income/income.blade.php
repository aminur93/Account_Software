@extends('admin.layouts.master')

@section('page')
    Income Summary
@endsection

@push('css')

@endpush

@section('content')
<div class="panel panel-inverse">
    <div class="panel-heading">
        <form action="" method="GET" class="" id="filter_form" style="padding-top: 12px; padding-bottom: 0px;">
            <div class="row">
                <div class="form-group col-md-2">
                    <select class="form-control" required name="year_id">
                        <option value="">Select year</option>
                        @foreach($ins_years as $year)
                            <option {{  request()->has('year_id') != '' ? ( request()->year_id == $year->year ? 'selected' : "") : '' }} value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="customer_id">
                        <option value="">Select customer</option>
                        @foreach($customers as $cust)
                            <option {{  request()->has('customer_id') != '' ? ( request()->customer_id == $cust->id ? 'selected' : "") : '' }} value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="category_id">
                        <option value="">Select category</option>
                            @foreach($category as $cat)
                                <option {{  request()->has('category_id') != '' ? ( request()->category_id == $cat->id ? 'selected' : "") : '' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-default">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-body">
        <table id="data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    @for($monthNum=1; $monthNum<=12; $monthNum++)
                        @php
                            $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
                        @endphp
                        <th>{{ $monthName }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                    @foreach ($cat_month as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        @foreach($value as $v_key => $t_val)
                            @if(count($t_val) != 0)
                            <td>
                                @foreach($t_val as $v)
                                    <span> {{ $t_val[0]->total_payment }}</span>
                                @endforeach
                            </td>
                            @else
                            <td>
                                <span> 0</span>
                            </td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    @foreach ($cat_month_total as $key => $value)
                            <th>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach($value as $av)
                                    @php
                                        $sum += $av->all_m_total_payment;
                                    @endphp
                                @endforeach
                                <span>{{ $sum }}</span>
                            </th>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection


@push('js')

@endpush

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purbachol Builders Ltd</title>

	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="/assets/css/animate.min.css" rel="stylesheet" />
	<link href="/assets/css/style.min.css" rel="stylesheet" />

    <style>
        @media print{.content,.page-header-fixed,body{padding:0!important;margin:0!important}.header,.sidebar,.theme-panel{display:none!important}.invoice-company{border-bottom:1px solid #e2e7eb!important;margin-bottom:20px!important}.invoice .invoice-from,.invoice .invoice-to{float:left!important;display:inline!important;width:25%!important;margin:0!important}.invoice .invoice-date{float:right!important;margin:0!important;width:25%!important;display:inline!important;text-align:right!important}.invoice-header{margin:0!important;padding:0!important}.table-responsive{border:none!important;display:block!important;float:left!important;width:100%!important;margin-top:10px!important}.invoice-price{margin-top:20px!important;border:1px solid #e2e7eb!important;float:left!important;width:100%!important;display:block!important}.invoice .invoice-price .invoice-price-left,.invoice .invoice-price .invoice-price-right{display:block!important;float:left!important;width:75%!important}.invoice .invoice-price .invoice-price-right{width:25%!important}.invoice-price .invoice-price-right{text-align:right!important}.invoice-price .invoice-price-left .sub-price{float:left!important;display:block!important;margin-top:5px}.invoice-footer,.invoice-note{float:left!important;width:100%!important}}
    </style>
</head>
<body>

<div class="invoice">
    <div class="invoice-company">
        <span style="float:right;" class="hidden-print">
            <div id="editor"></div>
        <a href="{{ route('invoice',$installment->id) }}" class="btn btn-sm btn-success m-b-10" id="download"><i class="fa fa-download m-r-5"></i> Export as PDF</a>
        <a href="" onclick="window.print()" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>
        </span>
        Invoice
    </div>
    <div class="invoice-header">
        <span class="invoice-from">
            <small>from</small>
            <address class="m-t-5 m-b-5">
                <strong>Purbachol Builders Ltd.</strong><br />
                M.R Center,<br />
                House # 49,(9th Floor),<br />
                Road # 17,<br />
                Banani, Dhaka<br />
                +88 02 9822044
            </address>
        </span>
        <span class="invoice-to">
            <small>to</small>
            <address class="m-t-5 m-b-5">
                <strong>{{ $installment->customer_name }}</strong><br />
                {{ $installment->Address }}<br />
                {{ $installment->phone }}<br />
                {{ $installment->email }}<br />
            </address>
        </span>
        <div class="invoice-date">
            <small>INSTALLMENT DATE: {{ $installment->install_date }}</small>
            <div class="invoice-detail">
                Category: {{ $installment->name }}<br>
                Sub Category: {{ $installment->sname }}<br>
                Booking Type: {{ $installment->booking_type }}<br>
            </div>
        </div>
    </div>
    <div class="invoice-content">
        <div class="table-responsive">
            <table style="width:100%" class="table table-invoice">
                <thead>
                    <tr>
                        <th>Booking No</th>
                        <th>Installment Name</th>
                        <th>Square Fit</th>
                        <th>Total price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $installment->booking_no }}</td>
                        <td>{{ $installment->install_name }}</td>
                        <td>{{ $installment->square_fit }}</td>
                        <td>৳ {{ $installment->total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>Payment</small>
                        ৳ {{ $installment->payment }}
                    </div>
                </div>
            </div>
            <div class="invoice-price-right">
                <small>DUE</small> ৳ {{ $due }}
            </div>
        </div>
    </div>
    <br>
    <div class="invoice-note">
        * Thanks For Your Business.
    </div>
    <div class="invoice-footer text-muted">
        <br>
        <span style="float:left;">
            <p>---------------------------</p>
            Customer Signature
        </span>
        <span style="float:right;">
            <p>---------------------------</p>
            Accounts Signature
        </span>
    </div>
</div>

<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
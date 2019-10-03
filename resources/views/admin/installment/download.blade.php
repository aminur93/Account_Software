<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purbachol Builders Ltd</title>

</head>
<body>

<div class="invoice">
    <div class="invoice-company">
		<span style="font-weight:bold;">
			Invoice
        </span>
	</div>
	<br><br>
    <div class="invoice-header">
        <span style="float: left; width: 33.33%;" class="invoice-from">
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
        <span style="float: left;width:33%;" class="invoice-to">
            <p>to</p>
            <address class="m-t-5 m-b-5">
                <strong>{{ $installment->customer_name }}</strong><br />
                {{ $installment->Address }}<br />
                {{ $installment->phone }}<br />
                {{ $installment->email }}<br />
            </address>
        </span>
        <div style="float: left;width:33%;" class="invoice-date">
            <small>INSTALLMENT DATE: {{ $installment->install_date }}</small>
            <div class="invoice-detail">
                Category: {{ $installment->name }}<br>
                Sub Category: {{ $installment->sname }}<br>
                Booking Type: {{ $installment->booking_type }}<br>
            </div>
        </div>
	</div>
	<br><br><br><br><br><br><br><br><br>
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
                        <td><small> BDT </small {{ $installment->total }}</td>
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
                        <span>PAYMENT</span>
                        <small> BDT</small> {{ $installment->payment }}
                    </div>
                </div>
            </div>
            <div style="float:right;">
                <span>DUE </span><small> BDT</small> {{ $due }}
            </div>
        </div>
    </div>
    <br><br>
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

</body>
</html>
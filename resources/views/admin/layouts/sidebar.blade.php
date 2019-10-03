
<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                  @if(Auth::user()->image)
                      <a href=""><img src="/uimage/{{ Auth::user()->image }}" /></a>
                  @else
                    <img src="/assets/img/user-13.jpg" />
                  @endif
                </div>
                <div class="info">
                    @php
                      echo Auth::user()->uname;
                    @endphp

                    @if(Auth::user()->type=='admin')
                      <small>Super Admin</small>
                    @else
                      @php 
                          $name = \App\Branch::where('id', Auth::user()->branchId)->pluck('branch_name');
                      @endphp
                      <small>{{ $name[0] }} Branch</small>
                    @endif
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->

        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>

            <li class="has-sub active">
                <a href="{{ route('purbachol.dashboard') }}">
                    <i class="fa fa-laptop"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->type == 'admin')
              <li class="has-sub">
                  <a href="javascript:;">
                      <b class="caret pull-right"></b>
                      <i class="fa fa-users"></i>
                      <span>Users</span>
                  </a>

                  <ul class="sub-menu">
                      <li><a href="{{ route('user.index') }}">User</a></li>
                      <li><a href="{{ url('/permission') }}">Permission</a></li>
                  </ul>
              </li>
            @endif

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>Customer</span>
                </a>

                <ul class="sub-menu">
                    <li><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li><a href="{{ route('booking.index') }}">Booking</a></li>

                </ul>
            </li>

            <li>
                <a href="{{ route('vendor.index') }}"><i class="fa fa-industry"></i> <span>Vendor</span></a>

            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-align-left"></i>
                    <span>Income</span>
                </a>

                <ul class="sub-menu">
                    <li><a href="{{ route('installment.index') }}">Installment</a></li>
                  <li><a href="{{ route('other.index') }}">Others</a></li>
                </ul>
            </li>


            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-shopping-cart"></i>
                    <span>Expenses</span>
                </a>
                <ul class="sub-menu">

                    <li><a href="{{ url('/seller/commission') }}">Seller Commission</a></li>
                    <li><a href="{{ url('/customer/commision') }}">Booking Commission</a></li>
                    <li><a href="{{ route('vendorPayment.index') }}">Payment</a></li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-university"></i>
                    <span>Banking</span>
                </a>
                <ul class="sub-menu">

                    <li><a href="{{ route('account.index') }}">Account</a></li>
                    <li><a href="{{ route('transfer.index') }}">Transfer</a></li>
                    <li><a href="{{ url('/transaction') }}">Transaction</a></li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file"></i>
                    <span>Report</span>
                </a>
                <ul class="sub-menu">
                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            Income
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('report.income') }}">Income Summary</a></li>
                            <li><a href="{{ route('report.booking') }}">Booking Summary</a></li>
                            <li><a href="{{ route('report.other') }}">Others Income Summary</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            Expense
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('report.sales') }}">Sales Commission Summary</a></li>
                            <li><a href="{{ route('report.customer') }}">Booking Commission Summary</a></li>
                            <li><a href="{{ route('report.vendor') }}">Others Expense Summary</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="has-sub">
              <a href="javascript:;">
                  <b class="caret pull-right"></b>
                  <i class="fa fa-cog"></i>
                  <span>Settings</span>
              </a>

              <ul class="sub-menu">
                  <li><a href="{{ route('category.index') }}">Category</a></li>
                  <li><a href="{{url('/subcategory')}}">Sub-category</a></li>
                  <li><a href="{{ route('company.index') }}">Company</a></li>
                  <li><a href="{{ route('branch.index') }}">Branch Name</a></li>
                  <li><a href="{{ route('salesperson.index') }}">Sales-person</a></li>
                  <li><a href="{{ route('payment.index') }}">Payment Type</a></li>
              </ul>
            </li>

            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->

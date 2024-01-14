@extends('layouts.datatable')
@section('title', 'Dashboard')

@section('content')
<div class="row">
<div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Today's Sales</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($todays_sells, 2)}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      <div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">This Month Sales</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($this_month_sells, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      <div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">This Year Sales</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($this_year_sells, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      <div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Total Sales</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($total_sells, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      @can('dd')
      <div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Total Purchases</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($total_purchases, 2)}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      <div class="col-xl-3 mb-4 col-lg-3 col-12">
        <div class="card h-100">
            <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Total Profit</h5>
            </div>
            </div>
            <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-taka"></i></div>
                        <div class="card-info">
                            <h3 class="mb-0">{{ number_format($total_profit, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>
      @endcan
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
          <div class="card-title mb-0">
            <h5 class="mb-0">Cash Summary</h5>
          </div>
          <!-- </div> -->
        </div>
        <div class="card-body">
          <div class="col-12 mt-3">
            <table class="table datatable">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>NAME</th>
                  <th>CASH</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 0; $total_cash = 0;  @endphp
                @foreach($users as $user)
                @php $total_cash += $user->cash;  @endphp
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->cash }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
          <div class="card-title mb-0">
            <h5 class="mb-0">Due List</h5>
          </div>
          <!-- </div> -->
        </div>
        <div class="card-body">
          <div class="col-12 mt-3">
            <table class="table datatable">
              <thead>
                <tr>
                  <th>INVOICE ID</th>
                  <th>BILL</th>
                  <th>PAID</th>
                  <th>DUE</th>
                </tr>
              </thead>
              <tbody>
                @php $total_due = 0;  @endphp
                @foreach($due_lists as $row)

                @php 
                  $due_amount = ($row->total - $row->paid_amount);
                  $total_due += $due_amount;
                @endphp

                  <tr>
                    <td>{{ $row->invoice_uid }}</td>
                    <td>{{ $row->total }}</td>
                    <td>{{ $row->paid_amount }}</td>
                    <td>{{ $due_amount }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


</div>
@endsection

@section('script')
<script>
  $('.datatable').dataTable();
</script>
@endsection
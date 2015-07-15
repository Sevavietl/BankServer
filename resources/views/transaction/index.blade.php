@extends('layout.main')

@section('head')
@parent

<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/transactions.js') }}"></script>
@stop

@section('content')
	<div class="widget widget-table">
		<div class="widget-header">
			<h3><i class="fa fa-table"></i> Transactions Table</h3>
			<div class="btn-group widget-header-toolbar">
			</div>
		</div>
		<div class="widget-content">
			<table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
				<thead>
					<tr>
						<th>Id</th>
						<th>Card Id</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Token</th>
						<th>Created At</th>
						<th>Updated At</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<td>{{ $transaction->getId() }}</td>
							<td>{{ $transaction->getCardId() }}</td>
							<td>{{ $transaction->getAmount() }}</td>
							<td>{{ $transaction->getStatus() }}</td>
							<td>{{ $transaction->getToken() }}</td>
							<td>{{ $transaction->getCreatedAt() }}</td>
							<td>{{ $transaction->getUpdatedAt() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

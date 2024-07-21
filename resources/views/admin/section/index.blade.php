@extends('admin.layouts.app')

@section('content')
<div class="main-container">
	<div class="pd-ltr-20 xs-pd-20-10">
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h4>Section</h4>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item">
									<a href="index.html">Home</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">
									Section
								</li>
							</ol>
						</nav>
					</div>
					<div class="col-md-6 col-sm-12 text-right">
						<div class="dropdown">
							<a class="btn btn-primary " href="{{route('section.create')}}" role="button" no-arrow>
								Add Section
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Simple Datatable start -->
			<div class="card-box mb-30">
				<div class="pd-20">

				</div>
				<div class="pb-20">
					<table id="sectionDatatable" class="data-table1 table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">ID</th>
								<th>Name</th>
								<!-- <th>Image</th> -->
								<!-- <th>Discount</th>-->
								<th>Status</th>
								<th class="datatable-nosort">Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
			<!-- Simple Datatable End -->

		</div>
		@include('admin.layouts.footer')
	</div>
</div>
@endsection

@push('script')
	<script src="{{ asset('assets/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{ asset('assets/vendors/scripts/datatable-setting.js')}}"></script>

	<!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">-->
	<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  -->

	<script type="text/javascript">
		$(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// $(".selectstatus").on("click", function () {
			// 	id = $(this).data("id");
			// 	alert(id);
			// });
			var table = $('#sectionDatatable').DataTable({
				processing: true,
				serverSide: true,
				"scrollY": "400px", // Set the height for the container
				"scrollCollapse": true, // Allow the container to collapse when the content is smaller
				"scrollX": false,
				pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

				ajax: {
					url: "{{ route('sectionAjax') }}",
					type: "POST",
					data: {
						from_date: $('input[name=from_date]').val(),
						end_date: $('input[name=end_date]').val(),
						status: $('select[name=status]').val(),
						search: $('input[name=name]').val(),
						search: $('input[section_name=name]').val(),

					},
					dataSrc: "data"
				},
				paging: true,
				pageLength: 10,
				"bServerSide": true,
				"bLengthChange": false,
				'searching': true,
				"aoColumns": [{
					"data": "id"
				},
				{ "data": "section_name" },
				{ "data": "status" },
				{ "data": "action" },
				],
				"columnDefs": [{
					"targets": [2],
					"orderable": false
				},]
			});

			// for chnage status
			$(document).on('click', '.selectstatus', function () {
    
				id = $(this).attr("data-id");
				status = $(this).attr("data-status");
				
                $.ajax({
                    type: "POST",
                    url: @json(route('changeStatus')),
                    data: { id: id, status: status },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == true) {
                            table.ajax.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });

		});
	</script>
@endpush
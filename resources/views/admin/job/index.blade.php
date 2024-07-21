@extends('admin.layouts.app')
@push('style')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<style>
		/* Custom Toastr Styles */
		#toast-container>div {
			background-color: brown;
			/* Dark background color */
			color: #fff;
			/* Light text color */
			box-shadow: none;
			/* Remove shadow */
			border: none;
		}

		#toast-container>div.toast-success {
			background-color: green;
			/* Success messages background color */
			background-color: green;
			transition: background-color 0.3s ease;
		}

		#toast-container>div.toast-error {
			background-color: #d9534f;
			/* Error messages background color */
		}

		#toast-container>div.toast-info {
			background-color: #5bc0de;
			/* Info messages background color */
		}

		#toast-container>div.toast-warning {
			background-color: #f0ad4e;
			/* Warning messages background color */
		}
	</style>

@endpush
@section('content')
<div class="main-container">
	<div class="pd-ltr-20 xs-pd-20-10">
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h4>Job</h4>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item">
									<a href="index.html">Home</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">
									Job
								</li>
							</ol>
						</nav>
					</div>
					<div class="col-md-6 col-sm-12 text-right">
						<div class="dropdown">
							<a class="btn btn-primary " href="{{route('jobs.create')}}" role="button"
								no-arrow>
								Add Job
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
					<table id="jobDatatable" class="data-table1 table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">ID</th>
								<th>Name</th>
								<th>Job Category</th>
								<th>Description</th>
								<th>Status</th>
								<th>Action</th>

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
			var table = $('#jobDatatable').DataTable({
				processing: true,
				serverSide: true,
				"scrollY": "400px", // Set the height for the container
				"scrollCollapse": true, // Allow the container to collapse when the content is smaller
				"scrollX": false,
				pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

				ajax: {
					url: "{{ route('jobAjax') }}",
					type: "POST",
					data: {
						from_date: $('input[name=from_date]').val(),
						end_date: $('input[name=end_date]').val(),
						status: $('select[name=status]').val(),
						search: $('input[name=job_name]').val(),
						// search: $('input[name=email]').val(),

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
				{ "data": "job_name" },
				{ "data": "job_category_name" },
				{ "data": "description" },
				{ "data": "status" },
				{ "data": "action" },

				],
                columnDefs: [
                    { "targets": [2], "orderable": false }, // Disable sorting on the "job_id" column
                    { "targets": [4,5,3], "orderable": false } // Disable sorting on the "job_id" column
                ]
			});

			// for chnage status
			$(document).on('click', '.selectJob', function () {

				id = $(this).attr("data-id");
				status = $(this).attr("data-status");

				$.ajax({
					type: "POST",
					url: @json(route('changeJobStatus')),
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

	@push('script')
		<script>
			@if (Session::has('message'))
				var type = "{{ Session::get('alert-type', 'info') }}"
				switch (type) {
					case 'info':
						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.info("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();
						break;
					case 'success':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.success("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();

						break;
					case 'warning':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.warning("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();

						break;
					case 'error':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.error("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();
						break;
				}
			@endif
		</script>
	@endpush
@endpush

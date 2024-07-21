@extends('admin.layouts.app')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Employee Job Request</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Employee Job Request
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">

                    </div>
                    <div class="pb-20">
                        <table id="employeeJobRequestDatatable" class="data-table1 table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">ID</th>
                                    <th>User Name</th>
                                    <th>Job Request</th>
                                    <th>Status</th>
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
    <script src="{{ asset('assets/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/scripts/datatable-setting.js') }}"></script>


    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#employeeJobRequestDatatable').DataTable({
                processing: true,
                serverSide: true,
                "scrollY": "400px", // Set the height for the container
                "scrollCollapse": true, // Allow the container to collapse when the content is smaller
                "scrollX": false,
                pagingType: "simple_numbers", // Use simple pagination (Previous/Next)

                ajax: {
                    url: "{{ route('employeeJobRequestAjax') }}",
                    type: "POST",
                    data: {
                        from_date: $('input[name=from_date]').val(),
                        end_date: $('input[name=end_date]').val(),
                        status: $('select[name=status]').val(),
                        search: $('input[name=title]').val(),

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
                    }

                ],
                columnDefs: [
            { "targets": [2], "orderable": false }, // Disable sorting on the "job_id" column
        ]
            });

        });
    </script>
@endpush

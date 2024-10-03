@extends('layouts.master')
@section('title', 'Banner')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
    <div class="content">
        <div class="grid 1grid-cols-12 gap-0 mt-5">
            <div class="intro-y c1ol-span-12 lg:col-span-12">
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">
                            Banner List
                        </h2>
                        <a href="{{ route('banner.createOrEdit') }}" class="btn btn-primary btn-md float-right"
                            data-toggle="tooltip">
                            <i class="fas fa-plus"></i>
                            Add New Banner</a>
                    </div>
                    <div class="p-5" id="responsive-table">
                        <div class="preview">
                            <div class="overflow-x-auto">
                                <table class="table mt-3 table-report" id="banner-table">
                                    <thead class="bg-box">
                                        <tr>
                                            <th class="whitespace-nowrap text-white">ID</th>
                                            <th class="whitespace-nowrap text-white"> Name</th>
                                            <th class="whitespace-nowrap text-white"> Image</th>
                                            <th class="whitespace-nowrap text-white"> Status</th>
                                            <th class="whitespace-nowrap text-white"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
@endsection
@push('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#banner-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('banner.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $(document).on('click', '.deleteButton', function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "You want to delete this banner?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
            $(document).on('change', '.changeStatus', function(e) {
                var status = ($(this).is(":checked")) ? 1 : 0;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                $.ajax({
                    url: "{{ route('banner.change.status') }}",
                    method: 'post',
                    data: {
                        id: $(this).data('id'),
                        status: status
                    },
                    success: function(result) {
                        toastr.success(result.success);
                    },
                    error: function(result) {
                        toastr.error(result.error);
                    }
                });
            });
        });
    </script>
@endpush

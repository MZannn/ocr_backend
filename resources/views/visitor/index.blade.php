@extends('layout.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="page-title">Data Visitor</h4>
                <div class="d-flex justify-content-around gap-10">
                    <input type="text" class="form-control" id="date">
                    <div class="btn btn-success btn-fillter" id="btn-fillter">
                        <i class="la la-filter &#xf0b0;"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nik</th>
                                                <th>Photo</th>
                                                <th>Nama</th>
                                                <th>Nomor Hp</th>
                                                <th>Alamat</th>
                                                <th>Nama Resident</th>
                                                <th>Alamat Resident</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#date').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'

                }
            });
            $('#date').on('cancel.daterangepicker', function(ev, picker) {
                // Mengosongkan nilai DateRangePicker
                $(this).val('');
            });
            let table = $('#dataTable').DataTable({
                bInfo: false,
                bLengthChange: false,
                serveside: true,
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                    sLengthMenu: "_MENU_items",
                },
                ajax: {
                    url: '{{ route('visitor.ajax') }}',
                    method: 'GET',
                    data: function(d) {
                        d._token = '{{ csrf_token() }}',
                            d.date = $('#date').val()
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                }, {
                    data: function(data) {
                        let reff = data.identity_number || '-';
                        return reff;
                    }
                }, {
                    data: function(data) {
                        let reff = data.photo || '-';
                        return `<a href="{{ url('storage') }}/${reff}"><img src="{{ url('storage') }}/${reff}" width="200" alt=""></a>`;
                    }
                }, {
                    data: function(data) {
                        let reff = data.name || '-';
                        return reff;
                    }
                }, {
                    data: function(data) {
                        let reff = data.phone_number || '-';
                        return reff;
                    }
                }, {
                    data: function(data) {
                        let reff = data.address || '-';
                        return reff;
                    }
                }, {
                    data: function(data) {
                        let reff = data.resident.name || '-';
                        return reff;
                    }
                }, {
                    data: function(data) {
                        let reff = data.resident.address || '-';
                        return reff;
                    }
                }, ]
            });

            $('#btn-fillter').on('click', function() {
                table.ajax.reload();
            })

            const alertToast = (icon, message) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: icon,
                    title: message
                })
            }

        });
    </script>
@endsection

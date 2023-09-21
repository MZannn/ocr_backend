@extends('layout.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="page-title">Data Resident</h4>
            <div class="btn btn-success btn-tambah" id="btn-tambah">
                <i class="la la-user-plus"></i> Tambah
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
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomor</th>
                                            <th>Aksi</th>
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

  <!-- Modal -->
  <div class="modal fade" id="modalInput" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Data Resident</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" method="POST" id="formInput">
            <input type="hidden" name="id" id="id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nomor Hp</label>
                    <input type="number" class="form-control" id="nomor" name="nomor">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="10" rows="3" class="form-control"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        let modalInput = $('#modalInput');
        let formInput = $('#formInput');
        $('#btn-tambah').on('click',function(){
            modalInput.modal('show');
        });

        formInput.on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : '{{ route('resident.store') }}',
                method : 'POST',
                data : {
                    _token : '{{ csrf_token() }}',
                    id : $('#id').val(),
                    nama : $('#nama').val(),
                    nomor : $('#nomor').val(),
                    alamat : $('#alamat').val()
                }
            }).then((ress) => {
                if(ress.status == 200){
                    alertToast('success',ress.message);
                    modalInput.modal('hide');
                    location.reload();
                }
            })
        })

        let table = $('#dataTable').DataTable({
            bInfo: false,
            bLengthChange: false,
            serveside:true,
            language: {
                search: "",
                searchPlaceholder: "Search",
                sLengthMenu: "_MENU_items",
            },
            ajax : {
                url : '{{ route('resident.ajax') }}',
                method : 'GET',
                data : function(d){
                    d._token = '{{ csrf_token() }}'
                }
            },
            columns : [{
                data : 'DT_RowIndex',
            },{
                data : function(data){
                    let reff = data.name || '-';
                    return reff;
                }
            },{
                data : function(data){
                    let reff = data.address || '-';
                    return reff;
                }
            },{
                data : function(data){
                    let reff = data.phone_number || '-';
                    return reff;
                }
            },{
                data : function(data){
                    let id = data.id || '-';
                    return `<div class="d-flex justify-content-around align-items-center">
                            <div class="btn btn-info btn-md btn-edit" data-id="${id}">
                                <i class="la la-pencil"></i>
                            </div>
                            <div class="btn btn-danger btn-md btn-trash" data-id="${id}">
                                <i class="la la-trash"></i>
                            </div>
                        </div>`
                }
            }]
        });

        table.on('click','.btn-edit',function(){
            let id = $(this).data('id');
            let url = '{{ route('resident.edit',':id') }}';
            let urlReplace = url.replace(':id',id);
            $.ajax({
                url : urlReplace,
                method : 'GET'
            }).then(ress => {
                $('#nama').val(ress.data.name),
                $('#nomor').val(ress.data.phone_number),
                $('#alamat').val(ress.data.address)
                $('#id').val(ress.data.id)
                modalInput.modal('show');
            })
        })

        table.on('click','.btn-trash',function(){
            let id = $(this).data('id');
            Swal.fire({
                title: 'Anda Yakin Ingin Menghapus ?',
                text: "Data Akan Di Delete Secara Permanent !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Hapus !'
            }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                        url : '{{ route('resident.delete') }}',
                        method : 'POST',
                        data : {
                            _token : '{{ csrf_token() }}',
                            id
                        }
                    }).then(ress => {
                        if(ress.status == 200) {
                            alertToast('success',ress.message);
                            location.reload();
                        }
                    })
                }
            })

        })

        modalInput.on('hidden.bs.modal',function(){
            $('#nama').val(''),
            $('#nomor').val(''),
            $('#alamat').val(''),
            $('#id').val('')
        })

        const alertToast = (icon,message) => {
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

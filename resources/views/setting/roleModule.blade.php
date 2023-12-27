
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Module Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Settings</a></li>
                    <li class="breadcrumb-item"><a href="">Module Role</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            @if($msgSuccess = Session::get('success'))
                <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success </strong>{!! $msgSuccess !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if($msgError = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error </strong>{!! $msgError !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableIso" style="width:100%" class="table table-striped table-sm text-center">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Level</th>
                                    <th>App</th>
                                    <th>Menu</th>
                                    <th style="width:200px">Action</th>
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
</section>

<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="role_module/role_update" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 id="title"></h5>
                </div>

                <div class="modal-body">
                    <div class="form-group row align-items-center mb-1">
                        <label for="create" class="col-sm-3 col-form-label">Create</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="create" class="custom-control-input" id="create">
                                <label class="custom-control-label" for="create"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row align-items-center mb-1">
                        <label for="read" class="col-sm-3 col-form-label">Read</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="read" class="custom-control-input" id="read">
                                <label class="custom-control-label" for="read"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row align-items-center mb-1">
                        <label for="edit" class="col-sm-3 col-form-label">Edit</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="edit" class="custom-control-input" id="edit">
                                <label class="custom-control-label" for="edit"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row align-items-center mb-1">
                        <label for="delete" class="col-sm-3 col-form-label">Delete</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="delete" class="custom-control-input" id="delete">
                                <label class="custom-control-label" for="delete"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row align-items-center mb-1">
                        <label for="approve" class="col-sm-3 col-form-label">Approve</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="approve" class="custom-control-input" id="approve">
                                <label class="custom-control-label" for="approve"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row align-items-center mb-1">
                        <label for="reject" class="col-sm-3 col-form-label">Reject</label>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="reject" class="custom-control-input" id="reject">
                                <label class="custom-control-label" for="reject"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="idRole" type="text" name="id" hidden>
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Role Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ url('setting/role_module/delete') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <h5>Are you sure to Delete?</h5>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="idDelete" type="text" name="id" hidden>
                    <button type="submit" class="btn btn-danger px-4">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {

        //datatables
        table = $('#tableIso').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            // "order": [],
            "autoWidth": false,
            "stateSave": true,
            "ajax": {
                url: "{{ url('setting/role_module/list') }}",
                type: "POST",
                data: function ( data ) {
                    data._token = "{{ csrf_token() }}";
                    // data.areafilter = $('#areaFilter').val();
                    // data.yearfilter = $('#yearFilter').val();
                    // data.datefilter = $('#datePickerFilter').val();
                    // data.statusfilter = $('#statusFilter').val();
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false
                }
            ],
            createdRow: function(row, data, index) {
                console.log(data[1])
                if (data[1] ) {
                  $('td:eq(1)', row).attr('style', 'text-align: left !important;');
                }   
            },
        });

        $('#roleModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')
            const inputChekced = $('input[type=checkbox]')

            inputChekced.attr('disabled','')
            inputChekced.removeAttr("checked")

            $('#idRole').val(id)
            $('#title').text(title)

            $.ajax({
                url: '{{ url("setting/role_module/edit") }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                },
                success : function(data){
                    var json = JSON.parse(data)
                    const inputChekced = $('input[type=checkbox]')
                    const create = $('#create')
                    const read = $('#read')
                    const edit = $('#edit')
                    const deleted = $('#delete')
                    const approve = $('#approve')
                    const reject = $('#reject')

                    json.crt == 1 ? create.attr('checked','') : ''
                    json.red == 1 ? read.attr('checked','') : ''
                    json.edt == 1 ? edit.attr('checked','') : ''
                    json.dlt == 1 ? deleted.attr('checked','') : ''
                    json.apr == 1 ? approve.attr('checked','') : ''
                    json.rjc == 1 ? reject.attr('checked','') : ''
                    
                    inputChekced.removeAttr("disabled")
                }
            });
        })

        $('#roleModal').on('hidden.bs.modal', function (e) {
            const inputChekced = $('input[type=checkbox]')
            inputChekced.removeAttr("checked")
        })

        $('#deleteModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')

            $('#idDelete').val(id)
        })
    });
</script>
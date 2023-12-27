<style>
	.select2-container--default .select2-selection--single {
		padding: 18px !important;
	}

	.select2-container .select2-selection--single .select2-selection__rendered {
		margin-top: -14px !important;
		margin-left: -17px !important;
        color: #ffffff !important;
	}

    .select2-container--default .select2-search--dropdown .select2-search__field {
        color: #000000 !important;
    }

	.select2-selection__arrow {
		margin-top: 5px !important;
	}
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Area</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item"><a href="#">User Area</a></li>
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
                <button  class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#frmUserArea" data-backdrop="static" data-keyboard="false">
					<i class="fa fa-plus"></i> Tambah Data
				</button>
            </div>
            
            <div class="col-md-12">
                <div class="card cardIn2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableIso" style="width:100%" class="table table-striped table-sm text-center">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Site Name</th>
                                    <!-- <th>Module</th> -->
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

<!-- modal add -->
<div class="modal hide fade" id="frmUserArea" role="dialog" aria-labelledby="frmUserAreaModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="frmUserAreaModalLabel">Add</h5>
			</div>
			<form method="post" action="{{ url('setting/user_area/save') }}">
                @csrf
				<div class="modal-body">
					<div class="form-group">
						<label>USER</label>
						<select class="select2 form-control" name="npk" id="npk">
							<option value="">Pilih User</option>
							@foreach ($user as $us)
								<option value="{{ $us->npk }}">{{ strtoupper($us->name) }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="site">LEVEL</label>
						<select class="select2 form-control" name="site" id="site">
							<option value="">Pilih Level</option>
							@foreach ($site as $st)
								<option value="<?= $st->site_id ?>"><?= strtoupper($st->site_name) ?></option>
                                @endforeach
						</select>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-sm btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- edit -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ url('setting/user_area/delete') }}" method="POST">
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
                url: "{{ url('setting/user_area/list') }}",
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

        $('#deleteModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')

            $('#idDelete').val(id)
        })
    });
</script>
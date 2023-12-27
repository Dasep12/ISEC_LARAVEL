@extends('srs::layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Internal Source</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Security Risk Survey</a></li>
                    <li class="breadcrumb-item"><a href="">Internal Source</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            @if($msg = Session::get('msgSuccess'))
                <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success </strong>{{ $msg }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if($msgErr = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error </strong>{{ $msgErr }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Edit Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card">
                            <form action="{{ url('srs/humint_source/update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body px-lg-4">
                                <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-lg-3">
                                        <label for="">Date</label>
                                        <input type="text" id="datetimepicker" class="form-control" name="tanggal" value="<?=date('Y-m-d H:i', strtotime($data_edit->event_date));?>" required>
                                        <input type="text" name="old_date" value="<?=date('Y-m-d H:i', strtotime($data_edit->event_date));?>" hidden>
                                        <input type="text" name="no_urut" value="<?=$data_edit->no_urut;?>" hidden>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="event">Event Name</label>
                                        <input id="event" class="form-control" name="event_name" autocomplete="off" value="<?=$data_edit->event_name;?>" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="reporter">Reporter</label>
                                        <input id="reporter" class="form-control" name="reporter" autocomplete="off" value="<?=$data_edit->reporter;?>" >
                                    </div>
                                </div>

                                <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-3">
                                        <label for="area">Area</label>
                                        <?= $select_area; ?>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="subArea1">Sub Area</label>
                                        <?= $select_subarea1; ?>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="subArea2">-</label>
                                        <?= $select_subarea2; ?>
                                        <!-- <select id="subArea2" class="form-control" name="sub_area2" disabled required></select> -->
                                    </div>

                                    <?php 
                                        if($select_subarea3 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                <label for="subArea3"></label>
                                                '.$select_subarea3.'
                                            </div>';
                                        }
                                    ?>
                                </div>

                                <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-3">
                                        <label for="assets">Target Assets</label>
                                        <?= $select_ass; ?>
                                    </div>

                                    <?php 
                                        if($select_subass1 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                    <label for="subAssets"></label>
                                                    '.$select_subass1.'
                                                </div>';
                                        }

                                        if($select_subass2 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                <label for="subAssets2"></label>
                                                '.$select_subass2.'
                                            </div>';
                                        }
                                    ?>
                                </div>

                                <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-3">
                                        <label for="riskSource">Risk Source</label>
                                        <?= $select_rso; ?>
                                    </div>
                                    
                                    <?php 
                                        if($select_rso1 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                    <label for="subRiskSource"></label>
                                                    '.$select_rso1.'
                                                </div>';
                                        }
                                    ?>
                                    
                                    <?php 
                                        if($select_rso2 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                    <label for="subRiskSource2"></label>
                                                    '.$select_rso2.'
                                                </div>';
                                        }
                                    ?>
                                </div>

                                <div class="form-row mt-2 mb-4 col-12-OFF">
                                    <div class="form-group col-3">
                                        <label for="risk">Risk</label>
                                        <?= $select_ris; ?>
                                    </div>
                                    
                                    <?php 
                                        if($select_ris1 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                    <label for="subRisk"></label>
                                                    '.$select_ris1.'
                                                </div>';
                                        }

                                        if($select_ris2 !== '')
                                        {
                                            echo '<div class="form-group col-3">
                                                    <label for="subRisk2"></label>
                                                    '.$select_ris2.'
                                                </div>';
                                        }
                                    ?>

                                    <div class="form-group col-3">
                                        <label for="riskLevel">Risk Level</label>
                                        <!-- <?= $select_rle; ?> -->
                                        <input id="riskLevel" class="form-control" type="text" name="risk_level" value="<?=$data_edit->risk_level_id;?>" readonly required>
                                    </div>
                                </div>

                                <fieldset class="border p-4 mt-2 mb-4">
                                    <legend class="w-auto h5">Vulnerability Lost</legend>

                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <label for="financial" class="font-weight-normal">Financial</label>
                                            <?= $select_fin; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="sdm" class="font-weight-normal">SDM</label>
                                            <?= $select_sdm; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="operational" class="font-weight-normal">Operational</label>
                                            <?= $select_ope; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="reputation" class="font-weight-normal">Reputation / Image</label>
                                            <?= $select_rep; ?>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="impactLevel" class="font-weight-normal">Impact Level</label>
                                            <input id="impactLevel" class="form-control" type="text" name="impact" value="<?=$data_edit->impact_level;?>" required readonly>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-row mt-2 mb-4">
                                    <div class="form-group col-7">
                                        <label for="chronology">Chronology</label>
                                        <textarea id="chronology" class="form-control" name="chronology" rows="5" required><?=$data_edit->chronology;?></textarea>
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="attach">Attach</label>
                                        <style type="text/css">
                                            .field-wrapper input[type=file]::file-selector-button 
                                            {
                                                border: 1px solid #bbbebf;
                                                padding: .2em .4em;
                                                border-radius: .2em;
                                                background-color: rgb(48 67 108 / 70%);
                                                color: #fff;
                                            }
                                        </style>
                                        <div class="field-wrapper">
                                            <div class="mb-1">
                                                <ul class="list-group list-group-flush mb-3">
                                                    <?php 
                                                        foreach ($data_edit_all as $key => $fle) {
                                                            if(!empty($fle->file_name))
                                                            echo '<li class="list-group-item attached-files p-0 mb-2">
                                                                <div class="d-flex justify-content-between">
                                                                    <a href="'.url('uploads/srsbi/humint/'.$fle->file_name).'" target="_blank">'.$fle->file_name.'</a>
                                                                    <input type="text" name="attached['.$fle->file_id.']" value="'.$fle->file_name.'" hidden>
                                                                    <button type="button" class="btn remove-attached text-danger" data-field-file="'.$fle->file_id.'"  data-file-name="'.$fle->file_name.'"  data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                                </li>';
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-info add-button mt-3" type="button" href="javascript:void(0);">Add More</button>

                                    </div>
                                </div>

                                <div class="form-row mt-2 mb-4">
                                    <input type="text" name="id" value="<?= $data_edit->id; ?>" hidden>
                                    <button class="btn btn-primary px-4" type="submit">UPDATE</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="frm-dlt-attc">
                <div class="modal-body">
                    <h5>Are you sure to Delete?</h5>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input id="fileId" type="text" name="file_id" hidden>
                    <input id="fileName" type="text" name="file_name" hidden>
                    <button id="btn-dlt-attc" type="button" class="btn btn-danger px-4">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        const subArea1 = $('#subArea1');
        const subArea2 = $('#subArea2')
        const subArea3 = $('#subArea3')
        const assets = $('#assets')
        const subAssets = $('#subAssets')
        const subAssets2 = $('#subAssets2')
        const riskSource = $('#riskSource')
        const subRiskSource = $('#subRiskSource')
        const subRiskSource2 = $('#subRiskSource2')
        const risk = $('#risk')
        const subRisk = $('#subRisk')
        const subRisk2 = $('#subRisk2')

        // SUB AREA 2 //
        const valTxt2 = subArea1.find('option:selected').text();
        const subArea2Label = subArea2.parents().children('label')

        subArea2Label.empty();
        subArea2Label.append(valTxt2);
        // SUB AREA 2 //

        // SUB AREA 3 //
        const valTxt3 = subArea2.find('option:selected').text();
        const subArea3Label = subArea3.parents().children('label')

        subArea3Label.empty();
        subArea3Label.append(valTxt3);
        // SUB AREA 3 //

        // SUB ASSETS 1 //
        const subAssVal1 = assets.find('option:selected').text();
        const subAss1Lbl = subAssets.parents().children('label');

        subAss1Lbl.empty();
        subAss1Lbl.append(subAssVal1);
        // SUB ASSETS 1 //

        // SUB ASSETS 2 //
        const subAssVal2 = subAssets.find('option:selected').text();
        const subAss1Lbl2 = subAssets2.parents().children('label');

        subAss1Lbl2.empty();
        subAss1Lbl2.append(subAssVal2);
        // SUB ASSETS 2 //

        // RISK SOURCE SUB 1 //
        const subRiSoVal1 = riskSource.find('option:selected').text();
        const subRiSoLbl1 = subRiskSource.parents().children('label');

        subRiSoLbl1.empty();
        subRiSoLbl1.append(subRiSoVal1);
        // RISK SOURCE SUB 1 //

        // RISK SOURCE SUB 2 //
        const subRiSoVal2 = subRiskSource.find('option:selected').text();
        const subRiSoLbl2 = subRiskSource2.parents().children('label');

        subRiSoLbl2.empty();
        subRiSoLbl2.append(subRiSoVal2);
        // RISK SOURCE SUB 2 //

        // RISK SUB 1 //
        const risVal = risk.find('option:selected').text();
        const subRiLbl1 = subRisk.parents().children('label');

        subRiLbl1.empty();
        subRiLbl1.append(risVal);
        // RISK SUB 1 //

        // RISK SUB 2 //
        const risVal1 = subRisk.find('option:selected').text();
        const subRiLbl2 = subRisk2.parents().children('label');

        subRiLbl2.empty();
        subRiLbl2.append(risVal1);
        // RISK SUB 2 //

        var attached = $('.attached-files').length;
        var maxField = (5 - attached);
        var addButton = $('.add-button');
        var wrapper = $('.field-wrapper');
        var fieldHTML = `<div class="parent-delete mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <input class="" type="file" accept="image/*,.pdf,.xls,.xlsx,.doc,.docx,.mp4" id="attach" name="attach[]">
                    <button class="btn remove-attach" type="button"><i class="fa fa-trash"></i></button>
                </div>
                <span class="d-block text-warning">* Max. Image & Video 20MB</span>
            </div>`;
        var x = 1;
        
        // ADD INPUT FILE MULTIPLE //
        $(addButton).click(function(){
            var attached = $('.attached-files').length;
            var maxField = (5 - attached);

            //Check maximum number of input fields
            if(x <= maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML);
            }
        });
        // ADD INPUT FILE MULTIPLE //
        
        // REMOVE INPUT FILE MULTIPLE //
        $(wrapper).on('click', '.remove-attach', function(e){
            e.preventDefault();
            $(this).parents('.parent-delete').remove();
            x--;
        });
        // REMOVE INPUT FILE MULTIPLE //

        $(function () {
            moment.locale('id');
            var start = moment().subtract(1, 'days');
            var end = moment();
            $('#datePickerFilter').daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                startDate: start,
                endDate: end,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    "format": "YYYY-MM-DD HH:mm",
                },
            });
        });

        $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
        });

        $('#btn-filter').click(function(){
            table.ajax.reload();  //just reload table
        });

        $('#btn-reset').click(function(){
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
        });

        $('#attach').change(function(e) {
            var fileName = $(this).val().match(/[^\\/]*$/)[0];
            $('#attach').parent().children('label').text(fileName);
            // $('#attach').after('<span class="d-block w-100 mt-2">'+fileName+'</span>');
        });

        $('#deleteModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('field-file')
            const name = target.data('file-name')
            
            $('#fileId').val('')
            $('#fileName').val('')
            $('#fileId').val(id)
            $('#fileName').val(name)
        })

        $('#btn-dlt-attc').click(function(e) {
            e.preventDefault();
            const id = $('#fileId').val()
            const name = $('#fileName').val()
            console.log(name);
            const targetParents = $(`[data-field-file='`+id+`']`).parent()

            targetParents.remove()

            $.ajax({
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: <?=$data_edit->id;?>,
                    fileId: id,
                    fileName: name,
                },
                url: "{{ url('srs/humint_source/delete_attached') }}",
                dataType:'json',
                success : function(response) {
                    // const res = JSON.parse(response)

                    if(response.code == '00')
                    {
                        $("#deleteModal").modal('hide');
                    }
                }
            });
        }); 

        $('#area').change(function (e) {
            const val = $(this).val();
            const subArea1 = $(this).parent().parent().find('.subArea1')
            subArea1.attr('disabled', true)

            if (val) {
                subArea1.removeAttr('disabled');
            }
            else
            {
                subArea1.prop('selectedIndex', 0) // reset position
            }
        });

        $('#subArea1').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const subArea2 = $('#subArea2')
            const subArea3 = $('#subArea3')
            const subArea2Label = subArea2.parents().children('label')
            // const subArea = $(this).next();
            // console.log(val)

            subArea2.empty();
            subArea2.attr('disabled', true);
            subArea2Label.empty();
            subArea2Label.append('-');

            if(subArea2.find('option:selected').text() !== 'production') {
                const subArea2 = $('#subArea2')
                subArea3.parents('.form-group').remove()
            }

            if (val) {
                $.ajax({
                    url: '{{ url('srs/humint_source/get_sub_area2') }}',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        idcateg: val,
                    },
                    cache: false
                }).done(function(data) {
                    subArea2Label.empty();
                    subArea2.removeAttr('disabled');
                    subArea2Label.append(valTxt);
                    subArea2.append(data);
                    // subArea.html(data);
                });
            }
        });

        $('#subArea2').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const subArea2 = $('#subArea2')
            const subArea3 = $('#subArea3')
            
            subArea3.parents('.form-group').remove()
            
            $.ajax({
                url: '{{ url('srs/humint_source/get_sub_area3') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            }).done(function(data) {
                if (data) {
                    subArea2.parents('.form-group').after(data);
                }
            });
        });

        $('#assets').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const assets = $('#assets')
            const subAssets = $('#subAssets')
            const subAssetsLabel = subAssets.parents().children('label')
            const subAssets2 = $('#subAssets2')
            
            subAssets.parents('.form-group').remove()
            subAssets2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url('srs/humint_source/get_sub_assets') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            }).done(function(data) {

                if(data) {
                    assets.parents('.form-group').after(data);
                    
                    $('#subAssets').change(function (e) {
                        const val = $(this).val();
                        const valTxt = $(this).find('option:selected').text();
                        const subAssets = $('#subAssets')
                        const subAssets2 = $('#subAssets2')
                        
                        subAssets2.parents('.form-group').remove()

                        $.ajax({
                            url: '{{ url('srs/humint_source/get_sub_assets2') }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subAssets.parents('.form-group').after(data);
                            }
                            else
                            {
                                subAssets2.empty()
                                subAssets2.parents('.form-group').remove()
                            }
                        });
                    });
                }
                else
                {
                    subAssets.empty()
                    subAssets.parents('.form-group').remove()
                }
            });
        });

        $('#subAssets').change(function (e) {
            const val = $(this).val();
            const valTxt = $(this).find('option:selected').text();
            const subAssets = $('#subAssets')
            const subAssets2 = $('#subAssets2')
            
            subAssets2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url('srs/humint_source/get_sub_assets2') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            }).done(function(data) {
                if(data) {
                    subAssets.parents('.form-group').after(data);
                }
                else
                {
                    subAssets2.empty()
                    subAssets2.parents('.form-group').remove()
                }
            });
        });

        $('#riskSource').change(function (e) {
            const val = $(this).val();
            const riskSource = $('#riskSource')
            const subRiskSource = $('#subRiskSource')
            const subRiskSource2 = $('#subRiskSource2')

            subRiskSource.parents('.form-group').remove()
            subRiskSource2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url('srs/humint_source/get_sub_risksource') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val,
                },
                cache: false
            })
            .done(function(data) {
                if(data) {
                    const subRiskSource = $('#subRiskSource')
                    
                    subRiskSource.parents('.form-group').remove()

                    riskSource.parents('.form-group').after(data);

                    $('#subRiskSource').change(function (e) {
                        const val = $(this).val();
                        const valTxt = $(this).find('option:selected').text();
                        const subRiskSource = $('#subRiskSource')
                        const subRiskSource2 = $('#subRiskSource2')
                        const subArea2Label = subArea2.parents().children('label')
                        
                        subRiskSource2.parents('.form-group').remove()
                        
                        $.ajax({
                            url: '{{ url('srs/humint_source/get_sub_risksource2') }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subRiskSource.parents('.form-group').after(data);
                                const subLabel = $('#subRiskSource2').parents().children('label')
                                subLabel.append(valTxt);
                            }
                            else
                            {
                                subRiskSource2.parents('.form-group').remove()
                            }
                        });
                    })
                }
                else
                {
                    subRiskSource.empty()
                }
            });
        })
        
        $('#risk').change(function (e) {
            const val = $(this).val();
            const risk = $('#risk')
            const subRisk = $('#subRisk')
            const subRisk2 = $('#subRisk2')
            const riskLevelId = val.split(":")[1]

            $('#riskLevel').val(val.split(":")[1])
            // $('#riskLevel').val(val.split(":")[1])
            
            riskLevelBg(riskLevelId)

            subRisk.parents('.form-group').remove()
            subRisk2.parents('.form-group').remove()

            $.ajax({
                url: '{{ url('srs/humint_source/get_sub_risk') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    idcateg: val.split(":")[0],
                },
                cache: false
            })
            .done(function(data) {
                if(data) {
                    risk.parents('.form-group').after(data);

                    $('#subRisk').change(function (e) {
                        const val = $(this).val();
                        const subRisk = $('#subRisk')
                        const subRisk2 = $('#subRisk2')
                        
                        subRisk2.parents('.form-group').remove()
                        
                        $.ajax({
                            url: '{{ url('srs/humint_source/get_sub_risk2') }}',
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                idcateg: val,
                            },
                            cache: false
                        }).done(function(data) {
                            if(data) {
                                subRisk.parents('.form-group').after(data);
                            }
                            else
                            {
                                // subRisk2.parents('.form-group').remove()
                            }
                        });
                    })
                }
                else
                {
                    // subRisk.parents('.form-group').remove()
                }
            })
        })
        
        $('#financial,#sdm,#operational,#reputation,#impactLevel').change(function (e) {
            const fin = $('#financial').val();
            const sdm = $('#sdm').val();
            const ope = $('#operational').val();
            const rep = $('#reputation').val();

            const arr = [fin.split(":")[0],sdm.split(":")[0],ope.split(":")[0],rep.split(":")[0]];
            // console.log(Math.max.apply(Math,arr))
            $('#impactLevel').val(Math.max.apply(Math,arr));
        })
        
        var riskLevelId = $('#risk').find("option:selected").val().split(":")[1]
        riskLevelBg(riskLevelId)

        function riskLevelBg(riskLevelId) {
            switch (riskLevelId) {
                case '1':
                    $('#riskLevel').attr('style', 'background-color: #06a506 !important; color: #000;');
                    break;
                case '2':
                    $('#riskLevel').attr('style', 'background-color: #f3ec03 !important; color: #000;');
                    break;
                case '3':
                    $('#riskLevel').attr('style', 'background-color: #f7a91a !important; color: #000;');
                    break;
                case '4':
                    $('#riskLevel').attr('style', 'background-color: #ff1818 !important; color: #000;');
                    break;
                case '5':
                    $('#riskLevel').attr('style', 'background-color: #c30505 !important; color: #000;');
                    break;
                default:
                    $('#riskLevel').removeAttr('style')
                    break;
            }
        }
    });
    
    // TinyMCE //
    tinymce.init({ 
        selector: '#chronology',
        height: 300,
        extended_valid_elements : "script[src|async|defer|type|charset]",
        plugins: [
            "advlist code autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
            "table contextmenu directionality emoticons paste textcolor fullscreen"
        ],
        fullscreen_native: true,
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect ",
        toolbar2: "| print preview "
    });
</script>
@endsection
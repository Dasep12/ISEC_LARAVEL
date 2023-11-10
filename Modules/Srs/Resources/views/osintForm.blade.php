@extends('srs::layouts.template')

@section('content')
<style>
    .datepicker {
        top: 260px !important;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>OSINT</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Analytic</a></li>
                    <li class="breadcrumb-item"><a href="">Operational</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            @if($msgSucs = Session::get('success'))
                <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success </strong>{!! $msgSucs !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if($msgErr = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error </strong>{!! $msgErr !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php if (AuthHelper::is_access_privilege($isModuleCode, 'crt')) { ?>
                            <button class="nav-link" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Input Data
                            </button>
                        <?php } ?>
                        <button class="nav-link active" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">View Data</button>
                        <button class="nav-link " id="nav-searchdata-tab" data-toggle="tab" data-target="#nav-searchdata" type="button" role="tab" aria-controls="nav-searchdata" aria-selected="false">Search Data</button>
                        <button class="nav-link" id="nav-searchprofile-tab" data-toggle="tab" data-target="#nav-searchprofile" type="button" role="tab" aria-controls="nav-searchprofile" aria-selected="false">Search Profile</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <?php if (AuthHelper::is_access_privilege($isModuleCode, 'crt')) { ?>
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card">
                                <!-- <div class="card-header">
                                <h3 class="card-title">Input Data Internal Source</h3>
                            </div> -->

                            <form action="osint_source/save" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body px-lg-4">

                                    <div class="form-row mb-4">
                                        <div class="form-group col-lg-3">
                                            <label for="datetimepicker2">Event Date</label>
                                            <input type="text" id="datetimepicker2" class="form-control" name="event_date" autocomplete="off" required>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="eventName">Activities Name</label>
                                            <textarea id="eventName" class="form-control" rows="1" name="activity_name" autocomplete="off" required></textarea>
                                        </div>
                                    </div>

                                    <!-- section 1 -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="plant">Plant</label>
                                            <select required class="form-control" name="plant" id="plant">
                                                <option value="">-- Select --</option>
                                                <?php foreach ($plant as $pl) : ?>
                                                    <option value="<?= $pl->id ?>"><?= $pl->plant ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <span id="load1" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                        <div class="form-group col-3" id="columnFirst" style="display: none;">
                                            <label required for="subArea">Area</label>
                                            <select class="form-control" name="area" id="subArea">
                                                <option value="">-- Select --</option>
                                                <?php foreach ($area as $ar) : ?>
                                                    <option value="<?= $ar->sub_id ?>"><?= $ar->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span id="load2" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                        <div style="display: none;" id="column3" class="form-group col-3">
                                            <label for="subArea1" id="column3label">Restirected Area</label>
                                            <select class="form-control" name="subArea1" id="subArea1">
                                                <option value="">-- Select --</option>
                                            </select>
                                            <span id="load3" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                        <div style="display: none;" id="column4" class=" form-group col-3">
                                            <label for="subArea2" id="column4label">Production</label>
                                            <select class="form-control" name="subArea2" id="subArea2">
                                                <option value="">-- Select --</option>
                                            </select>
                                            <span id="load4" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                    </div>

                                    <!-- section 2 -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="area">Target Issue</label>
                                            <select required class="form-control" name="issueTarget" id="issueTarget">
                                                <option value="">-- Select --</option>
                                                <?php foreach ($targetIssue as $ar) : ?>
                                                    <option value="<?= $ar->sub_id ?>"><?= $ar->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span id="load5" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        <div class="form-group col-3" id="column5" style="display: none;">
                                            <label required id="column5Label" for="area">Employee Issue</label>
                                            <select class="form-control" name="subIssueTarget" id="subIssueTarget">
                                                <option value="">-- Select --</option>
                                            </select>
                                            <span id="load6" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        <div class="form-group col-3" id="column6" style="display: none;">
                                            <label id="column6Label" for="area">Conflict</label>
                                            <select class="form-control" name="subIssueTarget1" id="subIssueTarget1">
                                                <option value="">-- Select --</option>
                                            </select>
                                            <span id="load7" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        <div class="form-group col-3" id="column7" style="display: none;">
                                            <label id="column7Label" for="area">Conflict</label>
                                            <select class="form-control" name="subIssueTarget2" id="subIssueTarget2">
                                                <option value="">-- Select --</option>
                                            </select>
                                            <span id="load8" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- section 3 -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="area">Risk Source</label>
                                            <select required class="form-control" name="riskSource" id="riskSource">
                                                <option selected value="">-- Select --</option>
                                                <?php foreach ($riskSource as $ar) : ?>
                                                    <option value="<?= $ar->sub_id ?>"><?= $ar->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span id="load9" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        <div class="form-group col-3" id="column8" style="display: none;">
                                            <label id="column8Label" for="area">Internal</label>
                                            <select required class="form-control" name="subriskSource" id="subriskSource">
                                                <option selected value="">-- Select --</option>
                                            </select>
                                            <span id="load10" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        <div class="form-group col-3" id="column9" style="display: none;">
                                            <label id="column9Label" for="area">Employee</label>
                                            <select class="form-control" name="subriskSource1" id="subriskSource1">
                                                <option selected value="">-- Select --</option>
                                            </select>
                                            <span id="load11" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                        <div class="form-group col-3" id="column09" style="display: none;">
                                            <label id="column09Label" for="area">Plant</label>
                                            <select class="form-control" name="employe_plant" id="subriskSource01">
                                                <option selected value="">-- Select --</option>
                                            </select>
                                            <span id="load011" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- Media -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="mediaIssue">Media</label>
                                            <select required class="form-control" name="mediaIssue" id="mediaIssue">
                                                <option selected value="">-- Select --</option>
                                                <?php foreach ($media as $m) : ?>
                                                    <option value="<?= $m['sub_id']; ?>"><?= $m['name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>

                                        <div class="form-group col-3" id="column10"  style="display: none;">
                                            <label id="column10Label" for="SubmediaIssue">-</label>
                                            <select class="form-control" name="SubmediaIssue" id="SubmediaIssue">
                                                <option selected value="">-- Select --</option>
                                            </select>
                                            <span id="load13" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- Regional -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="regional">Regional</label>
                                            <?= $regional; ?>
                                            <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- Legalitas -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="legalitas">Legalitas</label>
                                            <?= $legalitas; ?>
                                            <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- Format -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-3">
                                            <label for="format">Format</label>
                                            <?= $format; ?>
                                            <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                    </div>

                                    <!-- Negative Sentiment -->
                                    <div class="form-row mb-4 ">
                                        <div class="form-group col-3">
                                            <label for="hatespeech">Negative Sentiment</label>
                                            <?= $hatespeech; ?>
                                            <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label for="riskLevel">Risk Level</label>
                                            <input id="riskLevel" class="form-control" type="text" name="risk_level" value="" readonly required>
                                        </div>
                                    </div>
                                    <!-- Negative Sentiment -->

                                    <!-- Vulnerability Lost -->
                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Vulnerability Lost</legend>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for=" area">SDM Sector Effect</label>
                                                <select required class="form-control" name="sdm" id="sdm">
                                                    <option selected value="">-- Select --</option>
                                                    <?php foreach ($sdm as $m) : ?>
                                                        <option value="<?= $m->sub_id.':'.$m->level_id; ?>"><?= $m->level . '.' . $m->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <span id="load17" style="display: none;" class="font-italic text-white">loading data</span>
                                            </div>


                                            <div class="form-group col-3">
                                                <label for=" area">Reputation / Brand Image</label>
                                                <select required class="form-control" name="reput" id="reput">
                                                    <option selected value="">-- Select --</option>
                                                    <?php foreach ($reput as $m) : ?>
                                                        <option value="<?= $m->sub_id.':'.$m->level_id; ?>"><?= $m->level . '.' . $m->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <span id="load17" style="display: none;" class="font-italic text-white">loading data</span>
                                            </div>
                                        </div>

                                        <div class="form-row ml-1">
                                            <div class="form-group">
                                                <label for="impactLevel">Impact Level</label>
                                                <input id="impactLevel" class="form-control text-center" type="text" name="impact_level" readonly>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Total Level -->
                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Total Level</legend>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input id="totalLevel" class="form-control text-center" type="text" name="total_level" readonly required>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- section 7 -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-7">
                                            <label for="description">Description</label>
                                            <textarea id="description" class="form-control" name="description" rows="3"></textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <div class="form-row">
                                                <div class="form-group col-12 mb-5">
                                                    <label for="attach">Attach file photo/video</label>
                                                    <style type="text/css">
                                                        .field-wrapper input[type=file]::file-selector-button {
                                                            border: 1px solid #bbbebf;
                                                            padding: .2em .4em;
                                                            border-radius: .2em;
                                                            background-color: rgb(48 67 108 / 70%);
                                                            color: #fff;
                                                        }
                                                    </style>
                                                    <div class="field-wrapper">
                                                        <div class="mb-1">
                                                            <input class="" type="file" accept="image/*,.pdf,.xls,.xlsx,.doc,.docx,.mp4" id="attach" name="attach[]">
                                                            <!-- <label class="custom-file-label">Choose file</label> -->
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-info add-button mt-3" type="button" href="javascript:void(0);">Add More</button>
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="url1">URL 1</label>
                                                    <input id="url1" class="form-control" type="text" name="url1">
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="url2">URL 2</label>
                                                    <input id="url1" class="form-control" type="text" name="url2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-row mt-2 mb-4">
                                        <button class="btn btn-primary px-4" type="submit">SAVE</button>
                                    </div>
                                </div>
                                </form>

                            </div>
                        </div>
                    <?php } ?>

                    <!-- <?= !AuthHelper::is_access_privilege($isModuleCode, 'crt') ? 'show active' : ''; ?> -->
                    <div class="tab-pane fade  show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card">
                            <div class="card-body px-lg-4">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <form id="form-filter" class="form-horizontal">
                                            <div class="form-row">
                                                <div class="form-group col-lg-3">
                                                    <label for="">Date</label>
                                                    <input type="text" id="datePickerFilter" class="form-control" name="date_filter" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <button type="button" id="btn-filter" class="btn btn-primary px-4 mr-2">Filter</button>
                                                    <button type="button" id="btn-reset" class="btn btn-secondary px-4">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="table-responsive mt-5">
                                    <table id="tableOsint" style="width:100%" class="table table-striped table-sm text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activities</th>
                                                <th>Plant</th>
                                                <th>Media</th>
                                                <th>Platform</th>
                                                <th>Negative Sentiment</th>
                                                <th>Date</th>
                                                <th>Total Level</th>
                                                <th style="width:200px">Action</th>
                                            </tr>
                                        </thead>
                                        <!-- <tbody></tbody> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH DATA -->
                    <div class="tab-pane fade" id="nav-searchdata" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="card">
                            <div class="card-body px-lg-4 py-5">
                                <form id="formSearch" method="post" action="#">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h1 class="text-white">SEARCH</h1>
                                        </div>
                                        <div class="col-8 mx-auto">
                                            <!-- <input class="form-control" type="text" name="" placeholder="Type something..."> -->
                                            <div class="input-group">
                                                <input type="search" class="form-control rounded" name="keyword" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                                <button type="submit" class="btn btn-primary">search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- SEARCH DATA -->

                    <!-- SEARCH PROFILE -->
                    <div class="tab-pane fade" id="nav-searchprofile" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="card">
                            <div class="card-body px-lg-4 py-5">
                                <form id="formSearchProfile" method="post" action="#">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h1 class="text-white">SEARCH PROFILE</h1>
                                        </div>
                                        <div class="col-8 mx-auto">
                                            <div class="dropdown mb-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="dropdown-text"> Select Target</span>
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#"><label><input type="checkbox" class="selectall" /><span class="select-text"> Select</span> All</label></a></li>
                                                    <li class="divider"></li>
                                                    <li><a class="option-link" href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 1 '/> Instagram</label></a></li>
                                                    <li><a href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 2 '/> Facebook</label></a></li>
                                                    <li><a href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 3 '/> Tiktok</label></a></li>
                                                </ul>
                                            </div>

                                            <!-- <input class="form-control" type="text" name="" placeholder="Type something..."> -->
                                            <div class="input-group">
                                                <input type="search" class="form-control rounded" name="keyword_profile" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                                <button type="submit" class="btn btn-primary">search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- SEARCH PROFILE -->
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <!-- <div class="modal-header border-0">
                <h5 class="modal-title" id="detailModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Search Data Modal -->
<div class="modal fade" id="detailSearchModal" tabindex="-1" aria-labelledby="detailSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <h5 class="modal-title" id="detailModalLabel"></h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="osint_source/approve" method="POST">
            @csrf
            <div class="modal-body">
                <h5>Are you sure to Approve?</h5>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input id="idApprove" type="text" name="id" hidden>
                <button type="submit" class="btn btn-danger px-4">Yes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Approve Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="osint_source/delete" method="POST">
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

<script type="text/javascript" src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/dist/js/popper.min.js') }}"></script>

<script type="text/javascript">
    // TinyMCE //
    tinymce.init({
        selector: '#description',
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        },
        height: 300,
        extended_valid_elements: "script[src|async|defer|type|charset]",
        plugins: [
            "advlist code autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
            "table contextmenu directionality emoticons paste textcolor fullscreen"
        ],
        fullscreen_native: true,
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect ",
        toolbar2: "| print preview "
    });


    function openImg(image) {
        alert(image);
    }

    function animateLoading(mode='') {
        return `
            <div id="loadingProgress" class="loader d-flex w-100 justify-content-center py-3 `+mode+`">
                <div class="spinner-grow text-primary " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success ml-1 " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark ml-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `;
    }

    $(document).ready(function() {
        $('.selectall').click(function() {
            if ($(this).is(':checked')) {
                $('.option').prop('checked', true);
                var total = $('input[name="options[]"]:checked').length;
                $(".dropdown-text").html('Selected target (' + total + ')');
                $(".select-text").html(' Deselect');
            } else {
                $('.option').prop('checked', false);
                $(".dropdown-text").html('Selected target (0)');
                $(".select-text").html(' Select');
            }
        });

        $("input[type='checkbox'].justone").change(function(){
            var a = $("input[type='checkbox'].justone");
                if(a.length == a.filter(":checked").length){
                    $('.selectall').prop('checked', true);
                    $(".select-text").html(' Deselect');
                }
                else {
                    $('.selectall').prop('checked', false);
                    $(".select-text").html(' Select');
                }
            var total = $('input[name="options[]"]:checked').length;
            $(".dropdown-text").html('Selected target (' + total + ')');
        });

        // $('#datetimepicker2').datepicker({
        //     // defaultDate: true,
        //     // defaultTime: false,
        //     // pickTime: false,
        //     dateFormat: 'yy-mm-dd',
        // });

        var maxField = 5;
        var addButton = $('.add-button');
        var wrapper = $('.field-wrapper');
        var fieldHTML = `<div class="d-flex flex-row justify-content-between mb-1">
            <input class="" type="file" accept="image/*,.pdf,.xls,.xlsx,.doc,.docx,.mp4" id="attach" name="attach[]">
            <a class="remove-attach text-danger" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
            </div>`;
        var x = 1;

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML);
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove-attach', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
        
        //datatables
        table = $('#tableOsint').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            // "order": [],
            "autoWidth": false,
            "stateSave": true,
            "ajax": {
                "url": "<?= url('srs/osint_source/list_table'); ?>",
                "type": "POST",
                "data": function(data) {
                    data._token = "{{ csrf_token() }}";
                    data.datefilter = $('#datePickerFilter').val();
                }
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],
        });

        $('#btn-filter').click(function() {
            table.ajax.reload(); //just reload table
        });

        $('#btn-reset').click(function() {
            $('#form-filter')[0].reset();
            table.ajax.reload(); //just reload table
        });

        $('#detailModal').on('shown.bs.modal', function(e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            // console.log(title)
            // modal.find('#detailModalLabel').text(tds.text());

            $.ajax({
                url: '<?= url('srs/osint_source/detail'); ?>',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                    $('#detailModal .modal-body').html(`
                        <div id="loadingProgress" class="row justify-content-center">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success: function(data) {
                    // console.log(data)
                    $(".lds-ring").hide();
                    $('#detailModal .modal-body').html(data);
                    //menampilkan data ke dalam modal
                }
            });
        });

        $('#detailModal').on('hide.bs.modal', function(e) {
            $('#detailModal .modal-body').children().remove();
        })

        $('#deleteModal').on('shown.bs.modal', function(e) {
            $('#deleteModal .modal-body .title-approve').remove()

            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')

            $('#idDelete').val(id)
            $('#deleteModal .modal-body h5').after(`
               <span class="font-weight-bold title-approve">${title}</span> 
            `)
        })

        $('#approveModal').on('shown.bs.modal', function(e) {
            $('#approveModal .modal-body .title-approve').remove()

            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const title = target.data('title')

            $('#idApprove').val(id)
            $('#approveModal .modal-body h5').after(`
               <span class="font-weight-bold title-approve">${title}</span> 
            `)
        })

        $(function() {
            moment.locale('id');
            var start = moment().subtract(1, 'days');
            var end = moment();
            $('#datePickerFilter').daterangepicker({
                autoUpdateInput: false,
                timePicker: false,
                timePicker24Hour: false,
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
                    "format": "YYYY-MM-DD",
                    // "format": "LL",
                    // "separator": " - ",
                    // "applyLabel": "Apply",
                    // "cancelLabel": "Cancel",
                    // "weekLabel": "W",
                    // "daysOfWeek": [
                    //     "Min",
                    //     "Sen",
                    //     "Sel",
                    //     "Rab",
                    //     "Kam",
                    //     "Jum",
                    //     "Sab"
                    // ],
                    // "monthNames": [
                    //     "Januari",
                    //     "Februari",
                    //     "Maret",
                    //     "April",
                    //     "Mei",
                    //     "Juni",
                    //     "Juli",
                    //     "Augustus",
                    //     "September",
                    //     "Oktober",
                    //     "November",
                    //     "Desember"
                    // ],
                    // "firstDay": 1
                },
            });
        });

        $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('#formSearch').on('submit', function (e) {
            e.preventDefault();

            var data = $(this).serialize();
            var keyword = $("input[name='keyword']").val();
            
            if(keyword != '')
            {
                $.ajax({
                    url: '<?= url('srs/osint_source/search'); ?>',
                    type: 'POST',
                    data: {
                        keyword: keyword,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    beforeSend: function() {
                    $(".lds-ring").show();
                    },
                    success : function(data){
                        $(".lds-ring").hide();
                        $('#searchResult').remove();
                        $('#formSearch input').parents('.col-8').after(data);
                    }
                });
            }
        })

        $('#formSearchProfile').on('submit', function (e) {
            e.preventDefault();

            var data = $(this).serialize();
            var keyword = $("input[name='keyword_profile']").val();
            
            if(keyword != '')
            {
                $.ajax({
                    url: '<?= url('srs/osint_profile/search'); ?>',
                    type: 'POST',
                    data: {
                        keyword_profile: keyword,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    
                    beforeSend: function() {
                        $('.search-result-profile').remove();
                        $('#searchResultProfile').remove();
                        $('#formSearchProfile input').parents('.col-8').after(animateLoading(''));
                    },
                    success : function(data){
                        $('#loadingProgress').remove();
                        $('#formSearchProfile input').parents('#formSearchProfile').append(data);
                    },
                    error: function(){
                        $('#loadingProgress').remove();
                        $('#formSearchProfile input').parents('#formSearchProfile').append(`
                            <span class="search-result-profile d-flex justify-content-center text-white mt-4">Oops! Something went wrong.</span>
                        `);
                    }
                });
            }
        })

        $("#detailSearchModal").on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
            $('#detailSearchModal .modal-body').html('')
        });

        $('#detailSearchModal').on('shown.bs.modal', function (e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            const id = target.data('id')
            const row = $(target).closest("tr");
            const title = row.find("td:nth-child(2)");

            // modal.find('#detailModalLabel').text(tds.text());

            $.ajax({
                url: '<?= url('srs/osint_source/detail'); ?>',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                cache: false,
                beforeSend: function() {
                    $('#detailSearchModal .modal-body').html(`
                        <div id="loadingProgress" class="row justify-content-center">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-secondary" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success : function(data){
                    $(".lds-ring").hide();
                    $('#detailSearchModal .modal-body').html(data);//menampilkan data ke dalam modal
                }
            });
        })
    });

    $(function() {
        // section 1 
        $("#plant").change(function(e) {
            var id = $(this).val();
            var text = $('option:selected', this).text();
            console.log(text);
            if (id == "" || text == "PLANT UNKNOWN") {
                document.getElementById("columnFirst").style.display = "none";
                document.getElementById("column4").style.display = "none";
                document.getElementById("column3").style.display = "none";
                // var select = $('#subArea1');
                const text = '-- Select --';
                const $select = document.querySelector('#subArea1');
                const $options = Array.from($select.options);
                const optionToSelect = $options.find(item => item.text === text);
                optionToSelect.selected = true;
            } else {
                document.getElementById("columnFirst").style.display = "block";
                document.getElementById("column3").style.display = "none";
                document.getElementById("column4").style.display = "none";
            }
        })

        // filter 1 row 1 
        $("#subArea").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_subArea') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load2").style.display = "block";
                    document.getElementById("column3").style.display = "none";
                },
                complete: function() {
                    document.getElementById("column3").style.display = "block";
                    document.getElementById("load2").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    var select = $('#subArea1');
                    document.getElementById("column3").style.display = "block";
                    document.getElementById("column3label").innerHTML = label;
                    select.empty();
                    var added = document.createElement('option');
                    added.value = "";
                    added.innerHTML = "-- Select --";
                    select.append(added);
                    var result = JSON.parse(e);
                    for (var i = 0; i < result.length; i++) {
                        var added = document.createElement('option');
                        added.value = result[i].id;
                        added.innerHTML = result[i].name;
                        select.append(added);
                    }
                }
            })
        })

        // filter 2 row 1 
        $("#subArea1").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            var plant = $("select[id=plant] option:selected").val();
            $.ajax({
                url: "<?= url('srs/osint_source/get_subArea1') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load3").style.display = "block";
                },
                complete: function() {
                    document.getElementById("load3").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    plant: plant
                },
                success: function(e) {
                    // console.log(e);
                    if (parseInt(e) != 0) {
                        var select = $('#subArea2');
                        document.getElementById("column4").style.display = "block";
                        document.getElementById("column4label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        document.getElementById("column4").style.display = "none";
                    }
                }
            })
        })
        // 

        // section 2
        // filter 1 row 2
        $("#issueTarget").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_Issue') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load5").style.display = "block";
                    document.getElementById("column5").style.display = "none";
                    document.getElementById("column6").style.display = "none";
                    document.getElementById("column7").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load5").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    if (parseInt(e) != 0) {
                        var select = $('#subIssueTarget');
                        document.getElementById("column5").style.display = "block";
                        document.getElementById("column5Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        document.getElementById("column5").style.display = "none";
                    }

                }
            })
        })

        // filter 2 row 2
        $("#subIssueTarget").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_SubIssue') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load6").style.display = "block";
                    document.getElementById("column6").style.display = "none";
                    document.getElementById("column7").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load6").style.display = "none";
                    // document.getElementById("column6").style.display = "block";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    // console.log(e);
                    document.getElementById("column7").style.display = "none";
                    if (parseInt(e) != 0) {
                        var select = $('#subIssueTarget1');
                        document.getElementById("column6").style.display = "block";
                        document.getElementById("column6Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        document.getElementById("column6").style.display = "none";
                    }
                }
            })
        })

        // filter 3 row 2
        $("#subIssueTarget1").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_SubIssue1') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load7").style.display = "block";
                },
                complete: function() {
                    document.getElementById("load7").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    // console.log(e);
                    if (parseInt(e) != 0) {
                        var select = $('#subIssueTarget2');
                        document.getElementById("column7").style.display = "block";
                        document.getElementById("column7Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        document.getElementById("column7").style.display = "none";
                    }
                }
            })
        })

        // section 3
        // filter 1 row 3
        $("#riskSource").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_riskSource') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load9").style.display = "block";
                    document.getElementById("column8").style.display = "none";
                    document.getElementById("column9").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load9").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    // console.log(e);
                    if (parseInt(e) != 0) {
                        var select = $('#subriskSource');
                        document.getElementById("column8").style.display = "block";
                        document.getElementById("column8Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        document.getElementById("column8").style.display = "none";
                    }
                }
            })
        })

        // filter 2 row 3
        $("#subriskSource").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            $.ajax({
                url: "<?= url('srs/osint_source/get_riskSource1') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    document.getElementById("load10").style.display = "block";
                    document.getElementById("column9").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load10").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    // console.log(e);
                    if (parseInt(e) != 0) {
                        var select = $('#subriskSource1');
                        document.getElementById("column9").style.display = "block";
                        document.getElementById("column9Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                        var Plants = <?= json_encode($plant) ?>;
                        if (label == "Employee") {
                            var select1 = $('#subriskSource01');
                            document.getElementById("column09").style.display = "block";
                            document.getElementById("column09Label").innerHTML = "Plant";
                            select1.empty();
                            var added = document.createElement('option');
                            added.value = "";
                            added.innerHTML = "-- Select --";
                            select1.append(added);
                            for (var i = 0; i < Plants.length; i++) {
                                var added = document.createElement('option');
                                added.value = Plants[i].id;
                                added.innerHTML = Plants[i].plant;
                                select1.append(added);
                            }
                        } else {
                            var select1 = $('#subriskSource01');
                            document.getElementById("column09").style.display = "none";
                            select1.empty();
                            var added = document.createElement('option');
                            added.value = "";
                            added.innerHTML = "-- Select --";
                        }

                    } else {
                        document.getElementById("column9").style.display = "none";
                    }

                }
            })
        })

        // fitler 1 row 4
        $("#mediaIssue").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            var mediaIssue = $(this)

            $('#mediaLevel').val('')

            $.ajax({
                url: "<?= url('srs/osint_source/get_issuMedia') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    mediaIssue.parent().children('span').show();
                    mediaIssue.prop('disabled', true);
                    // document.getElementById("load12").style.display = "block";
                    // document.getElementById("column10").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load12").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id.split(":")[0],
                },
                success: function(e) {
                    if (parseInt(e) != 0) {
                        mediaIssue.parent().children('span').hide();
                        mediaIssue.prop('disabled', false);

                        var select = $('#SubmediaIssue');
                        document.getElementById("column10").style.display = "block";
                        document.getElementById("column10Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        // document.getElementById("column10").style.display = "none";
                        // document.getElementById("column11").style.display = "none";
                        // document.getElementById("column12").style.display = "none";
                    }

                }
            })
        })

        // filter 2 row 4
        $("#SubmediaIssue").change(function(e) {
            var id = $(this).val();
            var label = $('option:selected', this).text();
            var media = $('#mediaIssue').find('option:selected').val().split(':')[2];
            var submediaIssue = $('#SubmediaIssue');

            $.ajax({
                url: "<?= url('srs/osint_source/get_SubissuMedia') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    submediaIssue.parent().children('span').show();
                    submediaIssue.prop('disabled', true);
                    // document.getElementById("load13").style.display = "block";
                    // document.getElementById("column11").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load13").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(e) {
                    if (parseInt(e) != 0) {
                        var select = $('#SubmediaIssue1');
                        document.getElementById("column11").style.display = "block";
                        document.getElementById("column11Label").innerHTML = label;
                        select.empty();
                        var added = document.createElement('option');
                        added.value = "";
                        added.innerHTML = "-- Select --";
                        select.append(added);
                        var result = JSON.parse(e);
                        for (var i = 0; i < result.length; i++) {
                            var added = document.createElement('option');
                            added.value = result[i].id;
                            added.innerHTML = result[i].name;
                            select.append(added);
                        }
                    } else {
                        // document.getElementById("column11").style.display = "none";
                    }

                    submediaIssue.parent().children('span').hide();
                    submediaIssue.prop('disabled', false);

                    $('#mediaLevel').val(media)

                }
            })
        })

        // REGIONAL LEVEL
        $("#regional").change(function(e) {
            var id = $(this).val();
            var regionalLevel = $('option:selected', this).val().split(':')[2];

            $('#regionalLevel').val('')
            $('#regionalLevel').val(regionalLevel)
        })

        // LEGALITAS
        $("#legalitas").change(function(e) {
            var id = $(this).val();
            var label = $(this).find('option:selected').text();
            var legalitas = $(this)
            var legalitasSub1 = $('#legalitasSub1')
            var legalitasLevel = $('#legalitasLevel')

            legalitasLevel.val('')
            legalitasSub1.parents('.form-group').remove()

            $.ajax({
                url: "<?= url('srs/osint_source/getCategorySub1') ?>",
                method: "POST",
                cache: false,
                beforeSend: function() {
                    legalitas.parent().children('span').show();
                    legalitas.prop('disabled', true);
                    // document.getElementById("load12").style.display = "block";
                    // document.getElementById("column10").style.display = "none";
                },
                complete: function() {
                    document.getElementById("load12").style.display = "none";
                },
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id.split(":")[0],
                },
                success: function(data) {
                    legalitas.parents('.form-group').after(data);
                    var legalitasSub1 = $('#legalitasSub1')
                    legalitasSub1.parents().children('label').text(label);

                    // LEGALITAS SUB1
                    $("#legalitasSub1").change(function(e) {
                        var legalitasLevelVal = $('option:selected', this).val().split(':')[2];

                        legalitasLevel.val('')
                        legalitasLevel.val(legalitasLevelVal)
                    });

                    legalitas.parent().children('span').hide();
                    legalitas.prop('disabled', false);
                }
            })
        });

        // REGIONAL LEVEL
        $("#format").change(function(e) {
            var id = $(this).val();
            var formatLevel = $('option:selected', this).val().split(':')[2];

            $('#formatLevel').val('')
            $('#formatLevel').val(formatLevel)
        });

        $("#hatespeech").change(function(e) {
            const val = $(this).val();
            const riskLevel = val.split(":")[1]
            $('#riskLevel').val(riskLevel)

            // RISK LEVEL
            const impactLevel = $('#impactLevel').val();
            if(riskLevel.length != 0 && impactLevel.length != 0)
            {
                const totalLevel = (riskLevel * 0.5) + (impactLevel * 0.5);
                $('#totalLevel').val(totalLevel.toFixed(2))
            }
        });

        // Vulnerability Level
        $("#sdm, #reput").change(function(e) {
            var levelSdm = parseInt($("select[name=sdm] option:selected").text().split(".")[0]) || 0;
            var levelReput = parseInt($("select[name=reput] option:selected").text().split(".")[0]) || 0;

            const max = [levelSdm, levelReput];

            document.getElementById("impactLevel").value = Math.max.apply(Math,max);

            // RISK LEVEL
            const riskLevel = $('#riskLevel').val();
            const impactLevel = $('#impactLevel').val();
            if(riskLevel.length != 0 && impactLevel.length != 0)
            {
                const totalLevel = (riskLevel * 0.5) + (impactLevel * 0.5);
                $('#totalLevel').val(totalLevel.toFixed(2))
            }
        });
    })
</script>
@endsection
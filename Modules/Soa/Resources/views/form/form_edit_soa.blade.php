@extends('soa::layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daily Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Analytic</a></li>
                    <li class="breadcrumb-item"><a href="">Operational Index</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row information" id="information"></div>
        <div class="row">

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Edit Data</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card">
                            <form action="updateSoa" method="post">
                                @csrf
                                <input type="text" name="idTrans" id="idTrans" value="<?= $transHeader[0]->id ?>">
                                <div class="card-body px-lg-4">
                                    <div class="form-row mt-2 mb-4">
                                        <div class="form-group col-3">
                                            <label for="reportDate">Report Date</label>
                                            <input type="text" id="reportDate" class="form-control" value="<?= $transHeader[0]->report_date ?>" name="report_date" autocomplete="off" required>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="shift">Shift</label>
                                            <select name="shift" id="shift" class="form-control">
                                                <option <?= $transHeader[0]->report_date == 1 ? 'selected' : '' ?> value="1">1</option>
                                                <option <?= $transHeader[0]->report_date == 2 ? 'selected' : '' ?> value="2">2</option>
                                                <option <?= $transHeader[0]->report_date == 3 ? 'selected' : '' ?> value="3">3</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="area">Area</label>
                                            <select name="area" id="area" class="form-control">
                                                <option value="">Select Plant</option>
                                                <?php

                                                use Illuminate\Support\Facades\DB;

                                                foreach ($plant as $pl) { ?>
                                                    <option <?= $transHeader[0]->area_id == $pl->id ? 'selected' : '' ?> value="<?= $pl->id ?>"><?= ucwords(strtolower($pl->title)) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">People</legend>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">Employee Attendance</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_people WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='6' and status = 1 ");
                                                    $countemploye = 0;
                                                    if (count($qry) > 0) {
                                                        $countemploye = $qry[0]->attendance;
                                                    } else {
                                                        $countemploye = 0;
                                                    }
                                                    ?>
                                                    <input id="employee" value="<?= $countemploye ?>" class="form-control mask-int" name="employee" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="contractor" class="font-weight-normal">Contractor Attendance</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_people WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='9' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->attendance;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input value="<?= $count ?>" id="contractor" class="form-control mask-int" name="contractor" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="visitor" class="font-weight-normal">Visitor Attendance</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_people WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='7' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->attendance;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input value="<?= $count ?>" id="visitor" class="form-control mask-int" name="visitor" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <label for="businessPartner" class="font-weight-normal">Business Partner Attendance</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_people WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='8' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->attendance;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input value="<?= $count ?>" id="businessPartner" class="form-control mask-int" name="business_partner" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Document</legend>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">PKB</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_material WHERE trans_id = '" . $transHeader[0]->id . "'  AND category_id='12' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->document_in;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input id="pkb" value="<?= $count ?>" class="form-control mask-int" name="pkb" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">PKO</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_material WHERE trans_id = '" . $transHeader[0]->id . "'  AND category_id='1035' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->document_in;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input id="pko" value="<?= $count ?>" class="form-control mask-int" name="pko" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-3">
                                                <label for="employee" class="font-weight-normal">Surat Jalan</label>
                                                <div class="input-group">
                                                    <?php
                                                    $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_material WHERE trans_id = '" . $transHeader[0]->id . "'  AND category_id='1036' and status = 1 ");
                                                    $count = 0;
                                                    if (count($qry) > 0) {
                                                        $count = $qry[0]->document_in;
                                                    } else {
                                                        $count = 0;
                                                    }
                                                    ?>
                                                    <input value="<?= $count ?>" id="surat_jalan" class="form-control mask-int" name="surat_jalan" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Vehicle</legend>

                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="nav flex-column nav-pills people" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                            <button class="nav-link active" id="v-pills-employee-tab" data-toggle="pill" data-target="#v-pills-employee" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Employee</button>
                                                            <button class="nav-link" id="v-pills-visitor-tab" data-toggle="pill" data-target="#v-pills-visitor" type="button" role="tab" aria-controls="v-pills-visitor" aria-selected="false">Visitor</button>
                                                            <button class="nav-link" id="v-pills-bp-tab" data-toggle="pill" data-target="#v-pills-bp" type="button" role="tab" aria-controls="v-pills-bp" aria-selected="false">Business Partner</button>
                                                            <button class="nav-link" id="v-pills-contractor-tab" data-toggle="pill" data-target="#v-pills-contractor" type="button" role="tab" aria-controls="v-pills-contractor" aria-selected="false">Contractor</button>
                                                            <button class="nav-link" id="v-pills-pool-tab" data-toggle="pill" data-target="#v-pills-pool" type="button" role="tab" aria-controls="v-pills-pool" aria-selected="false">Pool</button>
                                                        </div>
                                                    </div>


                                                    <div class="col-10">
                                                        <div class="tab-content" id="v-pills-tabContent">
                                                            <div class="tab-pane fade show active" id="v-pills-employee" role="tabpanel" aria-labelledby="v-pills-employee-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car" class="font-weight-normal">Car</label>

                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='6' AND type_id='1' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input id="car_employee" class="form-control mask-int" name="car_employee" autocomplete="off" value="<?= $count ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class=" form-group col-3">
                                                                        <label for="Motorcycle" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='6' AND type_id='2' and status = 1  ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="motorcycle_employee" class="form-control mask-int" name="motorcycle_employee" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='6' AND type_id='1037' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="bicycle_employee" class="form-control mask-int" name="bicycle_employee" autocomplete="off" required>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-visitor" role="tabpanel" aria-labelledby="v-pills-visitor-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_visitor" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='7' AND type_id='1' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="car_visitor" class="form-control mask-int" name="car_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_visitor" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='7' AND type_id='2' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="motorcycle_visitor" class="form-control mask-int" name="motorcycle_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_visitor" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='7' AND type_id='1037' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="bicycle_visitor" class="form-control mask-int" name="bicycle_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_visitor" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='7' AND type_id='3' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="truck_visitor" class="form-control mask-int" name="truck_visitor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-bp" role="tabpanel" aria-labelledby="v-pills-bp-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_bp" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='8' AND type_id='1' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="car_bp" class="form-control mask-int" name="car_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_bp" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='8' AND type_id='2' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="motorcycle_bp" class="form-control mask-int" name="motorcycle_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_bp" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='8' AND type_id='1037' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="bicycle_bp" class="form-control mask-int" name="bicycle_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_bp" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='8' AND type_id='3' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="truck_bp" class="form-control mask-int" name="truck_bp" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-contractor" role="tabpanel" aria-labelledby="v-pills-contractor-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_contractor" class="font-weight-normal">Car</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "' AND people_id='9' AND type_id='1' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="car_contractor" class="form-control mask-int" name="car_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_contractor" class="font-weight-normal">Motorcycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='9' AND type_id='2'  and status = 1  ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="motorcycle_contractor" class="form-control mask-int" name="motorcycle_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_contractor" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='9' AND type_id='1037' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="bicycle_contractor" class="form-control mask-int" name="bicycle_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_contractor" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='9' AND type_id='3' and status = 1  ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="truck_contractor" class="form-control mask-int" name="truck_contractor" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="v-pills-pool" role="tabpanel" aria-labelledby="v-pills-pool-tab">
                                                                <div class="form-row">
                                                                    <div class="form-group col-3">
                                                                        <label for="car_pool" class="font-weight-normal">Car</label>

                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='32' AND type_id='1' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="car_pool" class="form-control mask-int" name="car_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="Motorcycle_pool" class="font-weight-normal">Motorcycle</label>

                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='32' AND type_id='2' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="motorcycle_pool" class="form-control mask-int" name="motorcycle_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="bicycle_pool" class="font-weight-normal">Bicycle</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='32' AND type_id='1037' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="bicycle_pool" class="form-control mask-int" name="bicycle_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-3">
                                                                        <label for="truck_pool" class="font-weight-normal">Truck</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            $qry = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction_vehicle WHERE trans_id = '" . $transHeader[0]->id . "'  AND people_id='32' AND type_id='3' and status = 1 ");
                                                                            $count = 0;
                                                                            if (count($qry) > 0) {
                                                                                $count = $qry[0]->amount;
                                                                            } else {
                                                                                $count = 0;
                                                                            }
                                                                            ?>
                                                                            <input value="<?= $count ?>" id="truck_pool" class="form-control mask-int" name="truck_pool" autocomplete="off" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="border p-4 mt-2 mb-4">
                                        <legend class="w-auto h5">Chronology</legend>
                                        <div class="form-row">
                                            <div class="form-group col-7">
                                                <label for="chronology">Chronology</label>
                                                <textarea id="chronology" class="form-control" name="chronology" rows="3" required><?= $transHeader[0]->chronology ?></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-row mt-2 mb-4 justify-content-end">
                                        <button class="btn btn-primary px-4" type="submit">SAVE</button>
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



<script type="text/javascript" src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }} "></script>

<script type="text/javascript">
    $(document).ready(function() {
        moment.locale('id');

        $('.mask-decimal').mask("#.##", {
            reverse: true
        }).attr('maxlength', 3);
        $('.mask-int').mask("###", {
            reverse: true
        }).attr('maxlength', 4);

        $("#reportDate").datepicker();

        // TinyMCE //
        tinymce.init({
            selector: '#chronology',
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


    });
</script>

@endsection
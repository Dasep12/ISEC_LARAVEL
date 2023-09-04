<style>
    .detailss li {
        font-size: 13px;
    }

    .detailss h6 {
        font-weight: bold;
    }

    #detailInfo {
        font-weight: bold;
        font-style: italic;
    }
</style>

<p>
    <?= strtoupper("Laporan Akhir Shift " . date('d F Y', strtotime($date))) ?>
</p>
<p><?= strtoupper("Area " . $area[0]->area) ?></p>
<?php

use Modules\Soa\Entities\SoaModel;

foreach ($area as $ar) : ?>
    <?php
    $people = SoaModel::detail_people($ar->id_trans);
    $vehicle = SoaModel::detail_vehicle($ar->id_trans);
    $document = SoaModel::detail_material($ar->id_trans);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h6><?= $ar->shift  ?> </h6>
        </div>
        <div class="col-lg-4 detailss">
            <h6>People</h6>
            <ol style="list-style-type: square">
                <?php foreach ($people as $p) : ?>
                    <li><?= $p->title . ' : ' .  $p->totals ?></li>
                <?php endforeach ?>
            </ol>
        </div>
        <div class="col-lg-4 detailss">
            <h6>Vehicle</h6>
            <ol style="list-style-type: square">
                <?php foreach ($vehicle as $v) : ?>
                    <li><?= $v->title . ' : ' .  $v->totals ?></li>
                <?php endforeach ?>
            </ol>
        </div>
        <div class="col-lg-4 detailss">
            <h6>Document</h6>
            <ol style="list-style-type: square">
                <?php foreach ($document as $d) : ?>
                    <li><?= $d->title . ' : ' .  $d->totals ?></li>
                <?php endforeach ?>
            </ol>
        </div>
    </div>
    <hr>
<?php endforeach; ?>
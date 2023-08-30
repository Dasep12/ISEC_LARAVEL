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

<div class="row">
    <div class="col-lg-12">
        <h6>Shift 1 </h6>
    </div>
    <div class="col-lg-4 detailss">
        <h6>People</h6>
        <ol style="list-style-type: square">

        </ol>
    </div>
    <div class="col-lg-4 detailss">
        <h6>Vehicle</h6>
        <ol style="list-style-type: square">

        </ol>
    </div>
    <div class="col-lg-4 detailss">
        <h6>Document</h6>
        <ol style="list-style-type: square">

        </ol>
    </div>
</div>
<hr>
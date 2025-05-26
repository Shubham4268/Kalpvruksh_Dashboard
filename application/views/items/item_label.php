<div id="itemLabelToPrint">
    <div class="text-center">
        <h4><b>Kalpvruksh Enterprises</b></h4>
        <h4><?= $item['name'] ?></h4>
        <p>Price: &#8377;<?= number_format($item['unitPrice'], 2) ?></p>
        <p><b>KP Price: &#8377;<?= number_format($item['discountedPrice'] ?? $item['unitPrice'], 2) ?></b></p>
    </div>
</div>

<div class="text-center hidden-print">
    <button type="button" class="btn btn-primary pil">
        <i class="fa fa-print"></i> Print
    </button>
    <button type="button" class="btn btn-danger" data-dismiss='modal'>
        <i class="fa fa-close"></i> Close
    </button>
</div>

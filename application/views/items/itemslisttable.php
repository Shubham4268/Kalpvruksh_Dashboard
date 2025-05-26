<?php defined('BASEPATH') or exit('') ?>

<div class='col-sm-6'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>

<div class='col-sm-6 text-right'><b>Items Total Worth/Price:</b> &#8377;<?= $cum_total ? number_format($cum_total, 2) : '0.00' ?></div>

<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Items</div>
        <?php if ($allItems): ?>
            <div class="table table-responsive">
                <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>ITEM NAME</th>
                            <th>ITEM CODE</th>
                            <th>CATEGORY</th>
                            <th>MANUFACTURER</th>
                            <th>ADDED BY</th>
                            <th>DESCRIPTION</th>
                            <th>QTY IN STOCK</th>
                            <th>UNIT PRICE</th>
                            <th>TOTAL SOLD</th>
                            <th>TOTAL EARNED</th>
                            <th>UPDATE QTY</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allItems as $get): ?>
                            <tr>
                                <input type="hidden" value="<?= $get->id ?>" class="curItemId">
                                <th class="itemSN"><?= $sn ?>.</th>

                                <td><a class="pointer vil" title="Click to view label"><span id="itemName-<?= $get->id ?>"><?= htmlspecialchars($get->name) ?></span></a></td>

                                <td><span id="itemCode-<?= $get->id ?>"><?= htmlspecialchars($get->code) ?></span></td>

                                <td>
                                    <span id="itemCategory-<?= $get->id ?>">
                                        <?= htmlspecialchars($get->category_name) ?> (ID: <?= htmlspecialchars($get->categoryId) ?>)
                                    </span>
                                </td>

                                <td>
                                    <span id="itemMnf-<?= $get->id ?>">
                                        <?= htmlspecialchars($get->manufacturer_name) ?> (ID: <?= htmlspecialchars($get->mnfId) ?>)
                                    </span>
                                </td>

                                <td><span><?= htmlspecialchars($get->adminName ?? 'N/A') ?></span></td>

                                <td>
                                    <span id="itemDesc-<?= $get->id ?>" data-toggle="tooltip" title="<?= htmlspecialchars($get->description) ?>" data-placement="auto">
                                        <?= word_limiter(htmlspecialchars($get->description), 15) ?>
                                    </span>
                                </td>

                                <td class="<?= $get->quantity <= 10 ? 'bg-danger' : ($get->quantity <= 25 ? 'bg-warning' : '') ?>">
                                    <span id="itemQuantity-<?= $get->id ?>"><?= htmlspecialchars($get->quantity) ?></span>
                                </td>

                                <td>&#8377;<span id="itemPrice-<?= $get->id ?>"><?= number_format($get->unitPrice, 2) ?></span></td>

                                <td><?= $this->genmod->gettablecol('transactions', 'SUM(quantity)', 'itemCode', $get->code) ?></td>

                                <td>&#8377;<?= number_format((float)($this->genmod->gettablecol('transactions', 'SUM(totalPrice)', 'itemCode', $get->code) ?? 0), 2) ?></td>

                                <td><a class="pointer updateStock" id="stock-<?= $get->id ?>">Update Quantity</a></td>

                                <td class="text-center text-primary">
                                    <span class="editItem" id="edit-<?= $get->id ?>"><i class="fa fa-pencil pointer"></i></span>
                                </td>

                                <td class="text-center">
                                    <i class="fa fa-trash text-danger delItem pointer" id="delete-<?= $get->id ?>"></i>
                                </td>
                            </tr>

                            <?php $sn++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <ul>
                <li>No items</li>
            </ul>
        <?php endif; ?>
    </div>
</div>

<div class="col-sm-12 text-center">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class='col-sm-6'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>

<div class='col-sm-6 text-right'><b>Total Manufacturers:</b> <?= isset($allManufacturers) ? count($allManufacturers) : '0' ?></div>

<div class='col-xs-12'>
    <div class="panel panel-primary">
        <div class="panel-heading">Manufacturers</div>
        
        <?php if (!empty($allManufacturers)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>MANUFACTURER NAME</th>
                        <th>ADDRESS</th>
                        <th>CONTACT</th>
                        <th>EMAIL</th>
                        <th>ADMIN ID</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sn = 1; ?>
                    <?php foreach ($allManufacturers as $manufacturer): ?>
                    <tr>
                        <input type="hidden" value="<?= $manufacturer->id ?>" class="curManufacturerId">
                        <th class="manufacturerSN"> <?= $sn ?>.</th>
                        <td><span id="mnf_name-<?= $manufacturer->id ?>"> <?= htmlspecialchars($manufacturer->mnf_name) ?> </span></td>
                        <td>
                            <span id="address-<?= $manufacturer->id ?>" 
                                  data-toggle="tooltip" 
                                  title="<?= htmlspecialchars($manufacturer->mnf_address) ?>, <?= htmlspecialchars($manufacturer->town) ?>, <?= htmlspecialchars($manufacturer->tal) ?>, <?= htmlspecialchars($manufacturer->dist) ?> - <?= htmlspecialchars($manufacturer->pincode) ?>">
                                <?= word_limiter("{$manufacturer->mnf_address}, {$manufacturer->town}, {$manufacturer->tal}, {$manufacturer->dist} - {$manufacturer->pincode}", 12) ?>
                            </span>
                        </td>
                        <td><span id="contact-<?= $manufacturer->id ?>"> <?= htmlspecialchars($manufacturer->contact) ?> </span></td>
                        <td><span id="email-<?= $manufacturer->id ?>"> <?= htmlspecialchars($manufacturer->email) ?> </span></td>
                        <td><span id="adminId-<?= $manufacturer->id ?>"> <?= htmlspecialchars($manufacturer->adminId) ?> </span></td>
                        <td class="text-center text-primary">
                            <span class="editManufacturer" id="edit-<?= $manufacturer->id ?>">
                                <i class="fa fa-pencil pointer"></i>
                            </span>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash text-danger delManufacturer pointer" id="delete-<?= $manufacturer->id ?>"></i>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <ul><li>No manufacturers found</li></ul>
        <?php endif; ?>
    </div>
</div>

<div class="col-sm-12 text-center">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>

    <?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

    <div class='col-sm-6'>
        <?= isset($range) && !empty($range) ? $range : ""; ?>
    </div>

    <div class='col-sm-6 text-right'><b>Total Categories:</b> <?= isset($categories) ? count($categories) : '0' ?></div>

    <div class='col-xs-12'>
        <div class="panel panel-primary">
            <div class="panel-heading">Categories</div>

            <?php if (!empty($categories)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Manufacturer ID</th>
                                <th>Admin ID</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 1; ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <input type="hidden" value="<?= $cat->id ?>" class="curCategoryId">
                                    <th class="categorySN"><?= $sn ?>.</th>
                                    <td><span id="cat_name-<?= $cat->id ?>"><?= htmlspecialchars($cat->category_name) ?></span></td>
                                    <td><span id="cat_desc-<?= $cat->id ?>"><?= htmlspecialchars($cat->category_description) ?></span></td>
                                    <td>
                                        <span id="mnfId-<?= $cat->id ?>">
                                            <?= htmlspecialchars($cat->mnf_name) ?> (ID: <?= htmlspecialchars($cat->mnfId) ?>)
                                        </span>
                                    </td>
                                    <td><span id="adminId-<?= $cat->id ?>"><?= htmlspecialchars($cat->adminId) ?></span></td>
                                    <td class="text-center text-primary">
                                        <span class="editCategory pointer" id="edit-<?= $cat->id ?>">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa fa-trash text-danger delCategory pointer" id="delete-<?= $cat->id ?>"></i>
                                    </td>
                                </tr>
                                <?php $sn++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <ul>
                    <li>No categories found</li>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <?= isset($links) ? $links : "" ?>
        </ul>
    </div>
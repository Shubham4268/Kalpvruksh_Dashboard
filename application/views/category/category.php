<?php
defined('BASEPATH') or exit('');
?>

<div class="pwell hidden-print">
    <div class="row">
        <div class="col-sm-12">
            <!-- Controls for adding and searching category -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 form-inline form-group-sm">
                        <button class="btn btn-primary btn-sm" id='createCategory'>Add New Category</button>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="categoryListPerPage">Show</label>
                        <select id="categoryListPerPage" class="form-control">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>per page</label>
                    </div>

                    <div class="col-sm-4 form-group-sm form-inline">
                        <label for="categoryListSortBy">Sort by</label>
                        <select id="categoryListSortBy" class="form-control">
                            <option value="category_name-ASC">Category Name (A-Z)</option>
                            <option value="category_name-DESC">Category Name (Z-A)</option>
                            <option value="date_added-ASC">Date Added (Asc)</option>
                            <option value="date_added-DESC">Date Added (Desc)</option>
                        </select>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='categorySearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="categorySearch" class="form-control" placeholder="Search Category">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Form for adding new category -->
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4 hidden" id='createNewCategoryDiv'>
                <div class="well">
                    <button class="close cancelAddCategory">&times;</button><br>
                    <form name="addNewCategoryForm" id="addNewCategoryForm" role="form">
                        <div class="text-center errMsg" id='addCategoryErrMsg'></div>

                        <!-- Name -->
                        <div class="form-group-sm">
                            <label for="categoryName">Category Name</label>
                            <input type="text" id="categoryName" name="category_name" class="form-control" required>
                            <span class="help-block errMsg" id="categoryNameErr"></span>
                        </div>

                        <!-- Description -->
                        <div class="form-group-sm">
                            <label for="categoryDescription">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="category_description" rows='3' required></textarea>
                            <span class="help-block errMsg" id="categoryDescriptionErr"></span>
                        </div>

                        <!-- Manufacturer ID Dropdown -->
                        <div class="form-group-sm">
                            <label for="categoryManufacturerId">Manufacturer</label>
                            <select id="categoryManufacturerId" name="mnfId" class="form-control" required>
                                <option value="">Select Manufacturer</option>
                                <?php foreach ($allManufacturers as $manufacturer): ?>
                                    <option value="<?= $manufacturer->id ?>">
                                        <?= $manufacturer->mnf_name ?> (ID: <?= $manufacturer->id ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block errMsg" id="categoryManufacturerIdErr"></span>
                        </div>

                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewCategory" type="submit">Add Category</button>
                            </div>
                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddCategory" class="btn btn-danger btn-sm cancelAddCategory">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category List -->
            <div class="col-sm-12" id="categoryListDiv">
                <div class="row">
                    <div class="col-sm-12" id="categoryListTable"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal for Editing -->
<div id="editCategoryModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Edit Category</h4>
                <div id="editCategoryFMsg" class="text-center"></div>
            </div>

            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="categoryNameEdit">Category Name</label>
                            <input type="text" id="categoryNameEdit" class="form-control" required>
                            <span class="help-block errMsg" id="categoryNameEditErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="categoryDescriptionEdit">Description</label>
                            <textarea id="categoryDescriptionEdit" class="form-control" rows="3" required></textarea>
                            <span class="help-block errMsg" id="categoryDescriptionEditErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="categoryManufacturerIdEdit">Manufacturer</label>
                            <select id="categoryManufacturerIdEdit" class="form-control" required>
                                <option value="">Select Manufacturer</option>
                                <?php foreach ($allManufacturers as $manufacturer): ?>
                                    <option value="<?= $manufacturer->id ?>">
                                        <?= $manufacturer->mnf_name ?> (ID: <?= $manufacturer->id ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block errMsg" id="categoryManufacturerIdEditErr"></span>
                        </div>
                    </div>

                    <input type="hidden" id="categoryIdEdit">
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="editCategorySubmit">Save</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>


<script src="<?= base_url() ?>public/js/category.js"></script>
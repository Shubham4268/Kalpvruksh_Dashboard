<?php
defined('BASEPATH') or exit('');
?>

<div class="pwell hidden-print">
    <div class="row">
        <div class="col-sm-12">
            <!-- Controls for adding and searching manufacturer -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 form-inline form-group-sm">
                        <button class="btn btn-primary btn-sm" id='createManufacturer'>Add New Manufacturer</button>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="manufacturerListPerPage">Show</label>
                        <select id="manufacturerListPerPage" class="form-control">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>per page</label>
                    </div>

                    <div class="col-sm-4 form-group-sm form-inline">
                        <label for="manufacturerListSortBy">Sort by</label>
                        <select id="manufacturerListSortBy" class="form-control">
                            <option value="mnf_name-ASC">Manufacturer Name (A-Z)</option>
                            <option value="mnf_name-DESC">Manufacturer Name (Z-A)</option>
                            <option value="date_added-ASC">Date Added (Asc)</option>
                            <option value="date_added-DESC">Date Added (Desc)</option>
                        </select>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='manufacturerSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="manufacturerSearch" class="form-control" placeholder="Search Manufacturer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Form for adding new manufacturer -->
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4 hidden" id='createNewManufacturerDiv'>
                <div class="well">
                    <button class="close cancelAddManufacturer">&times;</button><br>
                    <form name="addNewManufacturerForm" id="addNewManufacturerForm" role="form">
                        <div class="text-center errMsg" id='addManufacturerErrMsg'></div>

                        <!-- Name -->
                        <div class="form-group-sm">
                            <label for="manufacturerName">Name</label>
                            <input type="text" id="manufacturerName" name="mnf_name" class="form-control" required>
                            <span class="help-block errMsg" id="manufacturerNameErr"></span>
                        </div>

                        <!-- Address -->
                        <div class="form-group-sm">
                            <label for="manufacturerAddress">Address</label>
                            <textarea class="form-control" id="manufacturerAddress" name="mnf_address" rows='3' required></textarea>
                            <span class="help-block errMsg" id="manufacturerAddressErr"></span>
                        </div>

                        <!-- Line 1: District & Taluka -->
                        <div class="row">
                            <div class="col-sm-6 form-group-sm" style="padding-right: 5px;">
                                <label for="manufacturerDistrict">District</label>
                                <input type="text" id="manufacturerDistrict" name="dist" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerDistrictErr"></span>
                            </div>
                            <div class="col-sm-6 form-group-sm" style="padding-left: 5px;">
                                <label for="manufacturerTaluka">Taluka</label>
                                <input type="text" id="manufacturerTaluka" name="tal" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerTalukaErr"></span>
                            </div>
                        </div>

                        <!-- Line 2: Town & Pincode -->
                        <div class="row">
                            <div class="col-sm-6 form-group-sm" style="padding-right: 5px;">
                                <label for="manufacturerTown">Town</label>
                                <input type="text" id="manufacturerTown" name="town" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerTownErr"></span>
                            </div>
                            <div class="col-sm-6 form-group-sm" style="padding-left: 5px;">
                                <label for="manufacturerPincode">Pincode</label>
                                <input type="text" id="manufacturerPincode" name="pincode" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerPincodeErr"></span>
                            </div>
                        </div>

                        <!-- Line 3: Contact & Email -->
                        <div class="row">
                            <div class="col-sm-6 form-group-sm" style="padding-right: 5px;">
                                <label for="manufacturerContact">Contact</label>
                                <input type="text" id="manufacturerContact" name="contact" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerContactErr"></span>
                            </div>
                            <div class="col-sm-6 form-group-sm" style="padding-left: 5px;">
                                <label for="manufacturerEmail">Email</label>
                                <input type="email" id="manufacturerEmail" name="email" class="form-control" required>
                                <span class="help-block errMsg" id="manufacturerEmailErr"></span>
                            </div>
                        </div>

                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewManufacturer" type="submit">Add Manufacturer</button>
                            </div>
                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddManufacturer" class="btn btn-danger btn-sm cancelAddManufacturer">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manufacturer List -->
            <div class="col-sm-12" id="manufacturerListDiv">
                <div class="row">
                    <div class="col-sm-12" id="manufacturerListTable"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal to edit manufacturer -->
<div id="editManufacturerModal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center">Edit Manufacturer</h4>
        <div id="editManufacturerFMsg" class="text-center"></div>
      </div>
      <div class="modal-body">
        <form role="form">
          <div class="row">
            <div class="col-sm-12 form-group-sm">
              <label for="manufacturerNameEdit">Name</label>
              <input type="text" id="manufacturerNameEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerNameEditErr"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 form-group-sm">
              <label for="manufacturerAddressEdit">Address</label>
              <textarea id="manufacturerAddressEdit" class="form-control" required></textarea>
              <span class="help-block errMsg" id="manufacturerAddressEditErr"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerDistrictEdit">District</label>
              <input type="text" id="manufacturerDistrictEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerDistrictEditErr"></span>
            </div>
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerTalukaEdit">Taluka</label>
              <input type="text" id="manufacturerTalukaEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerTalukaEditErr"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerTownEdit">Town</label>
              <input type="text" id="manufacturerTownEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerTownEditErr"></span>
            </div>
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerPincodeEdit">Pincode</label>
              <input type="text" id="manufacturerPincodeEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerPincodeEditErr"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerContactEdit">Contact Number</label>
              <input type="text" id="manufacturerContactEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerContactEditErr"></span>
            </div>
            <div class="col-sm-6 form-group-sm">
              <label for="manufacturerEmailEdit">Email</label>
              <input type="email" id="manufacturerEmailEdit" class="form-control" required>
              <span class="help-block errMsg" id="manufacturerEmailEditErr"></span>
            </div>
          </div>

          <input type="hidden" id="manufacturerIdEdit">
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="editManufacturerSubmit">Save</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<script src="<?= base_url() ?>public/js/manufacturer.js"></script>
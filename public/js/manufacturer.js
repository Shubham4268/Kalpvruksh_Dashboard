'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);

    lmlt(); // Load all manufacturers on page ready

    // Toggle form for adding a new manufacturer
    $("#createManufacturer").click(function () {
        $("#manufacturerListDiv").toggleClass("col-sm-8 col-sm-12");
        $("#createNewManufacturerDiv").toggleClass('hidden');
        $("#manufacturerName").focus();
    });

    $(".cancelAddManufacturer").click(function () {
        document.getElementById("addNewManufacturerForm").reset();
        $("#createNewManufacturerDiv").addClass('hidden');
        $("#manufacturerListDiv").attr('class', "col-sm-12");
        $("#addManufacturerErrMsg").text("");
        $(".errMsg").text(""); 
    });

    // Adding a new manufacturer
    $("#addNewManufacturer").click(function (e) {
        e.preventDefault();
        const $btn = $(this).prop("disabled", true);
        const fields = [
            { id: "manufacturerName", name: "mnf_name" },
            { id: "manufacturerAddress", name: "mnf_address" },
            { id: "manufacturerDistrict", name: "dist" },
            { id: "manufacturerTaluka", name: "tal" },
            { id: "manufacturerTown", name: "town" },
            { id: "manufacturerPincode", name: "pincode" },
            { id: "manufacturerContact", name: "contact" },
            { id: "manufacturerEmail", name: "email" },
        ];

        let data = {}, hasError = false;

        $(".errMsg").text(""); // clear all errors

        fields.forEach(f => {
            const value = $(`#${f.id}`).val().trim();
            data[f.name] = value;
            if (!value) {
                $(`#${f.id}Err`).text("Required");
                hasError = true;
            }
        });

        if (hasError) {
            $("#addManufacturerErrMsg").text("Please fill all required fields.");
            return $btn.prop("disabled", false);
        }

        displayFlashMsg(`Adding Manufacturer '${data.mnf_name}'`, "fa fa-spinner faa-spin animated", '', '');

        $.post(appRoot + "manufacturer/add", data)
            .done(res => {
                if (res.status === 1) {
                    changeFlashMsgContent(res.msg, "text-success", '', 1500);
                    $("#addNewManufacturerForm")[0].reset();
                    lmlt();
                    $("#manufacturerName").focus();
                } else {
                    hideFlashMsg();
                    Object.keys(data).forEach(key => {
                        const errField = key === "mnf_name" ? "manufacturerName" :
                            key === "mnf_address" ? "manufacturerAddress" :
                                "manufacturer" + key.charAt(0).toUpperCase() + key.slice(1);
                        $(`#${errField}Err`).text(res[key] || "");
                    });
                    $("#addManufacturerErrMsg").text(res.msg);
                }
            })
            .fail(() => {
                changeFlashMsgContent("Unable to process your request. Please try again later!", "", "red", "");
            })
            .always(() => $btn.prop("disabled", false));
    });


    // Manufacturer search
    $("#manufacturerSearch").keyup(function () {
        var value = $(this).val();

        if (value) {
            $.ajax({
                url: appRoot + "search/manufacturersearch",
                type: "get",
                data: { v: value },
                success: function (returnedData) {
                    $("#manufacturerListTable").html(returnedData.manufacturerListTable);
                }
            });
        } else {
            lmlt();
        }
    });



    $("#manufacturerListTable").on('click', '.delManufacturer', function (e) {
        e.preventDefault();

        if (!confirm("Are you sure you want to delete this manufacturer?")) return;

        const manufacturerId = $(this).attr('id').split("-")[1];

        $.ajax({
            method: "POST",
            url: appRoot + "manufacturer/delete",
            data: { id: manufacturerId },
            success: function (res) {
                if (res.status === 1) {
                    lmlt();  // reload the manufacturer table
                } else {
                    alert(res.msg || "Deletion failed.");
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
    });

    // Edit manufacturer modal
    $("#manufacturerListTable").on('click', ".editManufacturer", function (e) {
        e.preventDefault();

        var manufacturerId = $(this).attr('id').split("-")[1];

        var manufacturerName = $("#mnf_name-" + manufacturerId).text().trim();
        var contact = $("#contact-" + manufacturerId).text().trim();
        var email = $("#email-" + manufacturerId).text().trim();

        var fullAddress = $("#address-" + manufacturerId).attr("title").trim(); // e.g., "Addr line, Town, Taluka, Dist - Pincode"
        console.log(fullAddress);

        // Parse fullAddress

        const addressRegex = /^(.*?),\s*([^,]+),\s*([^,]+),\s*([^,]+)\s*-\s*(\d{6})$/;
        const match = fullAddress.match(addressRegex);

        var address = "";
        var town = "";
        var tal = "";
        var dist = "";
        var pincode = "";


        if (match) {
            address = match[1];     // Sector 18
            town = match[2];        // Kopar Khairane
            tal = match[3];         // Thane
            dist = match[4];        // Navi Mumbai
            pincode = match[5];     // 431455
        }

        console.log({ address, town, tal, dist, pincode });

        // Set modal input values
        $("#manufacturerIdEdit").val(manufacturerId);
        $("#manufacturerNameEdit").val(manufacturerName);
        $("#manufacturerAddressEdit").val(address);
        $("#manufacturerTownEdit").val(town);
        $("#manufacturerTalukaEdit").val(tal);
        $("#manufacturerDistrictEdit").val(dist);
        $("#manufacturerPincodeEdit").val(pincode);
        $("#manufacturerContactEdit").val(contact);
        $("#manufacturerEmailEdit").val(email);

        // Show modal
        $("#editManufacturerModal").modal('show');
    });

    $("#editManufacturerSubmit").click(function () {
        const data = {
            id: $("#manufacturerIdEdit").val(),
            mnf_name: $("#manufacturerNameEdit").val(),
            mnf_address: $("#manufacturerAddressEdit").val(),
            contact: $("#manufacturerContactEdit").val(),
            email: $("#manufacturerEmailEdit").val(),
            dist: $("#manufacturerDistrictEdit").val(),
            tal: $("#manufacturerTalukaEdit").val(),
            town: $("#manufacturerTownEdit").val(),
            pincode: $("#manufacturerPincodeEdit").val()
        };

        // Basic check
        if (!data.id || !data.mnf_name || !data.mnf_address) {
            $("#manufacturerNameEditErr").html(!data.mnf_name ? "Required" : "");
            $("#manufacturerAddressEditErr").html(!data.mnf_address ? "Required" : "");
            return;
        }
        console.log(data);

        $.ajax({
            method: "POST",
            url: appRoot + "manufacturer/edit",
            data
        }).done(function (res) {
            if (res.status === 1) {
                $("#editManufacturerModal").modal('hide');
                lmlt();
            } else {
                $(".errMsg").html("");
                Object.keys(res).forEach(function (key) {
                    if (key !== 'status') {
                        $("#" + key + "EditErr").html(res[key].replace(/<\/?p>/g, ""));
                    }
                });
            }
        }).fail(function () {
            $("#editManufacturerFMsg").css('color', 'red').html("Request failed. Please try again.");
        });
    });

    // Reload manufacturer list table when sort or limit dropdowns change
    $("#manufacturerListPerPage, #manufacturerListSortBy").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lmlt(); // Reload manufacturer list
    });


});


function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

// Load Manufacturers List Table
function lmlt(url) {
    const sortVal = $("#manufacturerListSortBy").val();
    const limit = $("#manufacturerListPerPage").val();

    // Provide safe fallback if sortVal is malformed or empty
    const [orderBy, orderFormat] = sortVal ? sortVal.split("-") : ["manufacturer_name", "ASC"];

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "Manufacturer/lmlt/1", // default to page 1
        data: {
            orderBy: orderBy,
            orderFormat: orderFormat,
            limit: limit
        },
        success: function (returnedData) {
            hideFlashMsg();
            $("#manufacturerListTable").html(returnedData.manufacturerListTable);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            changeFlashMsgContent("Failed to load manufacturers. Try again.", "", "red", "");
        }
    });

    return false;
}

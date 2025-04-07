'use strict';

$(document).ready(function () {
    // Check if user is logged in
    checkDocumentVisibility(checkLogin);

    // Load the list of categories initially
    loadCategoryList();

    // Show/Hide Create Category form
    $("#createCategory").click(function () {
        $("#categoryListDiv").toggleClass("col-sm-8 col-sm-12");
        $("#createNewCategoryDiv").toggleClass('hidden');
        $("#categoryName").focus();
    });

    // Cancel button resets form and hides the create form
    $(".cancelAddCategory").click(function () {
        $("#addNewCategoryForm")[0].reset();
        $("#createNewCategoryDiv").addClass('hidden');
        $("#categoryListDiv").attr('class', "col-sm-12");
        $("#addCategoryErrMsg").text("");
        $(".errMsg").text("");
    });

    // Add new category form submit
    $("#addNewCategory").click(function (e) {
        e.preventDefault();
        const $btn = $(this).prop("disabled", true);

        const fields = [
            { id: "categoryName", name: "category_name" },
            { id: "categoryDescription", name: "category_description" },
            { id: "categoryManufacturerId", name: "mnfId" }
        ];

        let data = {}, hasError = false;

        $(".errMsg").text("");

        fields.forEach(f => {
            const value = $(`#${f.id}`).val().trim();
            data[f.name] = value;
            if (!value) {
                $(`#${f.id}Err`).text("Required");
                hasError = true;
            }
        });

        if (hasError) {
            $("#addCategoryErrMsg").text("Please fill all required fields.");
            return $btn.prop("disabled", false);
        }

        displayFlashMsg(`Adding Category '${data.category_name}'`, "fa fa-spinner faa-spin animated", '', '');

        $.post(appRoot + "Category/add", data)
            .done(res => {
                if (res.status === 1) {
                    changeFlashMsgContent(res.msg, "text-success", '', 1500);
                    $("#addNewCategoryForm")[0].reset();
                    loadCategoryList();
                    $("#categoryName").focus();
                } else {
                    hideFlashMsg();
                    Object.keys(data).forEach(key => {
                        const errField = key === "category_name" ? "categoryName" :
                            key === "category_description" ? "categoryDescription" :
                                key === "mnfId" ? "categoryManufacturerId" : key;
                        $(`#${errField}Err`).text(res[key] || "");
                    });
                    $("#addCategoryErrMsg").text(res.msg);
                }
            })
            .fail(() => {
                changeFlashMsgContent("Unable to process your request. Please try again later!", "", "red", "");
            })
            .always(() => $btn.prop("disabled", false));
    });

    // Live search categories
    $("#categorySearch").keyup(function () {
        const value = $(this).val();
        if (value) {
            $.ajax({
                url: appRoot + "search/categorysearch",
                type: "get",
                data: { v: value },
                success: function (returnedData) {
                    $("#categoryListTable").html(returnedData.categoryListTable);
                }
            });
        } else {
            loadCategoryList();
        }
    });

    // Sorting and pagination
    $("#categoryListPerPage, #categoryListSortBy").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        loadCategoryList();
    });

    // Trigger edit modal with existing data
    $("#categoryListTable").on('click', ".editCategory", function (e) {
        e.preventDefault();

        const categoryId = $(this).attr('id').split("-")[1];

        const categoryName = $(`#cat_name-${categoryId}`).text().trim();
        const description = $(`#cat_desc-${categoryId}`).text().trim();
        const mnfText = $(`#mnfId-${categoryId}`).text().trim();
        const mnfIdMatch = mnfText.match(/\(ID:\s*(\d+)\)/);
        const mnfId = mnfIdMatch ? mnfIdMatch[1] : "";


        // Set modal input values
        $("#categoryIdEdit").val(categoryId);
        $("#categoryNameEdit").val(categoryName);
        $("#categoryDescriptionEdit").val(description);
        $("#categoryManufacturerIdEdit").val(mnfId);

        // Show modal
        $("#editCategoryModal").modal('show');
    });

    // Submit update
    $("#editCategorySubmit").click(function () {
        const data = {
            id: $("#categoryIdEdit").val(),
            category_name: $("#categoryNameEdit").val().trim(),
            category_description: $("#categoryDescriptionEdit").val().trim(),
            mnfId: $("#categoryManufacturerIdEdit").val()
        };

        // Clear previous error messages
        $(".errMsg").html("");

        let hasError = false;
        if (!data.category_name) {
            $("#categoryNameEditErr").html("Required");
            hasError = true;
        }
        if (!data.category_description) {
            $("#categoryDescriptionEditErr").html("Required");
            hasError = true;
        }
        if (!data.mnfId) {
            $("#categoryManufacturerIdEditErr").html("Required");
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            method: "POST",
            url: appRoot + "category/edit",
            data
        }).done(function (res) {
            if (res.status === 1) {
                $("#editCategoryModal").modal('hide');
                loadCategoryList(); // You should define this function to re-fetch list
            } else {
                $(".errMsg").html("");
                Object.keys(res).forEach(key => {
                    if (key !== 'status') {
                        $(`#${key}EditErr`).html(res[key].replace(/<\/?p>/g, ""));
                    }
                });
            }
        }).fail(function () {
            $("#editCategoryFMsg").css('color', 'red').html("Request failed. Please try again.");
        });
    });

    $("#categoryListTable").on('click', '.delCategory', function (e) {
        e.preventDefault();

        if (!confirm("Are you sure you want to delete this category?")) return;

        const categoryId = $(this).attr('id').split("-")[1];

        $.ajax({
            method: "POST",
            url: appRoot + "category/delete",  // Make sure your route matches
            data: { id: categoryId },
            success: function (res) {
                if (res.status === 1) {
                    loadCategoryList();  // categoryListLoadTable or however you reload the table
                } else {
                    alert(res.msg || "Deletion failed.");
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
    });


});


function loadCategoryList(url) {
    const sortVal = $("#categoryListSortBy").val().split("-");
    const orderBy = sortVal[0];
    const orderFormat = sortVal[1];
    const limit = $("#categoryListPerPage").val();


    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "Category/loadCategoryList",
        data: { orderBy: orderBy, orderFormat: orderFormat, limit: limit },

        success: function (returnedData) {
            hideFlashMsg();
            $("#categoryListTable").html(returnedData.categoryListTable);
        },

        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            changeFlashMsgContent("Failed to load categories. Try again.", "", "red", "");
        }
    });

    return false;
}

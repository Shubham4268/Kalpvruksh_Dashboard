'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status

    //load all items once the page is ready
    lilt();



    //WHEN USE BARCODE SCANNER IS CLICKED
    $("#useBarcodeScanner").click(function (e) {
        e.preventDefault();

        $("#itemCode").focus();
    });




    /**
     * Toggle the form to add a new item
     */
    $("#createItem").click(function () {
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewItemDiv").toggleClass('hidden');
        $("#itemName").focus();
    });





    $(".cancelAddItem").click(function () {
        //reset and hide the form
        document.getElementById("addNewItemForm").reset();//reset the form
        $("#createNewItemDiv").addClass('hidden');//hide the form
        $("#itemsListDiv").attr('class', "col-sm-12");//make the table span the whole div
    });




    //execute when 'auto-generate' checkbox is clicked while trying to add a new item
    $("#gen4me").click(function () {
        //if checked, generate a unique item code for user. Else, clear field
        if ($("#gen4me").prop("checked")) {
            var codeExist = false;

            do {
                //generate random string, reduce the length to 10 and convert to uppercase
                var rand = Math.random().toString(36).slice(2).substring(0, 10).toUpperCase();
                $("#itemCode").val(rand);//paste the code in input
                $("#itemCodeErr").text('');//remove the error message being displayed (if any)

                //check whether code exist for another item
                $.ajax({
                    type: 'get',
                    url: appRoot + "items/gettablecol/id/code/" + rand,
                    success: function (returnedData) {
                        codeExist = returnedData.status;//returnedData.status could be either 1 or 0
                    }
                });
            }

            while (codeExist);

        }

        else {
            $("#itemCode").val("");
        }
    });

    // Show the add item form
    $('#addItemBtn').on('click', function () {
        $('#createNewItemDiv').removeClass('hidden');
    });

    // Cancel and hide the form
    $('.cancelAddItem').on('click', function () {
        $('#createNewItemDiv').addClass('hidden');
        $('#addNewItemForm')[0].reset();
        $('.errMsg').html('');
    });

    // Field validation helper
    function checkField(value, errId) {
        if (!value.trim()) {
            $('#' + errId).text('Required field');
            return false;
        }
        $('#' + errId).text('');
        return true;
    }

    // Hook onchange validations
    window.checkField = checkField;

    // Submit handler
    $('#addNewItem').on('click', function (e) {
        e.preventDefault();

        let isValid = true;

        isValid &= checkField($('#itemCode').val(), 'itemCodeErr');
        isValid &= checkField($('#itemName').val(), 'itemNameErr');
        isValid &= checkField($('#itemQuantity').val(), 'itemQuantityErr');
        isValid &= checkField($('#itemPrice').val(), 'itemPriceErr');
        isValid &= checkField($('#itemCategory').val(), 'itemCategoryErr');
        isValid &= checkField($('#itemMnf').val(), 'itemMnfErr');

        if (!isValid) return;

        const formData = {
            itemCode: $('#itemCode').val().trim(),
            itemName: $('#itemName').val().trim(),
            itemQuantity: $('#itemQuantity').val(),
            itemPrice: $('#itemPrice').val().trim(),
            itemDescription: $('#itemDescription').val().trim(),
            itemCategory: $('#itemCategory').val(),
            itemMnf: $('#itemMnf').val()
        };

        console.log(formData);

        $.ajax({
            url: 'Items/add', // Change to your actual route
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (res) {
                if (res.status === 1) {
                    $('#addNewItemForm')[0].reset();
                    $('#createNewItemDiv').addClass('hidden');
                    console.log(res);

                    lilt();
                } else {
                    $('#addCustErrMsg').html(`<span class="text-danger">${res.message}</span>`);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                $('#addCustErrMsg').html(`<span class="text-danger">An error occurred. Try again.</span>`);
            }
        });
    });

    //reload items list table when events occur
    $("#itemsListPerPage, #itemsListSortBy").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lilt();
    });



    $("#itemSearch").keyup(function () {
        var value = $(this).val();

        if (value) {
            $.ajax({
                url: appRoot + "Search/itemSearch",
                type: "get",
                data: { v: value },
                success: function (returnedData) {
                    $("#itemsListTable").html(returnedData.itemsListTable);
                }
            });
        }

        else {
            //reload the table if all text in search box has been cleared

            lilt();
        }
    });



    //triggers when an item's "edit" icon is clicked
    $("#itemsListTable").on('click', ".editItem", function (e) {
    e.preventDefault();

    const itemId = $(this).attr('id').split("-")[1];

    const itemName = $(`#itemName-${itemId}`).text().trim();
    const itemCode = $(`#itemCode-${itemId}`).text().trim();
    const itemPrice = $(`#itemPrice-${itemId}`).text().trim().replace(/,/g, '').split(".")[0];
    const itemDesc = $(`#itemDesc-${itemId}`).attr("title") || "";
    console.log(itemDesc);
    
    const categoryText = $(`#itemCategory-${itemId}`).text().trim();
    const categoryIdMatch = categoryText.match(/\(ID:\s*(\d+)\)/);
    const categoryId = categoryIdMatch ? categoryIdMatch[1] : "";
    
    const mnfText = $(`#itemMnf-${itemId}`).text().trim();
    const mnfIdMatch = mnfText.match(/\(ID:\s*(\d+)\)/);
    const mnfId = mnfIdMatch ? mnfIdMatch[1] : "";
    console.log(itemId);
    console.log(mnfText);
    console.log(mnfIdMatch);

    // Fill modal form fields
    $("#itemIdEdit").val(itemId);
    $("#itemNameEdit").val(itemName);
    $("#itemCodeEdit").val(itemCode);
    $("#itemPriceEdit").val(itemPrice);
    $("#itemDescriptionEdit").val(itemDesc);
    $("#itemCategoryEdit").val(categoryId);
    $("#itemMnfEdit").val(mnfId);

    // Clear old error messages
    $(".errMsg").html("");
    $("#editItemFMsg").html("");

    // Show modal
    $("#editItemModal").modal('show');
});


    $("#editItemSubmit").click(function () {
        var itemName = $("#itemNameEdit").val();
        var itemPrice = $("#itemPriceEdit").val();
        var itemDesc = $("#itemDescriptionEdit").val();
        var itemId = $("#itemIdEdit").val();
        var itemCode = $("#itemCodeEdit").val();
        var itemCategory = $("#itemCategoryEdit").val();
        var itemMnf = $("#itemMnfEdit").val();

        let hasError = false;

        if (!itemName) { $("#itemNameEditErr").html("Item name cannot be empty"); hasError = true; }
        if (!itemPrice) { $("#itemPriceEditErr").html("Item price cannot be empty"); hasError = true; }
        if (!itemCategory) { $("#itemCategoryEditErr").html("Please select a category"); hasError = true; }
        if (!itemMnf) { $("#itemMnfEditErr").html("Please select a manufacturer"); hasError = true; }
        if (!itemId) { $("#editItemFMsg").html("Unknown item"); hasError = true; }

        if (hasError) return;

        $("#editItemFMsg").css('color', 'black').html("<i class='" + spinnerClass + "'></i> Processing your request....");

        $.ajax({
            method: "POST",
            url: appRoot + "items/edit",
            data: {
                itemName, itemPrice, itemDesc, _iId: itemId,
                itemCode, itemCategory, itemMnf
            },
            dataType: "json"
        }).done(function (returnedData) {
            if (returnedData.status === 1) {
                $("#editItemFMsg").css('color', 'green').html("Item successfully updated");

                setTimeout(function () {
                    $("#editItemModal").modal('hide');
                }, 1000);

                lilt();
            } else {
                $("#editItemFMsg").css('color', 'red').html(returnedData.msg || "Validation failed");

                if (returnedData.itemName) $("#itemNameEditErr").html(returnedData.itemName);
                if (returnedData.itemCode) $("#itemCodeEditErr").html(returnedData.itemCode);
                if (returnedData.itemPrice) $("#itemPriceEditErr").html(returnedData.itemPrice);
                if (returnedData.itemCategory) $("#itemCategoryEditErr").html(returnedData.itemCategory);
                if (returnedData.itemMnf) $("#itemMnfEditErr").html(returnedData.itemMnf);
            }
        }).fail(function () {
            $("#editItemFMsg").css('color', 'red').html("Unable to process your request. Please try again.");
        });
    });


    //trigers the modal to update stock
    $("#itemsListTable").on('click', '.updateStock', function () {
        //get item info and fill the form with them
        var itemId = $(this).attr('id').split("-")[1];
        var itemName = $("#itemName-" + itemId).html();
        var itemCurQuantity = $("#itemQuantity-" + itemId).html();
        var itemCode = $("#itemCode-" + itemId).html();

        $("#stockUpdateItemId").val(itemId);
        $("#stockUpdateItemName").val(itemName);
        $("#stockUpdateItemCode").val(itemCode);
        $("#stockUpdateItemQInStock").val(itemCurQuantity);

        $("#updateStockModal").modal('show');
    });




    //runs when the update type is changed while trying to update stock
    //sets a default description if update type is "newStock"
    $("#stockUpdateType").on('change', function () {
        var updateType = $("#stockUpdateType").val();

        if (updateType && (updateType === 'newStock')) {
            $("#stockUpdateDescription").val("New items were purchased");
        }

        else {
            $("#stockUpdateDescription").val("");
        }
    });



    //handles the updating of item's quantity in stock
    $("#stockUpdateSubmit").click(function () {
        var updateType = $("#stockUpdateType").val();
        var stockUpdateQuantity = $("#stockUpdateQuantity").val();
        var stockUpdateDescription = $("#stockUpdateDescription").val();
        var itemId = $("#stockUpdateItemId").val();

        if (!updateType || !stockUpdateQuantity || !stockUpdateDescription || !itemId) {
            !updateType ? $("#stockUpdateTypeErr").html("required") : "";
            !stockUpdateQuantity ? $("#stockUpdateQuantityErr").html("required") : "";
            !stockUpdateDescription ? $("#stockUpdateDescriptionErr").html("required") : "";
            !itemId ? $("#stockUpdateItemIdErr").html("required") : "";

            return;
        }

        $("#stockUpdateFMsg").html("<i class='" + spinnerClass + "'></i> Updating Stock.....");

        $.ajax({
            method: "POST",
            url: appRoot + "items/updatestock",
            data: { _iId: itemId, _upType: updateType, qty: stockUpdateQuantity, desc: stockUpdateDescription }
        }).done(function (returnedData) {
            if (returnedData.status === 1) {
                $("#stockUpdateFMsg").html(returnedData.msg);

                //refresh items' list
                lilt();

                //reset form
                document.getElementById("updateStockForm").reset();

                //dismiss modal after some secs
                setTimeout(function () {
                    $("#updateStockModal").modal('hide');//hide modal
                    $("#stockUpdateFMsg").html("");//remove msg
                }, 1000);
            }

            else {
                $("#stockUpdateFMsg").html(returnedData.msg);

                $("#stockUpdateTypeErr").html(returnedData._upType);
                $("#stockUpdateQuantityErr").html(returnedData.qty);
                $("#stockUpdateDescriptionErr").html(returnedData.desc);
            }
        }).fail(function () {
            $("#stockUpdateFMsg").html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });



    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER
    $("#itemCode").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();

            //change to next input by triggering the tab keyboard
            $("#itemName").focus();
        }
    });



    //TO DELETE AN ITEM (The item will be marked as "deleted" instead of removing it totally from the db)
    $("#itemsListTable").on('click', '.delItem', function (e) {
        e.preventDefault();

        //get the item id
        var itemId = $(this).parents('tr').find('.curItemId').val();
        var itemRow = $(this).closest('tr');//to be used in removing the currently deleted row

        if (itemId) {
            var confirm = window.confirm("Are you sure you want to delete item? This cannot be undone.");

            if (confirm) {
                displayFlashMsg('Please wait...', spinnerClass, 'black');

                $.ajax({
                    url: appRoot + "items/delete",
                    method: "POST",
                    data: { i: itemId }
                }).done(function (rd) {
                    if (rd.status === 1) {
                        //remove item from list, update items' SN, display success msg
                        $(itemRow).remove();

                        //update the SN
                        resetItemSN();

                        //display success message
                        changeFlashMsgContent('Item deleted', '', 'green', 1000);
                    }

                    else {

                    }
                }).fail(function () {
                    console.log('Req Failed');
                });
            }
        }
    });
});



/**
 * "lilt" = "load Items List Table"
 * @param {type} url
 * @returns {undefined}
 */
function lilt(url) {
    var orderBy = $("#itemsListSortBy").val().split("-")[0];
    var orderFormat = $("#itemsListSortBy").val().split("-")[1];
    var limit = $("#itemsListPerPage").val();

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "items/lilt/1", // force page 1 if none given
        data: { orderBy: orderBy, orderFormat: orderFormat, limit: limit },

        success: function (returnedData) {
            hideFlashMsg();
            $("#itemsListTable").html(returnedData.itemsListTable); // <-- this ID must exist
        },

        error: function () {
            console.error("Failed to load items.");
        }
    });

    return false;
}



/**
 * "vittrhist" = "View item's transaction history"
 * @param {type} itemId
 * @returns {Boolean}
 */
function vittrhist(itemId) {
    if (itemId) {

    }

    return false;
}



function resetItemSN() {
    $(".itemSN").each(function (i) {
        $(this).html(parseInt(i) + 1);
    });
}
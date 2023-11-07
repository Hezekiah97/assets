$(function () {
  //load category create form
  $(".loadCategoryCreateForm").click(function () {
    $(".add-new-category").hide();
    $("#show-category-form").load($(this).attr("value"));
  });

  //load category update form
  $(".loadCategoryEditForm").click(function () {
    $(".add-new-category").hide();
    $("#show-category-form").load($(this).attr("value"));
  });

  //load owners create form
  $(".loadOwnerCreateForm").click(function () {
    $("#show-owners-form").load($(this).attr("value"));
  });

  //load owners update form
  $(".loadOwnerEdittForm").click(function () {
    $("#show-owners-form").load($(this).attr("value"));
  });

  //import book modal
  $(".importBtn").click(function (e) {
    $("#importModal")
      .modal("show")
      .find("#importModalContent")
      .load($(this).attr("value"));
  });

  //import asset modal
  $(".assetsImportBtn").click(function (e) {
    $("#assetsImportModal")
      .modal("show")
      .find("#assetsImportModalContent")
      .load($(this).attr("value"));
  });
});

// let rows = document.querySelectorAll('.row');
// rows.forEach((row) => {
//     row.addEventListener('click', (e) => {

//     if (e.target.classList.contains('showModalButton')) {

//     $('#modal').modal('show').find('#modalContent').load($('.showModalButton').attr('value'));

//     }
//     })
// })

// DELETE SELECTED BOOKS STARTS

$(".deleteBooksBtn").hide();

const singleBtns = document.querySelectorAll("#customCheckBook");

$("#customCheckAllBooks").change(() => {
  if (document.getElementById("customCheckAllBooks").checked == true) {
    $(this).prop("checked", true);

    singleBtns.forEach((btn) => {
      if (!btn.checked === true) {
        btn.checked = true;
      }
    });

    $(".deleteBooksBtn").show();
  } else {
    singleBtns.forEach((btn) => {
      if (btn.checked === true) {
        btn.checked = false;
      }
    });

    $(".deleteBooksBtn").hide();
  }
});

singleBtns.forEach((btn) => {
  btn.addEventListener("change", () => {
    if (btn.checked === true) {
      $(".deleteBooksBtn").show();
    } else {
      if (!document.getElementById("customCheckAllBooks").checked == true) {
        $(".deleteBooksBtn").hide();
      }
    }
  });
});

function deleteUsers() {
  const selected = $(`#users-table`).yiiGridView("getSelectedRows");
  const url = "index.php?r=user/delete-users";
  const location = "index.php?r=user/index";

  deleteHandler(url, selected, location);
}

function deleteAuthItem() {
  const selected = $(`#auth-item-table`).yiiGridView("getSelectedRows");
  const url = "index.php?r=auth-items/delete-items";
  const location = "index.php?r=auth-items/index";

  deleteHandler(url, selected, location);
}

function deleteAuthAssignments() {
  const selected = $(`#auth-assignment-table`).yiiGridView("getSelectedRows");
  const url = "index.php?r=auth-assignment/delete-items";
  const location = "index.php?r=auth-assignment/index";

  deleteHandler(url, selected, location);
}

function deleteAssets() {
  const selected = $(`#assets-table`).yiiGridView("getSelectedRows");
  const url = "index.php?r=assets/delete-assets";
  const location = "index.php?r=assets/index";

  deleteHandler(url, selected, location);
}

function deleteBook(id) {
  const selected = $(`#${id}`).yiiGridView("getSelectedRows");
  let url = "index.php?r=book/delete-books";
  let location = "index.php?r=book/index";

  if (id === "book-stock-table") {
    url = "index.php?r=book-stock/delete-stock-books";
    location = "index.php?r=book-stock/index";
  }

  deleteHandler(url, selected, location);
}

// DELETE SELECTED BOOKS ENDS

function deleteHandler(url, selected, location) {
  if (selected.length == 0) {
    bootbox.alert({
      message: "Please select data to delete!",
      size: "small",
      buttons: {
        ok: {
          label: "<i class='mdi mdi-check'></i> OK",
          className: "btn btn-primary btn-sm",
        },
      },
    });
  } else {
    bootbox.confirm({
      message: "Are you sure you want to delete this item(s)?",
      size: "small",
      buttons: {
        confirm: {
          label: "<i class='mdi mdi-check'></i> OK",
          className: "btn btn-primary btn-sm",
        },
        cancel: {
          label: "<i class='mdi mdi-close'></i> Cancel",
          className: "btn btn-danger btn-sm",
        },
      },
      callback: function (result) {
        if (result) {
          $.ajax({
            url: url,
            type: "post",
            data: {
              "_csrf-backend": yii.getCsrfToken(),
              selected: selected,
            },
            success: function () {
              window.location = location;
            },
            error: function () {
              console.log("failed");
            },
          });
        }
      },
    });
  }
}

$(".owner-confirm").click((e) => {
  e.preventDefault();

  bootbox.prompt({
    title:
      "By doing this you also change the ownership status to returned,are you sure?. If yes, please enter some comment about this action (OPTIONAL)",
    inputType: "textarea",
    buttons: {
      confirm: {
        label: "<i class='mdi mdi-check'></i> OK",
        className: "btn btn-primary btn-sm",
      },
      cancel: {
        label: "<i class='mdi mdi-close'></i> Cancel",
        className: "btn btn-danger btn-sm",
      },
    },
    callback: function (result) {
      if (result !== null) {
        $.ajax({
          url: "index.php?r=owners/return-asset",
          type: "post",
          data: {
            "_csrf-backend": yii.getCsrfToken(),
            id: $(".owner-confirm").attr("value"),
            comment: result,
          },
          success: function () {
            window.location = "index.php?r=owners/index";
          },
          error: function () {
            console.log("failed");
          },
        });
      }
    },
  });
});

$("#dispose-asset").click((e) => {
  e.preventDefault();
  // console.log('clicked');
  bootbox.prompt({
    title: "Please enter some comment about this action (REQUIRED)",
    inputType: "textarea",
    buttons: {
      confirm: {
        label: "<i class='mdi mdi-check'></i> OK",
        className: "btn btn-primary btn-sm",
      },
      cancel: {
        label: "<i class='mdi mdi-close'></i> Cancel",
        className: "btn btn-danger btn-sm",
      },
    },
    callback: function (result) {
      if (result !== "") {
        $.ajax({
          url: "index.php?r=assets/dispose",
          type: "post",
          data: {
            "_csrf-backend": yii.getCsrfToken(),
            id: $("#dispose-asset").attr("value"),
            comment: result,
          },
          success: function () {
            window.location = "index.php?r=assets/index";
          },
          error: function () {
            console.log("failed");
          },
        });
      } else {
        window.location = `index.php?r=assets/update&id=${$(
          "#dispose-asset"
        ).attr("value")}&msg=Please enter some comment about the disposal!`;
      }
    },
  });
});

//Ownership report by barcode
$("#ownership-report-btn").click((e) => {
  e.preventDefault();

  const barcode = $("#ownership-report-input").val();

  // window.location = "index.php?r=owners/report&barcode=" + barcode;
  window.location = "index.php?r=owners/export&barcode=" + barcode;

  // $.ajax({
  //   url : "index.php?r=owners/report",
  //   type: "post",
  //   data: {
  //     "_csrf-backend": yii.getCsrfToken(),
  //     barcode: barcode,
  //   },
  //   success: function () {
  //     window.location = "index.php?r=owners/index";
  //   },
  //   error: function () {
  //     console.log("failed");
  //   },
  // });
});

//Book stock report
$("#book-stock-report-div").hide();
$("#show-book-stock-report-div").click(() => {
  $("#book-stock-report-div").show();
  $("#show-book-stock-report-div").hide();
});

$("#stock-report-button").click((e) => {
  e.preventDefault();
  const fromDate = $("#stock-report-from-date").val();
  const toDate = $("#stock-report-to-date").val();
  const condition = $("#stock-report-condition").val();
  let status = null

  console.log(condition);


  if(condition === 'all-available') {
    status = 1
  }
  status = 0


  window.location = `index.php?r=book-stock/export-all&from_date=${fromDate}&to_date=${toDate}&status=${status}`;


});

// $('#dynamic-pagesize').change(() => {
//   const pageSize = $('#dynamic-pagesize').val();
// console.log(pageSize);

// $.ajax({
//   url: "index.php?r=book-stock/set-page-size",
//   type: "post",
//   data: {
//     "_csrf-backend": yii.getCsrfToken(),
//     pageSize
//   },
//   success: function () {
//     window.location = "index.php?r=book-stock/index";
//   },
//   error: function () {
//     console.log("failed");
//   },
// });
// })

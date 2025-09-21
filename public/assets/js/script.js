$(document).ready(function () {
  // klik edit
  $(".btn-edit").click(function () {
    // reset semua baris ke view mode
    $("tr").each(function () {
      $(this).find(".view-mode").removeClass("d-none");
      $(this).find(".edit-mode").addClass("d-none");
      $(this).find(".btn-edit").removeClass("d-none");
      $(this).find(".btn-save, .btn-cancel").addClass("d-none");
    });

    // baru aktifkan baris yang diklik
    let row = $(this).closest("tr");
    row.find(".view-mode").addClass("d-none");
    row.find(".edit-mode").removeClass("d-none");

    row.find(".btn-edit").addClass("d-none");
    row.find(".btn-save, .btn-cancel").removeClass("d-none");

    // scroll horizontal ke kanan (dengan animasi)
    let container = row.closest("table").parent();
    container.animate({ scrollLeft: container[0].scrollWidth }, 0);
  });

  // klik cancel
  $(".btn-cancel").click(function () {
    let row = $(this).closest("tr");
    row.find(".view-mode").removeClass("d-none");
    row.find(".edit-mode").addClass("d-none");

    row.find(".btn-edit").removeClass("d-none");
    row.find(".btn-save, .btn-cancel").addClass("d-none");

    // scroll horizontal ke kanan (dengan animasi)
    let container = row.closest("table").parent();
    container.animate({ scrollLeft: container[0].scrollWidth }, 0);
  });

  // klik save
  $(".btn-save").click(function () {
    let row = $(this).closest("tr");
    let form = row.find("form");

    if (form.length) {
      form.submit();
    }

    // let id = row.data("id"); // pastikan <tr data-id="{{ $item->id }}">

    // ambil semua input di baris edit
    // let data = {};
    // row.find("td.edit-mode").each(function () {
    //   let input = $(this).find("input, select, textarea");
    //   if (input.length > 0) {
    //     let name = input.attr("name");
    //     let value = input.val();
    //     data[name] = value;
    //   }
    // });

    // kirim ke server via AJAX
    // $.ajax({
    //   url: "/update-item-anggaran/" + id,
    //   type: "POST",
    //   data: {
    //     _token: $('meta[name="csrf-token"]').attr("content"),
    //     ...data,
    //   },
    //   success: function (res) {
    //     console.log("Update berhasil:", res);
    //   },
    //   error: function (xhr) {
    //     alert("Terjadi kesalahan saat update");
    //     console.error(xhr.responseText);
    //   },
    // });

    // update text view dari input
    // row.find("td.view-mode").each(function (index) {
    //   let input = row.find("td.edit-mode").eq(index).find("input");
    //   if (input.length > 0) {
    //     $(this).text(input.val());
    //   }
    // });

    // balik ke view mode
    // row.find(".view-mode").removeClass("d-none");
    // row.find(".edit-mode").addClass("d-none");
    // row.find(".btn-edit").removeClass("d-none");
    // row.find(".btn-save, .btn-cancel").addClass("d-none");
  });
});

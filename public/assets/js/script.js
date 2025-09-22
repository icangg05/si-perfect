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
  });

  // Script form item anggaran
  $(function () {
    // Reindex: ubah name & id radio per row tapi tetap restore pilihan yang sudah ada
    function reindexRows() {
      $("#formRows .form-row").each(function (rowIndex) {
        // simpan nilai radio yang terpilih di row ini (jika ada)
        let selected = $(this).find("input[type=radio]:checked").val() || null;

        // untuk setiap radio di row ini, ubah id/name dan kembalikan status checked jika cocok
        $(this)
          .find("input[type=radio]")
          .each(function () {
            const val = $(this).val();
            const newId = "sub_" + rowIndex + "_" + val; // unik berdasarkan rowIndex + value

            $(this).attr("id", newId);
            // Ini akan menimpa nama sementara dengan nama yang benar dan berurutan
            $(this).attr("name", "sub_kategori_laporan_id[" + rowIndex + "]");

            // update label yang mengikat radio ini
            $(this).siblings("label").attr("for", newId);

            // Hapus status checked sebelum diatur ulang
            $(this).prop("checked", false);

            // restore checked jika val sama dengan yang sebelumnya dipilih
            if (selected !== null && String(val) === String(selected)) {
              $(this).prop("checked", true);
            }
          });

        // Jika tidak ada yang terpilih setelah loop (misalnya baris baru),
        // pilih yang pertama sebagai default
        if ($(this).find("input[type=radio]:checked").length === 0) {
          $(this).find("input[type=radio]").first().prop("checked", true);
        }
      });
    }

    // tambah row
    $(document).on("click", ".addRow", function () {
      const lastRow = $("#formRows .form-row").last();
      const newRow = lastRow.clone(); // clone block terakhir

      // === PERBAIKAN UTAMA DI SINI ===
      // Beri nama SEMENTARA yang unik untuk radio di baris baru agar tidak
      // mengganggu pilihan di baris yang sudah ada.
      newRow
        .find("input[type=radio]")
        .attr("name", "temp_radio_" + new Date().getTime());
      // ================================

      // reset hanya input di row baru (jangan sentuh row lama)
      newRow
        .find("input")
        .not("[type=radio]")
        .each(function () {
          $(this).val("");
        });

      // Kosongkan semua radio di row baru, lalu pilih radio pertama sebagai default
      // Ini sekarang aman karena namanya berbeda dari baris lain.
      newRow
        .find("input[type=radio]")
        .prop("checked", false)
        .first()
        .prop("checked", true);

      $("#formRows").append(newRow);

      // reindex setelah append — reindex akan memberikan nama yang benar dan berurutan
      reindexRows();
    });

    // hapus row
    $(document).on("click", ".removeRow", function () {
      if ($("#formRows .form-row").length > 1) {
        $(this).closest(".form-row").remove();
        reindexRows();
      } else {
        alert("Minimal harus ada 1 item!");
      }
    });

    // inisialisasi pada load (agar id/name konsisten jika ada 1 row dari server)
    reindexRows();
  });
});

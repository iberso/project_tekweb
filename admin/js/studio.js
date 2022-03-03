$(document).ready(function () {

    $("table").addSortWidget(); //plugin tambahan untuk sort data table 

    $("#search_input").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_studio tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function generate_list_studio() {
        $("#table_studio").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_studio_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        if (data['status'] == 0) {
                            var txt1 = "<tr class='tbl-mid'><td>" + data['id_studio'] +
                                "</td><td>" + data['nama_studio'] + "</td><td>" + data['jumlah_kursi'] +
                                "</td><td>" + data['created_by'] +
                                "</td><td class='align-middle'><div class='btn btn-danger btn-block'>Non-Aktif</div></td><td><button class='btn btn-warning' id='" +
                                data['id_studio'] + "'>Detail</button></td></tr>"
                        } else {
                            var txt1 = "<tr class='tbl-mid'><td>" + data['id_studio'] +
                                "</td><td>" + data['nama_studio'] + "</td><td>" + data['jumlah_kursi'] +
                                "</td><td>" + data['created_by'] +
                                "</td><td class='align-middle'><div class='btn btn-success btn-block'>Aktif</div></td><td><button class='btn btn-warning' id='" +
                                data['id_studio'] + "'>Detail</button></td></tr>"
                        }
                        $("#table_studio").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    generate_list_studio();

    function generate_list_studio_w_filter($s) {
        $("#table_studio").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_studio_list_w_filter.php?s=' + $s,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        var txt1 = "<tr class='tbl-mid'><td>" + data['id_studio'] +
                            "</td><td>" + data['nama_studio'] + "</td><td>" + data['jumlah_kursi'] +
                            "</td><td>" + data['created_by'] +
                            "</td><td><button class='btn btn-warning' id='" +
                            data['id_studio'] + "'>Detail</button></td></tr>"
                        $("#table_studio").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }

    $(document).on("click", "#table_studio button.btn-warning", function () {
        $("#id_studio").html($(this).attr("id"));
        $id_std = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: 'process/get_detail_studio.php?id_studio=' + $id_std,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    var txt1 =
                        "<div class='text-center'><h2 class='color-font'>" +
                        response.nama_studio + "</h2><span>Jumlah Kursi : " + response.jumlah_kursi +
                        "</span><br><span>Created By : " + response
                            .created_by +
                        "</span>";
                    $("#isi_detail").html(txt1);
                    $("#eid_studio").val(response.id_studio);
                    $("#enama_studio").val(response.nama_studio);
                    $("#ejumlah_kursi").val(response.jumlah_kursi);
                    console.log("status = " + response.status);
                    $btn2 =
                        "<a class='btn btn-danger' id='btn_ya_hapus' href='process/post_hapus_studio.php?id_studio=" +
                        response.id_studio + "'>Ya, Hapus</button>";
                    //ini ada 2 opsi : btn1 = hard delete dan btn2 = soft delete
                    $("#tempat_btn_hapus").append($btn2);
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
        $("#modal_detail").modal('show');
        $("#btn_edit_data").removeClass("hide-div");
        $("#container_edit_studio").addClass("hide-div");
    });

    $("#submit_edit_studio").click(function (e) {
        e.preventDefault();
        if (!$("#enama_studio").val()) {
            $("#enama_studio").addClass("is-invalid");
        } else {
            $("#enama_studio").removeClass("is-invalid");
        }

        if (!$("#ejumlah_kursi").val()) {
            $("#ejumlah_kursi").addClass("is-invalid");
        } else {
            $("#ejumlah_kursi").removeClass("is-invalid");
        }
        if ($("#ejumlah_kursi").val() && $("#enama_studio").val() && $("#eid_studio").val()) {
            $("#form_edit_studio").submit();
        }
    });

    $("#submit_studio").click(function (e) {
        e.preventDefault();
        if (!$("#nama_studio").val()) {
            $("#nama_studio").addClass("is-invalid");
        } else {
            $("#nama_studio").removeClass("is-invalid");
        }
        if (!$("#jumlah_kursi").val()) {
            $("#jumlah_kursi").addClass("is-invalid");
        } else {
            $("#jumlah_kursi").removeClass("is-invalid");
        }
        if ($("#jumlah_kursi").val() && $("#nama_studio").val()) {
            $("#form_isi_studio").submit();
        }

    });

    function reset_all_invalid() {
        $("#nama_studio").removeClass("is-invalid");
        $("#jumlah_kursi").removeClass("is-invalid");
        $("#enama_studio").removeClass("is-invalid");
        $("#ejumlah_kursi").removeClass("is-invalid");
    }

    $("#btn_close_detail").click(function () {
        $("#tempat_btn_hapus").empty();
        $("#container_edit_studio").toggleClass("hide-div");
        $("#btn_edit_data").removeClass("hide-div");
        $("#btn_hapus_data").removeClass("hide-div");
        $("#container_hapus_studio").addClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_edit_data").click(function () {
        $("#container_edit_studio").toggleClass("hide-div");
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_hapus_data").addClass("hide-div");
    });

    $("#btn_hapus_data").click(function () {
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_hapus_data").addClass("hide-div");
        $("#container_hapus_studio").removeClass("hide-div");
    });

    $("#btn_lihat_studio").click(function () {
        $("#tambah_studio").addClass("hide-div");
        $("#data_studio").removeClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_tambah_studio").click(function () {
        $("#data_studio").addClass("hide-div");
        $("#tambah_studio").removeClass("hide-div");
    });

    $("#btn_batal_hapus").click(function () {
        $("#btn_edit_data").removeClass("hide-div");
        $("#btn_hapus_data").removeClass("hide-div");
        $("#container_hapus_studio").addClass("hide-div");
    });

    $("#btn_ya_hapus").click(function () {
        generate_list_studio();
    });

    $('#radio1').click(function () {
        if ($("#radio1").is(':checked')) {
            generate_list_studio_w_filter(1);
        }
    });
    $('#radio2').click(function () {
        if ($("#radio2").is(':checked')) {
            generate_list_studio_w_filter(0);
        }
    });
    $('#radio3').click(function () {
        if ($("#radio3").is(':checked')) {
            generate_list_studio();
        }
    });
});

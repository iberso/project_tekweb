$(document).ready(function () {
    // $("#data_film").show();
    // $("#tambah_film").hide();
    $("table").addSortWidget(); //plugin tambahan untuk sort data table 

    $("#search_input").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_film tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function generate_list_film() {
        $("#table_film").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_film_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        if (data['is_delete'] == 1) {
                            var txt1 = "<tr><td class='text-center'>" + data['id_film'] +
                                "</td><td>" + data[
                                'judul_film'] + "</td><td>" + data['sutradara'] +
                                "</td><td>" +
                                data['genre'] + "</td><td>" + data['produksi'] +
                                "</td><td class='text-center'>" + data[
                                'durasi'] + "</td><td class='text-center'>" + data[
                                'kategori_umur'] +
                                "</td><td class='text-center'>" +
                                data['created_by'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-danger btn-block'>Non-Aktif</div></td><td class='text-center'><button class='btn btn-warning' id='" +
                                data['id_film'] + "'>Detail</button></td></tr>"
                        } else {
                            var txt1 = "<tr><td class='text-center'>" + data['id_film'] +
                                "</td><td>" + data[
                                'judul_film'] + "</td><td>" + data['sutradara'] +
                                "</td><td>" +
                                data['genre'] + "</td><td>" + data['produksi'] +
                                "</td><td class='text-center'>" + data[
                                'durasi'] + "</td><td class='text-center'>" + data[
                                'kategori_umur'] +
                                "</td><td class='text-center'>" +
                                data['created_by'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-success btn-block'>Aktif</div></td><td class='text-center'><button class='btn btn-warning' id='" +
                                data['id_film'] + "'>Detail</button></td></tr>"
                        }
                        $("#table_film").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    generate_list_film();

    function generate_list_film_w_filter($d) {
        $("#table_film").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_film_list_w_filter.php?d=' + $d,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        var txt1 = "<tr><td class='text-center'>" + data['id_film'] +
                            "</td><td>" + data[
                            'judul_film'] + "</td><td>" + data['sutradara'] +
                            "</td><td>" +
                            data['genre'] + "</td><td>" + data['produksi'] +
                            "</td><td class='text-center'>" + data[
                            'durasi'] + "</td><td class='text-center'>" + data[
                            'kategori_umur'] +
                            "</td><td class='text-center'>" +
                            data['created_by'] +
                            "</td><td class='text-center'><button class='btn btn-warning' id='" +
                            data['id_film'] + "'>Detail</button></td></tr>"
                        $("#table_film").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }

    $(document).on("click", "#table_film button.btn-warning", function () {
        $("#id_film").html($(this).attr("id"));
        $id_fil = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: 'process/get_detail_film.php?id_film=' + $id_fil,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    var txt1 =
                        "<div class='text-center'><img src='../" +
                        response.poster +
                        "'width='250px' class='our-border shadow'></div><br><h2 class='color-font'>" +
                        response
                            .judul_film + "</h2><span>Sutradara : " + response
                            .sutradara +
                        "</span><br><span>Genre : " + response
                            .genre +
                        "</span><br><span>Produksi : " + response
                            .produksi +
                        "</span><br><span>Durasi : " + response
                            .durasi +
                        "</span><br><span>Kategori Umur : " + response
                            .kategori_umur +
                        "</span><br><p class='mt-4'>" + response
                            .sinopsi +
                        "</p>"
                    $("#isi_detail").html(txt1);
                    $("#eid_film").val(response.id_film);
                    $("#ejudul_film").val(response.judul_film);
                    $("#ejudulbefore").val(response.judul_film);
                    $("#esutradara").val(response.sutradara);
                    $("#egenre").val(response.genre);
                    $("#eproduksi").val(response.produksi);
                    $("#esinopsi").val(response.sinopsi);
                    $("#edurasi").val(response.durasi);
                    $("#ekategori").val(response.kategori_umur);
                    // $btn1 =
                    //     "<a class='btn btn-danger' id='btn_ya_hapus' href='process/get_hapus_film.php?id_film=" +
                    //     response.id_film + "&j_f=" + response.judul_film +
                    //     "'>Ya, Hapus</button>";
                    $btn2 =
                        "<a class='btn btn-danger' id='btn_ya_hapus' href='process/post_hapus_film.php?id_film=" +
                        response.id_film + "'>Ya, Hapus</button>";
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
        $("#container_edit_film").addClass("hide-div");
    });

    $("#submit_edit_film").click(function (e) {
        e.preventDefault();
        if (!$("#ejudul_film").val()) {
            $("#ejudul_film").addClass("is-invalid");
        } else {
            $("#ejudul_film").removeClass("is-invalid");
        }

        if (!$("#esutradara").val()) {
            $("#esutradara").addClass("is-invalid");
        } else {
            $("#esutradara").removeClass("is-invalid");
        }

        if (!$("#egenre").val()) {
            $("#egenre").addClass("is-invalid");
        } else {
            $("#egenre").removeClass("is-invalid");
        }

        if (!$("#eproduksi").val()) {
            $("#eproduksi").addClass("is-invalid");
        } else {
            $("#eproduksi").removeClass("is-invalid");
        }

        if (!$("#esinopsi").val()) {
            $("#esinopsi").addClass("is-invalid");
        } else {
            $("#esinopsi").removeClass("is-invalid");
        }

        if (!$("#edurasi").val()) {
            $("#edurasi").addClass("is-invalid");
        } else {
            $("#edurasi").removeClass("is-invalid");
        }

        if (!$("#eposter").val()) {
            $("#eposter").addClass("is-invalid");
        } else {
            $("#eposter").removeClass("is-invalid");
        }
        if ($("#ejudul_film").val() && $("#esutradara").val() && $("#egenre").val() && $("#eproduksi")
            .val() && $("#esinopsi").val() && $("#edurasi").val() && $("#eposter").val()) {
            $("#form_edit_film").submit();
        }
    });

    $("#submit_film").click(function (e) {
        e.preventDefault();
        if (!$("#judul_film").val()) {
            $("#judul_film").addClass("is-invalid");
        } else {
            $("#judul_film").removeClass("is-invalid");
        }

        if (!$("#sutradara").val()) {
            $("#sutradara").addClass("is-invalid");
        } else {
            $("#sutradara").removeClass("is-invalid");
        }

        if (!$("#genre").val()) {
            $("#genre").addClass("is-invalid");
        } else {
            $("#genre").removeClass("is-invalid");
        }

        if (!$("#produksi").val()) {
            $("#produksi").addClass("is-invalid");
        } else {
            $("#produksi").removeClass("is-invalid");
        }

        if (!$("#sinopsi").val()) {
            $("#sinopsi").addClass("is-invalid");
        } else {
            $("#sinopsi").removeClass("is-invalid");
        }

        if (!$("#durasi").val()) {
            $("#durasi").addClass("is-invalid");
        } else {
            $("#durasi").removeClass("is-invalid");
        }

        if (!$("#poster").val()) {
            $("#poster").addClass("is-invalid");
        } else {
            $("#poster").removeClass("is-invalid");
        }
        if ($("#judul_film").val() && $("#sutradara").val() && $("#genre").val() && $("#produksi")
            .val() && $("#sinopsi").val() && $("#durasi").val() && $("#poster").val()) {
            $("#form_isi_film").submit();
        }

    });

    function reset_all_invalid() {
        $("#ejudul_film").removeClass("is-invalid");
        $("#esutradara").removeClass("is-invalid");
        $("#egenre").removeClass("is-invalid");
        $("#eproduksi").removeClass("is-invalid");
        $("#esinopsi").removeClass("is-invalid");
        $("#edurasi").removeClass("is-invalid");
        $("#eposter").removeClass("is-invalid");
        $("#judul_film").removeClass("is-invalid");
        $("#sutradara").removeClass("is-invalid");
        $("#genre").removeClass("is-invalid");
        $("#produksi").removeClass("is-invalid");
        $("#sinopsi").removeClass("is-invalid");
        $("#durasi").removeClass("is-invalid");
        $("#poster").removeClass("is-invalid");
    }

    $("#btn_close_detail").click(function () {
        $("#tempat_btn_hapus").empty();
        $("#container_edit_film").toggleClass("hide-div");
        $("#btn_edit_data").removeClass("hide-div");
        $("#btn_hapus_data").removeClass("hide-div");
        $("#container_hapus_film").addClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_edit_data").click(function () {
        $("#container_edit_film").toggleClass("hide-div");
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_hapus_data").addClass("hide-div");
    });

    $("#btn_hapus_data").click(function () {
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_hapus_data").addClass("hide-div");
        $("#container_hapus_film").removeClass("hide-div");
    });

    $("#btn_lihat_film").click(function () {
        $("#tambah_film").addClass("hide-div");
        $("#data_film").removeClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_tambah_film").click(function () {
        $("#data_film").addClass("hide-div");
        $("#tambah_film").removeClass("hide-div");
    });

    $("#btn_batal_hapus").click(function () {
        $("#btn_edit_data").removeClass("hide-div");
        $("#btn_hapus_data").removeClass("hide-div");
        $("#container_hapus_film").addClass("hide-div");
    });

    $("#btn_ya_hapus").click(function () {
        generate_list_film();
    });

    $('#radio1').click(function () {
        if ($("#radio1").is(':checked')) {
            generate_list_film_w_filter(0);
        }
    });
    $('#radio2').click(function () {
        if ($("#radio2").is(':checked')) {
            generate_list_film_w_filter(1);
        }
    });
    $('#radio3').click(function () {
        if ($("#radio3").is(':checked')) {
            generate_list_film();
        }
    });
});

$(document).ready(function () {

    $("table").addSortWidget(); //plugin tambahan untuk sort data table 

    $("#search_input").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_jadwal tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });


    function list_nama_studio() {
        $.ajax({
            type: "GET",
            url: 'process/get_studio_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    $("#studio").empty();
                    response.forEach(function (data) {
                        if (data['status'] == 1) {
                            var txt1 = "<option value='" + data['id_studio'] + "'>" + data['nama_studio'] + "</option>";
                        }
                        $("#studio").append(txt1);
                        $("#estudio").append(txt1);
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    function list_nama_film() {
        $.ajax({
            type: "GET",
            url: 'process/get_film_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    $("#film").empty();
                    response.forEach(function (data) {
                        if (data['is_delete'] == 0) {
                            var txt1 = "<option value='" + data['id_film'] + "'>" + data['judul_film'] + "</option>";
                        }
                        $("#film").append(txt1);
                        $("#efilm").append(txt1);
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }

    list_nama_studio();
    list_nama_film();
    $('#studio').mousedown(function () {
        list_nama_studio();
    });

    $('#film').mousedown(function () {
        list_nama_film();
    });

    function generate_list_jadwal() {
        $("#table_jadwal").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_jadwal_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        if (data['jarak_tanggal'] < 0) {
                            var txt1 = "<tr class='tbl-mid'><td>" + data['id_jadwal'] +
                                "</td><td>" + data['tanggal_tampil'] + "</td><td>" + data['jam_val'] + "</td><td>Rp. " + data['harga'] +
                                "</td><td>" + data['nama_studio'] +
                                "</td><td>" + data['judul_film'] +
                                "</td><td>" + data['created_by'] +
                                "</td><td class='align-middle'><div class='btn btn-danger btn-block'>Non-Aktif</div></td><td><button class='btn btn-warning' id='" +
                                data['id_jadwal'] + "'>Detail</button></td></tr>"
                        } else {
                            var txt1 = "<tr class='tbl-mid'><td>" + data['id_jadwal'] +
                                "</td><td>" + data['tanggal_tampil'] + "</td><td>" + data['jam_val'] + "</td><td>Rp. " + data['harga'] +
                                "</td><td>" + data['nama_studio'] +
                                "</td><td>" + data['judul_film'] +
                                "</td><td>" + data['created_by'] +
                                "</td><td class='align-middle'><div class='btn btn-success btn-block'>Aktif</div></td><td><button class='btn btn-warning' id='" +
                                data['id_jadwal'] + "'>Detail</button></td></tr>"
                        }
                        $("#table_jadwal").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    generate_list_jadwal();

    function generate_list_jadwal_w_filter($s) {
        $("#table_jadwal").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_jadwal_list_w_filter.php?s=' + $s,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        var txt1 = "<tr class='tbl-mid'><td>" + data['id_jadwal'] +
                            "</td><td>" + data['tanggal_tampil'] + "</td><td>" + data['jam_val'] + "</td><td>Rp. " + data['harga'] +
                            "</td><td>" + data['nama_studio'] +
                            "</td><td>" + data['judul_film'] +
                            "</td><td>" + data['created_by'] +
                            "</td><td><button class='btn btn-warning' id='" +
                            data['id_jadwal'] + "'>Detail</button></td></tr>"
                        $("#table_jadwal").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }

    function generate_kursi_studio($id_fil, $tgl, $td, $jm_t, $jumlah_kursi) {
        var pos_X = [];
        var pos_Y = [];
        $("#isi_kursi").empty();
        $.ajax({
            type: "GET",
            url: 'process/get_kursi_jadwal.php?id=' + $id_fil + '&tgl_t=' + $tgl +
                '&id_std=' + $td + '&jm_t=' + $jm_t,
            success: function (responses) {
                try {
                    responses = $.parseJSON(responses);
                    responses.forEach(function (dat) {
                        pos_X.push(dat['pos_x'])
                        pos_Y.push(dat['pos_y'])
                    })
                    var x = $jumlah_kursi / 16;
                    //GENERATE TABLE KURSI
                    for (var i = 0; i < x; i++) {
                        var tbl;
                        tbl = "<tr>";
                        for (var j = 0; j < 16; j++) {
                            tbl += "<td><button type='button' id='pos_kursi' class='btn btn-sm text-white our-kursi color-black hoper-animation'>" +
                                String.fromCharCode(65 + i) + (j + 1) +
                                "</button></td>";
                        }
                        tbl += "</tr>";
                        $("#isi_kursi").append(tbl)
                    }
                    //GENERATE

                    //isi kursi 
                    for (var i = 0; i < pos_X.length; i++) {
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i])
                            .find("button").removeClass("color-black")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i])
                            .find("button").removeClass("border-top")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i])
                            .find("button").addClass("btn-danger")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i])
                            .find("button").attr("disabled", true)
                    }
                    //isi kursi 
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    $(document).on("click", "#table_jadwal button.btn-warning", function () {
        $("#id_jadwal").html($(this).attr("id"));
        $id_jdw = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: 'process/get_detail_jadwal.php?id_jadwal=' + $id_jdw,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    var txt1 =
                        "<div class='text-center'><img src='../" +
                        response.poster +
                        "'width='250px' class='our-border shadow'></div><div class='text-center'><h2 class='color-font'>" +
                        response.judul_film + "</h2><span>Studio : " + response
                            .nama_studio +
                        "</span><br><span>Tanggal Tayang : " + response.tanggal_tampil +
                        "</span><br><span>Jam Tayang : " + response
                            .jam_val +
                        "</span><br><span>Harga : Rp. " + response
                            .harga +
                        "</span><br><span>Created By : " + response
                            .created_by +
                        "</span>";

                    $("#isi_detail").html(txt1);
                    $("#etanggal_tayang").val(response.tanggal_tayang);
                    $("#ejam_tayang").val(response.jam_val);
                    $("#eharga").val(response.harga);
                    $("#estudio").val(response.id_studio);
                    $("#efilm").val(response.id_film);
                    $("#eid_jadwal").val(response.id_jadwal);
                    generate_kursi_studio(response.id_film, response.tanggal_tayang, response.id_studio, response.jam_val, response.jumlah_kursi)
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
        $("#modal_detail").modal('show');
        $("#btn_edit_data").removeClass("hide-div");
        $("#container_edit_jadwal").addClass("hide-div");
    });

    $("#submit_edit_jadwal").click(function (e) {
        e.preventDefault();
        if (!$("#etanggal_tayang").val()) {
            $("#etanggal_tayang").addClass("is-invalid");
        } else {
            $("#etanggal_tayang").removeClass("is-invalid");
        }

        if (!$("#ejam_tayang").val()) {
            $("#ejam_tayang").addClass("is-invalid");
        } else {
            $("#ejam_tayang").removeClass("is-invalid");
        }

        if (!$("#eharga").val()) {
            $("#eharga").addClass("is-invalid");
        } else {
            $("#eharga").removeClass("is-invalid");
        }

        if (!$("#estudio").val()) {
            $("#estudio").addClass("is-invalid");
        } else {
            $("#estudio").removeClass("is-invalid");
        }

        if (!$("#efilm").val()) {
            $("#efilm").addClass("is-invalid");
        } else {
            $("#efilm").removeClass("is-invalid");
        }

        if ($("#etanggal_tayang").val() && $("#ejam_tayang").val() && $("#eharga").val() && $("#estudio").val() && $("#efilm").val()) {
            $("#form_edit_jadwal").submit();
        }
    });

    $("#submit_jadwal").click(function (e) {
        e.preventDefault();
        if (!$("#tanggal_tayang").val()) {
            $("#tanggal_tayang").addClass("is-invalid");
        } else {
            $("#tanggal_tayang").removeClass("is-invalid");
        }

        if (!$("#jam_tayang").val()) {
            $("#jam_tayang").addClass("is-invalid");
        } else {
            $("#jam_tayang").removeClass("is-invalid");
        }

        if (!$("#harga").val()) {
            $("#harga").addClass("is-invalid");
        } else {
            $("#harga").removeClass("is-invalid");
        }

        if (!$("#studio").val()) {
            $("#studio").addClass("is-invalid");
        } else {
            $("#studio").removeClass("is-invalid");
        }

        if (!$("#film").val()) {
            $("#film").addClass("is-invalid");
        } else {
            $("#film").removeClass("is-invalid");
        }

        if ($("#tanggal_tayang").val() && $("#jam_tayang").val() && $("#harga").val() && $("#studio").val() && $("#film").val()) {
            $("#form_isi_jadwal").submit();
        }

    });

    function reset_all_invalid() {
        $("#tanggal_tayang").removeClass("is-invalid");
        $("#harga").removeClass("is-invalid");
        $("#studio").removeClass("is-invalid");
        $("#film").removeClass("is-invalid");
        $("#jam_tayang").removeClass("is-invalid");
    }

    $("#btn_close_detail").click(function () {
        $("#btn_cek_kursi").removeClass("hide-div");
        $("#container_edit_jadwal").toggleClass("hide-div");
        $("#btn_edit_data").removeClass("hide-div");
        $("#container_cek_kursi").addClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_edit_data").click(function () {
        $("#container_edit_jadwal").toggleClass("hide-div");
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_cek_kursi").addClass("hide-div");
    });

    $("#btn_cek_kursi").click(function () {
        $("#btn_edit_data").addClass("hide-div");
        $("#btn_cek_kursi").addClass("hide-div");
        $("#container_cek_kursi").removeClass("hide-div");
    });

    $("#btn_lihat_jadwal").click(function () {
        $("#tambah_jadwal").addClass("hide-div");
        $("#data_jadwal").removeClass("hide-div");
        reset_all_invalid();
    });

    $("#btn_tambah_jadwal").click(function () {
        $("#data_jadwal").addClass("hide-div");
        $("#tambah_jadwal").removeClass("hide-div");
    });

    $("#btn_close_cek_kursi").click(function () {
        $("#btn_edit_data").removeClass("hide-div");
        $("#btn_cek_kursi").removeClass("hide-div");
        $("#container_cek_kursi").addClass("hide-div");
    });

    $('#radio1').click(function () {
        if ($("#radio1").is(':checked')) {
            generate_list_jadwal_w_filter(1);
        }
    });
    $('#radio2').click(function () {
        if ($("#radio2").is(':checked')) {
            generate_list_jadwal_w_filter(0);
        }
    });
    $('#radio3').click(function () {
        if ($("#radio3").is(':checked')) {
            generate_list_jadwal();
        }
    });
});

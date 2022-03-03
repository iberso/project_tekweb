$(document).ready(function () {

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };
    var id_fil = getUrlParameter('id');//buat ngambil id dari paramter

    var judul_fil = "";
    var tanggal_fil = "";
    var jam_fil = "";
    var id_jdw = "";

    $.ajax({
        type: "GET",
        url: 'process/get_film_list.php?id=' + id_fil,
        success: function (response) {
            try {
                response = $.parseJSON(response);

                var txt1 =
                    "<div class='float-right d-inline border-0 rounded color-obj p-1 font-weight-bold'>" +
                    response.durasi + " menit</div><h2 class='card-title color-font mb-4'>" +
                    response
                        .judul_film +
                    "</h2> <p>Jenis Film : " + response.genre + "</p><p> Sutradara : " + response
                        .sutradara + "</p><p> Produksi : " + response.produksi +
                    "</p><h5><span class='badge badge-danger'>" + response.kategori_umur +
                    "</span></h5><br><h4 class ='card-title color-font mb-4'> Sinopsi </h4><p class = 'text-white' >" +
                    response.sinopsi + "</p> "

                var txt2 = "<img class='card-img-top' src='" + response.poster +
                    "'alt='Card image cap'>"
                $("#content").append(txt1)
                $("#poster-placeholder").append(txt2)
                $("#judul-film").html(response.judul_film)
                judul_fil = response.judul_film;
            } catch (e) { window.location.replace("../../error_page.php") }
        },
        error: function () {
            window.location.replace("../../error_page.php")
        }
    });

    $("#pesan_btn").on("click", function () {
        $.ajax({
            type: "GET",
            url: 'process/get_tanggal_tayang.php?id=' + id_fil,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    $("#tanggal_tayang").append(
                        "<option selected hidden class='text-muted'></option>"
                    );
                    response.forEach(function (data) {
                        var txt1 = "<option value=" +
                            data['tanggal_val'] +
                            ">" + data['tanggal_tayang'] +
                            "</option>"
                        $("#tanggal_tayang").append(txt1)
                    })
                } catch (e) { window.location.replace("../../error_page.php") }
            },
            error: function () {
                window.location.replace("../../error_page.php")
            }
        });
    });

    $("#detail-pesan").hide();

    $("#close_modal").on("click", function () {
        $("#tanggal_tayang").empty();
        $("#jam_placeholder").empty();
        $("#layar").hide();
        $("#detail-pesan").hide();
        clean_detail();
    });

    function clean_detail() {
        $("#no-kursi").empty();
        $("#tanggal-film").empty();
        $("#jam-film").empty();
        $("#jumlah-kursi").html(0);
    }

    var tgl, id_std, jm_t, kursi_std;
    $("#tanggal_tayang").change(function () {
        $("#jam_placeholder").empty();
        $("#isi_kursi").empty();
        $("#layar").hide();
        clean_detail();


        tgl = $(this).val();

        $.ajax({
            type: "GET",
            url: 'process/get_nama_studio.php?id=' + id_fil + '&tgl_t=' + tgl,
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    // console.log("nama_studio : " + response[i].nama_studio)

                    response.forEach(function (datat) {
                        //console.log("nama_studio dan id = " + datat['nama_studio'] +" " + datat['id_studio'])
                        var nm_std =
                            "<br><h5 class='mt-2 text-capitalize text-white d-inline-block mr-2'>" + datat[
                            'nama_studio'] +
                            "</h5><span class='text-white' value='" + datat['harga'] + "'>Rp. " + datat['harga'] + "</span><br>";
                        // console.log(txt1);

                        $("#harga_fil").html(datat['harga']);
                        //ASUMSINYA HARGA ITU DIBUAT PERTANGGAL TIDAK PER STUDIO

                        id_std = datat['id_studio']
                        kursi_std = datat['jumlah_kursi']
                        //batas atas ajax jam
                        $.ajax({
                            type: "GET",
                            url: 'process/get_jam_tayang.php?id=' + id_fil + '&tgl_t=' +
                                tgl + '&id_std=' + id_std,
                            success: function (responsee) {
                                try {
                                    responsee = $.parseJSON(responsee);
                                    // console.log("nama_studio : " + response[i].nama_studio)
                                    $("#jam_placeholder").append(nm_std)
                                    responsee.forEach(function (data) {
                                        var txt2 = "<span id='" + data['id_jadwal'] + "' >"
                                        txt2 +=
                                            "<div id='jam" +
                                            datat['id_studio'] +
                                            "' class='btn jm mr-2 color-unpick text-white hoper-animation'>" +
                                            data['jam_val'] +
                                            "</div></span>"
                                        // console.log(txt2);
                                        $("#jam_placeholder").append(txt2)
                                    })
                                } catch (e) { window.location.replace("../../error_page.php") }
                            },
                            error: function () {
                                window.location.replace("../../error_page.php")
                            }
                        });
                        //batas bawah ajax jam
                    })
                } catch (e) { }
            },
            error: function () {
                window.location.replace("../../error_page.php")
            }
        });
    });

    $("#layar").hide();
    //buat milih jam
    $(document).on("click", ".jm", function () {

        $("#harga_fil").autoNumeric("init");
        id_jdw = $(this).parent().attr("id");
        var pos_X = [];
        var pos_Y = [];
        $("#isi_kursi").empty();
        $("#layar").show();
        $("#detail-pesan").show();
        $("#jumlah-kursi").html(0);
        $("#no-kursi").empty();

        $("#jam_placeholder .btn").each(function () {
            //alert("JAM = " + $(this).html());
            if ($(this).hasClass("color-obj")) {
                $(this).removeClass("color-obj")
            }
        });
        $(this).addClass("color-obj");

        $("#jam-film").html($(this).text())
        $("#tanggal-film").html($("#tanggal_tayang").children("option:selected").text())

        tanggal_fil = $("#tanggal_tayang").children("option:selected").val();
        jm_t = $(this).text();
        jam_fil = $(this).text();

        td = ($(this).attr("id")).substr(3, 3); // biar cuman ambil id_studio

        //alert("tanggal = " + tgl + " id_studio = " + td + " jam_tayang = " + jm_t)

        $.ajax({
            type: "GET",
            url: 'process/get_kursi_studio.php?id=' + id_fil + '&tgl_t=' + tgl +
                '&id_std=' + td + '&jm_t=' + jm_t,
            success: function (responses) {
                try {
                    responses = $.parseJSON(responses);
                    responses.forEach(function (dat) {
                        pos_X.push(dat['pos_x'])
                        pos_Y.push(dat['pos_y'])
                    })

                    x = kursi_std / 16;
                    //GENERATE TABLE KURSI
                    for (var i = 0; i < x; i++) {
                        var tbl;
                        tbl = "<tr>";
                        for (var j = 0; j < 16; j++) {
                            tbl +=
                                "<td><button type='button' id='pos_kursi' class='btn btn-sm text-white our-kursi color-black hoper-animation'>" +
                                String.fromCharCode(65 + i) + (j + 1) +
                                "</button></td>";
                        }
                        tbl += "</tr>";
                        $("#isi_kursi").append(tbl)
                    }
                    //GENERATE

                    //isi kursi 
                    for (var i = 0; i < pos_X.length; i++) {
                        // $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i]).html("X")
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
                } catch (e) { window.location.replace("../../error_page.php") }
            },
            error: function () {
                window.location.replace("../../error_page.php")
            }
        });

    });

    $(document).on("click", "#pos_kursi", function () {
        // console.log($(this).html())
        // console.log("X = " + ($(this).html().charCodeAt(0) - 65) + " Y = " + ($(this).text().substr(1,2) - 1)) 
        var jml_kursi = 0;
        var pil_X = ($(this).html().charCodeAt(0) - 65);
        var pil_Y = ($(this).text().substr(1, 2) - 1);


        $("#isi_kursi  > tr > td .btn").each(function () {
            if ($(this).hasClass("our-color-kursi")) {
                jml_kursi += 1;
            }
        });

        if (jml_kursi != 10 || $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button")
            .hasClass("our-color-kursi")) {
            if ($("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").hasClass(
                "our-color-kursi")) {
                $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").toggleClass(
                    "our-color-kursi color-black")
            } else {
                $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").toggleClass(
                    "our-color-kursi color-black")
            }

            $("#no-kursi").empty();

            jml_kursi = 0; //untuk reset kembali counter kursi

            var totalharga = 0;

            $("#isi_kursi  > tr > td .btn").each(function () {
                if ($(this).hasClass("our-color-kursi")) {
                    // console.log($(this).html());
                    jml_kursi += 1;
                    totalharga += Number((($("#harga_fil").html().replace("Rp. ", "")).replace(",00", "")).replace(".", ""));

                    if (jml_kursi > 1) {
                        $("#no-kursi").append(", " + $(this).html());
                    } else {
                        $("#no-kursi").append($(this).html());
                    }
                }
            });
            var final_harga = (totalharga / 1000).toFixed(3);
            $("#total-harga").html("Rp. " + final_harga);
            $("#jumlah-kursi").html(jml_kursi);
        } else {
            $("#alert_kursi").modal("show");
            return;
        }
    });

    var poskursi = [];

    function cek_jumlah_kursi() {
        var kursi = 0;

        $("#isi_kursi  > tr > td .btn").each(function () {
            if ($(this).hasClass("our-color-kursi")) {
                kursi += 1;
                poskursi.push($(this).html())
            }
        });
        return kursi;
    }

    var posX = [];
    var posY = [];
    function cek_pos_kursi() {
        posX = [];
        posY = [];
        $("#isi_kursi  > tr > td .btn").each(function () {
            if ($(this).hasClass("our-color-kursi")) {
                var pil_X = ($(this).html().charCodeAt(0) - 65);
                var pil_Y = ($(this).text().substr(1, 2) - 1);
                posX.push(pil_X);
                posY.push(pil_Y);
            }
        });
    }

    $(document).on("click", "#pesan_tiket", function () {
        if (cek_jumlah_kursi() != 0) {
            var temp_data;
            // console.log("Jumlah Kursi : " + cek_jumlah_kursi() + '\n' + "Pos Kursi : " + poskursi + '\n' + "Id Film : " + id_fil + '\n' + "Tanggal Film : " + tanggal_fil + '\n' + "id_jadwal : " + id_jdw);
            cek_pos_kursi();
            data = posX.map(function (e, i) { return { "posX": e, "posY": posY[i] } });

            temp_data = { "id_studio": td, "id_jadwal": id_jdw, "kursi": data }
            console.log(data)
            $.ajax({
                url: "process/post_data_pesanan.php",
                type: "POST",
                data: JSON.stringify(temp_data),
                success: function (response) {
                    $("#proses").modal('show');
                    setTimeout(munculin_proses, 4000);
                }, error: function (jqXHR, textStatus, errorThrown) {
                    window.location.replace("../../error_page.php")
                }
            });

            function munculin_proses() {
                window.location.replace("pembayaran.php")
            }
        } else {
            $("#alert_pilih_kursi").modal("show");
        }
    });
    // { "idbrg": idbr, "namabrg": nm, "hargabrg": nil }


});
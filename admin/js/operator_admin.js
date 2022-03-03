$(document).ready(function () {
    $("table_user").addSortWidget(); //plugin tambahan untuk sort data table 

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function generate_list_admin() {
        $("#table_user").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_admin_user_list.php',
            success: function (response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function (data) {
                        if (data['role'] == 1) {
                            var txt1 = "<tr><td class='text-center'>" + data['id_admin'] +
                                "</td><td class='text-center'> " + data[
                                'username'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-danger btn-block'>Admin</div></td></tr>"
                        } else {
                            var txt1 = "<tr><td class='text-center'>" + data['id_admin'] +
                                "</td><td class='text-center'>" + data['username'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-info btn-block'>Operator</div></td><td class='align-middle text-center'><a class='btn btn-danger' href='process/post_hapus_admin.php?id_admin=" +
                                data['id_admin'] + "'>Hapus</div></td></tr>"
                        }
                        $("#table_user").append(txt1)
                    })
                } catch (e) { window.location.href = "error_page.php" }
            },
            error: function () {
                window.location.href = "error_page.php";
            }
        });
    }
    generate_list_admin();

    $("#btn_tambah_operator").click(function (e) {
        e.preventDefault();
        $("#lihat_data_operator").addClass("hide-div");
        $("#tambah_data_operator").removeClass("hide-div");
    });

    $("#btn_lihat_operator").click(function (e) {
        e.preventDefault();
        $("#lihat_data_operator").removeClass("hide-div");
        $("#tambah_data_operator").addClass("hide-div");
    });
});
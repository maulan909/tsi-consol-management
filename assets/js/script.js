$(document).ready(function () {

    $("#palet_no").on('keyup', function () {
        var locInput = $(this).val();
        $.ajax({
            url: url + 'consol/get',
            method: 'post',
            data: { location: locInput },
            dataType: 'json',
            success: function (data) {
                if (data.status == 'overload') {
                    $('#suggested').attr('class', 'text text-danger').html('Disarankan menggunakan palet no ' + data.suggest + ' karena total koli lebih sedikit');
                } else if (data.status == 'reject') {
                    $('#suggested').attr('class', 'text text-danger').html('Palet no ' + locInput + ' tidak tersedia');
                } else {
                    $('#suggested').attr('class', 'd-none');
                }

            }
        });
    });

    //ajax location
    $("#ca_no").on('keyup', function () {
        var caNo = $(this).val();

        $.ajax({
            url: url + 'consol/get',
            method: 'post',
            data: { ca_no: caNo },
            dataType: 'json',
            success: function (data) {
                if (data.status != null) {
                    if (data.status == 'first') {
                        $('#jmlPicklist').attr('class', 'alert alert-primary').html('Picklist ke : ' + (data.consol + 1) + ' dari ' + data.picklist + ' Picklist');
                        $('#jmlKoli').attr('class', 'alert alert-primary').html('Total Koli Sebelumnya: ' + (data.koli) + ' Koli');
                        if(data.zona != ''){
                            $('#kotaZona').attr('class', 'h4 font-weight-bold alert alert-primary').html('Tujuan : ' + (data.kota) + ' | ' + (data.zona));
                        }
                    } else if (data.status == 'part') {
                        $('#ca_no').attr('readonly', '');
                        $('#palet_no').val(data.palet_no);
                        $('#palet_no').attr('readonly', '');
                        $('#jmlPicklist').attr('class', 'alert alert-primary').html('Picklist ke : ' + (data.consol + 1) + ' dari ' + data.picklist + ' Picklist');
                        $('#jmlKoli').attr('class', 'alert alert-primary').html('Total Koli Sebelumnya: ' + (data.koli) + ' Koli');
                        if(data.zona != ''){
                            $('#kotaZona').attr('class', 'h4 font-weight-bold alert alert-primary').html('Tujuan : ' + (data.kota) + ' | ' + (data.zona));
                        }
                    } else if (data.status == 'moved') {
                        swal({
                            title: "Nomor CA ini sudah di Pindah Ke Zona Pengiriman ",
                            icon: "warning",
                            text: "Ada indikasi kelebihan barang di Nomor CA yang anda input!",
                            buttons: ["Batal", "OK"],
                        })
                        .then((willCheck) => {
                            if (willCheck) {
                                window.open(url + 'package/moved#search=' + encodeURI(caNo), "_self");
                            } else {
                                window.open(url + 'package/moved#search=' + encodeURI(caNo), "_self");
                            }
                        });
                    } else if (data.status == 'full') {
                        swal({
                            title: "Nomor CA ini sudah lengkap dan berada di Palet No " + data.palet_no,
                            icon: "info",
                            text: "Ada indikasi kelebihan barang di Nomor CA yang anda input!",
                            buttons: ["Batal", "Cek"]
                        })
                        .then((willCheck) => {
                            if (willCheck) {
                                window.open(url + 'package/readytomove#search=' + encodeURI(caNo), "_self");
                            } else {
                                window.open(url + 'package/readytomove#search=' + encodeURI(caNo), "_self");
                            }
                        });
                    } else if (data.status == 'done') {
                        swal({
                            title: "Nomor CA ini sudah di dikirim !",
                            icon: "warning",
                            text: "Ada indikasi kelebihan barang di Nomor CA yang anda input!",
                            buttons: ["Batal", "OK"],
                        })
                        .then((willCheck) => {
                            if (willCheck) {
                                window.open(url + "package/history", "_self");
                            } else {
                                window.open(url + "package/history", "_self");
                            }
                        });
                    }
                } else {
                    $('#kotaZona').attr('class', 'd-none');
                    $('#jmlPicklist').attr('class', 'd-none');
                    $('#jmlKoli').attr('class', 'd-none');
                }
            }
        });
    });

    //confirm delete item consol
    $('#dataTable').on('click', '.delCons', function () {
        const id = $(this).data('id');
        swal({
            title: "Anda yakin ingin menghapus data ini?",
            icon: "warning",
            buttons: ["Batal", "Hapus"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    window.open(url + 'consol/delete/' + id, "_self");
                }
            });
    });



    $('#userTable').DataTable({

    });
    var searchHash = location.hash.substr(1),
        searchString = searchHash.substr(searchHash.indexOf('search='))
            .split('&')[0]
            .split('=')[1];
    //data table team console
    $('#dataTable').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 5 }
        ],
        "order": [[4, "desc"]]
    });

    //data table waitin package
    $('#waitList').DataTable({

    });
    $('#labelForm').submit(function () {

        var w = window.open('about:blank', 'Popup_Window', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=1000,height=700,left = 100,top = 100');
        this.target = 'Popup_Window';
    })
    //data table ready to move
    $('#readyList').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 5 }
        ],
        "oSearch": { "sSearch": searchString }
    });

    //data table moved package
    $('#movedList').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 5 }
        ],
        "oSearch": { "sSearch": searchString }
    });

    //data table offline
    $('#offlineList').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 3 }
        ]
    });
    $('#historyTable').DataTable({
        "order": [[6, "desc"]],
        "oSearch": { "sSearch": searchString }
    });

    //confirm move CA Consol to Delivery
    $('#readyList').on('click', '.moveCons', function () {
        const id = $(this).data('id');
        swal({
            title: "Anda yakin ingin memindahkan data ini?",
            text: "Paket akan di pindahkan ke Zona Pengiriman!",
            icon: "warning",
            buttons: ["Batal", "Pindahkan"],
            dangerMode: true,
        })
            .then((willMove) => {
                if (willMove) {
                    $.ajax({
                        url: url + 'package/movedeliver',
                        method: 'post',
                        data: { ca: id },
                        dataType: 'json',
                        success: function () {
                        }
                    })
                    setTimeout(function () {
                        window.open(url + 'package/readytomove', '_self');
                    }, time);
                }
            });
    });

    //confirm move back Delivery to Consol
    $('#movedList').on('click', '.moveReverse', function () {
        const id = $(this).data('id');
        swal({
            title: "Anda yakin ingin memindahkan data ini?",
            text: "Paket akan di pindahkan kembali ke palet consol!",
            icon: "warning",
            buttons: ["Batal", "Pindahkan"],
            dangerMode: true,
        })
            .then((willMove) => {
                if (willMove) {
                    $.ajax({
                        url: url + 'package/moveReverse',
                        method: 'post',
                        data: { ca_no: id },
                        dataType: 'json',
                        success: function () {
                        }
                    })
                    setTimeout(function () {
                        window.open(url + 'package/moved', '_self');
                    }, time);
                }
            });
    });

    //confirm move Offline Consol to Delivery
    $('#offlineList').on('click', '.moveConsUnd', function () {
        const id = $(this).data('id');
        swal({
            title: "Anda yakin ingin memindahkan data ini?",
            text: "Paket akan di pindahkan ke Zona Pengiriman!",
            icon: "warning",
            buttons: ["Batal", "Pindahkan"],
            dangerMode: true,
        })
            .then((willMove) => {
                if (willMove) {
                    $.ajax({
                        url: url + 'package/movedeliver',
                        method: 'post',
                        data: { ca: id },
                        dataType: 'json',
                        success: function () {
                        }
                    })
                    setTimeout(function () {
                        window.open(url + 'package/undetected', '_self');
                    }, time);
                }
            });
    });


    //ajax edit item consol
    $("#ca_no_edit").on('keyup', function () {

        var caNoEdit = $("#ca_no_edit").val();

        $.get('ajax/data.php?key=' + caNoEdit, function (data) {
            var hasil = data.split("_");
            if (hasil != "") {
                $("#loc_palet").val(hasil[1]);
                $("#loc_palet").attr("disabled", "");
            } else {
                $("#loc_palet").removeAttr('disabled', "");
            }

        });
    });

    //validation Form Edit Consol
    $('#formConsEdit').submit(function () {
        var caNo = $('#ca_no_edit').val().length;
        var loc = $('#loc_palet');
        var koli = $('#koli');

        if (caNo == 0) {
            $('#caval').html('Nomor CA wajib diisi!');
            return false;
        } else if (loc.val().length == 0) {
            $('#palval').attr("class", "text text-danger");
            $('#palval').html('Lokasi Palet wajib diisi!');
            return false;
        } else if (koli.val().length == 0) {
            $('#koval').html('Jumlah Koli wajib diisi!');
            return false;
        } else if (loc.val() < 0) {
            $('#palval').html('Masukan angka di atas 0!');
            return false;
        } else if (koli.val() < 0) {
            $('#koval').html('Masukan angka di atas 0!');
            return false;
        }
        $("#ca_no_edit").removeAttr('disabled', "");
        $("#loc_palet").removeAttr('disabled', "");

    });

    //form validation number
    $("#palet_no").on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    //form validation number
    $("#koli").on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $.ajax({
        url: url + 'package/check',
        method: 'post',
        dataType: 'json',
        data: { key: 'user' },
        success: function (data) {
            if (data.ready == true) {
                $('#readytomove').attr('class', 'badge badge-primary badge-counter d-inline-block');
            }
            if (data.undetected == true) {
                $('#undetected').attr('class', 'badge badge-primary badge-counter d-inline-block');
            }
        }
    });
    $('#username').on('keyup', function () {
        var username = $('#username').val();
        var type = 'username';
        $.ajax({
            url: url + 'user/check',
            method: 'post',
            dataType: 'json',
            data: {
                type: type,
                key: username
            },
            success: function (data) {
                if (data) {
                    $('#alertUsername').html(data.username + ' already used');
                } else {
                    if (username.length >= 8 && username.length <= 15) {
                        $('#alertUsername').html(username + ' available');
                    } else {
                        $('#alertUsername').html('');

                    }
                }
            }
        })
    });
    $('#email').on('keyup', function () {
        var email = $('#email').val();
        var type = 'email';
        $.ajax({
            url: url + 'user/check',
            method: 'post',
            dataType: 'json',
            data: {
                type: type,
                key: email
            },
            success: function (data) {
                if (data) {
                    $('#alertEmail').html(data.email + ' already used');
                } else {
                    if (email.length != 0) {
                        $('#alertEmail').html(email + ' available');
                    } else {
                        $('#alertEmail').html('');
                    }
                }
            }
        });
    });
    $('#btnGenerate').on('click', function () {
        var text = Math.random().toString(36).slice(-8);
        $('#password').val(text);
    });
    $('#btnTambahUser').on('click', function () {
        $('#userModalLabel').html('Tambah User');
        $('#userModal form').attr('action', url + 'user');
        $('#userModal button[type=submit]').html('Tambah');

        $('#id').val('');
        $('#username').val('');
        $('#username').removeAttr('readOnly');
        $('#email').val('');
        $('#email').removeAttr('readOnly');
        $('#password').attr('required', '');
        $('#role_id').val('');
        $('#is_active').attr('checked', '');
        $('#alertUsername').html('');
        $('#alertEmail').html('');

    });
    $('#userTable').on('click', '.btnEditUser', function () {
        var id = $(this).data('id');
        $('#password').val('');
        $('#userModalLabel').html('Edit User');
        $('#userModal form').attr('action', url + 'user/edit');
        $('#userModal button[type=submit]').html('Edit');
        $.ajax({
            url: url + 'user/check',
            method: 'post',
            data: {
                type: 'id',
                key: id
            },
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#username').val(data.username);
                $('#username').attr('readOnly', '');
                $('#email').val(data.email);
                $('#email').attr('readOnly', '');
                $('#password').removeAttr('required');
                $('#role_id').val(data.role_id);
                $('#alertUsername').html('');
                $('#alertEmail').html('');
                if (data.is_active == 1) {
                    $('#is_active').attr('checked', '');
                } else {
                    $('#is_active').removeAttr('checked');
                }
            }
        })
    });
    $('#userTable').on('click', '.btnHapusUser', function () {
        var id = $(this).data('id');
        $('#userHapusModal a').attr('href', url + 'user/hapus/' + id);
    });
    $('#userModal #btnTambahRole').on('click', function () {
        $('#roleModalLabel').html('Tambah Role');
        $('#id').val('');
        $('#rolename').val('');
        $('#roleModal form').attr('action', url + 'user/role');
        $('#roleModal button[type=submit]').html('Tambah');
    });
    $('.btnEditRole').on('click', function () {
        var roleId = $(this).data('id');
        $('#roleModalLabel').html('Edit Role');
        $('#roleModal form').attr('action', url + 'user/editrole');
        $('#roleModal button[type=submit]').html('Edit');
        $.ajax({
            url: url + 'user/getrole',
            type: 'post',
            data: { id: roleId },
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#rolename').val(data.role);
            }
        })
    });
    $('#roleModal button[type=submit]').on('click', function () {
        if ($('#rolename').val() == '') {
            $('#alertRoleName').html('The Role Name field is required!');
            return false;
        }
    });
    $('.btnHapusRole').on('click', function () {
        var id = $(this).data('id');
        $('#roleHapusModal a').attr('href', url + 'user/hapusrole/' + id);
    });
    $('.table-bordered').on('click', '.form-check-input', function () {
        const roleId = $(this).data('role');
        const menuId = $(this).data('menu');
        $.ajax({
            url: url + 'user/changerole',
            type: 'post',
            data: {
                roleId: roleId,
                menuId: menuId
            },
            success: function () {
                document.location.href = url + 'user/roleaccess/' + roleId;
            }
        });
    });
    $('#btnTambahMenu').on('click', function () {
        $('#menuModalLabel').html('Tambah Menu');
        $('#menuModal form').attr('action', url + 'menu');
        $('#menuModal button[type=submit]').html('Tambah');
        $('#id').val('');
        $('#menu_name').val('');
    });
    $('.btnEditMenu').on('click', function () {
        var id = $(this).data('id');
        $('#menuModalLabel').html('Edit Menu');
        $('#menuModal form').attr('action', url + 'menu/edit');
        $('#menuModal button[type=submit]').html('Edit');
        $.ajax({
            url: url + 'menu/getmenu',
            method: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#menu_name').val(data.menu);
            }
        });
    });
    $('.btnHapusMenu').on('click', function () {
        var id = $(this).data('id');
        $('#menuHapusModal a').attr('href', url + 'menu/hapus/' + id);
    });

    $('#btnTambahSubmenu').on('click', function () {
        $('#submenuModalLabel').html('Tambah Submenu');
        $('#submenuModal form').attr('action', url + 'menu/submenu');
        $('#submenuModal button[type=submit]').html('Tambah');
        $('#id').val('');
        $('#title').val('');
        $('#menu_id').val('');
        $('#url').val('');
        $('#icon').val('');
        $('#is_active').attr('checked', 'checked');
    });
    $('.btnEditSubmenu').on('click', function () {
        var id = $(this).data('id');
        $('#submenuModalLabel').html('Edit Submenu');
        $('#submenuModal form').attr('action', url + 'menu/editsubmenu');
        $('#submenuModal button[type=submit]').html('Edit');
        $.ajax({
            url: url + 'menu/getsubmenu',
            method: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                $('#id').val(data.id);
                $('#title').val(data.title);
                $('#menu_id').val(data.menu_id);
                $('#url').val(data.url);
                $('#icon').val(data.icon);
                if (data.is_active == 0) {
                    $('#is_active').removeAttr('checked');
                } else {
                    $('#is_active').attr('checked', '');
                }
            }
        })
    });
    $('.btnHapusSubmenu').on('click', function () {
        var id = $(this).data('id');
        $('#submenuHapusModal a').attr('href', url + 'menu/hapussubmenu/' + id);
    });
});




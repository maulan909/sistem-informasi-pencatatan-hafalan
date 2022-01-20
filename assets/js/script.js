$(document).ready(function () {
    console.log('https://github.com/maulan909');
    var pdf = {};
    //ajax location

    //pdf generate
    $('#generatePDF').on('click', function () {
        pdf.current = $('#koli').val();
        console.log(pdf);
        window.open(
            $(this).data('link') +
                '?data=' +
                encodeURIComponent(JSON.stringify(pdf)),
            'popupWindow',
            'width=600, heigth=600, scrollbar=yes'
        );
    });

    //confirm delete item consol
    $('#dataTable').on('click', '.delCons', function () {
        const id = $(this).data('id');
        swal({
            title: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            buttons: ['Batal', 'Hapus'],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.open(url + 'consol/delete/' + id, '_self');
            }
        });
    });

    $('#userTable').DataTable({});
    var searchHash = location.hash.substr(1),
        searchString = searchHash
            .substr(searchHash.indexOf('search='))
            .split('&')[0]
            .split('=')[1];
    //data table team console
    $('#dataTable').DataTable({
        columnDefs: [{ orderable: false, targets: 5 }],
        order: [[4, 'desc']],
    });

    //data table waitin package
    $('#waitList').DataTable({});
    $('#labelForm').submit(function () {
        var w = window.open(
            'about:blank',
            'Popup_Window',
            'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=1000,height=700,left = 100,top = 100'
        );
        this.target = 'Popup_Window';
    });

    //form validation number
    $('#nip').on('keypress keyup blur', function (event) {
        $(this).val(
            $(this)
                .val()
                .replace(/[^\d].+/, '')
        );
        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });
    $('#nis').on('keypress keyup blur', function (event) {
        $(this).val(
            $(this)
                .val()
                .replace(/[^\d].+/, '')
        );
        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });
    $('#telepon').on('keypress keyup blur', function (event) {
        $(this).val(
            $(this)
                .val()
                .replace(/[^\d].+/, '')
        );
        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
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
                key: username,
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
            },
        });
    });
    $('#nip').on('keyup', function () {
        var nip = $('#nip').val();
        var type = 'guru.nip';
        $.ajax({
            url: url + 'master/getguru',
            method: 'post',
            dataType: 'json',
            data: {
                type: type,
                key: nip,
            },
            success: function (data) {
                if (data) {
                    $('#alertNip').html(data.nip + ' already used');
                } else {
                    if (nip.length >= 0 && nip.length <= 30) {
                        $('#alertNip').html(nip + ' available');
                    } else {
                        $('#alertNip').html('');
                    }
                }
            },
        });
    });
    $('#email').on('keyup', function () {
        var email = $('#email').val();
        var type = 'user.email';
        $.ajax({
            url: url + 'user/check',
            method: 'post',
            dataType: 'json',
            data: {
                type: type,
                key: email,
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
            },
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
                key: id,
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
            },
        });
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
            },
        });
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
    $('#userTable').on('click', '.btnDetailGuru', function () {
        var id = $(this).data('id');
        $.ajax({
            url: url + 'master/getguru',
            method: 'post',
            data: {
                type: 'guru.id',
                key: id,
            },
            dataType: 'json',
            success: function (data) {
                let html = `
                <table>
                <tr>
                <td class="w-50 py-2">NIP</td>
                <td class="w-50">${data.nip}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Nama</td>
                <td class="w-50">${data.name}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Email</td>
                <td class="w-50">${data.email}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Nomor Telepon</td>
                <td class="w-50">${data.telepon}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Alamat</td>
                <td class="w-50">${data.alamat}</td>
                </tr>
                </table>`;
                $('#guruDetailModal .modal-body').html(html);
            },
        });
    });
    $('#userTable').on('click', '.btnHapusGuru', function () {
        var id = $(this).data('id');
        $('#guruHapusModal a').attr('href', url + 'master/hapus-guru/' + id);
    });

    $('#userTable').on('click', '.btnDetailSiswa', function () {
        var id = $(this).data('id');
        $.ajax({
            url: url + 'master/getsiswa',
            method: 'post',
            data: {
                type: 'siswa.id',
                key: id,
            },
            dataType: 'json',
            success: function (data) {
                let html = `
                <table>
                <tr>
                <td class="w-50 py-2">NIS</td>
                <td class="w-50">${data.nis}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Nama</td>
                <td class="w-50">${data.name}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Kelas</td>
                <td class="w-50">${data.kelas}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Email</td>
                <td class="w-50">${data.email}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Nomor Telepon</td>
                <td class="w-50">${data.telepon}</td>
                </tr>
                <tr>
                <td class="w-50 py-2">Alamat</td>
                <td class="w-50">${data.alamat}</td>
                </tr>
                </table>`;
                $('#siswaDetailModal .modal-body').html(html);
            },
        });
    });
    $('#userTable').on('click', '.btnHapusSiswa', function () {
        var id = $(this).data('id');
        $('#siswaHapusModal a').attr('href', url + 'master/hapus-siswa/' + id);
    });
    $('.table-bordered').on('click', '.form-check-input', function () {
        const roleId = $(this).data('role');
        const menuId = $(this).data('menu');
        $.ajax({
            url: url + 'user/changerole',
            type: 'post',
            data: {
                roleId: roleId,
                menuId: menuId,
            },
            success: function () {
                document.location.href = url + 'user/roleaccess/' + roleId;
            },
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
            },
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
            },
        });
    });
    $('.btnHapusSubmenu').on('click', function () {
        var id = $(this).data('id');
        $('#submenuHapusModal a').attr('href', url + 'menu/hapussubmenu/' + id);
    });
});

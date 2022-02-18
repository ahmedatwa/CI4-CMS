function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}


$(document).ready(function () {

    // Menu Button x|s viewport 
    $('#button-menu').on('click', function (e) {
        e.preventDefault();
        $('#sidebar').toggleClass('active');
    });

    // Disable delete Button 
    $(document).on('click', "input[name^=\'selected\'], #selectAll", function () {
        if ($(this).is(":checked")) {
            $("a[name=\'button-delete\']").removeClass('disabled').attr('aria-disabled', false);
        } else {
            $("a[name=\'button-delete\']").addClass('disabled').attr('aria-disabled', true);
        }
    });

    // Input Errors Highlight
    const feedbackElement = document.body.querySelector('.invalid-feedback');
    if (feedbackElement) {
        feedbackElement.each(function () {
            const element = $(this).prev();
            if (element.hasClass('form-control')) {
                element.addClass('is-invalid');
            }
        });
    }

    // ============================================================== 
    // Summernote Image Manager
    // ============================================================== 
    $(document).on('click', 'a[data-ci-toggle=\'image\']', function (e) {

        var $element = $(this);
        var $popover = $element.data('.popover');

        e.preventDefault();

        // destroy all image popovers
        $('a[data-toggle="image"]').popover('destroy');

        if ($popover) {
            return;
        }

        $element.popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<a type="button" id="button-image" class="btn btn-primary"><i class="far fa-edit"></i></a> <a type="button" id="button-clear" class="btn btn-danger"><i class="fas fa-minus-square"></i></a>';
            }
        });

        $element.popover('show');

        $('#button-image').on('click', function () {
            var $button = $(this);
            var $icon = $button.find('> i');

            $.ajax({
                url: 'index.php/common/filemanager?user_token=' + getURLVar('user_token') + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
                dataType: 'html',
                beforeSend: function () {
                    $button.prop('disabled', true);
                    if ($icon.length) {
                        $icon.attr('class', 'fas fa-circle-notch fa-spin');
                    }
                },
                complete: function () {
                    $button.prop('disabled', false);

                    if ($icon.length) {
                        $icon.attr('class', 'fas fa-pencil-alt');
                    }
                },
                success: function (html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
                    $('#modal-image').modal('show');
                }
            });
            $element.popover('dispose');
        });

        $(document).on('click', '#button-clear', function () {
            $element.find('img').attr('src', $element.find('img').attr('data-ci-placeholder'));
            $element.parent().find('input').val('');
            $element.popover('dispose');
        });
    });


    // ============================================================== 
    // Sidebar  
    // ============================================================== 

    // Set last page opened on the menu
    $('#menu a[href]').on('click', function () {
        sessionStorage.setItem('menu', $(this).attr('href'));
    });

    if (!sessionStorage.getItem('menu')) {
        $('#menu .menu-dashboard').addClass('active');
    } else {
        // Sets active and open to selected page in the left column menu.
        $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().addClass('active');
    }

    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li > a').removeClass('collapsed');

    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('ul').addClass('show');

    $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active');


    // ============================================================== 
    // gijgo Date Picker
    // ============================================================== 
    const datepicker = document.getElementById('datepicker');
    if (datepicker) {
        $(datepicker).datepicker({
            uiLibrary: 'bootstrap',
            format: 'dd/mm/yyyy',
            footer: false
        });
    }

    // BootStrap Tooltip
    $('[data-toggle-tooltip="tooltip"]').tooltip()

    // // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function () {
        $('[data-toggle-tooltip=\'tooltip\']').tooltip({
            container: 'body'
        });
    });


    // ============================================================== 
    // Swal
    // ============================================================== 
    // save

    $(document).on("click", "a[name=\'button-save\']", function (e) {
        e.preventDefault();
        swal.fire({
            title: "Are you sure?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            icon: 'question',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('href'),
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    method: "POST",
                    dataType: "json",
                    data: $('#' + $(this).attr('form')).serialize(),
                    beforeSend: function () {
                        $('.alert, .text-danger, .invalid-feedback').remove();
                        $('#' + $(this).attr('form') + 'input').removeClass('is-invalid');
                    },
                    success: function (json) {
                        if (json['success']) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: json['success'],
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                if (result.isDismissed) {
                                    location = json['redirect'];
                                }
                            });
                        }

                        if (json['validationErrors']) {
                            for (i in json['validationErrors']) {
                                if (i.includes('.')) {
                                   let x = i.substring(i.indexOf(".") + 1).replace(".", "-");
                                    $('#input-' + x).addClass('is-invalid')
                                    $('#input-' + x).after('<div class="invalid-feedback">' + json['validationErrors'][i] + '</div>');
                                } else {
                                    $('#input-' + i).addClass('is-invalid')
                                    $('#input-' + i).after('<div class="invalid-feedback">' + json['validationErrors'][i] + '</div>');
                                }
                            }

                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: json['error_warning'],
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } // validationErrors
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        })
    });
    // Delete
    $(document).on("click", "a[name=\'button-delete\']", function (e) {
        e.preventDefault();
        swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            showCloseButton: true,
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('href'),
                    method: "POST",
                    dataType: "json",
                    data: $('#' + $(this).attr('form')).serialize(),
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    beforeSend: function () {
                        $('.alert, .text-danger, .invalid-feedback').remove();
                    },
                    success: function (json) {
                        if (json['success']) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: json['success'],
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                if (result.isDismissed) {
                                    location = json['redirect'];
                                }
                            });
                        }

                        if (json['error_warning']) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: json['error_warning'],
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        })
    });
});

// ============================================================== 
// END Form Submission Swal
// ============================================================== 
const Swal = window.swal = window.Swal = require('sweetalert2')
require('metismenu');
window.moment = require('moment');
moment.locale('id');

// Slide Down Effect
$('.dropdown:not(.dropdown-animate-fade,.dropdown-animate-modern)').on('show.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});
$('.dropdown:not(.dropdown-animate-fade,.dropdown-animate-modern)').on('hide.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});

// Fade Effect
$('.dropdown-animate-fade').on('show.bs.dropdown', function (e) {
    $(this).find('.dropdown-menu').fadeIn().show();
});
$('.dropdown-animate-fade').on('hide.bs.dropdown', function (e) {
    $(this).find('.dropdown-menu').show().fadeToggle();
});

// Admin Section
$('#app>.overlay,.toggle-sidebar,.close-indicator').click(function () {
    $('body').toggleClass('toggled');
});
$('#garudasidenav, #metismenu').metisMenu();

function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML = `<span class="d-none d-md-inline d-sm-none">Pukul</span> ${h}:${m}:${s}`;
    setTimeout(startTime, 1000);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
}
startTime();

$(".bouton-filtrage[type='reset']").click(function(e) {
    window.location.href = window.location.href;
});

$(".bouton-filtrage[type='submit']").click(function(e) {
    $('#page').val(1);
});

jQuery(document).ready(function($) {
    $('#wp_test_data').DataTable();



} );

function get_user(id){
    var div = document.createElement('div');
    div.id = 'overlay';
    div.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
    $('body').append(div);
    $.ajax({
        url: ajaxurl,
        type: 'post',
        data: {action: 'get_detail_user',user: id},
        success: function(resulf){
            $('#detail_user .modal-content').html(resulf);
            $('#detail_user').modal();
            div.remove();
        }
    })
}
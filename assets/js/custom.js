$('.toggle-password').click(function(){
    $(this).children().toggleClass('mdi-eye-outline mdi-eye-off-outline');
    let input = $(this).prev();
    input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
});

$("#alert").hide();
$('#loginFrom').submit(function(e) {
    e.preventDefault();
    let formData = $('#loginFrom').serialize();
    $.ajax({
        method: "POST",
        url: baseUrl + "/model/profileModel.php?action=login",
        data: formData,
        dataType: 'JSON',
        beforeSend: function() {
          $(".btnLogin").html('<i class="fa fa-spinner"></i> Processing...');
          $(".btnLogin").prop('disabled', true);
          $("#alert").hide();
          
        }
      })

    .fail(function(response) {
        alert( "Try again later." );
    })

    .done(function(response) {
        if(response.status == 0){
          $("#alert").html(response.message);
          $("#alert").show();
        }else{
          location.href = response.url;
        }
        
    })
    .always(function() {
        $(".btnLogin").html('Login');
        $(".btnLogin").prop('disabled', false);
    });
    return false;
});
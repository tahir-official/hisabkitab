$('.toggle-password').click(function(){
    $(this).children().toggleClass('mdi-eye-outline mdi-eye-off-outline');
    let input = $(this).prev();
    input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
});
/*login script start*/
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
/*login script end*/

/*forget script start*/
$('#ForgetForm').submit(function(e) {

    e.preventDefault();
    let formData = $('#ForgetForm').serialize();

    $.ajax({
      method: "POST",
      url: baseUrl + "/model/profileModel.php?action=forgetPassword",
      data: formData,
      dataType: 'JSON',
      beforeSend: function() {
        $(".btnSubmit").html('<i class="fa fa-spinner"></i> Processing...');
        $(".btnSubmit").prop('disabled', true);
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
        $("#alert").html(response.message);
        $("#alert").show();
        $('#ForgetForm')[0].reset();
      }
      
    })
    .always(function() {
      $(".btnSubmit").html('Submit');
      $(".btnSubmit").prop('disabled', false);
    });
 
  return false;
});
/*forget script end*/
/*update script start*/
function updateProfile(){
  let formData = $('#updateProfile').serialize();

  $.ajax({
    method: "POST",
    url: baseUrl + "/model/profileModel.php?action=updateStore",
    data: formData,
    dataType: 'JSON',
    beforeSend: function() {
      $(".btnSubmit").html('<i class="fa fa-spinner"></i> Processing...');
      $(".btnSubmit").prop('disabled', true);
      $("#alert").hide();
      
    }
  }) 

  .fail(function(response) {
    alert( "Try again later." );
  })

  .done(function(response) {
    $('.btnSubmit').prop('disabled',false);
    $('.btnSubmit').html('Update');
    $("#alert").html(response.message);
    $("#alert").show();
    $("#adminName").html(response.name);
    
  })
	.always(function() {
      $(".btnSubmit").html('Submit');
      $(".btnSubmit").prop('disabled', false);
  });
  return false; 
}
/*update script end*/

function resetPasswordFrom(){
  $('#updatePassword')[0].reset();
  return false; 
}

/*update password script start*/
function updatePassword(){
  let formData = $('#updatePassword').serialize();
  $.ajax({
    method: "POST",
    url: baseUrl + "/model/profileModel.php?action=changePassword",
    data: formData,
    dataType: 'JSON',
    beforeSend: function() {
      $("#updatePassBtn").html('<i class="fa fa-spinner"></i> Processing...');
      $("#updatePassBtn").prop('disabled', true);
      $("#alert").hide();
      
    }
  }) 

  .fail(function(response) {
    alert( "Try again later." );
  })

  .done(function(response) {
    $('#updatePassBtn').prop('disabled',false);
    $('#updatePassBtn').html('Change');
    $("#alert").html(response.message);
    $("#alert").show();
    if(response.status==1){
      $('#updatePassword')[0].reset();
    }
    
  })

  .always(function() {
    $("#updatePassBtn").html('Change');
    $("#updatePassBtn").prop('disabled', false);
  });
  return false; 
}
/*update password script end*/

/*load user model script start*/
function loadPopupUser(user_type,data_id){
    $.ajax({
        method: "POST",
        url: baseUrl + "/model/userModel.php?action=loadPopupUser",
        data: {user_type:user_type,data_id:data_id},
        dataType: 'JSON',
        beforeSend: function() {
          $("#popupcontent").html('<div id="loader"></div>');
          
        }
    })

    .fail(function(response) {
        alert( "Try again later." );
    })

    .done(function(response) {
      $.getScript(baseUrl+"/assets/js/custom.js");
      $("#popupcontent").html(response.html);
      
        
    })
    .always(function() {
      $('#form-dialog').modal('toggle');
    });
    
    return false;
}
/*load user model script end*/

/*city script start*/
function loadCity(state_id,set_id){
    $.ajax({
        method: "POST",
        url: baseUrl + "/model/basicModel.php?action=getCites",
        data: {state_id:state_id},
        dataType: 'JSON',
        beforeSend: function() {
          $("#"+set_id).html('<option>Please wait</option>');
          
        }
    })

    .fail(function(response) {
        alert( "Try again later." );
    })

    .done(function(response) {
      $("#"+set_id).html(response.html);
        
     })

     
    
  return false;
}


/*city script start*/

function tableLoad(loadurl,other_id){

  var dataTable = $('#mytable').DataTable({
   "processing" : true,
   "serverSide" : true,
   "order" : [],
   "ajax" : {
     url:loadurl,
     type:"POST",
     data: {
      other_id: other_id
     }
   },
   'columnDefs': [ {

    'targets': '_all', /* column index */

    'orderable': false, /* true or false */

 }]
   
 });

}

$(document).ready(function () {
      /*start user form*/
      $('#userForm').validate({ 
        
        rules: {
        fname: {
          required : true
          
        },
        lname: {
          required : true
        },
        email_address: {
            required: true,
            email: true
        },
        c_number: {
          required : true,
          number: true
          
        },
        
        state_id: {
          required : true,
          
        },
        city_id: {
          required : true,
          
        }
      },
          submitHandler: function (form) { 
            let formData = $('#userForm').serialize();
            $.ajax({
              method: "POST",
              url: baseUrl + "/model/userModel.php?action=userData",
              data: formData,
              dataType: 'JSON',
              beforeSend: function() {
                $(".btnsbt").html('<i class="fa fa-spinner"></i> Processing...');
                $(".btnsbt").prop('disabled', true);
                $("#popupalert").hide();
                $("#alert").hide();
                
                  
              }
          })
      
          .fail(function(response) {
              alert( "Try again later." );
          })
      
          .done(function(response) {
            if(response.status==0){
              $("#popupalert").show();
              $("#popupalert").html(response.message);
              $(".btnsbt").html('Submit');
              $(".btnsbt").prop('disabled', false);
            }else{
              $('#form-dialog').modal('hide');
              $('#mytable').DataTable().destroy();
              tableLoad(response.fetchTableurl,null);
              $("#alert").html(response.message);
              $("#alert").show();

            }
              
          })
          .always(function() {
            $(".btnsbt").html('Submit');
              $(".btnsbt").prop('disabled', false);
           });
              return false; 
          }
      });
      /*end user form*/
      /*start add paid iteam*/

      $('#AddbillIteamForm').validate({ 
    
        rules: {
        paid_amount: {
        required : true,
        number: true
        },
        payment_mode: {
        required : true
        },
        paid_date: {
        required: true,
        
        },
        paid_image: {
        required : true,
        
        },
        
        },
        submitHandler: function (form) { 
        var formData = new FormData($('#AddbillIteamForm')[0]);
        $.ajax({
            method: "POST",
            url: baseUrl + "/model/billModel.php?action=paidIteamManage",
            data: formData,
            dataType: 'JSON',
            cache:false,
            contentType: false,
            processData: false,
            beforeSend: function() {
            $(".btnSubmit").html('<i class="fa fa-spinner"></i> Processing...');
            $(".btnSubmit").prop('disabled', true);
            $("#popupalert").hide();
            $("#alert").hide();
            
                
            }
        })
    
        .fail(function(response) {
            alert( "Try again later." );
        })
    
        .done(function(response) {
           if(response.status==0){
              $("#popupalert").show();
              $("#popupalert").html(response.message);
              $(".btnSubmit").html('Add');
              $(".btnSubmit").prop('disabled', false);
           }else{
              
            $('#form-dialog').modal('hide');
            $('#mytable').DataTable().destroy();
            tableLoad(response.fetchTableurl,response.other_id);
            $("#alert").show();
            $("#alert").html(response.message);
            $("#paidid").html(response.paid_amount);
            $("#dueid").html(response.due_amount);
           }
        })
        .always(function() {
           $(".btnSubmit").html('Add');
           $(".btnSubmit").prop('disabled', false);
        });
            return false; 
        }
    });
    /*end add paid iteam*/


    /*start update paid iteam*/

    $('#updatebillIteamForm').validate({ 
    
      rules: {
      paid_amount: {
      required : true,
      number: true
      },
      payment_mode: {
      required : true
      },
      paid_date: {
      required: true,
      
      },
      },
      submitHandler: function (form) { 
      var formData = new FormData($('#updatebillIteamForm')[0]);
      $.ajax({
          method: "POST",
          url: baseUrl + "/model/billModel.php?action=paidIteamManage",
          data: formData,
          dataType: 'JSON',
          cache:false,
          contentType: false,
          processData: false,
          beforeSend: function() {
          $(".btnSubmit").html('<i class="fa fa-spinner"></i> Processing...');
          $(".btnSubmit").prop('disabled', true);
          $("#popupalert").hide();
          $("#alert").hide();
          
              
          }
      })
  
      .fail(function(response) {
          alert( "Try again later." );
      })
  
      .done(function(response) {
         if(response.status==0){
            $("#popupalert").show();
            $("#popupalert").html(response.message);
            $(".btnSubmit").html('Update');
            $(".btnSubmit").prop('disabled', false);
         }else{
            
          $('#form-dialog').modal('hide');
          $('#mytable').DataTable().destroy();
          tableLoad(response.fetchTableurl,response.other_id);
          $("#alert").show();
          $("#alert").html(response.message);
          $("#paidid").html(response.paid_amount);
            $("#dueid").html(response.due_amount);
         }
      })
      .always(function() {
         $(".btnSubmit").html('Update');
         $(".btnSubmit").prop('disabled', false);
      });
          return false; 
      }
  });
  /*end update paid iteam*/
  
  });

  function changeUserStatus(user_id,status,user_type,fetchTableurl){
    if(status==1){
      var alertmessage='Are you sure you want to deactive this '+user_type+ '?';
    }else{
      var alertmessage='Are you sure you want to active this '+user_type+ '?';
    }
    if(confirm(alertmessage)){
          $.ajax({
            method: "POST",
            url: baseUrl + "/model/userModel.php?action=changeUserStatus",
            data: {user_id:user_id,status:status,user_type:user_type},
            dataType: 'JSON',
            beforeSend: function() {
               $('.stbtn').attr("disabled",true);
               $("#alert").hide();
             }
        })

        .fail(function(response) {
            alert( "Try again later." );
        })

        .done(function(response) {
          if(response.status==0){
            $('.stbtn').attr("disabled",false);
          }else{
            $('#form-dialog').modal('hide');
            $('#mytable').DataTable().destroy();
            tableLoad(fetchTableurl,null);
            
          }
          $("#alert").html(response.message);
          $("#alert").show();
            
        })

        .always(function() {
          $('.stbtn').attr("disabled",false);
         });
       
      }
      else{
          return false;
      }
     
  }

  function changeBillStatus(bill_id){
    var alertmessage='Are you sure you want to mark as completed ?';
    if(confirm(alertmessage)){
          $.ajax({
            method: "POST",
            url: baseUrl + "/model/billModel.php?action=changeBillStatus",
            data: {bill_id:bill_id},
            dataType: 'JSON',
            beforeSend: function() {
               $('.stbtn').attr("disabled",true);
               $("#alert").hide();
             }
        })

        .fail(function(response) {
            alert( "Try again later." );
        })

        .done(function(response) {
          if(response.status==0){
            $('.stbtn').attr("disabled",false);
          }else{
            $('#form-dialog').modal('hide');
            $('#mytable').DataTable().destroy();
            tableLoad(response.fetchTableurl,null);
            
          }
          $("#alert").html(response.message);
          $("#alert").show();
            
        })

        .always(function() {
          $('.stbtn').attr("disabled",false);
         });
       
      }
      else{
          return false;
      }
     
  }

  /*load bill iteam model script start*/
function loadPopupBillIteam(bill_id,paid_id){
  $.ajax({
      method: "POST",
      url: baseUrl + "/model/billModel.php?action=loadPopupBillIteam",
      data: {bill_id:bill_id,paid_id:paid_id},
      dataType: 'JSON',
      beforeSend: function() {
        $("#popupcontent").html('<div id="loader"></div>');
        
      }
  })

  .fail(function(response) {
      alert( "Try again later." );
  })

  .done(function(response) {
    $.getScript(baseUrl+"/assets/js/custom.js");
    $("#popupcontent").html(response.html);
    $('.number_input').mask('00000.00', { reverse: true });
    
      
  })
  .always(function() {
    $('#form-dialog').modal('toggle');
  });
  
  return false;
}
/*load bill iteam model script end*/

  

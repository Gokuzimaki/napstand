var url=''+host_addr+'snippets/mobpoint.php';
function doOpts(form){
    if (form!==""){
        var opts = {
                type: 'GET',
                url: url,
                data: $form.serialize(),
                dataType: 'json',
                success: function(output) {
                  console.log(output);
                  item_loader.addClass('hidden').css("display","");
                  var msg="Request is done";
                    raiseMainModal('Done!!', ''+msg+'', 'success');
                  // item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
                  if(output.success=="true"){

                  }
                 
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                    raiseMainModal('Failure!!', ''+errmsg+'', 'fail');

                    // item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        $.ajax(opts);
        
    }
}

function forceForm() {
    $(document).ready(function() {
        $('' + formObj + ' input[name=entryvariant]').val();
    });
}
$(document).ready(function() {
    var pagedata = document.URL;
    var pagedatatwo = pagedata.split(".");
    var realpage = pagedatatwo[0];
    // var usertype=$('input[name=userdata]').attr('data-type');;
    // var userid=$('input[name=userdata]').attr('value');
    
    //remove error class from input elements when focus lost 
    $(document).on("blur", 'input[type=text],input[type=email],input[type=file],input[type=search],input[type=number]', function() {
        $(this).removeClass('error-class');
        // $(this).css('border','1px solid #c9c9c9');
    });
    $(document).on("blur", 'select', function() {
        $(this).removeClass('error-class');
        // $(this).css('border','0px');
    });
    $(document).on("blur", '.fileinput-button', function() {
        $(this).removeClass('error-class');
        // $(this).css('border','0px');
    });
    $(document).on("blur", 'textarea', function() {
        $(this).removeClass('error-class');
        // $(this).css('border','1px solid #c9c9c9');
    });
    $(document).on("mouseenter", 'form #elementholder', function() {
        $(this).removeClass('error-class');
        $(this).css('border', '0px');
    });
    
    $(document).on("click", 'input[type=button]', function() {
        var viewwindow = $('#viewneditcontent');
        var buttonname = $(this).attr('name');
        var buttonid = $(this).attr('id');
        var tester = "";
        if(buttonname=="createappuser"){
            var formstatus=true;
            // tinyMCE.triggerSave();
            var inputname1=$('input[name=firstname]');
            var inputname2=$('input[name=middlename]');
            var inputname3=$('input[name=lastname]');
            var inputname4=$('input[name=email]');
            var inputname5=$('input[name=pword]');

            if(inputname1.val()==""){
                // window.alert('Please provide Firstname.');
                errmsg='Please provide Firstname.';
                raiseMainModal('Form error!!', ''+errmsg+'', 'fail');
                $("#mainPageModal").on("hidden.bs.modal", function () {
                    $(inputname1).addClass('error-class').focus();
                });
                formstatus= false;
            }else if(inputname3.val()==""){
                window.alert('Please give the lastname.');
                $(inputname3).addClass('error-class').focus();
                formstatus= false;
            }else if(inputname4.val()==""){
                window.alert('Give email address.');
                $(inputname4).addClass('error-class').focus();
                formstatus= false;
            }else if(inputname5.val()==""){
                window.alert('Provide the name of this user.');
                $(inputname5).addClass('error-class').focus();
                formstatus= false;
            }
            if(inputname4.val()!==""&&formstatus==true){
                var outit = emailValidatorReturnableTwo(inputname4.val());
                if (outit['status'] == "false") {
                    window.alert(outit['errormsg']);
                    inputname4.addClass('error-class').focus();
                    formstatus=false;

                }else{
                    formstatus=false;
                    var msg="Please wait the email address is being verified";
                    raiseMainModal('Verifying Email DO NOT CLOSE THIS UNTIL FINISHED!!', ''+msg+'', 'info');

                    $.ajax({
                            type: "GET",
                            data:{  
                                displaytype: "verifyemail",
                                email:""+inputname4.val()+"",
                                loadoutextra:"appuser",
                                extraval:""
                            },
                            dataType: 'json',
                            url: ""+host_addr+"snippets/display.php",
                            success: function(msg) {
                                console.log(msg);
                                result="";
                                if (msg.success == "true") {
                                    raiseMainModal('Verified!!!', ''+msg.msg+' Form is ready for submission', 'success');
                                    formstatus=true;
                                    var confirmed=window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                                    console.log(confirmed);
                                    if(confirmed===true){
                                        $('form[name=appuserform]').submit();
                                    }
                                } else {
                                    raiseMainModal('Email Already Used!!', ''+msg.msg+'', 'fail');
                                    $("#mainPageModal").on("hidden.bs.modal", function () {
                                        $(inputname4).addClass('error-class').focus();
                                    });
                                    
                                }
                                    
                                    // console.log(inputname1.val(),inputname2.val(),inputname3.val(),inputname3.val().length);
            
                            },
                            error: function() {
            
                                result = '<div class="alert error"><i class="fa fa-times-circle"></i>There was an error sending the message!</div>';
                                $("#formstatus-4").html(result);
            
                            }
                    });

                }
            }
            if(formstatus==true){
                var confirmed=window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if(confirmed===true){
                $('form[name=userform]').submit();
                }
            }
        }
    });
});

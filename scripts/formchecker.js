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
        
        if (buttonname == "adminloginsubmit") {
            var formstatus = true;
            var inputname1 = $('input[name=username]').val();
            var inputname2 = $('input[name=password]').val();
            if (inputname1 == "") {
                window.alert('Please enter the username number');
                $("input[name=username]").addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2 == "") {
                window.alert('Please enter your password');
                $("input[name=password]").addClass('error-class').focus();
                formstatus = false;
            }
            if (formstatus == true) {
                $('form[name=adminloginform]').submit();
            }
        }
        if (buttonname == "createblogtype") {
            var formstatus = true;
            var inputname1 = $('input[name=name]');
            var inputname2 = $('textarea[name=description]');
            if (inputname1.val() == "") {
                window.alert('Please fill the name field.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please give a description for the blog.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=blogtype]').submit();
                }
            }
        }
        if (buttonname == "createblogcategory") {
            var formstatus = true;
            var inputname1 = $('select[name=categoryid]');
            var inputname2 = $('input[name=name]');
            var inputname3 = $('input[name=profpic]');
            var inputname4 = $('input[name=subtext]');
            
            if (inputname1.val() == "") {
                window.alert('Please select a blog type.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please fill the category name field.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } /*else if (inputname1.val() == "3" && inputname3.val() == "") {
                window.alert('Please select a category image for this, endeavour to make sure your image dimension is not too large i.e greater than 1280 on both width and length.');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname1.val() == "3" && inputname4.val() == "") {
                window.alert('Please state the subtext of the category.');
                $(inputname4).addClass('error-class').focus();
                formstatus = false;
            }*/
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=blogcategory]').submit();
                }
            }
        }
        if (buttonname == "createblogpost") {
            var formstatus = true;
            tinyMCE.triggerSave();
            var inputname1 = $('select[name=blogtypeid]');
            var inputname2 = $('select[name=blogcategoryid]');
            var inputname3 = $('input[name=profpic]');
            var inputname4 = $('input[name=title]');
            var inputname5 = $('textarea[name=introparagraph]');
            var inputname6 = $('textarea[name=blogentry]');
            var inputname7 = $('select[name=blogentrytype]');
            var inputname8 = $('input[name=bannerpic]');
            
            
            if (inputname1.val() == "") {
                window.alert('Please select a blog type.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please select the category for this blog post.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() == "" && (inputname7.val() == "" || inputname7.val() == "normal")) {
                window.alert('Please select a cover image for this post, endeavour to make sure your image dimension is not too large i.e greater than 1280 on both width and length.');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname4.val() == "") {
                window.alert('Please the title of the blog post, adviceably, make the title as close to what a web user would search for when looking for the content you want to post.');
                $(inputname4).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname5.val() == "" && (inputname7.val() == "" || inputname7.val() == "normal")) {
                var monitor = window.confirm('Please give the introductory part of this blog, this could be a short summary of the contents of the blog, something to make your reader have an understanding of your post there in or to make them actually want to continue reading. click cancel if you want to continue');
                if (monitor === true) {
                    $(inputname5).addClass('error-class').focus();
                    formstatus = false;
                } else if (inputname6.val() == "" && (inputname7.val() == "" || inputname7.val() == "normal")) {
                    window.alert('Please give the blog post some meaning, its empty');
                    $(inputname6).addClass('error-class').focus();
                    formstatus = false;
                }
            } else if (inputname8.val() == "" && inputname7.val() == "banner") {
                window.alert('Please give the banner image');
                $(inputname8).addClass('error-class').focus();
                formstatus = false;
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The post is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    // console.log(confirmed,$('form[name=blogpost]'));
                    $('form[name=blogpost]').submit();
                }
            }
        
        }
        if (buttonname == "createblogcomment") {
            var formstatus = true;
            var inputname1 = $('input[name=name]');
            var inputname2 = $('input[name=email]');
            var inputname4 = $('input[name=sectester]');
            var inputname5 = $('input[name=secnumber]');
            
            tinyMCE.triggerSave();
            var inputname3 = $('textarea[name=comment]');
            console.log(inputname3.val());
            if (inputname1.val() == "") {
                window.alert('Please provide your fullname');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please fill the email address field.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() == "") {
                window.alert('You haven\'t given any comment');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname5.val() == "") {
                window.alert('Please enter the security number');
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname4.val() !== inputname5.val()) {
                window.alert('Sorry the security number is not correct.');
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() !== "") {
                var status = emailValidator(inputname2.val());
                formstatus = status;
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('Your comment is ready to be submitted, it would be reviewed before being activated for this blog post, if you dont want to comment click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=blogcommentform]').submit();
                }
            }
        }
        if (buttonname == "unsubscribe") {
            var formstatus = true;
            var inputname1 = $('input[name=email]');
            if (inputname1.val() == "") {
                window.alert('Please fill the email address field.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname1.val() !== "") {
                var status = emailValidator(inputname1.val());
                status !== "" ? formstatus = status : status = status;
            }
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check or are unsure you want to cancel your subscription, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    // console.log(confirmed,$('form[name=blogpost]'));
                    $('form[name=unsubscribe]').submit();
                }
            }
        }
        if (buttonname == "creategallery") {
            var formstatus = true;
            var inputname1 = $('input[name=gallerytitle]');
            var inputname2 = $('textarea[name=gallerydetails]');
            
            if (inputname1.val() == "") {
                window.alert('Please give the gallery title.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please give the gallery details.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            }
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=galleryform]').submit();
                }
            }
        }
        if (buttonname == "createadvert") {
            var formstatus = true;
            var inputname1 = $('select[name=advertpage]');
            var inputname2 = $('select[name=adverttype]');
            var inputname3 = $('input[name=advertowner]');
            var inputname4 = $('input[name=adverttitle]');
            var inputname5 = $('input[name=advertlandingpage]');
            var inputname6 = $('input[name=profpic]');
            if (inputname1.val() == "") {
                window.alert('Please select the page this advert will show up on.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Choose an advert type');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() == "") {
                window.alert('State the owner of the advert');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname4.val() == "") {
                window.alert('Give the title for the advert');
                $(inputname4).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname5.val() == "") {
                window.alert('Please give the complete url of the landing page for this advert');
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname6.val() == "") {
                window.alert('Choose a file to upload for this advert.');
                $(inputname6).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname6.val() !== "") {
                var output = getExtension(inputname6.val());
                if (inputname2.val() == "videoadvert") {
                    if (output['extension'] !== "mp4" || output['type'] !== "") {
                        window.alert('Choose a valid mp4 video file to upload.');
                        $(inputname6).addClass('error-class').focus();
                        formstatus = false;
                    }
                }
                // console.log(output['type'],output['extension']);
            }
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=advertform]').submit();
                }
            }
        }
        
        
        if (buttonname == "createclientadmin") {
            var formstatus = true;
            var inputname1 = $('input[name=businessname]');
            var inputname2 = $('textarea[name=businessdescription]');
            var inputname3 = $('select[name=state]');
            var inputname4 = $('select[name=LocalGovt]');
            var inputname5 = $('textarea[name=businessaddress]');
            var inputname6 = $('input[name=phoneone]');
            var inputname7 = $('input[name=phonetwo]');
            var inputname8 = $('input[name=phonethree]');
            var inputname9 = $('input[name=email]');
            var inputname10 = $('select[name=catid]');
            if (inputname1.val() == "") {
                window.alert('Please provide a business name.');
                $('div#BusinessBlock').addClass('in');
                $('div#ClientLocationBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname10.val() == "") {
                window.alert('Please choose a content category.');
                $('div#BusinessBlock').addClass('in');
                $('div#ClientLocationBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname10).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Give a Brief Description of the business');
                $('div#BusinessBlock').addClass('in');
                $('div#ClientLocationBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() == "") {
                window.alert('Select the state');
                $('div#ClientLocationBlock').addClass('in');
                $('div#BusinessBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname4.val() == "") {
                window.alert('Choose the local government area');
                $('div#ClientLocationBlock').addClass('in');
                $('div#BusinessBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname4).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname5.val() == "") {
                window.alert('Business address is missing');
                $('div#ClientLocationBlock').addClass('in');
                $('div#BusinessBlock').removeClass('in');
                $('div#clientcontactBlock').removeClass('in');
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname6.val() == "" && inputname7.val() == "" && inputname8.val() == "") {
                window.alert('No phone number specified.');
                $('div#clientcontactBlock').addClass('in');
                $('div#ClientLocationBlock').removeClass('in');
                $('div#BusinessBlock').removeClass('in');
                $(inputname6).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname9.val() == "") {
                window.alert('no email address specified.');
                $('div#clientcontactBlock').addClass('in');
                $('div#ClientLocationBlock').removeClass('in');
                $('div#BusinessBlock').removeClass('in');
                $(inputname9).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname9.val() !== "") {
                var status = emailValidator(inputname9.val());
                formstatus = status;
            }
            
            // console.log(output['type'],output['extension']);
            
            
            
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=clientform]').submit();
                }
            }
        }
        
        if (buttonname == "createuseradmin") {
            var formstatus = true;
            var pointmonitor = false;
            // informaion block
            var inputname1 = $('input[name=firstname]');
            var inputname10 = $('select[name=catid]');
            var inputname2 = $('input[name=middlename]');
            var inputname11 = $('input[name=lastname]');
            var inputname12 = $('input[name=nickname]');
            var inputname16 = $('select[name=gender]');
            var inputname13 = $('input[name=profpic]');
            var inputname14 = $('textarea[name=bio]');
            
            // location block
            var inputname3 = $('select[name=state]');
            var inputname4 = $('select[name=LocalGovt]');
            var inputname5 = $('textarea[name=fulladdress]');
            
            // contact block
            var inputname6 = $('input[name=phoneone]');
            var inputname7 = $('input[name=phonetwo]');
            var inputname8 = $('input[name=phonethree]');
            var inputname9 = $('input[name=email]');
            
            // social block
            var inputname15 = $('input[name=socialcount]');
            
            // get the section classes for the form if any
            var informationblock = $('div#informationBlock');
            var locationblock = $('div#LocationBlock');
            var contactblock = $('div#contactBlock');
            var socialblock = $('div#socialBlock');
            if (inputname1.val() == "") {
                window.alert('Please provide the first name.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname11.val() == "") {
                window.alert('Fill the last name field.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname11).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname16.val() == "") {
                window.alert('Specify Gender.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname16).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname10.val() == "") {
                window.alert('Please choose a content category.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname10).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname13.val() == "") {
                window.alert('Choose a profile Picture.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname13).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname14.val() == "") {
                window.alert('Provide bio content.');
                informationblock.addClass('in');
                locationblock.removeClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname14).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname3.val() == "") {
                window.alert('Select the state');
                informationblock.removeClass('in');
                locationblock.addClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname4.val() == "") {
                window.alert('Choose the local government area');
                informationblock.removeClass('in');
                locationblock.addClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname4).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname5.val() == "") {
                window.alert('Provide valid address');
                informationblock.removeClass('in');
                locationblock.addClass('in');
                contactblock.removeClass('in');
                socialblock.removeClass('in');
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname6.val() == "" && inputname7.val() == "" && inputname8.val() == "") {
                window.alert('No phone number specified.');
                informationblock.removeClass('in');
                locationblock.removeClass('in');
                contactblock.addClass('in');
                socialblock.removeClass('in');
                $(inputname6).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname9.val() == "") {
                window.alert('no email address specified.');
                informationblock.removeClass('in');
                locationblock.removeClass('in');
                contactblock.addClass('in');
                socialblock.removeClass('in');
                $(inputname9).addClass('error-class').focus();
                formstatus = false;
            	pointmonitor = true;
            } else if (inputname9.val() !== "") {
                var status = emailValidator(inputname9.val());
                formstatus = status;
            	pointmonitor = true;
            }
            
            // perform social platform check 
            // console.log(formstatus,pointmonitor,inputname15.val());
            if (Math.floor(inputname15.val())>0) {
                // formmonitor = "monitoring";
                for (var i = 1; i <= inputname15.val(); i++) {
                    var socialhandle = $('input[data-type=handle][data-pos=' + i + ']')
                    var sociallink = $('input[data-type=link][data-pos=' + i + ']');
                    // console.log(sociallink,socialhandle);
                    if (socialhandle.val() == "" && sociallink.val() !== "") {
                        window.alert('Please provide the social handle information.');
                        informationblock.removeClass('in');
                        locationblock.removeClass('in');
                        contactblock.removeClass('in');
                        socialblock.addClass('in');
                        $(socialhandle).addClass('error-class').focus();
                        formstatus = false;
                        pointmonitor = true;
                        break;
                    } else if (socialhandle.val() !== "" && sociallink.val() == "") {
                        window.alert('Please provide the social link information.');
                        informationblock.removeClass('in');
                        locationblock.removeClass('in');
                        contactblock.removeClass('in');
                        socialblock.addClass('in');
                        $(sociallink).addClass('error-class').focus();
                        formstatus = false;
                        pointmonitor = true;
                        break;
                    }
                }
            }
            
            // console.log(output['type'],output['extension']);
            
            
            
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                // console.log(confirmed);                
                if (confirmed === true) {
                	// verify the email address
                	$('form[name=userform] .loadermini').removeClass('hidden');
                	$('form[name=userform] .ajax-msg-box').removeClass('hidden');
                	var url=''+host_addr+'snippets/display.php';
                	var opts = {
				        type: 'GET',
				        url: url,
				        data: {
				        	displaytype:"verifyemailuseradmin",
				        	email:""+inputname9.val()+"",
				        	usertype:"user"
				        },
				        dataType: 'json',
				        success: function(output) {
				        	// console.log(output);
                			$('form[name=userform] .loadermini').addClass('hidden');
				        	$('div.ajax-msg-box').html(output.msg);
				        	if(output.mailtest=="unmatched"){
				        		// console.log("matched content");
                    			$('form[name=userform]').submit();
				        	}
				        },
				        error: function(error) {
				            console.log(error.responseText);
				            alert("something went wrong check your console");
				        }
				    };
			        $.ajax(opts);

                }
            }
        }
        
        
        if (buttonname == "createcontentcategory") {
            var formstatus = true;
            var inputname1 = $('input[name=catname]');
            var inputname2 = $('textarea[name=description]');
            var inputname3 = $('input[name=profpic]');
            
            if (inputname1.val() == "") {
                window.alert('Please fill the category name field.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == "") {
                window.alert('Please provide a brief description for the category.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() == "") {
                window.alert('Please select a category image for this, endeavour to make sure your image dimension is not too large i.e greater than 1280 on both width and length.');
                $(inputname3).addClass('error-class').focus();
                formstatus = false;
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=contentcategoryform]').submit();
                }
            }
        }

        if (buttonname == "createparentcontent") {   
            var formstatus = true;
            var inputname1 = $('select[name=catid]');
            var inputname2 = $('select[name=userlist]');
            var inputname3 = $('select[name=napstandlist]');
            var inputname4 = $('select[name=clientlist]');
            var inputname5 = $('select[name=userreallist]');
            var inputname6 = $('select[name=clientreallist]');
            var inputname7 = $('input[name=contenttitle]');
            var inputname8 = $('textarea[name=description]');
            var inputname9 = $('input[name=profpic]');
            
            if (inputname1.val() == "") {
                window.alert('Please select the content category.');
                $(inputname1).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() == ""&&inputname3.val() == ""&&inputname4.val() == "") {
                window.alert('Please select the user class for this post, Napstand, client or user.');
                $(inputname2).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname2.val() !== ""&&inputname5.val() == ""&&inputname3.val() == "") {
                window.alert('Choose a user'); 
                $(inputname5).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname3.val() !== ""&&inputname6.val() == ""&&inputname3.val() == "") {
                window.alert('Choose a client');
                $(inputname6).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname7.val() == "") {
                window.alert('Provide the title for this content series');
                $(inputname7).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname8.val() == "") {
                window.alert('Provide the synopsis/ description for this content series');
                $(inputname8).addClass('error-class').focus();
                formstatus = false;
            } else if (inputname9.val() == "") {
                window.alert('Provide the cover image for this content series');
                $(inputname9).addClass('error-class').focus();
                formstatus = false;
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=parentcontentform]').submit();
                }
            }
        }

        if (buttonname == "createcontententry") {   
            var formstatus = true;
            var pointmonitor=false;
            var uploadtype = $('select[name=uploadtype]');
            var postprice = $('input[name=postprice]');
            var publishdata = $('select[name=publishdata]');
            var scheduledate = $('input[name=scheduledate]');
            var imagecount = $('input[name=imagecount]');
            var imagefilesizeout = $('input[name=filesizeout]');
            var zipfile = $('input[name=zipfile]');
            var zipfilesizeout = $('input[name=zipfilesizeout]');
            
            if (uploadtype.val() == "") {
                window.alert('Please select the content upload category.');
                $(uploadtype).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (postprice.val() == ""||Math.floor(postprice.val()) == "NaN") {
                window.alert('Provide a valid number for the price, set the value to "0" if this entry is free to view');
                $(postprice).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (Math.floor(postprice.val()) > Math.floor(postprice.attr("max"))) {
                window.alert('You have exceeded the valid value limit for entry prices which currently set at "'+postprice.attr("max")+'"');
                $(postprice).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (publishdata.val() == "schedule"&&(scheduledate.val() == ""||scheduledate.val().length < 16||scheduledate.val().length < 18)) {
                window.alert('If you\'re scheduling this entry, please endeavour');
                $(scheduledate).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (uploadtype.val() == "imageupload"&&imagecount.val()=="") {
                window.alert('Specify the number of images to upload');
                $(imagecount).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (uploadtype.val() == "zipupload"&&zipfile.val()=="") {
                window.alert('Choose a "zip" archive file to upload your images, remember, only images must be in the archive and they must be named in numerical order');
                $(zipfile).addClass('error-class').focus();
                $('.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            }
            
            if (pointmonitor==false&&uploadtype.val() == "imageupload"&&Math.floor(imagecount.val())>0) {
                for(var i=1;i<=Math.floor(imagecount.val());i++){
                    var curimage=$('input[name=image_'+i+'');
                    var loadstate=curimage.attr('data-state');
                    // check if the image data is still being loaded on the form
                    if(typeof(loadstate)!=="undefined"&&loadstate=="loading"){
                        window.alert('The file data for Entry '+i+' is not completed');

                        $(curimage).addClass('error-class').focus();

                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }

                    // check if the image input has a file in it
                    if(curimage.val()==""){
                        window.alert('Choose an image for Entry '+i+'');
                        $(curimage).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }
                    // if the image input has a file then check to validate it as an image file
                    var ftype=getExtension(curimage.val());
                    if(ftype['type']!=="image"){
                        window.alert('Choose a valid image for Entry '+i+'');
                        $(curimage).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }

                }
                // check if file size limit has not been exceeded
                if (pointmonitor==false&&Math.floor(imagefilesizeout.val())>0) {
                    // recalculate total size
                    var totalsize=calculateTotalFileSize(imagefilesizeout.val());
                    if(totalsize['megabyte']>30){
                        window.alert('Your file size limit for this upload has been exceeded');
                        $(imagecount).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus = false;
                    }
                }
            }
            if(pointmonitor==false&&uploadtype.val() == "zipupload"){
                var ftype=getExtension(zipfile.val());
                var totalsize=calculateTotalFileSize(zipfilesizeout.val());
                if(ftype['extension']!=="zip"){
                    window.alert('Choose a valid "zip" archive file to upload your images, remember, only images must be in the archive and they must be named in numerical order');
                    $(zipfile).addClass('error-class').focus();
                    $('.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                    formstatus = false;
                    pointmonitor=true;
                }else if(totalsize['megabyte']>30){
                    window.alert('Your file size limit for this upload has been exceeded');
                    $(zipfile).addClass('error-class').focus();
                    $('.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                    pointmonitor=true;
                    formstatus = false;
                }
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                // console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=contententryform]').submit();
                }
            }
        }

        if (buttonname == "editcontententry") {   
            var formstatus = true;
            var pointmonitor=false;
            var formid=$(this).attr("data-id");
            var formselector='form[name=editcontententryform][data-contentid='+formid+'] ';
            var uploadtype = $(''+formselector+'select[name=edituploadtype]');
            var postprice = $(''+formselector+'input[name=editpostprice]');
            var publishdata = $(''+formselector+'select[name=editpublishdata]');
            var scheduledate = $(''+formselector+'input[name=editscheduledate]');
            var imagecount = $(''+formselector+'input[name=imagecountedit]');
            var imagefilesizeout = $(''+formselector+'input[name=filesizeoutedit]');
            var zipfile = $(''+formselector+'input[name=zipfileedit]');
            var zipfilesizeout = $(''+formselector+'input[name=zipfilesizeoutedit]');
            // console.log(postprice.val(),postprice.attr("value"));
            /*if (uploadtype.val() == "") {
                window.alert('Please select the content category.');
                $(uploadtype).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else*/ if (postprice.val() == ""||Math.floor(postprice.val()) == "NaN") {
                window.alert('Provide a valid number for the price, set the value to "0" if this entry is free to view');
                $(postprice).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (postprice.val() !== "" && Math.floor(postprice.val()) > Math.floor(postprice.attr("max"))) {
                window.alert('You have exceeded the valid value limit for entry prices which is currently set at "'+postprice.attr("max")+'"');
                $(postprice).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (publishdata.val() == "schedule"&&(scheduledate.val() == ""||scheduledate.val().length < 16||scheduledate.val().length < 18)) {
                window.alert('If you\'re scheduling this entry, please endeavour');
                $(scheduledate).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (uploadtype.val() == "imageuploadedit"&&imagecount.val()=="") {
                window.alert('Specify the number of images to upload');
                $(imagecount).addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            } else if (uploadtype.val() == "zipuploadedit"&&zipfile.val()=="") {
                window.alert('Choose a "zip" archive file to upload your images, remember, only images must be in the archive and they must be named in numerical order');
                $(zipfile).addClass('error-class').focus();
                $('.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                formstatus = false;
                pointmonitor=true;
            }
            
            if (pointmonitor==false&&uploadtype.val() == "imageuploadedit"&&Math.floor(imagecount.val())>0) {
                for(var i=1;i<=Math.floor(imagecount.val());i++){
                    var curimage=$(''+formselector+'input[name=image_'+i+']');
                    var loadstate=curimage.attr('data-state');
                    // check if the image data is still being loaded on the form
                    if(typeof(loadstate)!=="undefined"&&loadstate=="loading"){
                        window.alert('The file data for Entry '+i+' is not completed');

                        $(curimage).addClass('error-class').focus();

                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }

                    // check if the image input has a file in it
                    if(curimage.val()==""){
                        window.alert('Choose an image for Entry '+i+'');
                        $(curimage).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }
                    // if the image input has a file then check to validate it as an image file
                    var ftype=getExtension(curimage.val());
                    if(ftype['type']!=="image"){
                        window.alert('Choose a valid image for Entry '+i+'');
                        $(curimage).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus=false;
                        break;
                    }

                }
                // check if file size limit has not been exceeded
                if (pointmonitor==false&&Math.floor(imagefilesizeout.val())>0) {
                    // recalculate total size
                    var totalsize=calculateTotalFileSize(imagefilesizeout.val());
                    if(totalsize['megabyte']>30){
                        window.alert('Your file size limit for this upload has been exceeded');
                        $(imagecount).addClass('error-class').focus();
                        pointmonitor=true;
                        formstatus = false;
                    }
                }
            }
            if(pointmonitor==false&&uploadtype.val() == "zipuploadedit"){
                var ftype=getExtension(zipfile.val());
                var totalsize=calculateTotalFileSize(zipfilesizeout.val());
                if(ftype['extension']!=="zip"){
                    window.alert('Choose a valid "zip" archive file to upload your images, remember, only images must be in the archive and they must be named in numerical order');
                    $(zipfile).addClass('error-class').focus();
                    $(''+formselector+'.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                    formstatus = false;
                    pointmonitor=true;
                }else if(totalsize['megabyte']>30){
                    window.alert('Your file size limit for this upload has been exceeded');
                    $(zipfile).addClass('error-class').focus();
                    $(''+formselector+'.fileinput-button.'+zipfile.attr('name')+'').addClass('error-class').focus();
                    pointmonitor=true;
                    formstatus = false;
                }
            }
            // console.log(status);
            if (formstatus == true) {
                var confirmed = window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                // console.log(confirmed);
                if (confirmed === true) {
                    $('form[name=editcontententryform][data-contentid='+formid+']').submit();
                }
            }
        }

        if(buttonname == "sortcontententryorder"){
            var total_length=$('ul.sortable_content_entries > li').length;

            if(Math.floor(total_length)>0){
                var formid=$(this).attr("data-id");
                var formselector='form[name=sortcontentform][data-contentid='+formid+'] ';
                confirm=window.confirm("You are about to submit a new sort order for this content entry, click/tap OK to continue or 'Cancel' to stop");
                if(confirm===true){
                    $(''+formselector+'').submit();
                }
            }
        }


        if(buttonname=="submituser"){
            var formstatus=true;
            tinyMCE.triggerSave();
            var inputname1=$('input[name=username]');
            var inputname2=$('input[name=password]');
            var inputname3=$('select[name=accesslevel]');
            var inputname4=$('input[name=fullname]');

            if(inputname1.val()==""){
            window.alert('Please provide the username.');
                $(inputname1).addClass('error-class').focus();
                formstatus= false;
            }else if(inputname2.val()==""){
            window.alert('Please give the password.');
                $(inputname2).addClass('error-class').focus();
                formstatus= false;
            }else if(inputname3.val()==""){
            window.alert('Please select the access level.');
                $(inputname2).addClass('error-class').focus();
                formstatus= false;
            }else if(inputname4.val()==""){
            window.alert('Provide the name of this user.');
                $(inputname4).addClass('error-class').focus();
                formstatus= false;
            }
            if(formstatus==true){
                var confirmed=window.confirm('The form is ready to be submitted, if you want to cross check, click "Cancel" otherwise click "OK"');
                console.log(confirmed);
                if(confirmed===true){
                $('form[name=userform]').submit();
                }
            }
        }

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
            if(inputname4.val()!==""){
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
                                // console.log(msg);
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

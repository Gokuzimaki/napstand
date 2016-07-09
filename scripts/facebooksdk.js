   // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          testAPI();

        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
      }
   window.fbAsyncInit = function() {
        FB.init({
          appId      : '1634947986743780',
          xfbml      : true,
          status     : true,
          version    : 'v2.4'
        });
        FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
        });
      };

      
      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }
      // Now that we've initialized the JavaScript SDK, we call 
      // FB.getLoginStatus().  This function gets the state of the
      // person visiting this page and can return one of three states to
      // the callback you provide.  They can be:
      //
      // 1. Logged into your app ('connected')
      // 2. Logged into Facebook, but not your app ('not_authorized')
      // 3. Not logged into Facebook and can't tell if they are logged into
      //    your app or not.
      //
      // These three cases are handled in the callback function.

  
      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
          console.log('Successful login for: ' + response.name);
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + ''+response.first+'';
            
        });
      }  

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
      /*window.fbAsyncInit = function() {
        FB.init({
            appId   : 'YOUR_APP_ID',
            oauth   : true,   // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          testAPI();

        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.

          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
      }
   window.fbAsyncInit = function() {
        FB.init({
          appId      : '1634947986743780',
          oauth   : true,
          xfbml      : true,
          status     : true,
          version    : 'v2.4'
        });
//         FB.getLoginStatus(function(response) {
//         statusChangeCallback(response);
//         });
      };

      
      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }
      // Now that we've initialized the JavaScript SDK, we call 
      // FB.getLoginStatus().  This function gets the state of the
      // person visiting this page and can return one of three states to
      // the callback you provide.  They can be:
      //
      // 1. Logged into your app ('connected')
      // 2. Logged into Facebook, but not your app ('not_authorized')
      // 3. Not logged into Facebook and can't tell if they are logged into
      //    your app or not.
      //
      // These three cases are handled in the callback function.

  
      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me?fields=id,name,gender', function(response) {
          console.log('Successful login for: ' + response.name,response);
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '!';
            
        });
      }  

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
      /*window.fbAsyncInit = function() {
        FB.init({
            appId   : 'YOUR_APP_ID',
            oauth   : true,
            status  : true, // check login status
            cookie  : true, // enable cookies to allow the server to access the session
            xfbml   : true // parse XFBML
        });

      };*/
function doLogin(){
  FB.login(function(response) {
      if (response.authResponse) {
          console.log('Welcome!  Fetching your information.... ');
          access_token = response.authResponse.accessToken; //get access token
          user_id = response.authResponse.userID; //get FB UID                
          expiry = response.authResponse.expiresIn; //get FB UID                
          console.log(response); // dump complete info
          console.log(access_token,user_id); // dump complete info
          FB.api('/me?fields=name,gender,email,birthday,first_name,middle_name,last_name,age_range', function(response) {
              user_email = response.email; //get user email
              user_gender = response.gender; //get user email
              user_firstname = response.first_name; //get user email
              user_middlename = response.middle_name; //get user email
              user_lastname = response.last_name; //get user email
              user_age = response.age_range.min; //get user email
              console.log(response); // dump complete info
              localid="";
                $.ajax({
                  type: "POST",
                  data:{  
                    entryvariant: "fbreglog",
                    accesstoken:""+access_token+"",
                    expiry:""+expiry+"",
                    userid:""+user_id+"",
                    useremail:""+user_email+"",
                    gender:""+user_gender+"",
                    age:""+user_age+"",
                    firstname:""+user_firstname+"",
                    middlename:""+user_middlename+"",
                    lastname:""+user_lastname+"",
                    extraval:""
                  },
                  url: ""+host_addr+"snippets/basicsignup.php",
                  dataType: "json",
                  success: function(msg) {
                    console.log(msg);
                    // result="";
                    // jsonreturn fields
                    /*
                    *activitytype - the nature of the current activity values are - "" 
                    *activitystatus - the error if any the app should specify values are - "success", failure 
                    *errormessage - the error if any the app should specify occurs on failure value for activity status 
                    *pointurl - the url the app should redirect to
                    *curid - the id (from maxmegold) of the user login in or registering 
                    */
                    if (msg.activitystatus == 'success') {
                        window.location.href=''+msg.pointurl+'';
                    } else if(msg.activitystatus=="failure"){
                      $('#status').html(msg.errormessage);
                    }
                      
                        // console.log(inputname1.val(),inputname2.val(),inputname3.val(),inputname3.val().length);
          
                  },
                  error: function(er) {
                    console.log(er);
                    result = '<div class="alert error"><i class="fa fa-times-circle"></i>There was an error getting you in!<br> '+er+'</div>';
                    $("#status").html(result);
          
                  }
              }); 
              
              document.getElementById('status').innerHTML =
          'Thanks for logging in, ' + response.name + '! Do note that using this feature to register still requires a little effort from you, concerning updating your profile. <br>You will be redirected shortly, please be patient and let adsbounty set you up...';
            /*FB.api('/me/picture', function(responsetwo) {      
                console.log(responsetwo); // dump complete info
            });*/
          // you can store this data into your database             

          });
      } else {
          //user hit cancel button
          console.log('User cancelled login or did not fully authorize.');
      }
  });
}
// for handling user already logged in settings
function doReSetup(){
    FB.api('/me?fields=name,gender,email,birthday,first_name,middle_name,last_name,age_range', function(response) {
        user_email = response.email; //get user email
        user_gender = response.gender; //get user email
        user_firstname = response.first_name; //get user email
        user_middlename = response.middle_name; //get user email
        user_lastname = response.last_name; //get user email
        user_age = response.age_range.min; //get user email
        console.log(response); // dump complete info
        localid="";
          $.ajax({
            type: "POST",
            data:{  
              entryvariant: "fbreglog",
              accesstoken:""+access_token+"",
              expiry:""+expiry+"",
              userid:""+user_id+"",
              useremail:""+user_email+"",
              gender:""+user_gender+"",
              age:""+user_age+"",
              firstname:""+user_firstname+"",
              middlename:""+user_middlename+"",
              lastname:""+user_lastname+"",
              extraval:""
            },
            url: ""+host_addr+"snippets/basicsignup.php",
            dataType: "json",
            success: function(msg) {
              console.log(msg);
              // result="";
              // jsonreturn fields
              /*
              *activitytype - the nature of the current activity values are - "" 
              *activitystatus - the error if any the app should specify values are - "success", failure 
              *errormessage - the error if any the app should specify occurs on failure value for activity status 
              *pointurl - the url the app should redirect to
              *curid - the id (from Adsbounty) of the user login in or registering 
              */
              if (msg.activitystatus == 'success') {
                  window.location.href=''+msg.pointurl+'';
              } else if(msg.activitystatus=="failure"){
                $('#status').html(msg.errormessaage);
              }
                
                  // console.log(inputname1.val(),inputname2.val(),inputname3.val(),inputname3.val().length);
    
            },
            error: function(er) {
              console.log(er);
              result = '<div class="alert error"><i class="fa fa-times-circle"></i>There was an error getting you in!<br> '+er+'</div>';
              $("#status").html(result);
    
            }
        }); 
        
        document.getElementById('status').innerHTML =
    'Thanks for logging in, ' + response.name + '! Do note that using this feature to register still requires a little effort from you, concerning updating your profile. <br>You will be redirected shortly, please be patient and let adsbounty set you up...';
      /*FB.api('/me/picture', function(responsetwo) {      
          console.log(responsetwo); // dump complete info
      });*/
      // you can store this data into your database             

    });
}
/*function fb_login(){
    FB.getLoginStatus(function(response) {
          // statusChangeCallback(response);
          if (response.status === 'connected') {
          // Logged into your app and Facebook.
          access_token = response.authResponse.accessToken; //get access token
          user_id = response.authResponse.userID; //get FB UID                
          expiry = response.authResponse.expiresIn; //get FB UID  
          doReSetup();

        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.

          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
            doLogin();
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
            doLogin();
        }
          
    });

}*/
  /*(function() {
      var e = document.createElement('script');
      e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
      e.async = true;
      document.getElementById('fb-root').appendChild(e);
  }());*/
          /*  status  : true, // check login status
            cookie  : true, // enable cookies to allow the server to access the session
            xfbml   : true // parse XFBML
        });

      };*/

function fb_login(){
    FB.login(function(response) {
        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID
            console.log(access_token,user_id); // dump complete info
            
            FB.api('/me', function(response) {
                user_email = response.email; //get user email
                console.log(response); // dump complete info
                document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '! '+user_email+'';
            // you can store this data into your database             
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }/*, {
        scope: 'public_profile,email'
    }*/);
}
/*(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());*/
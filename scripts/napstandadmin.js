$(document).ready(function() {
    hideBind("div[name=closefullcontenthold]", "#fullbackground", "fadeOut", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontenthold", "fadeOut", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontent", "html", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontentheader", "html", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontentdetails", "html", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontentheader", "fadeOut", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontentdetails", "fadeOut", 1000, "", "");
    hideBind("div[name=closefullcontenthold]", "#fullcontentpointerhold", "fadeOut", 1000, "", "");
    $(document).on("click", "ul li a[appdata-type=menulinkitem]", function() {
        var linkname = $(this).attr("appdata-name");
        //$('section.content').html(help[''+linkname+'']);
        var sublinkreq = new Request();
        sublinkreq.generate('section.content', true);
        //enter the url
        sublinkreq.url('' + host_addr + 'snippets/display.php?displaytype=' + linkname + '&extraval=admin');
        //send request
        sublinkreq.opensend('GET');
        //update dom when finished, takes four params targetElement,entryType,entryEffect,period
        sublinkreq.update('section.content', 'html', 'fadeIn', 1000);
    
    });
    $(document).on("blur", 'div#formend select[name=photocount]', function() {
        //window.alert('event called');
        var photocount = $(this).val();
        var photocountmain = photocount;
        var curpics = $('input[name=piccount]').val();
        console.log(curpics, this, photocount)
        var totoptions = '<option value="">--add More?--</option>';
        if (curpics == "" || curpics < 1) {
            while (photocount > 0) {
                $('<br><br><input type="file" class="curved" name="defaultpic' + photocount + '"/>').insertAfter('#formend select[name=photocount]');
                photocount--;
            }
            //update the current number of photo fields displayed
            $('input[name=piccount]').attr('value', '' + photocountmain + '');
            //update selection options
            var totpics = 10 - Math.floor(photocountmain);
            var rempics = Math.floor(totpics);
            // console.log(rempics,photocount);
            if (rempics > 0) {
                //updates the selection box for he remainning possible photo uploads
                while (rempics > 0) {
                    totoptions += '<option value="' + rempics + '">' + rempics + ' File</option>';
                    // $('<option value="'+rempics+'">'+rempics+' Photos</option>').insertBefore('select[name=photocount] option');      
                    rempics--;
                }
                $(this).html(totoptions);
            } else {
                totoptions = '<option value="">Max Of 10</option>';
                $(this).html(totoptions);
            }
        } else {
            //
            var photoentry;
            while (photocount > 0) {
                photoentry = Math.floor(photocount) + Math.floor(curpics);
                $('<br><br><input type="file" class="curved" name="defaultpic' + photoentry + '"/>').insertAfter('select[name=photocount]');
                photocount--;
            }
            // console.log("In here");
            var totpics = Math.floor(curpics) + Math.floor(photocountmain);
            var checkpicleft = 10 - totpics;
            var rempics = checkpicleft;
            console.log(rempics, totpics);
            $('input[name=piccount]').attr('value', '' + totpics + '');
            if (rempics > 0) {
                while (rempics > 0) {
                    totoptions += '<option value="' + rempics + '">' + rempics + ' Files</option>';
                    // $('<option value="'+rempics+'">'+rempics+' Photos</option>').insertBefore('select[name=photocount] option');      
                    rempics--;
                }
                $(this).html(totoptions);
            } else {
                totoptions = '<option value="">Max Of 10</option>';
                $(this).html(totoptions);
            }
        }
    });
    
    $(document).on("click", "a[data-name=mainsearchbyoption]", function() {
        var thetype = $(this).attr("data-value");
        var theplaceholder = $(this).attr("data-placeholder");
        var thetext = $(this).text();
        $('input[name=searchby]').val("" + thetype + "");
        $('input[name=q]').attr("placeholder", "" + theplaceholder + "");
        $('button[data-name=searchbyspace]').html("" + thetext + " <span class=\"fa fa-caret-down\"></span>");
    });
    $(document).on("click", "input[type=button][name=mainsearch]", function() {
        var searchby = $('form[name=mainsearchform] select[name=searchby').val();
        var searchval = $('form[name=mainsearchform] input[name=mainsearch').val();
        if (searchby !== "" && searchval !== "") {
            var searchreq = new Request();
            searchreq.generate('#contentdisplayhold,section.content', true);
            //enter the url
            searchreq.url('../snippets/display.php?displaytype=mainsearch&searchby=' + searchby + '&mainsearch=' + searchval + '&extraval=admin');
            //send request
            searchreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            searchreq.update('div#contentdisplayhold,section.content', 'html', 'fadeIn', 1000);
        
        } else {
            window.alert("To use the search feature you must choose a 'Search By' option first then enter your search value next, then you can search, if any is empty you would keep seeing this.....until you follow the simple instruction.");
        }
    });
    $(document).on("click", "form[name=mainsearchform].sidebar-form button[type=button][name=mainsearch]", function() {
        var searchby = $('form[name=mainsearchform].sidebar-form input[name=searchby]').val();
        var searchval = $('form[name=mainsearchform].sidebar-form input[name=q]').val();
        if (searchby !== "" && searchval !== "") {
            var searchreq = new Request();
            searchreq.generate('section.content', true);
            //enter the url
            searchreq.url('../snippets/display.php?displaytype=mainsearch&searchby=' + searchby + '&mainsearch=' + searchval + '&extraval=admin');
            //send request
            searchreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            searchreq.update('section.content', 'html', 'fadeIn', 1000);
        
        } else {
            window.alert("To use the search feature you must choose a 'Search By' option first then enter your search value next, then you can search, if any is empty you would keep seeing this.....until you follow the simple instruction.");
            $('form[name=mainsearchform].sidebar-form input[name=q]').focus();
        }
    });
    
    $(document).on("click", '#editimgsoptionlinks a', function() {
        var linkname = $(this).attr('name');
        var linkid = $(this).attr('data-id');
        var albumreq = new Request();
        var albumlinkreq = new Request();
        if (linkname == "deletepic") {
            //   $('div[name=profimg'+;linkid+']').css("display","none");
            var confirm = window.confirm('Are you sure you want to delete this, click "OK" to delete this or "Cancel" to stop')
            if (confirm === true) {
                albumlinkreq.generate('#fullcontent', false);
                albumlinkreq.url('' + host_addr + 'snippets/display.php?displaytype=' + linkname + '&extraval=' + linkid + '');
                //send request
                albumlinkreq.opensend('GET');
                albumlinkreq.update('#fullcontent', 'none', 'none', 0);
                $('div[name=albumimg' + linkid + ']').fadeOut(500).html("");
                var galid = $(this).attr("data-galleryid");
                var thesrc = $(this).attr("data-src");
                var galname = $(this).attr("data-galleryname");
                galname == "" || typeof (galname) == "undefined" ? galname = "gallerydata" : galname = galname;
                var galleryimgsrcs = $('input[name=' + galname + '' + galid + ']').attr('data-images');
                var galleryimgsizes = $('input[name=' + galname + '' + galid + ']').attr('data-sizes');
                var posterpoint = $(this).attr('data-arraypoint');
                galleryimgsrcsarray = galleryimgsrcs.split(">");
                galleryimgsizesarray = galleryimgsizes.split("|");
                var id = $.inArray(thesrc, galleryimgsrcsarray);
                var dlength = galleryimgsrcsarray.length;
                var newimgsrcs = "";
                var newsizes = "";
                for (var t = 0; t < dlength; t++) {
                    if (t !== id) {
                        newimgsrcs == "" ? newimgsrcs += galleryimgsrcsarray[t] : newimgsrcs += "]" + galleryimgsrcsarray[t];
                        newsizes == "" ? newsizes += galleryimgsizesarray[t] : newsizes += "|" + galleryimgsizesarray[t];
                    }
                }
                /*$('input[name='+galname+''+galid+']').attr('data-images',''+newimgsrcs+'');
                $('input[name='+galname+''+galid+']').attr('data-sizes',''+newsizes+'');*/
                var galname = $(this).attr("data-galleryname");
                galname == "" || typeof (galname) == "undefined" ? galname = "gallerydata" : galname = galname;
                var galleryimgsrcs = $('input[name=' + galname + '' + galid + ']').attr('data-images');
                var galleryimgsizes = $('input[name=' + galname + '' + galid + ']').attr('data-sizes');
                var posterpoint = $(this).attr('data-arraypoint');
                var galleryimgsrcsarray = galleryimgsrcs.split(">");
                var galleryimgsizesarray = galleryimgsizes.split("|");
                var dlength = galleryimgsrcsarray.length;
                $('input[name=' + galname + '' + galid + ']').attr({
                    'data-images': '' + newimgsrcs + '',
                    'data-sizes': '' + newsizes + ''
                });
                /*$('input[name=gallerycount]').attr('value',''+dlength+'');
                $('input[name=currentgalleryview]').attr('value','');
                $('input[name=curgallerydata]').attr('data-images',''+newimgsrcs+'');
                $('input[name=curgallerydata]').attr('data-sizes',''+newsizes+'');*/
                var tlength = $('div[name=galleryfullholder' + galid + ']').find("a[name=deletepic]").length;
                console.log(id, tlength);
                for (var i = 0; i < tlength; i++) {
                    var curpoint = $('div[name=galleryfullholder' + galid + ']').find("a[name=deletepic]")[i].attributes[4].value;
                    if (curpoint > posterpoint) {
                        var newpoint = curpoint - 1;
                        $('div[name=galleryfullholder' + galid + ']').find("a[name=deletepic]")[i].attributes[4].value = newpoint;
                        $('div[name=galleryfullholder' + galid + ']').find("a[name=viewpic]")[i].attributes[4].value = newpoint;
                    }
                }
            }
        
        } else if (linkname == "viewpic") {
            $('#fullcontent img[name=fullcontentwait]').show();
            // var gallery_name=$('input[name=bloggallerydata]').attr('title');
            var gallery_name = "";
            // var gallery_details=$('input[name=bloggallerydata]').attr('data-details');
            var posterpoint = $(this).attr('data-arraypoint');
            var galleryimgsrcsarray = new Array();
            var galleryimgsizesarray = new Array();
            var galid = $(this).attr("data-galleryid");
            var galname = $(this).attr("data-galleryname");
            galname == "" || typeof (galname) == "undefined" ? galname = "gallerydata" : galname = galname;
            console.log($('input[name=' + galname + '' + galid + ']'), 'input[name=' + galname + '' + galid + ']');
            var galleryimgsrcs = $('input[name=' + galname + '' + galid + ']').attr('data-images');
            var galleryimgsizes = $('input[name=' + galname + '' + galid + ']').attr('data-sizes');
            var galleryimgsrcsarray = galleryimgsrcs.split(">");
            var galleryimgsizesarray = galleryimgsizes.split("|");
            var posterimg = galleryimgsrcsarray[posterpoint];
            var gallerydata = "";
            var gallerytotal = galleryimgsrcsarray.length - 1;
            gallery_name += '<input type="hidden" name="gallerycount" value="' + gallerytotal + '"/><input type="hidden" name="currentgalleryview" value="' + posterpoint + '"/><input type="hidden" name="curgallerydata" data-images="' + galleryimgsrcs + '" data-sizes="' + galleryimgsizes + '" data-galleryname="' + galname + '" value=""/>';
            if (galleryimgsrcsarray.length > 1) {
                for (var i = 0; i < galleryimgsrcsarray.length; i++) {
                // console.log(galleryimgsrcsarray[i],galleryimgsizesarray[i],posterimg);
                }
                var prevpoint = Math.floor(posterpoint) - 1;
                var nextpoint = Math.floor(posterpoint) + 1;
                prevpoint < 0 ? prevpoint = 0 : prevpoint = prevpoint;
                console.log(prevpoint, nextpoint);
                nextpoint >= galleryimgsrcsarray.length ? nextpoint = galleryimgsrcsarray.length - 1 : nextpoint = nextpoint;
                $('img[name=pointleft]').attr("data-point", "" + prevpoint + "");
                $('img[name=pointright]').attr("data-point", "" + nextpoint + "");
            }
            var cursize = galleryimgsizesarray[posterpoint].split(',');
            var imgwidth = Math.floor(cursize[0]);
            var imgheight = Math.floor(cursize[1]);
            var contwidth = $('#fullcontent').width();
            var contheight = $('#fullcontent').height();
            contwidth = Math.floor(contwidth);
            contheight = Math.floor(contheight);
            var outs = new Array();
            outs = produceImageFitSize(imgwidth, imgheight, 960, 700, "off");
            var firstcontent = '<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="' + host_addr + 'images/closefirst.png" title="Close"class="total"/></div>' + 
            '<img src="' + posterimg + '" name="galleryimgdisplay" style="' + outs['style'] + '" title="' + gallery_name + '"/>' + 
            '<img src="' + host_addr + 'images/waiting.gif" name="fullcontentwait" style="margin-top:285px;margin-left:428px;z-index:80;">'
            ;
            $('#fullcontent').html("" + firstcontent + "");
            $('#fullcontentheader').html(gallery_name);
            // $('#fullcontentdetails').html(gallery_details);
            var topdistance = $(window).scrollTop();
            // console.log(topdistance);
            if (topdistance > 100) {
                var pointerpos = topdistance + 100;
                $('#fullcontent').css("margin-top", "" + topdistance + "px");
                $('#fullcontentpointerhold').css("margin-top", "" + topdistance + "px");
            } else {
                $('#fullcontent').css("margin-top", "0px");
                $('#fullcontentpointerhold').css("margin-top", "0px");
            }
            
            $('#fullbackground').fadeIn(1000);
            $('#fullcontenthold').fadeIn(1000);
            $('#fullcontent').fadeIn(1000);
            $('#fullcontentheader').fadeIn(1000);
            $('#fullcontentdetails').fadeIn(1000);
            $('#fullcontentpointerhold').fadeIn(1000);
            $('img[name=galleryimgdisplay]').load(function() {
                $('#fullcontent img[name=fullcontentwait]').hide();
            });
        
        } else {
        
        }
    });
    
    
    $(document).on("click", '#editmediacontentoptionlinks a', function() {
        var linkname = $(this).attr('name');
        var linkid = $(this).attr('data-id');
        var mediatype = $(this).attr('data-mediatype');
        var medianame = $(this).attr('data-medianame');
        var mainsrc = $(this).attr('data-src');
        var mediareq = new Request();
        var medialinkreq = new Request();
        var outs = new Array();
        if (linkname == "view") {
            if (mediatype == "image") {
                var imgwidth = $(this).attr('data-width');
                var imgheight = $(this).attr('data-height');
                outs = produceImageFitSize(imgwidth, imgheight, 960, 700, "off");
                var dispcontent = '<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>' + 
                '<img src="' + mainsrc + '" name="galleryimgdisplay" style="' + outs['style'] + '" title=""/>' + 
                '<img src="../images/waiting.gif" name="fullcontentwait" style="margin-top:285px;margin-left:428px;z-index:80;">'
                ;
            
            } else if (mediatype == "audio") {
                outs = produceImageFitSize(360, 80, 960, 700, "off");
                var dispcontent = '<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>' + 
                '<audio src="' + mainsrc + '" controls="" preload="none" style="float:left;' + outs['style'] + '" title="">You do not have support for html5 audio <a href="' + mainsrc + '">click here</a> to download this media content</audio>';
            } else if (mediatype == "video") {
                outs = produceImageFitSize(400, 300, 960, 700, "off");
                var dispcontent = '<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>' + 
                '<video title="" id="example_video_1" style="float:left;width:400px;height:300px;' + outs['style'] + '" class="video-js vjs-default-skin" controls preload="true" width="" height="200px" poster="" data-setup="{}">' + 
                '<source src="' + mainsrc + '"/>You do not have support for html5 video <a href="' + mainsrc + '">click here</a> to download this media content</video>';
            }
            var topdistance = $(window).scrollTop();
            // console.log(topdistance);
            if (topdistance > 100) {
                var pointerpos = topdistance + 100;
                $('#fullcontent').css("margin-top", "" + topdistance + "px");
                $('#fullcontentpointerhold').css("margin-top", "" + topdistance + "px");
            } else {
                $('#fullcontent').css("margin-top", "0px");
                $('#fullcontentpointerhold').css("margin-top", "0px");
            }
            $('#fullcontent').html("" + dispcontent + "");
            $('#fullcontentheader').html(medianame);
            $('img[name=galleryimgdisplay]').load(function() {
                $('#fullcontent img[name=fullcontentwait]').hide();
            });
            $('#fullbackground').fadeIn(1000);
            $('#fullcontenthold').fadeIn(1000);
            $('#fullcontent').fadeIn(1000);
            $('#fullcontentheader').fadeIn(1000);
        
        
        } else if (linkname == "delete") {
            var confirm = window.confirm('Are you sure you want to delete this, click "OK" to delete this or "Cancel" to stop');
            if (confirm === true) {
                medialinkreq.generate('#fullcontent', false);
                medialinkreq.url('../snippets/display.php?displaytype=' + linkname + '&extraval=' + linkid + '');
                //send request
                medialinkreq.opensend('GET');
                medialinkreq.update('#fullcontent', 'none', 'none', 0);
                $('div[name=mediacontent' + linkid + ']').fadeOut(500);
            
            }
        }
    });
    
    $('#fullcontenthold img[name=pointleft]').on("click", function() {
        var totalcount = $('#fullcontentheader input[name=gallerycount]').attr("value");
        var currentview = $('#fullcontentheader input[name=currentgalleryview]').attr("value");
        var galleryimgsrcsarray = new Array();
        var galleryimgsizesarray = new Array();
        var galleryimgsrcs = $('#fullcontentheader input[name=curgallerydata]').attr('data-images');
        var galleryimgsizes = $('#fullcontentheader input[name=curgallerydata]').attr('data-sizes');
        /*var galname=$('#fullcontentheader input[name=curgallerydata]').attr('data-galleryname');
          galname==""||typeof(galname)=="undefined"?galname="gallerydata":galname=galname;*/
        galleryimgsrcsarray = galleryimgsrcs.split(">");
        galleryimgsizesarray = galleryimgsizes.split("|");
        var nextview;
        // console.log(currentview, totalcount);
        if (Math.floor(currentview) <= Math.floor(totalcount)) {
            nextview = Math.floor(currentview) - 1;
            console.log(nextview);
            //nextview works in array index format meaning 0 holds a valid position
            if (nextview > -1 && nextview <= totalcount) {
                $('#fullcontent img[name=fullcontentwait]').show();
                $('div#fullcontent img[name=galleryimgdisplay]').attr("src", "").hide();
                var nextimg = galleryimgsrcsarray[nextview];
                console.log(nextview, nextimg);
                var cursize = galleryimgsizesarray[nextview].split(',');
                var imgwidth = Math.floor(cursize[0]);
                var imgheight = Math.floor(cursize[1]);
                var contwidth = $('#fullcontent').width();
                var contheight = $('#fullcontent').height();
                contwidth = Math.floor(contwidth);
                contheight = Math.floor(contheight);
                var outs = new Array();
                outs = produceImageFitSize(imgwidth, imgheight, 960, 700, "off");
                
                $('#fullcontent img[name=galleryimgdisplay]').attr({
                    "src": "" + nextimg + "",
                    "style": "" + outs['style'] + ""
                }).load(function() {
                    $(this).fadeIn(1000);
                    $('#fullcontent img[name=fullcontentwait]').hide();
                });
                $('#fullcontentheader input[name=currentgalleryview]').attr("value", "" + nextview + "");
            }
        }
    });
    
    $('#fullcontentpointerright img[name=pointright]').on("click", function() {
        var totalcount = Math.floor($('#fullcontentheader input[name=gallerycount]').attr("value"));
        var currentview = Math.floor($('#fullcontentheader input[name=currentgalleryview]').attr("value"));
        var galleryimgsrcsarray = new Array();
        var galleryimgsizesarray = new Array();
        var galleryimgsrcs = $('#fullcontentheader input[name=curgallerydata]').attr('data-images');
        var galleryimgsizes = $('#fullcontentheader input[name=curgallerydata]').attr('data-sizes');
        galleryimgsrcsarray = galleryimgsrcs.split(">");
        galleryimgsizesarray = galleryimgsizes.split("|");
        var nextview;
        console.log($(this).attr("name"), totalcount);
        if (currentview <= totalcount) {
            nextview = Math.floor(currentview) + 1;
            //nextview works in array index format meaning 0 holds a valid position
            if (nextview > -1 && nextview <= totalcount) {
                $('#fullcontent img[name=fullcontentwait]').show();
                $('div#fullcontent img[name=galleryimgdisplay]').attr("src", "").hide();
                $('#fullcontent img[name=galleryimgdisplay]').attr({
                    "src": "" + host_addr + "images/waiting.gif",
                    "style": "margin-top:285px;margin-left:428px;"
                });
                var nextimg = galleryimgsrcsarray[nextview];
                console.log(nextview, nextimg);
                var cursize = galleryimgsizesarray[nextview].split(',');
                var imgwidth = Math.floor(cursize[0]);
                var imgheight = Math.floor(cursize[1]);
                var contwidth = $('#fullcontent').width();
                var contheight = $('#fullcontent').height();
                contwidth = Math.floor(contwidth);
                contheight = Math.floor(contheight);
                var outs = new Array();
                outs = produceImageFitSize(imgwidth, imgheight, 960, 700, "off");
                $('#fullcontent img[name=galleryimgdisplay]').attr({
                    "src": "" + nextimg + "",
                    "style": "" + outs['style'] + ""
                }).load(function() {
                    $('#fullcontent img[name=fullcontentwait]').hide();
                    $(this).fadeIn(1000);
                });
                $('#fullcontentheader input[name=currentgalleryview]').attr("value", "" + nextview + "");
            }
        }
    
    });
    
    $(document).on("click", "#contentdisplayhold table td audio", function() {
        // console.log($('section.content table td audio'),$('section.content table td audio').length);
        for (var i = 0; i <= $('section.content table td audio').length; i++) {
            // check if the current audio element has buffered information
            var loadtest = $('section.content table td audio')[i].buffered.length;
            if (loadtest == 1 && $('section.content table td audio')[i] !== this) {
                $('section.content table td audio')[i].pause();
                $('section.content table td audio')[i].currentTime = 0;
            }
        }
        // $(this).addClass('activeaudio');
    
    });
    
    
    
    
    
    /*blog post content handle section*/
    
    $(document).on("blur", "select[name=editblogcategory]", function() {
        var theval = $(this).val();
        console.log(theval);
        if (theval !== "") {
            var editcatreq = new Request();
            editcatreq.generate('section.content', true);
            //enter the url
            var url = '../snippets/display.php?displaytype=editblogcategorymain&blogtypeid=' + theval + '&extraval=admin';
            editcatreq.url('../snippets/display.php?displaytype=editblogcategorymain&blogtypeid=' + theval + '&extraval=admin');
            //send request
            editcatreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            editcatreq.update('section.content', 'html', 'fadeIn', 1000);
        } else {
        
        }
    
    });
    $(document).on("blur", "select[name=blogtypeid]", function() {
        var theid = $(this).val();
        if (theid !== "") {
            var blogcatreq = new Request();
            blogcatreq.generate('select[name=blogcategoryid]', false);
            //enter the url
            blogcatreq.url('../snippets/display.php?displaytype=getblogcategories&blogtypeid=' + theid + '&extraval=admin');
            //send request
            blogcatreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            blogcatreq.update('select[name=blogcategoryid]', 'html', 'fadeIn', 1000);
        } else {
        
        }
    });
    $(document).on("click", "input[name=viewblogposts]", function() {
        
        var theid = $('select[name=blogtypeid]').val();
        var secondid = $('select[name=blogcategoryid]').val();
        if (theid !== "") {
            var blogpostreq = new Request();
            blogpostreq.generate('section.content', false);
            //enter the url
            blogpostreq.url('../snippets/display.php?displaytype=viewblogposts&blogtypeid=' + theid + '&blogcategoryid=' + secondid + '&extraval=admin');
            //send request
            blogpostreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            blogpostreq.update('section.content', 'html', 'fadeIn', 1000);
        
        } else {
        
        }
    });
    $(document).on("click", "input[name=viewsubscribers]", function() {
        
        var theid = $('select[name=blogtypeid]').val();
        var secondid = $('select[name=blogcategoryid]').val();
        if (theid !== "") {
            var blogpostreq = new Request();
            blogpostreq.generate('section.content', false);
            //enter the url
            blogpostreq.url('../snippets/display.php?displaytype=viewsubscribers&blogtypeid=' + theid + '&blogcategoryid=' + secondid + '&extraval=admin');
            //send request
            blogpostreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            blogpostreq.update('section.content', 'html', 'fadeIn', 1000);
        
        } else {
        
        }
    });
    $(document).on("click", "input[name=viewadverts]", function() {
        var theid = $('select[name=advertcat]').val();
        // var secondid=$('select[name=blogcategoryid]').val();
        if (theid !== "") {
            var advertscatreq = new Request();
            advertscatreq.generate('section.content', false);
            //enter the url
            advertscatreq.url('../snippets/display.php?displaytype=viewadverts&advertcat=' + theid + '&extraval=admin');
            //send request
            advertscatreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            advertscatreq.update('section.content', 'html', 'fadeIn', 1000);
        } else {
        
        }
    });
    $(document).on("click", "a[name=morecatposts]", function() {
        var catid = $(this).attr("data-catid");
        var nextid = $(this).attr("data-next");
        if (nextid > 0) {
            var blogcatpostreq = new Request();
            blogcatpostreq.generate('div[name=waitinghold]', true);
            //enter the url
            blogcatpostreq.url('../snippets/display.php?displaytype=viewblogposts&blogtypeid=' + theid + '&blogcategoryid=' + secondid + '&extraval=admin');
            //send request
            blogcatpostreq.opensend('GET');
            //update dom when finished, takes four params targetElement,entryType,entryEffect,period
            blogcatpostreq.update('section.content div:last', 'insertAfter', 'fadeIn', 1000);
        
        } else {
        
        }
    });
    $(document).on("click", "a[name=removecomment]", function() {
        var cid = $(this).attr("data-cid");
        var comremreq = new Request();
        comremreq.generate('div[name=minicommentsearchhold] div[data-id=' + cid + ']', false);
        //enter the url
        comremreq.url('../snippets/display.php?displaytype=removecomment&cid=' + cid + '&extraval=admin');
        //send request
        comremreq.opensend('GET');
        //update dom when finished, takes four params targetElement,entryType,entryEffect,period
        comremreq.update('div[name=minicommentsearchhold] div[data-id=' + cid + ']', 'html', '', 0);
        $('div[name=minicommentsearchhold] div[data-id=' + cid + ']').fadeOut(500);
        // console.log($('div[name=minicommentsearchhold] div[data-id=' + cid + ']'));
    });
    
    $(document).on("click", "td[name=trcontrolpoint] a", function() {
        var linkname = $(this).attr("name");
        var linkid = $(this).attr("data-divid");
        // console.log(linkid, linkname);
        if (linkname == "disablecomment") {
            $(this).attr({
                "name": "reactivatecomment",
                "data-type": "reactivatecomment"
            }).text('Reactivate');
            $("td[name=commentstatus" + linkid + "]").text("disabled");
        } else if (linkname == "activatecomment" || linkname == "reactivatecomment") {
            $(this).attr({
                "name": "disablecomment",
                "data-type": "disablecomment"
            }).text('Disable');
            $("td[name=commentstatus" + linkid + "]").text("active");
        
        } else if (linkname == "editsingleservicerequest" || linkname == "editsinglebooking") {
            $("td[name=servicestatus" + linkid + "]").text("active");
            $("td[name=bookingstatus" + linkid + "]").text("active");
        } else if (linkname == "disablesubscriber") {
            $(this).attr({
                "name": "activatesubscriber",
                "data-type": "activatesubscriber"
            }).text('activate');
            $("td[name=subscriptionstatus" + linkid + "]").text("inactive");
        } else if (linkname == "activatesubscriber") {
            $(this).attr({
                "name": "disablesubscriber",
                "data-type": "disablesubscriber"
            }).text('disable');
            $("td[name=subscriptionstatus" + linkid + "]").text("active");
        }
    });
    /*end*/

    $(document).on("click", "input[type=checkbox]", function() {
        var datastate = $(this).attr("data-state");
        if (datastate == "off") {
            $(this).attr("data-state", "on");
        } else {
            $(this).attr("data-state", "off");
        }
    });
    
    $(document).on("click", "#contentdisplayhold table td audio", function() {
        // console.log($('section.content table td audio'),$('section.content table td audio').length);
        for (var i = 0; i <= $('section.content table td audio').length; i++) {
            // check if the current audio element has buffered information
            var loadtest = $('section.content table td audio')[i].buffered.length;
            if (loadtest == 1 && $('section.content table td audio')[i] !== this) {
                $('section.content table td audio')[i].pause();
                $('section.content table td audio')[i].currentTime = 0;
            }
        }
        // $(this).addClass('activeaudio');
    
    });
    
    
    
    $(document).on("blur","select[name=blogentrytype]",function(){
        var curtype=$(this).val();
        // console.log(bcurtype);
        if(curtype=="normal"||curtype==""){
          $('#contentdisplayhold div[data-name=introparagraph], section.content div[data-name=introparagraph]').show(300);
          $('#contentdisplayhold div[data-name=blogentry], section.content div[data-name=blogentry]').show(300);
          $('#contentdisplayhold div[data-name=coverphoto], section.content div[data-name=coverphoto]').show(300);
          $('#contentdisplayhold div[data-name=coverphotofloat], section.content div[data-name=coverphotofloat]').show(300);
          $('#contentdisplayhold div[data-name=bannerpicentry], section.content div[data-name=bannerpicentry]').hide(300);
          $('#contentdisplayhold div[data-name=galleryentry], section.content div[data-name=galleryentry]').hide(300);
          $('#contentdisplayhold div[data-name=videosection], section.content div[data-name=videosection]').hide(300);
          $('#contentdisplayhold div[data-name=audiosection], section.content div[data-name=audiosection]').hide(300);
        }else if(curtype=="gallery"){
          $('#contentdisplayhold div[data-name=introparagraph], section.content div[data-name=introparagraph]').hide(300);
          $('#contentdisplayhold div[data-name=blogentry], section.content div[data-name=blogentry]').hide(300);
          $('#contentdisplayhold div[data-name=coverphoto], section.content div[data-name=coverphoto]').hide(300);
          $('#contentdisplayhold div[data-name=coverphotofloat], section.content div[data-name=coverphotofloat]').hide(300);
          $('#contentdisplayhold div[data-name=bannerpicentry], section.content div[data-name=bannerpicentry]').hide(300);
          $('#contentdisplayhold div[data-name=galleryentry], section.content div[data-name=galleryentry]').show(300);
          $('#contentdisplayhold div[data-name=videosection], section.content div[data-name=videosection]').hide(300);
          $('#contentdisplayhold div[data-name=audiosection], section.content div[data-name=audiosection]').hide(300);
        }else if(curtype=="banner"){
          $('#contentdisplayhold div[data-name=introparagraph], section.content div[data-name=introparagraph]').hide(300);
          $('#contentdisplayhold div[data-name=blogentry], section.content div[data-name=blogentry]').hide(300);
          $('#contentdisplayhold div[data-name=coverphoto], section.content div[data-name=coverphoto]').hide(300);
          $('#contentdisplayhold div[data-name=coverphotofloat], section.content div[data-name=coverphotofloat]').hide(300);
          $('#contentdisplayhold div[data-name=bannerpicentry], section.content div[data-name=bannerpicentry]').show(300);
          $('#contentdisplayhold div[data-name=galleryentry], section.content div[data-name=galleryentry]').hide(300);
          $('#contentdisplayhold div[data-name=videosection], section.content div[data-name=videosection]').hide(300);
          $('#contentdisplayhold div[data-name=audiosection], section.content div[data-name=audiosection]').hide(300);
        }else if(curtype=="video"){
          $('#contentdisplayhold div[data-name=introparagraph], section.content div[data-name=introparagraph]').show(300);
          $('#contentdisplayhold div[data-name=blogentry], section.content div[data-name=blogentry]').show(300);
          $('#contentdisplayhold div[data-name=coverphoto], section.content div[data-name=coverphoto]').show(300);
          $('#contentdisplayhold div[data-name=coverphotofloat], section.content div[data-name=coverphotofloat]').show(300);
          $('#contentdisplayhold div[data-name=bannerpicentry], section.content div[data-name=bannerpicentry]').hide(300);
          $('#contentdisplayhold div[data-name=galleryentry], section.content div[data-name=galleryentry]').hide(300);
          $('#contentdisplayhold div[data-name=videosection], section.content div[data-name=videosection]').show(300);
          $('#contentdisplayhold div[data-name=audiosection], section.content div[data-name=audiosection]').hide(300);
        }else if(curtype=="audio"){
          $('#contentdisplayhold div[data-name=introparagraph], section.content div[data-name=introparagraph]').show(300);
          $('#contentdisplayhold div[data-name=blogentry], section.content div[data-name=blogentry]').show(300);
          $('#contentdisplayhold div[data-name=coverphoto], section.content div[data-name=coverphoto]').show(300);
          $('#contentdisplayhold div[data-name=coverphotofloat], section.content div[data-name=coverphotofloat]').show(300);
          $('#contentdisplayhold div[data-name=bannerpicentry], section.content div[data-name=bannerpicentry]').hide(300);
          $('#contentdisplayhold div[data-name=galleryentry], section.content div[data-name=galleryentry]').hide(300);
          $('#contentdisplayhold div[data-name=videosection], section.content div[data-name=videosection]').hide(300);
          $('#contentdisplayhold div[data-name=audiosection], section.content div[data-name=audiosection]').show(300);
        }

    });
    $(document).on("blur", "select[name=questiontype]", function() {
        var curtype = $(this).val();
        if (curtype == "answersonly") {
            $('div[name=answergroup],span[name=answergroup]').fadeIn(500);
            $('div[name=questionshold] div.inputgroup-mbottom').attr("style", "");
            $('div[name=scorevalidity]').fadeIn(500);
        } else if (curtype == "datagathering") {
            $('div[name=questionshold] div.inputgroup-mbottom').css("width", "98%");
            $('div[name=answergroup],span[name=answergroup]').hide(0);
            $('div[name=scorevalidity]').hide(500);
        }
        ;
    })
    
    
    
    

    /*var old_index=0;
    $("ul.sortable_content_entries").sortable({
      group: 'sortable_content_entries',
      pullPlaceholder: false,
      handle: '.dragimg_placeholder',
      exclude:'#editimgsoptionlinks ul',
      // animation on drop
      onDrop: function  ($item, container, _super,event) {
            
            var cur_index=$item.index()+1;
            var parentul=$item.parent();
            var dataid=parentul.attr("data-id");
            var total_length=$('ul.sortable_content_entries[data-id='+dataid+'] > li').length;
            if(Math.floor(cur_index)<Math.floor(old_index)){

                for(var i=cur_index;i<=old_index;i++){
                    // change form input data and values
                    var parent=$('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+')');
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+')').attr("data-order-attr",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .img_list_position').text(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .content_image_loader').attr("data-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .single_image_hold').attr("data-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') a[name=deletepic_contententry]').attr("data-order-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=imgid_]').attr("name","imgid_"+i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=mainid_]').attr("name","mainid_"+i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=mainid_]').val(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').val(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').attr("value",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').attr("data-id",i);
                    // console.log('Affected: ', parent);
                }
            }else if (Math.floor(cur_index)>Math.floor(old_index)) {

                for(var i=old_index;i<=cur_index;i++){
                     // change form input data and values
                    var parent=$('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+')');
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+')').attr("data-order-attr",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .img_list_position').text(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .content_image_loader').attr("data-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') .single_image_hold').attr("data-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') a[name=deletepic_contententry]').attr("data-order-id",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=imgid_]').attr("name","imgid_"+i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=mainid_]').attr("name","mainid_"+i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name*=mainid_]').val(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').val(i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').attr("value",i);
                    $('ul.sortable_content_entries[data-id='+dataid+'] > li:nth-of-type('+i+') input[name=changeorder]').attr("data-id",i);
                    // console.log('Affected(Lower): ', parent);
                }
            }
            $item.attr("style","");
            console.log(old_index,cur_index,total_length);
      },

      // set $item relative to cursor position
      onDragStart: function ($item, container, _super, event) {
            // $('input[name=changeorder').blur();
            var offset = $item.offset(),
                pointer = container.rootGroup.pointer;
                old_index=$item.index()+1;
                // console.log(pointer.left,offset.left,pointer.left - offset.left,"Client X: ",event.clientX);
            // $item.css("z-index","9999");
            $item.css({
                  "z-index":"9999",
                  "left": pointer.left,
                  "top": pointer.top
            });
            adjustment = {
              left: offset.left,
              top: offset.top
            };

            // _super($item, container);
      },
      onDrag: function ($item, position) {
            // console.log("cur position: ",position);

            $item.css({
                  "position":"absolute",
                  "left": position.left,
                  "top": position.top
            });
      }
    })*/
    //Datemask dd/mm/yyyy
    if ($(document).inputmask) {
        $("#datemask").inputmask("dd-mm-yyyy", {
            "placeholder": "dd-mm-yyyy"
        });
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {
            "placeholder": "mm/dd/yyyy"
        });
        //Money Euro
        $("[data-mask]").inputmask();
    }
    if ($(document).timepicker) {
        $(".timepicker").timepicker({
            showInputs: true
        });
        // console.log("touch down");
    }
    if($(document).sortable){
        $("#editimgsoptionlinks ul").sortable({
            drag:false,
            drop:false
        })
    }
    if ($(document).daterangepicker) {
        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'DD-MM-YYYY h:mm:ss'
        });
        $('#scheduleentry').datetimepicker({
            format:"YYYY-MM-DD HH:mm",
            keepOpen:true
        })
        $('#editscheduleentry').datetimepicker({
            format:"YYYY-MM-DD HH:mm",
            keepOpen:true
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
        {
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            startDate: moment().subtract('days', 29),
            endDate: moment()
        }, 
        function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );
    }
    if ($(document).iCheck) {
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    }
    
    if ($(document).colorpicker) {
        // Colorpicker
        $("input.my-colorpicker1").colorpicker();
        // color picker with addon
        $("input.my-colorpicker2").colorpicker();
    }
    if ($(document).timepicker) {
        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
    }
});
if ($(document).knob) {
    $(function() {
        
        
        
        /* jQueryKnob */
        
        $(".knob").knob({
            /*change : function (value) {
           //console.log("change : " + value);
           },
           release : function (value) {
           console.log("release : " + value);
           },
           cancel : function () {
           console.log("cancel : " + this.value);
           },*/
            draw: function() {
                
                // "tron" case
                if (this.$.data('skin') == 'tron') {
                    
                    var a = this.angle(this.cv)// Angle
                    , sa = this.startAngle // Previous start angle
                    , sat = this.startAngle // Start angle
                    , ea // Previous end angle
                    , eat = sat + a // End angle
                    , r = true;
                    
                    this.g.lineWidth = this.lineWidth;
                    
                    this.o.cursor 
                    && (sat = eat - 0.3) 
                    && (eat = eat + 0.3);
                    
                    if (this.o.displayPrevious) {
                        ea = this.startAngle + this.angle(this.value);
                        this.o.cursor 
                        && (sa = ea - 0.3) 
                        && (ea = ea + 0.3);
                        this.g.beginPath();
                        this.g.strokeStyle = this.previousColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                        this.g.stroke();
                    }
                    
                    this.g.beginPath();
                    this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                    this.g.stroke();
                    
                    this.g.lineWidth = 2;
                    this.g.beginPath();
                    this.g.strokeStyle = this.o.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                    this.g.stroke();
                    
                    return false;
                }
            }
        });
        /* END JQUERY KNOB */
        
        //INITIALIZE SPARKLINE CHARTS
        $(".sparkline").each(function() {
            var $this = $(this);
            $this.sparkline('html', $this.data());
        });
        
        /* SPARKLINE DOCUMENTAION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
        drawDocSparklines();
        drawMouseSpeedDemo();
    });
}

function drawDocSparklines() {
    // Bar + line composite charts
    $('#compositebar').sparkline('html', {
        type: 'bar',
        barColor: '#aaf'
    });
    $('#compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], 
    {
        composite: true,
        fillColor: false,
        lineColor: 'red'
    });
    
    
    // Line charts taking their values from the tag
    $('.sparkline-1').sparkline();
    
    // Larger line charts for the docs
    $('.largeline').sparkline('html', 
    {
        type: 'line',
        height: '2.5em',
        width: '4em'
    });
    
    // Customized line chart
    $('#linecustom').sparkline('html', 
    {
        height: '1.5em',
        width: '8em',
        lineColor: '#f00',
        fillColor: '#ffa',
        minSpotColor: false,
        maxSpotColor: false,
        spotColor: '#77f',
        spotRadius: 3
    });
    
    // Bar charts using inline values
    $('.sparkbar').sparkline('html', {
        type: 'bar'
    });
    
    $('.barformat').sparkline([1, 3, 5, 3, 8], {
        type: 'bar',
        tooltipFormat: '{{value:levels}} - {{value}}',
        tooltipValueLookups: {
            levels: $.range_map({
                ':2': 'Low',
                '3:6': 'Medium',
                '7:': 'High'
            })
        }
    });
    
    // Tri-state charts using inline values
    $('.sparktristate').sparkline('html', {
        type: 'tristate'
    });
    $('.sparktristatecols').sparkline('html', 
    {
        type: 'tristate',
        colorMap: {
            '-2': '#fa7',
            '2': '#44f'
        }
    });
    
    // Composite line charts, the second using values supplied via javascript
    $('#compositeline').sparkline('html', {
        fillColor: false,
        changeRangeMin: 0,
        chartRangeMax: 10
    });
    $('#compositeline').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], 
    {
        composite: true,
        fillColor: false,
        lineColor: 'red',
        changeRangeMin: 0,
        chartRangeMax: 10
    });
    
    // Line charts with normal range marker
    $('#normalline').sparkline('html', 
    {
        fillColor: false,
        normalRangeMin: -1,
        normalRangeMax: 8
    });
    $('#normalExample').sparkline('html', 
    {
        fillColor: false,
        normalRangeMin: 80,
        normalRangeMax: 95,
        normalRangeColor: '#4f4'
    });
    
    // Discrete charts
    $('.discrete1').sparkline('html', 
    {
        type: 'discrete',
        lineColor: 'blue',
        xwidth: 18
    });
    $('#discrete2').sparkline('html', 
    {
        type: 'discrete',
        lineColor: 'blue',
        thresholdColor: 'red',
        thresholdValue: 4
    });
    
    // Bullet charts
    $('.sparkbullet').sparkline('html', {
        type: 'bullet'
    });
    
    // Pie charts
    $('.sparkpie').sparkline('html', {
        type: 'pie',
        height: '1.0em'
    });
    
    // Box plots
    $('.sparkboxplot').sparkline('html', {
        type: 'box'
    });
    $('.sparkboxplotraw').sparkline([1, 3, 5, 8, 10, 15, 18], 
    {
        type: 'box',
        raw: true,
        showOutliers: true,
        target: 6
    });
    
    // Box plot with specific field order
    $('.boxfieldorder').sparkline('html', {
        type: 'box',
        tooltipFormatFieldlist: ['med', 'lq', 'uq'],
        tooltipFormatFieldlistKey: 'field'
    });
    
    // click event demo sparkline
    $('.clickdemo').sparkline();
    $('.clickdemo').bind('sparklineClick', function(ev) {
        var sparkline = ev.sparklines[0]
          , 
        region = sparkline.getCurrentRegionFields();
        value = region.y;
        alert("Clicked on x=" + region.x + " y=" + region.y);
    });
    
    // mouseover event demo sparkline
    $('.mouseoverdemo').sparkline();
    $('.mouseoverdemo').bind('sparklineRegionChange', function(ev) {
        var sparkline = ev.sparklines[0]
          , 
        region = sparkline.getCurrentRegionFields();
        value = region.y;
        $('.mouseoverregion').text("x=" + region.x + " y=" + region.y);
    }).bind('mouseleave', function() {
        $('.mouseoverregion').text('');
    });
}

/**
       ** Draw the little mouse speed animated graph
       ** This just attaches a handler to the mousemove event to see
       ** (roughly) how far the mouse has moved
       ** and then updates the display a couple of times a second via
       ** setTimeout()
       **/
function drawMouseSpeedDemo() {
    var mrefreshinterval = 500;
    // update display every 500ms
    var lastmousex = -1;
    var lastmousey = -1;
    var lastmousetime;
    var mousetravel = 0;
    var mpoints = [];
    var mpoints_max = 30;
    $('html').mousemove(function(e) {
        var mousex = e.pageX;
        var mousey = e.pageY;
        if (lastmousex > -1) {
            mousetravel += Math.max(Math.abs(mousex - lastmousex), Math.abs(mousey - lastmousey));
        }
        lastmousex = mousex;
        lastmousey = mousey;
    });
    var mdraw = function() {
        var md = new Date();
        var timenow = md.getTime();
        if (lastmousetime && lastmousetime != timenow) {
            var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
            mpoints.push(pps);
            if (mpoints.length > mpoints_max)
                mpoints.splice(0, 1);
            mousetravel = 0;
            $('#mousespeed').sparkline(mpoints, {
                width: mpoints.length * 2,
                tooltipSuffix: ' pixels per second'
            });
        }
        lastmousetime = timenow;
        setTimeout(mdraw, mrefreshinterval);
    }
    ;
    // We could use setInterval instead, but I prefer to do it this way
    setTimeout(mdraw, mrefreshinterval);
}
function showLocalGovt(str) 
{
    document.getElementById("LocalGovt").innerHTML = "<option>Loading...</option>";
    if (str == "") 
    {
        document.getElementById("LocalGovt").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) 
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } 
    else 
    {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            document.getElementById("LocalGovt").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "" + host_addr + "snippets/display.php?displaytype=lgout&extraval&state=" + str, true);
    xmlhttp.send();
}
function showLocalGovtTwo(str, target) 
{
    if (target == "") {
        target = "LocalGovt";
    }
    if (str == "") 
    {
        document.getElementById("" + target + "").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) 
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } 
    else 
    {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            document.getElementById("" + target + "").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "" + host_addr + "snippets/display.php?displaytype=lgout&extraval&state=" + str, true);
    xmlhttp.send();
}
/*
       * Custom Label formatter
       * ----------------------
       */
function labelFormatter(label, series) {
    return "<div style='font-size:13px; text-align:center; padding:4px; color: #fff; font-weight: 600;'>" 
    + label 
    + "<br/>" 
    + Math.round(series.percent) + "%</div>";
}
$(document).on("blur", "input[data-ajax-upload=true][data-preview=true]", function() {
    // console.log($(this).val());
    var theformname = $(this).attr("data-form-name");
    var bar = $('div.progress[data-name=' + theformname + '-progress] .progress-bar');
    bar.css("width", "0%");
    var percent = $('div.progress[data-name=' + theformname + '-progress] .progress-percent');
    percent.text("0%");
});
$(document).on("click", "input[type=button][data-ajax-upload=true],input[type=submit][data-ajax-upload=true]", function() {
    var theformname = $(this).attr("data-form-name");
    var url = $(this).attr("data-upload-path");
    var bar = $('div.progress[data-name=' + theformname + '-progress] .progress-bar');
    bar.css("width", "0%");
    var percent = $('div.progress[data-name=' + theformname + '-progress] .progress-percent');
    percent.text("0%");
    // var status = $('#status');
    var data = new FormData();
    var file_objs = $('form[name=' + theformname + '] input[type="file"]');
    var file_data = $('form[name=' + theformname + '] input[type="file"]')[0].files;
    // for multiple files
    var sentinel_monitor = "nothing";
    for (var i = 0; i < file_data.length; i++) {
        data.append(file_objs[i].name, file_objs[i].files[0]);
        if (file_objs[i].value !== "") {
            sentinel_monitor = "content";
        }
    
    }
    var other_data = $('form[name=' + theformname + ']').serializeArray();
    $.each(other_data, function(key, input) {
        data.append(input.name, input.value);
        // console.log(input.name,input.value,"name value pair")
    });
    // datatwo.append($('form[name='+theformname+']').serialize());
    
    // console.log(data,other_data,file_objs);
    var opts = {
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    $('form[name=' + theformname + '] img[data-target-loader=true]').removeClass("hidden");
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    // console.log(percentComplete);
                    bar.width(percentComplete);
                    percent.html(percentComplete);
                    if (percentComplete === 100) {
                        bar.css("width", percentComplete + "%");
                        percent.html('Done');
                    }
                
                }
            }, false);
            
            return xhr;
        },
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(output) {
            // console.log(output);
            var original = output.original;
            var medsize = output.medsize;
            var thumbnail = output.thumbnail;
            var imgid = output.imgid;
            var filesize = output.filesize;
            var filename = output.filetitle;
            var genout = '<div class="single_image_hold" name="albumimg' + imgid + '">' + 
            '  <div class="img_placeholder">' + 
            '    <img src="' + host_addr + '' + thumbnail + '"/>' + 
            '  </div>' + 
            '  <div id="editimgsoptionlinks" class="img_options">' + 
            '    <ul> ' + 
            '      <li>' + 
            '        <a href="' + host_addr + '' + original + '" data-lightbox="muralgallery" data-src="' + host_addr + '' + original + '" name="viewpic">' + 
            '          <i class="fa fa-eye"></i>' + 
            '        </a>' + 
            '      </li>' + 
            '      <li><a href="##delete" data-id="' + imgid + '" name="deletepic"><i class="fa fa-trash"></i></a></li>' + 
            '    </ul>' + 
            '  </div>' + 
            '</div>';
            $(genout).insertBefore('div[name=' + theformname + '_display] div:first');
            if ($('div.default_no_entries')) {
                $('div.default_no_entries').hide();
            }
            // clear any content that is used to preview an image or other stuff
            $('form[name=' + theformname + '] [data-target-load=true]').addClass("hidden").attr("src", "");
            $('form[name=' + theformname + '] [data-ajax-upload=true]').val("");
            $('form[name=' + theformname + '] img[data-target-loader=true]').addClass("hidden");
            
            bar.css("width", "0%");
            percent.html('0%');
        },
        error: function(error) {
            console.log(error);
            alert("something went wrong check your console");
        }
    };
    if (data.fake) {
        // Make sure no text encoding stuff is done by xhr
        opts.xhr = function() {
            var xhr = jQuery.ajaxSettings.xhr();
            xhr.send = xhr.sendAsBinary;
            return xhr;
        }
        opts.contentType = "multipart/form-data; boundary=" + data.boundary;
        opts.data = data.toString();
    }
    // console.log(opts)
    if (sentinel_monitor == "content") {
        $.ajax(opts);
    }
});
$(document).on("click","p.username_display span a",function(){
    //get the main parent element of the link
    var mainparent=$(this).parent().parent();
    // get the select element for the choosen dataid
    var reallist=mainparent.attr("data-target");
    var targetinput=mainparent.attr("data-type");
    var inputfield=$('input[name='+targetinput+']')
    var dataid=$(this).attr("data-id");
    // set the selection box value to that of the dataid
    $('select[name='+reallist+']').val(dataid);
    if($('p.alertparentcontent')&&typeof($('p.alertparentcontent'))!=="undefined"){
        var catid=$('#usercontentcategory').val();
        var item_loader=$('p.alertparentcontent');
        var userid=$('select[name='+reallist+']').val();
        // console.log("the user id: ",userid);
        if(userid!==""&&typeof(userid)!=='undefined'){
            if(userid=="yes"||userid=="yesfull"){
                userid=0;
            }
            var url=''+host_addr+'snippets/display.php';
            var done1="";
            var done2="";
            item_loader.removeClass('hidden').css("display","").html("").text('Loading parent content(s)...');
            
            var opts = {
                    type: 'GET',
                    url: url,
                    data: {
                      displaytype:'userparentcontentlist',
                      catid:''+catid+'',
                      userid:''+userid+'',
                      extraval:"viewer"
                    },
                    dataType: 'json',
                    success: function(output) {
                      // console.log(output);
                      // item_loader.addClass('hidden').css("display","");
                      item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
                      if(output.success=="true"){

                            $('select[name=parentcontentlist]').html(output.msg);
                      }
                     
                    },
                    error: function(error) {
                        if(typeof(error)=="object"){
                            console.log(error.responseText);
                        }
                        item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                        // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                    }
            };
            $.ajax(opts);
        }
    }

    // hide the main parent element
    mainparent.delay(300).fadeOut(200);
    inputfield.val("");
})
result="";
$(document).on("blur","#usercontentcategory",function(){
    var catid=$(this).val();
    var item_loader=$('p.category_loader');
    var url=''+host_addr+'snippets/display.php';
    var done1="";
    var done2="";
    item_loader.removeClass('hidden').css("display","").html("").text('Loading users and clients...');
    $('select[name=userreallist]').html('<option value="">Loading...</option>');
    $('select[name=clientreallist]').html('<option value="">Loading...</option>');
    var opts = {
            type: 'GET',
            url: url,
            data: {
              displaytype:'usercatlist',
              catid:''+catid+'',
              extraval:"viewer"
            },
            dataType: 'json',
            success: function(output) {
              // console.log(output);
              // item_loader.addClass('hidden').css("display","");
              if(output.success=="true"){
                done1="done";
                if(done1=="done"&&done2=="done"){
                    item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
                }
                if(output.resultcount==0){
                    // item_loader.html('Sorry, nothing matched the name <b>'+searchval+'</b>');
                    $('select[name=userreallist]').html(""+output.msg+"");
                }else{
                    $('select[name=userreallist]').html(output.msg);
                }
              }
             
            },
            error: function(error) {
                if(typeof(error)=="object"){
                    console.log(error.responseText);
                }
                item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
            }
    };
    $.ajax(opts);
    var opts2 = {
            type: 'GET',
            url: url,
            data: {
              displaytype:'clientcatlist',
              catid:''+catid+'',
              extraval:"viewer"
            },
            dataType: 'json',
            success: function(output) {
              // console.log(output.msg);
              // item_loader.addClass('hidden').css("display","");
              if(output.success=="true"){
                done2="done";
                if(done1=="done"&&done2=="done"){
                    item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
                }
                if(output.resultcount==0){
                    // item_loader.html('Sorry, nothing matched the name <b>'+searchval+'</b>');
                    $('select[name=clientreallist]').html(""+output.msg+"");
                }else{
                    $('select[name=clientreallist]').html(""+output.msg+"");
                }
              }
             
            },
            error: function(error) {
                if(typeof(error)=="object"){
                    console.log(error.responseText);
                }
                item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
            }
    };
    $.ajax(opts2);
    if(done1=="done"&&done2=="done"){
        item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
    }
});

$(document).on("blur","select[name=userlist],select[name=napstandlist],select[name=clientlist]",function(){
    var listtype=$(this).attr("name");
    if(listtype=="userlist"){
        $('select[name=userreallist]').removeClass("hidden");
        $('input[name=searchuserslist]').removeClass("hidden");
        $('select[name=napstandlist]').val("");
        $('select[name=clientlist]').val("");
        $('input[name=searchclientslist]').addClass("hidden");
        $('select[name=clientreallist]').addClass("hidden");
        $('p[data-target=clientreallist]').html("").addClass("hidden");
    }else if (listtype=="clientlist") {
        $('input[name=searchclientslist]').removeClass("hidden");
        $('select[name=clientreallist]').removeClass("hidden");
        $('select[name=napstandlist]').val("");
        $('select[name=userlist]').val("");
        $('input[name=searchuserslist]').addClass("hidden");
        $('select[name=userreallist]').addClass("hidden");
        $('p[data-target=userreallist]').html("").addClass("hidden");
    }else if (listtype=="napstandlist") {
        $('select[name=clientlist]').val("");
        $('select[name=userlist]').val("");
        $('p[data-target=clientreallist]').html("").addClass("hidden");
        $('p[data-target=userreallist]').html("").addClass("hidden");
        $('input[name=searchclientslist]').addClass("hidden");
        $('input[name=searchuserslist]').addClass("hidden");
        $('select[name=clientreallist]').addClass("hidden");
        $('select[name=userreallist]').addClass("hidden");
    }
});
$(document).on("input","input[name=searchuserslist],input[name=searchclientslist]",function(){
    var target=$(this).attr('data-target');
    // var searchtype=$(this).name();
    var catid=$('select#usercontentcategory').val();
    var searchtype=$(this).attr("name");
    var searchval=$(this).val();
    var item_loader=$('p[data-type='+searchtype+']');
    // console.log(item_loader,searchtype,searchval,catid);
    if(searchval.replace(/\s\s*/g,"")!==""&&catid!==""&&typeof(catid)!=="undefined"){
        item_loader.removeClass('hidden').css("display","").html("").text('Searching...');
        var url=''+host_addr+'snippets/display.php';
        var opts = {
                type: 'GET',
                url: url,
                data: {
                  displaytype:''+searchtype+'',
                  searchval:''+searchval+'',
                  catid:''+catid+'',
                  extraval:"viewer"
                },
                dataType: 'json',
                success: function(output) {
                  // console.log(output);
                  // item_loader.addClass('hidden').css("display","");
                  if(output.success=="true"){
                    if(output.resultcount==0){
                        item_loader.html('Sorry, nothing matched the name <b>'+searchval+'</b>');
                    }else{
                        item_loader.html(output.msg);
                    }
                  }
                 
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        request=$.ajax(opts);
        // console.log(request);
    }else{
        if(typeof(request)=="object"){
            request.abort();
        }
        item_loader.removeClass("hidden").text("Please select a valid content category first then use the search field");
    }
})



$(document).on("blur","select[name=clientreallist],select[name=napstandlist],select[name=userreallist]",function(){
    var catid=$('#usercontentcategory').val();
    var item_loader=$('p.alertparentcontent');
    var userid=$(this).val();
    if(userid!==""&&typeof(userid)!=='undefined'){
        if(userid=="yes"){
            userid=0;
        }
        var url=''+host_addr+'snippets/display.php';
        var done1="";
        var done2="";
        item_loader.removeClass('hidden').css("display","").html("").text('Loading parent content(s)...');
        
        var opts = {
                type: 'GET',
                url: url,
                data: {
                  displaytype:'userparentcontentlist',
                  catid:''+catid+'',
                  userid:''+userid+'',
                  extraval:"viewer"
                },
                dataType: 'json',
                success: function(output) {
                  // console.log(output);
                  // item_loader.addClass('hidden').css("display","");
                  item_loader.text("Done!!!").delay(500).addClass("hidden").text("");
                  if(output.success=="true"){

                        $('select[name=parentcontentlist]').html(output.msg);
                  }
                 
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    item_loader.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")/*.addClass('hidden').css("display","")*/;
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        $.ajax(opts);
    }
});


$(document).on("blur","select[name=publishdata]",function(){
    var curval=$(this).val();
    if(curval=="scheduled"){
        $('div[data-name=schedulesection]').removeClass("hidden");
    }else{
        $('div[data-name=schedulesection]').addClass("hidden");

    }
});

$(document).on("blur","select[name=parentcontentlist]",function(){
    var curval=$(this).val();

})
$(document).on("blur","select[name=uploadtype]",function(){
    var curval=$(this).val();
    if(curval=="imageupload"){
        $('div[data-name=upload-image-section]').removeClass("hidden");
        $('div[data-name=upload-zip-section]').addClass("hidden");
        $('input[name=zipfile]').val("");
        $('input[name=zipfilesizeout]').val(0);
        $('.entrymarker.zip p.total-size').html("");
    }else if(curval=="zipupload"){
        $('div[data-name=upload-image-section]').addClass("hidden");
        $('div[data-name=upload-zip-section]').removeClass("hidden");
        $('input[name=imagecount]').val("");
        $('div[data-name=upload-image-section] .image_upload_section div.upload_section').remove();
        $('input[name=filesizeout]').val(0);
        $('div[data-name=upload-image-section] .entrymarker.images p.total-size').html("");
    }else{
        $('div[data-name=upload-image-section]').addClass("hidden");
        $('div[data-name=upload-zip-section]').addClass("hidden");
        $('input[name=zipfile]').val("");
        $('input[name=zipfilesizeout]').val(0);
        $('div[data-name=upload-zip-section].entrymarker.zip p.total-size').html("");
        // reset the image counter, delete the active image upload content
        // reset the image total filesize input field
        // remove the total filesize display markup
        $('input[name=imagecount]').val("");
        $('div[data-name=upload-image-section] div.upload_section').remove();
        $('input[name=filesizeout]').val(0);
        $('div[data-name=upload-image-section] .entrymarker.images p.total-size').html("");
    }
})

$(document).on("blur","input[name=imagecount]",function(){
    var curval=$(this).val();
    var limit=$(this).attr("data-max");
    // limit=typeof(limit)=="undefined"?curval:limit;
    var $item_loader=$('div[data-name=upload-image-section] .entrymarker');
    var content='';
    if(Math.floor(curval)>0&&Math.floor(curval)<=limit){
        for(var i=1;i<=curval;i++){
            if($('div[data-name=upload-image-section] div.upload_section').hasClass('_'+i)){
               
            }else{
                content='<div class="col-xs-3 upload_section _'+i+'">'
                        +'    <div class="img_prev_hold _'+i+'">'
                        +'    </div>'
                        +'    <div class="form-group">'
                        +'        <label>Select Image '+i+':</label>'
                        +'        <div class="input-group">'
                        +'          <div class="input-group-addon">'
                        +'            <i class="fa fa-file-image-o"></i>'
                        +'          </div>'
                        +'          <input type="file" name="image_'+i+'" onChange="contentImageSelect(this)" class="form-control"/>'
                        +'        </div><!-- /.input group -->'
                        +'    </div><!-- /.form group -->'
                        +'</div>';
                $(content).insertBefore($item_loader);
            }
        }
        // remember to compare numeric values and not strings

        if(Math.floor(curval)<Math.floor(limit)){
            // console.log("The current value: ",curval);
            // delete the excess
            for(var t=Math.floor(curval)+1;t<=Math.floor(limit);t++){
                // console.log(typeof($('div.upload_section._'+t+'')),t,$('div.upload_section').hasClass('_'+t+''));
                if($('div[data-name=upload-image-section] div.upload_section').hasClass('_'+t+'')){
                    // reduce the bytesize count and recalculate the total combined
                    // size, but check if it has a file first;
                    var curinput=$('input[name=image_'+t+']');
                    if(curinput.val()!==""){
                        var curfilesize=curinput.attr('data-file-size');
                        var filesize=$('input[name=filesizeout]');
                        var totalfilesize=filesize.val();
                        var curtotalsize=totalfilesize-curfilesize;
                        filesize.val(curtotalsize);
                        // recalculate total size
                        var totalsize=calculateTotalFileSize(curtotalsize);
                        // deal only in MB
                        var cursize='<span class="color-green">'+totalsize['megabyte']+'MB</span>';
                        if(totalsize['megabyte']>30){
                          cursize='<span class="color-red">'+totalsize['megabyte']+'MB</span>';
                        }
                        $('div[data-name=upload-image-section] .entrymarker p.total-size').html(cursize);
                    }
                    $('div[data-name=upload-image-section] div.upload_section._'+t+'').hide().remove();
                }
            } 
        }
    }else{
        alert("Specify the amount of images required, ensuring that the value is a valid number greater than 0 and less or equal to "+limit+", anything else will be ignored");
    }

})

$(document).on("blur","input[name=zipfile]",function(){
    var targetElem=$(this);
    var ftype=getExtension(targetElem.val());
    // set the state of the file field
    // $(this).attr("data-state","loading");
    // $('.entrymarker.zip p.total-size').html('<img src="'+host_addr+'images/waiting.gif" class="loadermini">')

})

$(document).on("click","input[name=loadcontentseries]",function(){
    var parentlist=$('select[name=parentcontentlist]');
    var cattypelist=$('select[name=publishstatustypeout]');
    var parentid=parentlist.val();
    var pstat=cattypelist.val();
    if(parentid==""){
        window.alert('Please select a valid parent content from the list');
        parentlist.addClass("error-class").focus();
    }else{
        var item_loader=document.createElement("div");
        item_loader.setAttribute("class","content_image_loader_content_entries_edit");
        item_loader.innerHTML='<img src="'+host_addr+'images/loading.gif" class="loadermidi"/>';
        // console.log(item_loader);
        $('div.parent_content_display').html(item_loader);
        var url=''+host_addr+'snippets/display.php';
        var opts = {
                type: 'GET',
                url: url,
                data: {
                  displaytype:'loadcontentseriesadmin',
                  parentid:''+parentid+'',
                  publishstatus:''+pstat+'',
                  usertype:'adn',
                  extraval:"admin"
                },
                dataType: 'json',
                success: function(output) {
                  // console.log(output);
                  // item_loader.addClass('hidden').css("display","");
                  item_loader.remove();
                  if(output.success=="true"){
                        $('div.parent_content_display').html(output.msg);
                  }
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                    item_loader.remove()/*.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")*//*.addClass('hidden').css("display","")*/;
                    raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        $.ajax(opts)
    }
});
$(document).on("click","input[name=loadcontentseriesuser]",function(){
    var parentlist=$('select[name=parentcontentlist]');
    var cattypelist=$('select[name=publishstatustypeout]');
    var parentid=parentlist.val();
    var pstat=cattypelist.val();
    if(parentid==""){
        window.alert('Please select a valid parent content from the list');
        parentlist.addClass("error-class").focus();
        parentlist.select2("open");
    }else{
        var item_loader=document.createElement("div");
        item_loader.setAttribute("class","content_image_loader_content_entries_edit");
        item_loader.innerHTML='<img src="'+host_addr+'images/loading.gif" class="loadermidi"/>';
        // console.log(item_loader);
        $('div.parent_content_display').html(item_loader);
        var url=''+host_addr+'snippets/display.php';
        var opts = {
                type: 'GET',
                url: url,
                data: {
                  displaytype:$(this).attr("name"),
                  parentid:''+parentid+'',
                  publishstatus:''+pstat+'',
                  usertype:'adn',
                  extraval:"admin"
                },
                dataType: 'json',
                success: function(output) {
                  // console.log(output);
                  // item_loader.addClass('hidden').css("display","");
                  item_loader.remove();
                  if(output.success=="true"){
                        $('div.parent_content_display').html(output.msg);
                  }
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                    item_loader.remove()/*.html("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again")*//*.addClass('hidden').css("display","")*/;
                    raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        $.ajax(opts)
    }
});

/*$(document).on("blur","div.upload_section input[name*=image_][type=file]",function(){
    var targetElem=$(this);
    var divide=targetElem.attr("name").split('e');
    var c=divide[1];
    // console.log("c: ",c, this)
    if (targetElem.val()!=="") {
        var ftype=getExtension(targetElem.val());
        if(ftype['type']=="image"){  
            
            readURLTwo(targetElem,"napstanduserimgupload");
            // console.log("src data: ",bytesize,filesrc);
        }else{
            alert("Please Upload an image, no other file format is accepted here");
        }   
    }else{

        var curfilesize=targetElem.attr('data-file-size');
        if(typeof(curfilesize)!=="undefined"&&curfilesize!==""){
            var filesize=$('input[name=filesizeout]');
            var totalfilesize=filesize.val();
            var curtotalsize=totalfilesize-curfilesize;
            filesize.val(curtotalsize);
            // recalculate total size
            var totalsize=calculateTotalFileSize(curtotalsize);
            // deal only in MB
            var cursize='<span class="color-green">'+totalsize['megabyte']+'MB</span>';
            if(totalsize['megabyte']>30){
              cursize='<span class="color-red">'+totalsize['megabyte']+'MB</span>';
            }
            $('.entrymarker p.total-size').html(cursize);
            targetElem.attr('data-file-size','0')
        }
        $('.img_prev_hold.'+c+'').html("");

    }

})*/

var timestamp=0;
$('.generic_ajax_pages_hold._top, .generic_ajax_pages_hold._bottom').bootpag({
    total: 15,
    page: 1,
    maxVisible: 9,
    leaps: true,
    firstLastUse: true,
    first: '<i class="fa fa-arrow-left"></i>',
    last: '<i class="fa fa-arrow-right"></i>',
    wrapClass: 'pagination',
    dataquery:true,
    datacurquery:"SELECT * FROM capitalexpenditure ORDER BY code desc",
    dataipp:15,
    datavariant:true,
    datapages:[15,25,40,60],
    datatarget:'.generic_ajax_pages_hold .page_content_out_hold',
    dataitemloader:'.content_image_loader_bootpag',
    activeClass: 'active',
    disabledClass: 'disabled',
    nextClass: 'next',
    prevClass: 'prev',
    lastClass: 'last',
    firstClass: 'first'
}).on("page", function(event, num){
    event.preventDefault();
    var curtimestamp=parseInt(event.timeStamp);
    var doajax="";
    var timetest=0;
    // stop bootpag from running twice for dual pagination elements
    // on the same target
    if(timestamp==0){
        timestamp=curtimestamp;
    }else{
        timetest=parseInt(curtimestamp)-parseInt(timestamp);
        if(timetest<=10){
            doajax="false";
        }
    }
    if(doajax==""){
        timestamp=curtimestamp;
        var dataparent=$(this)[0].childNodes[1];
        if(dataparent.getAttribute("class").indexOf("pagination bootpag")>-1){
            dataparent=$(this)[0].childNodes[2];
        }
        var endtarget=$(this)[0].parentNode.getElementsByClassName('page_content_out_hold')[0];
        var page=parseInt(num);
        var dipp=15;
        var curquery="";
        var outputtype="";
        // console.log($(this)[0].parentNode.getElementsByClassName('content_image_loader_bootpag'),endtarget);
        for(var i=0;i<dataparent.childNodes.length;i++){
            // console.log(dataparent.childNodes[i],dataparent.childNodes[i].name);
            if(dataparent.childNodes[i].name=="curquery"){
                curquery=dataparent.childNodes[i].value;
            }
            if(dataparent.childNodes[i].name=="outputtype"){
                outputtype=dataparent.childNodes[i].value;
            }
            if(dataparent.childNodes[i].name=="ipp"){
                dipp=dataparent.childNodes[i].value;
            }

        }
        // for testing purposes only
        outputtype="";

        // var item_loader=$(this)[0].parentNode.getElementById('content_image_loader_bootpag');
        var item_loader=$(this)[0].parentNode.getElementsByClassName('content_image_loader_bootpag')[0];
        item_loader.className=item_loader.className.replace( /(?:^|\s)hidden(?!\S)/g , '' );
        // console.log(item_loader,item_loader.className);
        // item_loader.removeClass('hidden');
        var url=''+host_addr+'snippets/display.php';
        var opts = {
                type: 'GET',
                url: url,
                data: {
                  displaytype:'paginationpagesout',
                  ipp:dipp,
                  curquery:curquery,
                  outputtype:outputtype,
                  page:num,
                  loadtype:'jsonloadalt',
                  extraval:"admin"
                },
                dataType: 'json',
                success: function(output) {
                  // console.log(endtarget);
                  // console.log(output);
                  item_loader.className +=' hidden';
                  // item_loader.addClass('hidden').css("display","");
                  // item_loader.remove();
                  if(output.success=="true"){
                        endtarget.innerHTML=output.msg;
                  }
                },
                error: function(error) {
                    if(typeof(error)=="object"){
                        console.log(error.responseText);
                    }
                    var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                    // item_loader.remove();
                    item_loader.className +=' hidden';
                    raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                }
        };
        $.ajax(opts)
        // console.log(event,$(this)[0].childNodes,dataparent);
        // get the datadiv refereence
        // $(".content4").html("Page " + num); // or some ajax content loading...
        // $(this).addClass("current");
        
    }

}); 
var timestampselect=0;
$(document).on("click","select[name=general_ipp_select]",function(){
    var ipp=$(this).val();
    var ipp2=$(this).attr("data-curipp");
    console.log();
    if(ipp!==ipp2&&ipp!==""){
        /*var curtimestamp=Math.floor(Date.now() / 1000);
        var doajax="";
        var timetest=0;
        if(timestampselect==0){
            timestampselect=curtimestamp;
        }else{
            timetest=parseInt(curtimestamp)-parseInt(timestampselect);
            if(timetest<=10){
                doajax="false";
            }
        }
        console.log();
        if(doajax==""){*/
            // timestamp=curtimestamp;
            var dataparent=$(this).parent().parent().parent()[0].childNodes[1];
            var bootpagul=$(this).parent().parent().parent()[0].childNodes[0];
            if(dataparent.getAttribute("class").indexOf("pagination bootpag")>-1){
                bootpagul=dataparent;
                dataparent=$(this).parent().parent().parent()[0].childNodes[2];
            }

            var endtarget=$(this).parent().parent().parent().parent()[0].getElementsByClassName('page_content_out_hold')[0];
            var page=1;
            var dipp=parseInt(ipp);
            var curquery="";
            var outputtype="";
            // console.log(dataparent,$(this).parent().parent().parent().parent()[0].getElementsByClassName('content_image_loader_bootpag'),endtarget,bootpagul);
            for(var i=0;i<dataparent.childNodes.length;i++){
                // console.log(dataparent.childNodes[i],dataparent.childNodes[i].name);
                if(dataparent.childNodes[i].name=="curquery"){
                    curquery=dataparent.childNodes[i].value;
                }
                if(dataparent.childNodes[i].name=="outputtype"){
                    outputtype=dataparent.childNodes[i].value;
                }
                /*if(dataparent.childNodes[i].name=="ipp"){
                    dipp=dataparent.childNodes[i].value;
                }*/

            }
            // for testing purposes only
            // outputtype="";
            // var item_loader=$(this)[0].parentNode.getElementById('content_image_loader_bootpag');
            var item_loader=$(this).parent().parent().parent().parent()[0].getElementsByClassName('content_image_loader_bootpag')[0];
            item_loader.className=item_loader.className.replace( /(?:^|\s)hidden(?!\S)/g , '' );
            // console.log(item_loader,item_loader.className);
            // item_loader.removeClass('hidden');
            var url=''+host_addr+'snippets/display.php';

            // pulls the new result count for the ipp(Instances per page) value
            var opts = {
                    type: 'GET',
                    url: url,
                    data: {
                      displaytype:'paginationpages',
                      ipp:dipp,
                      curquery:curquery,
                      outputtype:outputtype,
                      page:page,
                      loadtype:'bootpag',
                      extraval:"admin"
                    },
                    dataType: 'json',
                    success: function(output) {
                      // console.log(endtarget);
                      // console.log(output);
                      // item_loader.className +=' hidden';
                      // item_loader.addClass('hidden').css("display","");
                      // item_loader.remove();
                      if(output.success=="true"){
                            // endtarget.innerHTML=output.msg;
                            // reinitialise the pagination fields to the new count
                            // empty previous bootpag containers and populate them
                            $('.generic_ajax_pages_hold._top, .generic_ajax_pages_hold._bottom').html("");
                            doBootPagReInit(output.resultcount,curquery,ipp);
                            

                      }
                    },
                    error: function(error) {
                        if(typeof(error)=="object"){
                            console.log(error.responseText);
                        }
                        var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                        // item_loader.remove();
                        item_loader.className +=' hidden';
                        raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                        // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                    }
            };
            $.ajax(opts)
            // pulls the new content for the page display
            var opts2 = {
                    type: 'GET',
                    url: url,
                    data: {
                      displaytype:'paginationpagesout',
                      ipp:dipp,
                      curquery:curquery,
                      outputtype:outputtype,
                      page:page,
                      loadtype:'jsonloadalt',
                      extraval:"admin"
                    },
                    dataType: 'json',
                    success: function(output) {
                      // console.log(endtarget);
                      // console.log(output);
                      item_loader.className +=' hidden';
                      // item_loader.addClass('hidden').css("display","");
                      // item_loader.remove();
                      if(output.success=="true"){
                            endtarget.innerHTML=output.msg;
                      }
                    },
                    error: function(error) {
                        if(typeof(error)=="object"){
                            console.log(error.responseText);
                        }
                        var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
                        // item_loader.remove();
                        item_loader.className +=' hidden';
                        raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                        // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
                    }
            };
            $.ajax(opts2)
            // console.log(event,$(this)[0].childNodes,dataparent);
            // get the datadiv refereence
            // $(".content4").html("Page " + num); // or some ajax content loading...
            // $(this).addClass("current");
        // }
    }
})
$(document).on("blur","select[name=publishdata]",function(){
    var curval=$(this).val();
    if(curval=="scheduled"){
        $('div[data-name=schedulesection]').removeClass("hidden");
    }else{
        $('div[data-name=schedulesection]').addClass("hidden");

    }
});


/*edit section for user content entry uploads*/
$(document).on("blur","select[name=editpublishdata]",function(){
    var curval=$(this).val();
    if(curval=="scheduled"){
        $('div[data-name=editschedulesection]').removeClass("hidden");
    }else{
        $('div[data-name=editschedulesection]').addClass("hidden");

    }
});
$(document).on("click","div#editimgsoptionlinks a[name=deletepic_contententry]",function(){
    var orderid=$(this).attr("data-order-id");
    var imgid=$(this)[0].attributes['data-imgid'].nodeValue;
    var formid=$(this).attr("data-id");
    var formselector='form[name=sortcontentform][data-contentid='+formid+'] ';
    var targetparid=$(this).attr("data-id");
    if(targetparid!==""&&typeof($(this).attr("data-id"))!=="undefined"){
        targetparid='[data-id='+targetparid+']';
        targetparidmain='div'+targetparid+' ';
    }else{
        targetparid="";
        targetparidmain="";
    }
    console.log(imgid,$(this),formid,$(this)[0].attributes['data-imgid'].nodeValue);
    var total_length=$('ul.sortable_content_entries'+targetparid+' > li').length;
    // only delete if there are more than one item on display
    if(Math.floor(total_length)>1){
        var confirm=window.confirm('Are you sure you want to delete this? This action is irreversible.');
        if(confirm===true){
            var listitem=$('ul.sortable_content_entries[data-id='+formid+'] > li[data-order-attr='+orderid+']');
            /*block all the displays*/
                var item_loader=$('ul.sortable_content_entries'+targetparid+' div.content_image_loader');
                item_loader.removeClass('hidden');
                /*stop user from being able to submit*/
                $(''+formselector+'input[name=sortcontententryorder]').attr("disabled","true");
            /*end*/
            var url=''+host_addr+'snippets/display.php';
            var opts = {
                    type: 'GET',
                    url: url,
                    data: {
                      displaytype:$(this).attr("name"),
                      contentid:''+formid+'',
                      extraval:''+imgid+''
                    },
                    dataType: 'json',
                    success: function(output) {
                        // console.log(output);
                        // item_loader.addClass('hidden').css("display","");
                        if(output.success=="true"){
                            listitem.fadeOut(500).remove();
                            var total_entries_elem=$(''+formselector+'input[name=entrycount]');
                            for(var i=orderid;i<=total_length;i++){
                                // change form input data and values
                                var parent=$('ul.sortable_content_entries > li:nth-of-type('+i+')');
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+')').attr("data-order-attr",i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') .img_list_position').text(i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') .content_image_loader').attr("data-id",i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') .single_image_hold').attr("data-id",i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') a[name=deletepic_contententry]').attr("data-order-id",i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') input[name*=imgid_]').attr("name","imgid_"+i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') input[name*=mainid_]').attr("name","mainid_"+i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') input[name*=mainid_]').val(i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') input[name=changeorder]').attr("value",i);
                                $('ul.sortable_content_entries'+targetparid+' > li:nth-of-type('+i+') input[name=changeorder]').attr("data-id",i);
                                // console.log('Affected: ', parent);
                            }
                            // set the total count of entries on the sort form to the proper count
                            total_length=$('ul.sortable_content_entries'+targetparid+' > li').length;
                            total_entries_elem.val(total_length);

                            // hide the main loader
                            item_loader.delay(1500).addClass('hidden');
                            // alert("Successfully Deleted");
                            $(''+formselector+'input[name=sortcontententryorder]').removeAttr("disabled");
                            raiseMainModal('Success!!', 'Deletion was succesful', 'success');
                        }
                    },
                    error: function(error) {
                        if(typeof(error)=="object"){
                            console.log(error.responseText);
                        }
                        // raise the success modal
                        $(''+formselector+'input[name=sortcontententryorder]').removeAttr("disabled");
                        errmsg='Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again';
                        raiseMainModal('Failure!!', ''+errmsg+'', 'fail');
                    
                    }
            }
            $.ajax(opts);
        }
            
            
        
    }else{

    }

})
$(document).on("blur","select[name=edituploadtype]",function(){
    var curval=$(this).val();
    var targetparid=$(this).attr("data-id");
    if(targetparid!==""&&typeof($(this).attr("data-id"))!=="undefined"){
        targetparid='[data-id='+targetparid+']';
        targetparidmain='div'+targetparid+' ';
    }else{
        targetparid="";
        targetparidmain="";
    }
    // console.log(targetparid,$('div[data-name=upload-image-sectionedit]'+targetparid+''));
    if(curval=="imageuploadedit"){
        $('div[data-name=upload-image-sectionedit]'+targetparid+'').removeClass("hidden");
        $('div[data-name=upload-zip-sectionedit]'+targetparid+'').addClass("hidden");
        $(''+targetparidmain+'input[name=zipfileedit]').val("");
        $(''+targetparidmain+'input[name=zipfilesizeoutedit]').val(0);
        $('div[data-name=upload-zip-sectionedit]'+targetparid+' .entrymarker p.total-size').html("");
    }else if(curval=="zipuploadedit"){
        $('div[data-name=upload-image-sectionedit]'+targetparid+'').addClass("hidden");
        $('div[data-name=upload-zip-sectionedit]'+targetparid+'').removeClass("hidden");
        $(''+targetparidmain+'input[name=imagecountedit]'+targetparid+'').val("");
        $('div[data-name=upload-image-sectionedit]'+targetparid+' div.upload_section').remove();
        $(''+targetparidmain+'input[name=filesizeoutedit]').val(0);
        $('div[data-name=upload-image-sectionedit]'+targetparid+' .entrymarker.imagesedit p.total-size').html("");
    }else{
        $('div[data-name=upload-image-sectionedit]'+targetparid+'').addClass("hidden");
        $('div[data-name=upload-zip-sectionedit]'+targetparid+'').addClass("hidden");
        $(''+targetparidmain+'input[name=zipfileedit]').val("");
        $(''+targetparidmain+'input[name=zipfilesizeoutedit]'+targetparid+'').val(0);
        $('div[data-name=upload-zip-sectionedit]'+targetparid+' .entrymarker.zipedit p.total-size').html("");
        // reset the image counter, delete the active image upload content
        // reset the image total filesize input field
        // remove the total filesize display markup
        $(''+targetparidmain+'input[name=imagecountedit]').val("");
        $('div[data-name=upload-image-sectionedit]'+targetparid+' div.upload_section').remove();
        $(''+targetparidmain+'input[name=filesizeoutedit]').val(0);
        $('div[data-name=upload-image-sectionedit]'+targetparid+' .entrymarker.imagesedit p.total-size').html("");
    }
})
$(document).on("blur","input[name=imagecountedit]",function(){
    var curval=$(this).val();
    var limit=$(this).attr("data-max");
    var targetparid=$(this).attr("data-id");
    if(targetparid!==""&&typeof($(this).attr("data-id"))!=="undefined"){
        targetparid='[data-id='+targetparid+']';
        targetparidmain='div'+targetparid+'';
    }else{
        targetparid="";
        targetparidmain="";
    }
    // limit=typeof(limit)=="undefined"?curval:limit;
    var $item_loader=$('div[data-name=upload-image-sectionedit]'+targetparid+' .entrymarker');
    var content='';
    if(Math.floor(curval)>0&&Math.floor(curval)<=limit){
        for(var i=1;i<=curval;i++){
            if($('div[data-name=upload-image-sectionedit]'+targetparid+' div.upload_section').hasClass('_'+i)){
               
            }else{
                content='<div class="col-xs-3 upload_section _'+i+'">'
                        +'    <div class="img_prev_hold _'+i+'">'
                        +'    </div>'
                        +'    <div class="form-group">'
                        +'        <label>Select Image '+i+':</label>'
                        +'        <div class="input-group">'
                        +'          <div class="input-group-addon">'
                        +'            <i class="fa fa-file-image-o"></i>'
                        +'          </div>'
                        +'          <input type="file" name="image_'+i+'" onChange="contentImageSelect(this)" data-edit="edit" class="form-control"/>'
                        +'        </div><!-- /.input group -->'
                        +'    </div><!-- /.form group -->'
                        +'</div>';
                $(content).insertBefore($item_loader);
            }
        }
        // remember to compare numeric values and not strings
        if(Math.floor(curval)<Math.floor(limit)){
            // console.log("The current value: ",curval);
            // delete the excess
            for(var t=Math.floor(curval)+1;t<=Math.floor(limit);t++){
                // console.log(typeof($('div.upload_section._'+t+'')),t,$('div.upload_section').hasClass('_'+t+''));
                if($('div[data-name=upload-image-sectionedit]'+targetparid+' div.upload_section').hasClass('_'+t+'')){
                    // reduce the bytesize count and recalculate the total combined
                    // size, but check if it has a file first;
                    var curinput=$('div[data-name=upload-image-sectionedit]'+targetparid+' input[name=image_'+t+']');
                    if(curinput.val()!==""){
                        var curfilesize=curinput.attr('data-file-size');
                        var filesize=$(''+targetparidmain+'input[name=filesizeoutedit]');
                        var totalfilesize=filesize.val();
                        var curtotalsize=totalfilesize-curfilesize;
                        filesize.val(curtotalsize);
                        // recalculate total size
                        var totalsize=calculateTotalFileSize(curtotalsize);
                        // deal only in MB
                        var cursize='<span class="color-green">'+totalsize['megabyte']+'MB</span>';
                        if(totalsize['megabyte']>30){
                          cursize='<span class="color-red">'+totalsize['megabyte']+'MB</span>';
                        }
                        $('div[data-name=upload-image-sectionedit]'+targetparid+' .entrymarker p.total-size').html(cursize);
                    }
                    $('div[data-name=upload-image-sectionedit]'+targetparid+' div.upload_section._'+t+'').hide().remove();
                }
            } 
        }
    }else{
        alert("Specify the amount of images required, ensuring that the value is a valid number greater than 0 and less or equal to "+limit+", anything else will be ignored");
    }

})


function reSortTwo(button,dataid=""){
    var prevSib=button.previousSibling;
   
    if(prevSib.nodeType==3){
        prevSib=prevSib.previousSibling;
    }
    console.log();
    // console.log(button.previousSibling.previousSibling,prevSib);
    var curval=$(prevSib).attr("value");
    var newval=$(prevSib).val();
    // console.log(curval,newval);
    var newattr=Math.floor(newval)-1;
    if(newattr==0){
        newattr=1;
    }
    // console.log(typeof(Math.floor(curval)));
    if(Math.floor(newval)>0){
        // copy the content of the two affected elements
        // var parentul=button.parent();
        // var dataid=parentul.attr("data-id");
        var datainput="";
        if(dataid!==""&&typeof(dataid)!=="undefined"){
            datainput='[data-id='+dataid+']';
        }
        // console.log(datainput);
        var total_length=$('ul.sortable_content_entries'+datainput+' > li').length;
        var curelem=$('ul.sortable_content_entries'+datainput+' > li[data-order-attr='+curval+']');
        var targetelem=$('ul.sortable_content_entries'+datainput+' > li[data-order-attr='+newval+']');
        var curorder=curelem.attr("data-original-order");
        var targetorder=targetelem.attr("data-original-order");
        var realelem=curelem.clone();

        // console.log(curorder,targetorder,realelem);
        if(Math.floor(newval)<=Math.floor(total_length)){
            /*Inter change type section*/
                /*curelem.html(targetmarkup);
                // get their markup
                var curmarkup=curelem.html();
                var targetmarkup=targetelem.html();
                // interchange their markup
                targetelem.html(curmarkup);
                // sort out their order content
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+')').attr("data-order-attr",curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') .img_list_position').text(curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') .content_image_loader').attr("data-id",curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') .single_image_hold').attr("data-id",curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') a[name=deletepic_contententry]').attr("data-order-id",curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') input[name*=imgid_]').attr("name","imgid_"+curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') input[name*=mainid_]').attr("name","mainid_"+curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') input[name*=mainid_]').val(curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') input[name=changeorder]').attr("value",curval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+') input[name=changeorder]').attr("data-id",curval);   
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+curval+')').attr("data-order-attr",curval);
                
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') .img_list_position').text(newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') .content_image_loader').attr("data-id",newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') .single_image_hold').attr("data-id",newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') a[name=deletepic_contententry]').attr("data-order-id",newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') input[name*=imgid_]').attr("name","imgid_"+newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') input[name*=mainid_]').attr("name","mainid_"+newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') input[name*=mainid_]').val(newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') input[name=changeorder]').attr("value",newval);
                $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+newval+') input[name=changeorder]').attr("data-id",newval);*/
            /*end interchange type section*/
            /*Move type section*/
                // take out the previous version of the moving element
                if(Math.floor(curval)<Math.floor(newval)){
                    curelem.remove();
                    // object is moving forward
                    realelem.insertAfter('ul.sortable_content_entries'+datainput+' > li[data-order-attr='+newval+']');
                    for(i=Math.floor(curval);i<=Math.floor(newval);i++){
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+')').attr("data-order-attr",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .img_list_position').text(i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .content_image_loader').attr("data-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .single_image_hold').attr("data-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') a[name=deletepic_contententry]').attr("data-order-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=imgid_]').attr("name","imgid_"+i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=mainid_]').attr("name","mainid_"+i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=mainid_]').val(i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name=changeorder]').attr("value",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name=changeorder]').attr("data-id",i);
                        // alert('You pressed enter!');
                    }
                    var outmsg='Content "'+curval+'" was moved to position "'+newval+'"';
                    raiseMainModal('Success!!', ''+outmsg+'', 'success');
                }else if(Math.floor(curval)>Math.floor(newval)){
                    curelem.remove();
                    // object is moving backward
                    realelem.insertBefore('ul.sortable_content_entries'+datainput+' > li[data-order-attr='+newval+']');
                    for(i=Math.floor(newval);i<=Math.floor(curval);i++){
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+')').attr("data-order-attr",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .img_list_position').text(i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .content_image_loader').attr("data-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') .single_image_hold').attr("data-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') a[name=deletepic_contententry]').attr("data-order-id",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=imgid_]').attr("name","imgid_"+i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=mainid_]').attr("name","mainid_"+i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name*=mainid_]').val(i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name=changeorder]').attr("value",i);
                        $('ul.sortable_content_entries'+datainput+' > li:nth-of-type('+i+') input[name=changeorder]').attr("data-id",i);
                        // alert('You pressed enter!');
                    }
                    var outmsg='Content "'+curval+'" was moved to position "'+newval+'"';
                    raiseMainModal('Success!!', ''+outmsg+'', 'success');
                }
                if(Math.floor(curval)==Math.floor(newval)){
                    var outmsg='Content "'+curval+'"made no movement';
                    raiseMainModal('Failure!!', ''+outmsg+'', 'fail');

                }
            /*end move type section*/
        }else{
            var outmsg="Invalid range value";
            raiseMainModal('Failure!!', ''+outmsg+'', 'fail');

        }
    }else{
        var outmsg="Invalid value";
        raiseMainModal('Failure!!', ''+outmsg+'', 'fail');
    }
    
    
    event.preventDefault();         
}
$(document).on("focus","input[name=changeorder]",function () {
    // body...
    $(document).keypress(function(e) {
        if(e.which == 13) {
            // alert('You pressed enter!');
            event.preventDefault();
        }
    });
})
$(document).on("blur","input[name=zipfile]",function(){
    var targetElem=$(this);
    var ftype=getExtension(targetElem.val());
    // set the state of the file field
    // $(this).attr("data-state","loading");
    // $('.entrymarker.zip p.total-size').html('<img src="'+host_addr+'images/waiting.gif" class="loadermini">')

})
$(document).on("blur","select[name=editdata]",function(){
    var targetElem=$(this);
    var targetparid=targetElem.attr("data-id");
    if(targetparid!==""&&typeof(targetElem.attr("data-id"))!=="undefined"){
        targetparid='[data-id='+targetparid+']';
    }else{
        targetparid="";
    }
    if(targetElem.val()=="editprevious"){
        $('div.edit_prev_uploads_section'+targetparid+'').removeClass("hidden");
        $('div.editcontententryform'+targetparid+'').addClass("hidden");
        // run ajax request to pull in latest info on the users content
    }else if(targetElem.val()=="editdetails"){
        $('div.editcontententryform'+targetparid+'').removeClass("hidden");
        $('div.edit_prev_uploads_section'+targetparid+'').addClass("hidden");
    }

})
//set this variable for new projects to work
var host_addr="http://"+location.hostname+"/";
if(host_addr.indexOf('localhost/')>-1){
    host_addr="http://localhost/napstand/";
}
if(host_addr.indexOf('ngrok')>-1){
    // console.log();
    var host_addr="http://"+location.hostname+"/napstand/";
    // host_addr="http://localhost/napstand/";
}
//get userid and usertype
$(document).ready(function(){
userid=$('input[name=userdata]').attr('data-userid');
usertype=$('input[name=userdata]').attr('data-usertype');
$(document).on("click","#formstatus",function(){
  $(this).fadeOut(500);
})
//refresh or reload a script
jQuery.cachedScript = function( url, options ) {
 
  // Allow user to set any option except for dataType, cache, and url
  options = $.extend( options || {}, {
    dataType: "script",
    cache: true,
    url: url
  });
 
  // Use $.ajax() since it is more flexible than $.getScript
  // Return the jqXHR object so we can chain callbacks
  return jQuery.ajax( options );
};
 
// Usage
/*$.cachedScript( "../scripts/jscripts/tiny_mce/tiny_mce.js" ).done(function( script, textStatus ) {
  console.log( textStatus );
});*/
});
// console.log(usertype);
$(document).on("click","div#menulinkcontainer a[data-type=sublink]",function(){
$("div#menulinkcontainer a[data-type=sublink]").attr("data-state","inactive");
$(this).attr("data-state","active");
var dataname=$(this).attr("data-name");
  $(this).find("div#menunotification[data-target="+dataname+"]").fadeOut(1000);

});
/*admin lte control mainlink clicks*/
$(document).on("click","li.treeview a[appdata-otype=mainlink]",function(){
  $(this).children("small.mainsmall").fadeOut(300).remove();
  // console.log($(this).children("small.mainsmall"));
});
$(document).on("click","a[appdata-type=menulinkitem][appdata-otype=mainlink]",function(){
  $("ul.sidebar-menu ul").removeClass("menu-open").attr("style"," ");
  $("ul.sidebar-menu li").removeClass("active");
  // console.log($(this).children("small.mainsmall"));
})


$(document).on("click","ul li a[appdata-type=menulinkitem]",function(){
  var pcrumb=$(this).attr("appdata-pcrumb");
  $("ul.sidebar-menu ul li").removeClass("active");
  $(this).parent().addClass("active");
  $(this).children("small").fadeOut(200).remove();
  //   $(this).getElementsByTagName("small").fadeOut(200).remove();
  var pcrumb=$(this).attr("appdata-pcrumb");

  // console.log($(this).children("small"));
  var crumb=$(this).html();
  var fa=$(this).attr("appdata-fa");
  var notifylinkval="";
  var crumbout="";
  if(pcrumb!=="undefined"&&typeof(pcrumb)!=="undefined"){
    fa!=="undefined"&&typeof(fa)!=="undefined"?fa=fa+" ":fa="";
    crumbout+="<li><a href=\"#"+pcrumb+"\">"+fa+""+pcrumb+"</a></li>";
    notifylinkval=pcrumb;
  $('h1[appdata-name=notifylinkheader]').text(notifylinkval);

  }
  if(crumb!=="undefined"&&typeof(crumb)!=="undefined"){
    crumbdata=crumb.split(">");
    /*if(crumbdata.length>1){
      for(var c=0;c<crumbdata.length;c++){
        crumbout!==""?crumbout+="<li><a href=\"#"+crumbdata[c]+"\">"+crumbdata[c]+"</a></li>":crumbout="<li><a href=\"#"+crumbdata[c]+"\">"+crumbdata[c]+"</a></li>";

      }
    }else{
     crumbout!==""?crumbout+="<li><a href=\"#"+crumb+"\">"+crumb+"</a></li>":crumbout="<li><a href=\"#"+crumb+"\">"+crumb+"</a></li>";
    }*/
    crumbout+="&nbsp;&nbsp; >&nbsp;&nbsp; "+crumb;
  }
  if(crumbout==""){
    crumbout='<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
  }else{

  }
  /*create bread crumb*/
    $('ol[appdata-name="breadcrumb"]').html(crumbout);
  /*end*/
});
/*end*/
$(document).on("click","div#menulinkcontainer a[data-type=mainlink]",function(){
var parentcontrol=this.parentNode
var dataname=$(this).attr("data-name");
// console.log($(parentcontrol));
  $(parentcontrol).find("div#menunotification[data-target="+dataname+"]").fadeOut(1000);
 

  var datastate=$(parentcontrol).attr("data-state");

  var  thelength=$(parentcontrol).find("a").length;
  var newheight=0;
  if(datastate=="inactive"){
  $("div#menulinkcontainer").attr({"data-state":"inactive"}).css("height","");
$("div#menulinkcontainer a[data-type=sublink]").attr("data-state","inactive");
  $("a[data-type=sublink]").attr("style","");
    $(parentcontrol).attr("data-state","active");
if(thelength>2){
for(var i=0;i<thelength;i++){
newheight+=$(parentcontrol).find("a")[i].clientHeight;
}  
}else{
 newheight=$(parentcontrol).find("a")[1].clientHeight+31;
}
if(newheight>0){
  newheight=newheight+3;
  if(thelength>2){
$(parentcontrol).animate({height:""+newheight+""},1000,function(){
  $("div#menulinkcontainer[data-state=inactive]").css("height","");
});
  }else{
$(parentcontrol).animate({height:""+newheight+""},500,function(){
  $("div#menulinkcontainer[data-state=inactive]").css("height","");
});    
  }

}
  // console.log($(parentcontrol).find("a")[1].clientHeight,newheight,parentcontrol.clientHeight);
  }else if(datastate=="active"){

  }
});
//for table admin display control
$(document).on("click","td[name=trcontrolpoint] a",function(){
  var linkname=$(this).attr("name");
  // console.log(linkname);
  var linktype=$(this).attr("data-type");
  var controlid=$(this).attr("data-divid");
  var tout="Edit";
  linkname=="generatesinglesurveyrewards"?tout="Generate Reward":(linkname=="claimreward"?tout="Claim":"Edit");
  if(linkname=="edit"||linkname=="view"){

  }else if(linkname=="remove"||linkname=="delete"){
    $('tr[data-id='+controlid+']').fadeOut(500);
  }
    var loadstate=$('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editmodal]').attr("data-load");
    var presentcontent= $('tr[name=tableeditcontainer][dfata-divid='+controlid+'] div[data-type=editdisplay]').text();
   presentcontent=presentcontent.replace(/\s\s*/g,"");
    // console.log(linkname,linktype,controlid,loadstate,presentcontent,$('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editmodal]'));
    var datastate=$('tr[name=tableeditcontainer][data-divid='+controlid+']').attr("data-state");
    if(datastate=="inactive"){   
      // console.log('inactive  zone');
    $('tr[name=tableeditcontainer] td div[data-type=editmodal]').css({"height":"0"});
    $('tr[name=tableeditcontainer] td div[data-type=editmodal]').css({"min-height":""});
    $('tr[name=tableeditcontainer] td').css("padding","0px");
    $('tr[name=tableeditcontainer]').attr("data-state","inactive");
    $('tr[name=tableeditcontainer] td div[data-type=editdisplay]').html("");
     if(linkname!=="disablecomment"&&linkname!=="activatecomment"&&linkname!=="reactivatecomment"&&linkname!=="activatesubscriber"&&linkname!=="disablesubscriber"){
      $('td[name=trcontrolpoint] a').text(""+tout);   
      $('td[name=trcontrolpoint] a[data-divid='+controlid+']').text("Hide");
    $('tr[name=tableeditcontainer][data-divid='+controlid+'] td').css("padding","8px 5px 8px");
    }
    
  // control point for static table behaviour, good for javascript only editing
     if(linkname!=="disablecomment"&&linkname!=="activatecomment"&&linkname!=="reactivatecomment"&&linkname!=="activatesubscriber"&&linkname!=="disablesubscriber"){
      $(this).text("Hide");
    $('tr[name=tableeditcontainer][data-divid='+controlid+'] td').css("padding","8px 5px 8px");
    }
    var targetheight=$('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]').height();
    if(loadstate=="unloaded"||presentcontent==""){
  // control point for static table behaviour, good for javascript only editing
    if(linkname!=="disablecomment"&&linkname!=="activatecomment"&&linkname!=="reactivatecomment"&&linkname!=="activatesubscriber"&&linkname!=="disablesubscriber"){    
      $('div[data-type=editmodal][data-divid='+controlid+']').animate({height:""+targetheight+""},500,function(){
        $(this).css({"min-height":""+targetheight+"","height":"auto"});
      var editreq=new Request();
    editreq.generate('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]',true);
    //enter the url
    editreq.url(''+host_addr+'snippets/display.php?displaytype='+linktype+'&editid='+controlid+'&extraval=admin');
    //send request
    editreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    editreq.update('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]','html','fadeIn',1000);
    $('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]').attr("data-load","loaded");
      });
    }else{
      var editreq=new Request();
    editreq.generate('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]',false);
    //enter the url
    editreq.url(''+host_addr+'snippets/display.php?displaytype='+linktype+'&editid='+controlid+'&extraval=admin');
    //send request
    editreq.opensend('GET');
    // console.log('in here');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    editreq.update('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editdisplay]','nothing','',0);
    }
  }else if(loadstate=="loaded"||presentcontent!==""){   
  // control point for static table behaviour, good for javascript only editing

    $('tr[name=tableeditcontainer][data-divid='+controlid+'] div[data-type=editmodal]').animate({height:""+targetheight+""},500,function(){
      $(this).css({"min-height":""+targetheight+""});
    });
    
  }
  if(linkname!=="disablecomment"&&linkname!=="activatecomment"&&linkname!=="reactivatecomment"&&linkname!=="activatesubscriber"&&linkname!=="disablesubscriber"){
    $('tr[name=tableeditcontainer][data-divid='+controlid+']').attr("data-state","active");
  }
    }else if (datastate=="active") {
      // console.log('inactive  zone');  
      $(this).text(""+tout);   
    $('tr[name=tableeditcontainer] td div#completeresultdisplaycontent').html("");
    $('div[data-type=editmodal][data-divid='+controlid+']').css({"min-height":"","height":"0"});
    $('tr[name=tableeditcontainer][data-divid='+controlid+'] td').css("padding","0px");
    $('tr[name=tableeditcontainer][data-divid='+controlid+']').attr("data-state","inactive");
    $('div[data-type=editmodal]').css({"min-height":""});
    $('tr[name=tableeditcontainer] td').css("padding","0px");
    $('tr[name=tableeditcontainer]').attr("data-state","inactive");
    $('td[name=trcontrolpoint] a').text(""+tout);  

    };
});

$(document).on("click","div.meneame div[data-name=paginationpageshold] a",function(){
  $("div.meneame div[data-name=paginationpageshold] a").removeClass("current");
  $(this).addClass("current");
  var page=$(this).attr("data-page");
  var ipp=$(this).attr("data-ipp");
  var curquery=$("input[name=curquery]").val();
  var outputtype=$("input[name=outputtype]").val();
  // console.log("achieved",page,ipp,curquery,outputtype);
  var pagesreq=new Request();
    pagesreq.generate('div.meneame div[data-name=paginationpageshold]',false);
    //enter the url 
    pagesreq.url(''+host_addr+'snippets/display.php?displaytype=paginationpages&curquery='+curquery+'&ipp='+ipp+'&page='+page+'&extraval=admin');
    //send request
    pagesreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    pagesreq.update('div.meneame div[data-name=paginationpageshold]','html','',0);
  $("div.meneame input[name=currentview]").attr({"data-ipp":""+ipp+"","data-page":""+page+"","value":""+page+""}).trigger('change');
});

$(document).on("change","div.meneame input[name=currentview]",function(){
  // console.log("in here");
  var page=$("div.meneame input[name=currentview]").attr("data-page");
  var ipp=$("div.meneame input[name=currentview]").attr("data-ipp");
  var curquery=$("input[name=curquery]").val();
  var outputtype=$("input[name=outputtype]").val();

  // var url=''+host_addr+'snippets/display.php?displaytype=paginationpagesout&curquery='+curquery+'&outputtype='+outputtype+'&ipp='+ipp+'&page='+page+'&extraval=admin';
  var pagesoutreq=new Request();
    pagesoutreq.generate('section.content div[data-name=contentholder]',true);
    //enter the url
    pagesoutreq.url(''+host_addr+'snippets/display.php?displaytype=paginationpagesout&curquery='+curquery+'&outputtype='+outputtype+'&ipp='+ipp+'&page='+page+'&extraval=admin');
    //send request
    pagesoutreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    pagesoutreq.update('section.content div[data-name=contentholder]','html','fadeIn',500);
});

$(document).on("blur","div.meneame select[name=entriesperpage]",function(){
  var ipp=$(this).val();
  var ipp2=$("div.meneame input[name=currentview]").attr("data-ipp");
  // console.log(typeof ipp,ipp2);

  /*ipp=Math.floor(ipp);
  ipp2=Math.floor(ipp2);*/
  if(ipp!==ipp2){
    var page=1;
    var curquery=$("input[name=curquery]").val();
    var outputtype=$("input[name=outputtype]").val();
    // console.log("achieved",page,ipp,curquery,outputtype);
    var pagesreq=new Request();
    pagesreq.generate('div.meneame div[data-name=paginationpageshold]',false);
    //enter the url
    pagesreq.url(''+host_addr+'snippets/display.php?displaytype=paginationpages&curquery='+curquery+'&ipp='+ipp+'&page=1&extraval=admin');
    //send request
    pagesreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    pagesreq.update('div.meneame div[data-name=paginationpageshold]','html','',0);
    $("div.meneame input[name=currentview]").attr({"data-ipp":""+ipp+"","data-page":""+page+"","value":""+page+""}).trigger('change');
  }
});

/*for generic ajax pages loading using bootpag plugin*/
/*$(document).on("click","div.generic_ajax_pages_hold.pagination_pages ul li",function(){
  $("div.meneame div[data-name=paginationpageshold] a").removeClass("current");
  $(this).addClass("current");
  var page=$(this).attr("data-page");
  var ipp=$(this).attr("data-ipp");
  var curquery=$("input[name=curquery]").val();
  var outputtype=$("input[name=outputtype]").val();
  // console.log("achieved",page,ipp,curquery,outputtype);
  var pagesreq=new Request();
    pagesreq.generate('div.meneame div[data-name=paginationpageshold]',false);
    //enter the url
    pagesreq.url(''+host_addr+'snippets/display.php?displaytype=paginationpages&curquery='+curquery+'&ipp='+ipp+'&page='+page+'&extraval=admin');
    //send request
    pagesreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    pagesreq.update('div.meneame div[data-name=paginationpageshold]','html','',0);
  $("div.meneame input[name=currentview]").attr({"data-ipp":""+ipp+"","data-page":""+page+"","value":""+page+""}).trigger('change');
});*/
/*end*/

//for generic calender control, relies on connection.php function and display.php control
//the php function is calenderOut(date,time,year), refer to the connection.php page 

$(document).on("click",'div#calmonthpointer',function(){
var months = new Array();
months[1] = "January"; months[2] = "Feburary";
months[3] = "March"; months[4] = "April";
months[5] = "May"; months[6] = "June";
months[7] = "July"; months[8] = "August";
months[9] = "September"; months[10] = "October";
months[11] = "November"; months[12] = "December";
var curviewmonth=$('div#calDispDetails').attr("data-curmonth");
var curyear=Math.floor($('div#calDispDetails').attr("data-year"));
// var popmonth=months[nextmonth];
var pointname=$(this).attr("name");
var datatheme=$(this).attr("data-theme");
var datacontrol=$(this).attr("data-control");
var dataviewtype=$(this).attr("data-viewtype");
var datapop=new Array();
var datedata= new Date();
var curmonth=datedata.getMonth();
// var curyear=Math.floor(datedata.getFullYear());
var nextyear=curyear;
var prevyear=curyear;
var prevmonth=Math.floor(curviewmonth)-1;
var nextmonth=Math.floor(curviewmonth)+1;
var data_target=$(this).attr('data-target');
// data_target==""?data_target="":data_target=""+data_target+"";
prevmonth<1? prevyear= curyear-1: prevyear;
prevmonth<1? prevmonth=12: prevmonth;
nextmonth>12? nextyear= curyear+1: nextyear;
nextmonth>12? nextmonth=1: nextmonth;
if(pointname=="calpointleft"){
var requireddate="1-:-"+prevmonth+"-:-"+prevyear+"-:-"+data_target+"-:-"+datatheme+"-:-"+datacontrol+"-:-"+dataviewtype+"";
var data_pop=""+months[prevmonth]+", "+prevyear+"";
$('div#calDispDetails').html(data_pop).attr({"data-curmonth":""+prevmonth+"","data-year":""+prevyear+""});
}else if(pointname=="calpointright"){
var requireddate="1-:-"+nextmonth+"-:-"+nextyear+"-:-"+data_target+"-:-"+datatheme+"-:-"+datacontrol+"-:-"+dataviewtype+"";
var data_pop=""+months[nextmonth]+", "+nextyear+"";
$('div#calDispDetails').html(data_pop).attr({"data-curmonth":""+nextmonth+"","data-year":""+nextyear+""});
}
// console.log(datatheme,requireddate);
var calFullreq=new Request();
  //enter the url 
  if(usertype!=="admin"){
  calFullreq.generatetwo('#calHold #calDaysHold',true);
  calFullreq.url(''+host_addr+'snippets/display.php?displaytype=calenderout&extraval='+requireddate+'');
  }else{
  calFullreq.generate('#calHold #calDaysHold',true);
  calFullreq.url(''+host_addr+'snippets/display.php?displaytype=calenderout&extraval='+requireddate+'');
  }
    
  //send request
  calFullreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  calFullreq.update('#calHold #calDaysHold','html','fadeIn',1000);
  // console.log(pointname,data_pop,requireddate);
});
$(document).on("click",'div#calDaysHold div#calDay',function(){
$('div#calDaysHold #calDay').removeClass("activedate");
$(this).addClass("activedate");
var date=$(this).attr('name');
var data_target=$(this).attr('data-target');
if(data_target!==""){
$('input[name='+data_target+']').attr("value",""+date+"");
}
});


function createImageArray(){
/*Creates an image Stack and returns it based on a given parent and target image
by either getting the image attribute or specified data attribute
*/  
}

function getPageName(){
var pagedata=document.URL;

if(pagedata.indexOf('www.')>-1||pagedata.indexOf('com')>-1||pagedata.indexOf('co.uk')>-1||pagedata.indexOf('org')>-1||pagedata.indexOf('co.')>-1){
  if(pagedata.indexOf('/')>-1){
  var pagedatatwo=pagedata.split(".");
 var totalsplitone=pagedatatwo.length - 2;
 var realclone=pagedatatwo[totalsplitone];
 var realpage=pagedatatwo[totalsplitone];
 if(typeof(realpage)!=="undefined"){
 var nexthalve=realpage.split("/");
 var totalsplit=nexthalve.length - 1;
 for(var i=0;i<pagedatatwo.length;i++){
// console.log(pagedatatwo[i],i); 
 }
 var realpage=nexthalve[totalsplit];
 realclone.indexOf('http:')>-1||realclone.indexOf('https:')>-1?realpage="index":realpage=realpage;
 }else{
  realpage="index";
 }
// // console.log(realpage);
  }else{
var realpage="index";
  }
}else{
  var pagedatatwo=pagedata.split(".");
 var realpage=pagedatatwo[0];
 var testval="/";
 var nexthalve=realpage.split("/");
 var totalsplit=nexthalve.length - 1;
 var realpage=nexthalve[totalsplit];
}
 return realpage;
}

function colorChanger(targetElement,originalcolor,targetcolor,monitor,textocolor,textflipcolor){

var colorChangerFunc;
var prevcolor=$(''+targetElement+'').css("background-color");

if(monitor==1){
monitor=0;
$(''+targetElement+'').css("background",""+targetcolor+"");
$(''+targetElement+'').css("color",""+textflipcolor+"");
}else if(monitor==0){
monitor=1;
$(''+targetElement+'').css("background",""+originalcolor+"");
$(''+targetElement+'').css("color",""+textocolor+"");

}
// console.log(targetElement,originalcolor,prevcolor);
colorChangerFunc=window.setTimeout("colorChanger('"+targetElement+"','"+originalcolor+"','"+targetcolor+"',"+monitor+",'"+textocolor+"','"+textflipcolor+"')",2000);
}

function getExtension(entry){
var outs=new Array();
outs['extension']="";
outs['rextension']="";
outs['type']="";
  if(entry!==""){

    var extension=entry.split('.');
    var alength=extension.length;
    var realposition=alength-1;
    extension=extension[realposition].toLowerCase();
    // console.log(extension);
    outs['rextension']=""+extension+"";
    var entrytype="";
    if (extension=="jpg"||extension=="jpeg"||extension=="png"||extension=="gif"||extension=="svg") {
      entrytype="image";
    } else if(extension=="mp4"||extension=="3gp"||extension=="flv"||extension=="swf"||extension=="webm") {
      entrytype="video";   
    }else if (extension=="doc"||extension=="docx"||extension=="xls"||extension=="xlsx"||extension=="ppt"||extension=="pptx") {
       entrytype="office";
    }else if (extension=="pdf") {
       entrytype="pdf";
    }else if(extension=="mp3"||extension=="ogg"||extension=="wav"||extension=="amr"){
      entrytype="audio";
    }else if(extension=="zip"||extension=="rar"||extension=="7z"){
      entrytype="archive";
    }else{
      entrytype="others";
    }
      outs['extension']=extension;
      outs['type']=entrytype;
    }
    return outs;
}

function getPageGetData(partname){
var pagedata=document.URL;
var getdata="nothing";
var pagedatatwo="";
var pagefol="nothing";
if(partname=="bookmark"){
 pagedatatwo=pagedata.split("#");
 pagefol=pagedatatwo[1];
 getdata=pagefol;
}else if(pagedata.indexOf(""+partname+"") > -1){
 pagedatatwo=pagedata.split(""+partname+"");
 pagefol=pagedatatwo[1];
if(pagefol!=="nothing"){
if(pagefol.indexOf("&") > -1&&pagefol.indexOf("#") < 0){
getdata=pagefol.split("&");
var totaldata=getdata.length;
getdata=getdata[0].split("=");
//getdata=getdata[1];
getdata=getdata[1];
 }else if(pagefol.indexOf("&") < 0 &&pagefol.indexOf("#") < 0){
getdata=pagefol.split("=");
getdata=getdata[1];
 }else if(pagefol.indexOf("&") > -1&&pagefol.indexOf("#") > -1){
  getdata=pagefol.split("&");
getdata=getdata[0].split("#");
var totaldata=getdata.length;
getdata=getdata[0].split("=");
getdata=getdata[1];
 }else if(pagefol.indexOf("&") < 0 &&pagefol.indexOf("#") > -1){
 getdata=pagefol.split("#");
 getdata=getdata[0].split("=");
getdata=getdata[1];
 }
}
}
 return getdata;
}
function searchComment(blogid){
  var searchval=$('input[name=minisearch'+blogid+']').val();
  var presentcontent=searchval.replace(/\s\s*/g,"");
  if(searchval!==""&&presentcontent!==""){
    searchval=="*fullcommentsview*"?searchval="gwolcomments":searchval=searchval;
    // console.log(searchval,presentcontent);
    var searchcomreq=new Request();
    searchcomreq.generate('div#formend div[name=commentfullhold'+blogid+']',true);
    //enter the url
    searchcomreq.url(''+host_addr+'snippets/display.php?displaytype=searchcomments&searchval='+searchval+'&blogid='+blogid+'&extraval=admin');
    //send request
    searchcomreq.opensend('GET');
    //update dom when finished, takes four params targetElement,entryType,entryEffect,period
    searchcomreq.update('div#formend div[name=commentfullhold'+blogid+']','html','fadeIn',1000);
  }
}
function genericSlider(type,targetElement,period){
/*
Generic Slider
Takes the above arguments and performs as follows
-type: values,-imagestack
              -ajax

*/
}
function produceImageFitSize(curwidth,curheight,contwidth,contheight,auto){
var output=new Array();
output['width']="20px";
output['height']="20px";
output['style']="";
output['truewidth']=curwidth;
output['trueheight']=curheight;
var style="";
if(curwidth!==""&&curheight!==""&&contwidth!==""&&contheight!==""){
if(contwidth>contheight){
if(curwidth>contwidth||curheight>contheight){

if(curwidth>curheight&&curheight>=contheight&&curwidth>contwidth){
curwidth=contwidth;

style='cursor:pointer;height:'+contheight+'px;width:'+curwidth+'px;margin:auto;';
}else if(curwidth<curheight&&curheight>contheight&&curwidth>contwidth){
  var extrawidth=Math.floor(curwidth-contheight);
  var dimensionratio=curwidth/curheight;
// console.log(dimensionratio);

   curwidth=Math.floor(contheight*dimensionratio);
    var widthdiff=contwidth-curwidth;
    if(widthdiff>0){
    var marginleft=Math.floor(widthdiff/2);
    }else{
      var marginleft=0;
    }
  if(extrawidth>contwidth&&extrawidth>contheight){
    extrawidth=curwidth-extrawidth;
  }/*else if (curwidth>contwidth&&curwidth>contheight) {
    curwidth=curwidth-120;
}*/

style='cursor:pointer;width:'+curwidth+'px;height:'+contheight+'px;margin-left:'+marginleft+'px;test:;';
if(auto=="on"){
style='cursor:pointer;width:'+curwidth+'px;height:'+contheight+'px;test:;';
}
}else if(curwidth<curheight&&curheight>=contheight&&curwidth<contwidth){
  var dimensionratio=curwidth/curheight;
  // console.log(dimensionratio);

   curwidth=Math.floor(contheight*dimensionratio);
    var widthdiff=contwidth-curwidth;
    if(widthdiff>0){
    var marginleft=Math.floor(widthdiff/2);
    }else{
      var marginleft=0;
    }

style='cursor:pointer;width:'+curwidth+'px;height:'+contheight+'px;margin-left:'+marginleft+'px;';
}else if(curwidth>curheight&&curheight<contheight&&curwidth>contwidth){
  var dimensionratio=curwidth/curheight;
// console.log(dimensionratio);
   curwidth=Math.floor(contheight*dimensionratio);
    var difference=contheight-curheight;
    var margintop=Math.floor(difference/2);
    if(auto=="on"){
style='cursor:pointer;width:'+contwidth+'px;height:'+curheight+'px;margin-top:auto;'; 
    }else{      
style='cursor:pointer;width:'+contwidth+'px;height:'+curheight+'px;margin-top:'+margintop+'px;'; 
    }
  }else if(curwidth<curheight&&curheight<contheight){
    var difference=contheight-curheight;
    var margintop=Math.floor(difference/2);
  curwidth=curheight-10;
    if(auto=="on"){
style='cursor:pointer;width:'+curwidth+'px;height:'+curheight+'px;margin-top:auto;'; 
    }else{      
style='cursor:pointer;width:'+curwidth+'px;height:'+curheight+'px;margin-top:'+margintop+'px;'; 
    }
  }else if(curwidth==curheight&&curheight>contheight){
  var marginleft=Math.floor(contwidth)-Math.floor(contheight);
  marginleft=Math.floor(marginleft/2);
style='cursor:pointer;width:'+contheight+'px;height:'+contheight+'px;margin-left:'+marginleft+'px;'; 
  }

}else{
    var difference=contheight-curheight;
    var margintop=Math.floor(difference/2);
    var widthdiff=contwidth-curwidth;
    var marginleft=Math.floor(widthdiff/2);
style='cursor:pointer;width:'+curwidth+'px;height:'+curheight+'px;margin-left:'+marginleft+'px;margin-top:'+margintop+'px;';
}
output['width']=curwidth;
output['height']=curheight;
output['style']=""+style+"";

}else if(contwidth<contheight){

}

return output;
}
}
function validateEmailDB(email){
  
}

function emailValidator(inputname6){
// console.log(inputname6);
var statuscontrol=true;
var inputname7=inputname6.replace(/\s\s*/g,"");
if(inputname7.length<1){
  statuscontrol= false;
  window.alert("E-mail field is empty");
  $("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf("/") > -1) {
  statuscontrol= false;
  window.alert("E-mail address has invalid character: /");
  $("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf(":") > -1) {
    statuscontrol= false;
  window.alert("E-mail address has invalid character: :");
  $("input[name=email]").css('border','1px solid red').focus();
  }else if (inputname7.indexOf(",") > -1) {
    statuscontrol= false;
  window.alert("E-mail address has invalid character: ,");
  $("input[name=email]").css('border','1px solid red').focus();
  }else if (inputname7.indexOf(";") > -1) {
    statuscontrol= false; 
window.alert("E-mail address has invalid character: ;")
$("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf("@") < 0) {
  statuscontrol= false;
window.alert("E-mail address is missing @");
$("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf("\.") < 0) {
  statuscontrol= false;
window.alert("E-mail address is missing .");
$("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf("@") > -1) {
var inputtester=inputname7.split("@");
var firstpart=inputtester[0];
var secondpart=inputtester[1];
// console.log(secondpart);
if(secondpart.length<2&&secondpart[0]=="."){
    statuscontrol= false;
window.alert('Complete your email address properly,server name missing');
$("input[name=email]").css('border','1px solid red').focus();
}else if(firstpart.length<1){
window.alert('You seem to have...errr..left out something in your email, we cannot find anything before the @');
$("input[name=email]").css('border','1px solid red').focus();
}else if (inputname7.indexOf("\.") > -1) {
var inputtester=inputname7.split(".");
var totalsplit=inputtester.length - 1;
 var realvalue=inputtester[totalsplit];
if(realvalue.length<1){
    statuscontrol= false;
window.alert('Complete your email address properly,domain name missing, try .com .net e.t.c');
$("input[name=email]").css('border','1px solid red').focus();
}
}
}else{
  statuscontrol=true;
  // console.log(statuscontrol);
}
// $("input[name=email]").attr("value",""+inputname7+"");
return statuscontrol;
}


function emailValidatorReturnableTwo(email) {
    var outs = [];
    var inputname7 = email.replace(/\s\s*/g, "");
    var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var statuscontrol = "true"
      , 
    errormsg = "none";
    ;
    // console.log(email,inputname7);
    
    if (inputname7.length > 0) {
        var match = inputname7.search(pattern);
        if (match < 0) {
            statuscontrol = "false";
            errormsg = "Email invalid";
        }
    } else {
        statuscontrol = "false";
        errormsg = "No email provided";
    }
    outs['status'] = statuscontrol;
    // alert(outs['status']);
    outs['errormsg'] = errormsg;
    return outs;
}
function testCharVal(string){
  var testing="false";
  if(string!==""){
  var newstring=string.toLowerCase();
  if(newstring.indexOf("a") > -1|| newstring.indexOf("b") > -1|| newstring.indexOf("c") > -1|| newstring.indexOf("d") > -1|| newstring.indexOf("e") > -1|| newstring.indexOf("f") > -1|| newstring.indexOf("g") > -1|| newstring.indexOf("h") > -1|| newstring.indexOf("i") > -1|| newstring.indexOf("j") > -1|| newstring.indexOf("k") > -1|| newstring.indexOf("l") > -1|| newstring.indexOf("m") > -1|| newstring.indexOf("n") > -1|| newstring.indexOf("o") > -1|| newstring.indexOf("p") > -1|| newstring.indexOf("q") > -1|| newstring.indexOf("r") > -1|| newstring.indexOf("s") > -1|| newstring.indexOf("t") > -1|| newstring.indexOf("u") > -1|| newstring.indexOf("v") > -1|| newstring.indexOf("w") > -1|| newstring.indexOf("x") > -1|| newstring.indexOf("y") > -1|| newstring.indexOf("/") > -1|| newstring.indexOf(",") > -1|| newstring.indexOf(".") > -1|| newstring.indexOf("<") > -1|| newstring.indexOf(">") > -1|| newstring.indexOf("?") > -1|| newstring.indexOf("\\") > -1|| newstring.indexOf("|") > -1|| newstring.indexOf("'") > -1|| newstring.indexOf("\"") > -1|| newstring.indexOf(":") > -1|| newstring.indexOf(";") > -1|| newstring.indexOf("}") > -1|| newstring.indexOf("]") > -1|| newstring.indexOf("{") > -1|| newstring.indexOf("[") > -1|| newstring.indexOf("`") > -1|| newstring.indexOf("~") > -1|| newstring.indexOf("!") > -1|| newstring.indexOf("@") > -1|| newstring.indexOf("#") > -1|| newstring.indexOf("$") > -1|| newstring.indexOf("%") > -1|| newstring.indexOf("^") > -1|| newstring.indexOf("&") > -1|| newstring.indexOf("*") > -1|| newstring.indexOf("(") > -1|| newstring.indexOf(")") > -1|| newstring.indexOf("_") > -1|| newstring.indexOf("+") > -1|| newstring.indexOf("1") > -1|| newstring.indexOf("2") > -1|| newstring.indexOf("3") > -1|| newstring.indexOf("4") > -1|| newstring.indexOf("5") > -1|| newstring.indexOf("6") > -1|| newstring.indexOf("7") > -1|| newstring.indexOf("8") > -1|| newstring.indexOf("9") > -1|| newstring.indexOf("0") > -1|| newstring.indexOf("-") > -1|| newstring.indexOf("=") > -1){
  testing="true";
  }
    
  }
  return testing;
}
function hideBind(clickElem,targetElement,effect,period,extraAttr,extraVal){
$(document).on("click",''+clickElem+'',function(){
var extradatas=extraAttr.split(".");
extraAttr=extradatas[0];
var elemType=extradatas[1];
  var testvalue="";
testvalue=$(this).attr("data-id");
if(extraAttr!==""&&extraAttr!=="multiple"){
$(''+targetElement+'').attr(""+extraAttr+"",""+extraVal+"");

}else if(extraAttr=="multiple"){

// console.log(extraAttr,elemType,testvalue,extraVal,clickElem);
$(''+targetElement+' '+elemType+'['+extraVal+'='+testvalue+']');
if(effect=="slidedown"||effect=="slideDown"){
$(''+targetElement+' '+elemType+'['+extraVal+'='+testvalue+']').animate({height:"0px"},period,function(){
  $(this).hide();
});
}else if (effect=="fadeOut"||effect=="fadeout") {
$(''+targetElement+' '+elemType+'['+extraVal+'='+testvalue+']').fadeOut(period);
}else if (effect=="hide"||effect=="Hide") {
$(''+targetElement+' '+elemType+'['+extraVal+'='+testvalue+']').hide(period);
}else if (effect=="html"||effect=="Html") {
$(''+targetElement+' '+elemType+'['+extraVal+'='+testvalue+']').hide(period).html('');
}
}else{
if(effect=="slidedown"||effect=="slideDown"){
$(''+targetElement+'').animate({height:"0px"},period,function(){
  $(this).hide();
});
}else if (effect=="fadeOut"||effect=="fadeout") {
$(''+targetElement+'').fadeOut(period);
}else if (effect=="hide"||effect=="Hide") {
$(''+targetElement+'').hide(period);
}else if (effect=="html"||effect=="Html") {
$(''+targetElement+'').hide(period).html('');
}
}  
});


}
function hoverChange(targetImg,hoverImg){
$(document).ready(function(){
  var realimg="";
// console.log(realimg);
$(document).on("mouseenter",''+targetImg+'',function(){
 realimg=$(''+targetImg+'').attr("src");
$(this).attr("src",""+hoverImg+"");
});
$(document).on("mouseleave",''+targetImg+'',function(){
$(this).attr("src",""+realimg+"");  
});
});
}
function errorControl(countval){
$(document).ready(function(){
if(countval>0){
  $('#contentleftcontent h2').html("<font>You Have done this three times, sorry but you cant login for the next "+countval+"seconds.</font>");
countval--;
console.log(countval)
window.setTimeout('errorControl('+countval+')', 1000);
  $('#backhold').css("display","block");
//  document.getElementById('contentleftcontent').firstChild('');

}else{
window.clearTimeout(errorControl);  
  $('#backhold').css("display","none");
  $('#contentleftcontent h2').css("display","none");
}
});
}

function effectControl(targetElement,entryType,entryEffect,period,entryVal){
var timeoutval=period/2;
timeoutval=Math.floor(timeoutval);
//console.log(timeoutval);
if(entryType!=="insertBefore"&&entryType!=="insertAfter"){
if(entryEffect=="fadein"||entryEffect=="fadeIn"){
      $(document).ready(function(){
      $(''+targetElement+'').hide().html(entryVal).fadeIn(period);
      });
}else if(entryEffect=="fadeto"||entryEffect=="fadeTo"){
      $(document).ready(function(){
      $(''+targetElement+'').hide().html(entryVal).fadeTo(period,0.9,function(){});
      });
}else if(entryEffect=="show"||entryEffect=="Show"){
      $(document).ready(function(){
      $(''+targetElement+'').hide().html(entryVal).show(period);
        $(''+targetElement+'').attr({"style":""});
      });
}else if(entryEffect=="slidedown"||entryEffect=="slideDown"){
      $(document).ready(function(){
      $(''+targetElement+'').hide().html(entryVal).slideDown(period,function(){
          $(''+targetElement+'').attr({"style":""});
      });
      });
}else{
      $(''+targetElement+'').html(entryVal)
}
}else if(entryType=="insertBefore" || entryType=="insertAfter"){
if(entryType=="insertBefore" ||entryType=="insertbefore"){
if(entryEffect=="fadein"||entryEffect=="fadeIn"){
$(document).ready(function(){
$(''+entryVal+'').insertBefore(''+targetElement+'').fadeIn(period);
});

}else if(entryEffect=="fadeto"||entryEffect=="fadeTo"){
$(document).ready(function(){
$(entryVal).insertBefore(''+targetElement+'').fadeTo(period,0.8,function(){});
});

}else if(entryEffect=="slidedown"||entryEffect=="slideDown"){
$(document).ready(function(){
 $(entryVal).css("height","0px").insertBefore(''+targetElement+'').slideDown(period,function(){});
});

}else if(entryEffect=="show"||entryEffect=="Show"){
$(document).ready(function(){
$(entryVal).css("visibility","none").insertBefore(''+targetElement+'').show(period);
});
}
}else if(entryType=="insertAfter" ||entryType=="insertafter"){
if(entryEffect=="fadein"||entryEffect=="fadeIn"){
$(document).ready(function(){
$(entryVal).css("visibility","none").insertAfter(''+targetElement+'').fadeIn(period);
});

}else if(entryEffect=="fadeto"||entryEffect=="fadeTo"){
$(document).ready(function(){
$(entryVal).css("visibility","none").insertAfter(''+targetElement+'').fadeTo(period,0.8,function(){});
});

}else if(entryEffect=="slidedown"||entryEffect=="slideDown"){
$(document).ready(function(){
 $(entryVal).insertAfter(''+targetElement+'').slideDown(period,function(){
  $(''+targetElement+'').attr({"style":""});
 });
});

}else if(entryEffect=="show"||entryEffect=="Show"){
$(document).ready(function(){
$(entryVal).insertAfter(''+targetElement+'').show(period);
  $(''+targetElement+'').attr({"style":""});
});
}else{
      $(''+targetElement+'').html(entryVal)
}
}
}
}
function Requesttwo(maincontainer,waitdisplay,waittype,sendtype,targetElement,entryType,entryEffect,period,url){
  if(waitdisplay===true && waittype=="admin"){
    $(''+maincontainer+'').html('<img src="'+host_addr+'images/waiting.gif" class="total2"/>');
  }else if(waitdisplay===true && waittype=="viewer"){
    $(''+maincontainer+'').html('<img src="'+host_addr+'images/waiting.gif" class="total2"/>');
  }
var requestthree=false;
try {
  requestthree = new XMLHttpRequest();
} catch (trymicrosoft) {
  try {
    requestthree = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (othermicrosoft) {
    try {
      requestthree = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (failed) {
      requestthree = false;
    }
  }
}
      requestthree.open(""+sendtype+"", url, true);
      requestthree.send(null);  
requestthree.onreadystatechange=function(){
   if(requestthree.readyState == 2||requestthree.readyState == 1 || requestthree.readyState == 0){
    
   }else if (requestthree.readyState == 4) {
 var response=requestthree.responseText;
   // console.log(requestthree);
if(targetElement!=="none"){
effectControl(targetElement,entryType,entryEffect,period,response);
}else if(targetElement=="none"){
  if(entryType=="reload"){
    location.reload();
  }
}else{
  outs=response;
}

// console.log(targetElement,response,url,requestthree,period);
}

}
  // requestthree.onreadystatechange=generalUpdatetwo();
}

var Request=function(){
this.requesttwo = false;
var url;
var response;
}
//creates reference request object
Request.prototype={
  //get the url
url:function(dataentry){
url=dataentry;
},
opensend:function(sentType){
      this.requesttwo.open(""+sentType+"", url, true);
      this.requesttwo.send(null);  
},
update:function(targetElement,entryType,entryEffect,period){
  outs="nothing";
  
  requesttwo=this.requesttwo.readyState;
  this.requesttwo.onreadystatechange= function(){
   if(this.readyState == 2||this.readyState == 1 || this.readyState == 0){
    
   }else if (this.readyState == 4) {
   var response=this.responseText;
if(targetElement!=="none"){
effectControl(targetElement,entryType,entryEffect,period,response);
if(this.maincontainer!==targetElement){
$(''+this.maincontainer+'').html("");
}
}else{
  if(entryType=="reload"){
    location.reload();
  }
}

// console.log(targetElement,response,url,this.requesttwo,period);
}

}
  // this.requesttwo.onreadystatechange=generalUpdate;

},
updatetwo:function(){
  outs="nothing";
  

this.requesttwo.onreadystatechange= function(){
   if(this.requesttwo.readyState == 2||this.requesttwo.readyState == 1 || this.requesttwo.readyState == 0){
    
   }else if (this.requesttwo.readyState == 4) {
   var response=this.requesttwo.responseText;
// console.log(response);
return response;
}
}
  // this.requesttwo.onreadystatechange=generalUpdate;

},
  generate: function(maincontainer,waitdisplay){
    this.maincontainer=maincontainer;
  if(waitdisplay===true){
    $(''+maincontainer+'').html('<img src="'+host_addr+'images/waiting.gif" class="total2"/>');
  }
try {
  this.requesttwo = new XMLHttpRequest();
} catch (trymicrosoft) {
  try {
    this.requesttwo = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (othermicrosoft) {
    try {
      this.requesttwo = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (failed) {
      this.requesttwo = false;
    }
  }
}    

  },
  generatetwo: function(maincontainer,waitdisplay){
  if(waitdisplay===true){
    $(''+maincontainer+'').html('<img src="'+host_addr+'images/waiting.gif" class="total2"/>');
  }
try {
  this.requesttwo = new XMLHttpRequest();
} catch (trymicrosoft) {
  try {
    this.requesttwo = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (othermicrosoft) {
    try {
      this.requesttwo = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (failed) {
      this.requesttwo = false;
    }
  }
}    

  },
  extraFunctions: function(targetElement,value){
    if(this.requesttwo.readyState == 4){
      $(""+targetElement+"").html(""+value+"");
    }
  }
}
function endSlideMotion(){
if(slideFunction){
  clearTimeout(slideFunction);
  slideFunction="";
}
}

var slideFunction="";
var slidePoint=1;
function slideMotion(targetElement,slideDir,moveval,period,timeout,statestart){
  /*
  Timeout is the time inbetween the slide motions while
  stateStart is a value of 1 for motion firing off on pageload or
   0 for motion that waits the timeout period specified then changes to
   1 for continued motion.  
  */
   
  // console.log(targetElement,slideDir,moveval,period,timeout,statestart);
  if(statestart=="stop"){
  window.clearTimeout(slideFunction);
  // slideFunction=window.setTimeout("slideMotion('"+targetElement+"','"+slideDir+"','"+moveval+"','"+period+"','"+timeout+"','stop')",timeout);
  }else if(statestart==1){
  var curposleft=$(''+targetElement+'').css("left");
  curposleft2=curposleft.split("p");
  curposleft2=Math.floor(curposleft2[0]);
  var curposright=$(''+targetElement+'').css("right");
  var curposright2=curposright.split("p");
  curposright2=curposright2[0];
  var curpostop=$(''+targetElement+'').css("top");
  curpostop2=curpostop.split("p");
  curpostop2=Math.floor(curpostop2[0]);
  var curposbottom=$(''+targetElement+'').css("bottom");
  var curposbottom2=curposbottom.split("p");
  curposbottom2=Math.floor(curposbottom2[0]);
  var totalwidth=$(''+targetElement+'').width();
  var totalheight=$(''+targetElement+'').height();
  // console.log(curposleft,curposright,curposright2,curpostop,curposbottom,totalwidth,totalheight);
  if(slideDir=="left"){
  if(curposleft=="auto"||curposleft2<totalwidth-moveval){
  $(''+targetElement+'').animate({left:"+="+moveval+""},period,function(){
  $('div#slidepoint').attr("data-name","");
  slidePoint+=1;
  console.log(slidePoint);
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });     
  }else{
    $(''+targetElement+'').animate({left:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="right"){
  if(curposright=="auto"||curposright2<totalwidth-moveval){
  $(''+targetElement+'').animate({right:"+="+moveval+""},2000,function(){
  $('div#slidepoint').attr("data-name","");
  slidePoint+=1;
  console.log(slidePoint);
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({right:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="bottom"){
    if(curposbottom=="auto"||curposbottom2<totalheight-moveval){
  $(''+targetElement+'').animate({bottom:"+="+moveval+""},period,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({bottom:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="top"){
  if(curpostop=="auto"||curpostop2<totalheight-moveval){
  $(''+targetElement+'').animate({top:"+="+moveval+""},period,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({top:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }
  if(statestart=="stop"){
  clearTimeout(slideFunction);
  }else if(timeout!==""&&timeout>0){
  slideFunction=window.setTimeout("slideMotion('"+targetElement+"','"+slideDir+"',"+moveval+","+period+","+timeout+","+statestart+")",timeout);
  }
  }else if(statestart==0){
  slideFunction=window.setTimeout("slideMotion('"+targetElement+"','"+slideDir+"',"+moveval+","+period+","+timeout+",1)",timeout);
  }else{
   
  // console.log(curposleft,curposright,curposright2,curpostop,curposbottom,totalwidth,totalheight);
  if(slideDir=="left"){
  if(curposleft=="auto"||curposleft2<totalwidth-moveval){
  $(''+targetElement+'').animate({left:"+="+moveval+""},period,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });     
  }else{
    $(''+targetElement+'').animate({left:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="right"){
  if(curposright=="auto"||curposright2<totalwidth-moveval){
  $(''+targetElement+'').animate({right:"+="+moveval+""},2000,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({right:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="bottom"){
    if(curposbottom=="auto"||curposbottom2<totalheight-moveval){
  $(''+targetElement+'').animate({bottom:"+="+moveval+""},period,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({bottom:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  }else if(slideDir=="top"){
  if(curpostop=="auto"||curpostop2<totalheight-moveval){
  $(''+targetElement+'').animate({top:"+="+moveval+""},period,function(){
  slidePoint+=1;
   $('div#slidepoint').attr("data-name","");
  $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
  });  
  }else{
    $(''+targetElement+'').animate({top:"0"},period,function(){
      $('div#slidepoint').attr("data-name","");
      slidePoint=1;
    $('div#slidepoint[data-point=slide'+slidePoint+']').attr("data-name","activeslide");
    });
  }
  } 
  }
}
/*for controlling slide indicator and rigid slider*/
$(document).on("click","div#slidepoint",function(){
    window.clearTimeout(slideFunction);
    var slidename=$(this).attr("name");
    $('div#slidepoint').attr("data-name","");
    var parent=this.parentNode;
    var dir=parent.getAttribute("data-slidedir");
    console.log(dir)
    $(this).attr("data-name","activeslide");
    var nextpos=Math.floor(slidename)*Math.floor(937);
    if(slidename=="1"){
      nextpos=0;
    }
    $('div#slideholder').animate({right:""+nextpos+""},1000,function(){
      slideFunction=window.setTimeout("slideMotion('#slideholder','right',937,4685,12000,0)",12000);
    });
  });
/*end*/
var slideFunctionResponsive="";
var slidePoint=0;
function slideMotionResponsive(targetElement,slideDir,moveval,period,timeout,statestart){
/*
Timeout is the time inbetween the slide motions while
stateStart is a value of 1 for motion firing off on pageload or
 0 for motion that waits the timeout period specified then changes to
 1 for continued motion.  
*/
var parentcontent=$(''+targetElement+'').attr("data-slides");
var slidelength=$(''+targetElement+' div#slidepoint').width();
var curposleft=$(''+targetElement+'').css("left");
if(curposleft.indexOf("px")>-1){    
var curposleft2=curposleft.split("p");
curposleft2=Math.floor(curposleft2[0]);
  }else if (curposleft.indexOf("%")>-1) {
var curposleft2=curposleft.split("%");
curposleft2=Math.floor(curposleft2[0]);
  }

var curposright=$(''+targetElement+'').css("right");
var curposright2=curposright.split("p");
curposright2=curposright2[0];

var percentlast=100*parentcontent-100;
  var totpercent=parentcontent*slidelength;
  var lastpoint=slidelength-totpercent;
var totalwidth=slidelength*100;
var totalheight=$(''+targetElement+'').height();
 
// console.log(targetElement,slideDir,moveval,period,timeout,statestart);
// console.log(curposleft,lastpoint,slidelength,parentcontent);
if(statestart=="stop"){
window.clearTimeout(slideFunctionResponsive);
// slideFunction=window.setTimeout("slideMotion('"+targetElement+"','"+slideDir+"','"+moveval+"','"+period+"','"+timeout+"','stop')",timeout);
}else if(statestart==1){
/*var curpostop=$(''+targetElement+'').css("top");
curpostop2=curpostop.split("p");
curpostop2=Math.floor(curpostop2[0]);
var curposbottom=$(''+targetElement+'').css("bottom");
var curposbottom2=curposbottom.split("p");
curposbottom2=Math.floor(curposbottom2[0]);*/
if(slideDir=="left"){
if(curposleft2>lastpoint){
$(''+targetElement+'').animate({left:"-="+moveval+"%"},500,function(){

});     
}else{
  $(''+targetElement+'').animate({left:"0%"},2000,function(){});
}
}else if(slideDir=="right"){
if(curposright2<lastpoint){
$(''+targetElement+'').animate({right:"+="+moveval+"%"},2000,function(){
slidePoint+=1;

});  
}else{
  $(''+targetElement+'').animate({right:"0%"},period,function(){});
}
}/*else if(slideDir=="bottom"){
  if(curposbottom=="auto"||curposbottom2<totalheight-moveval){
$(''+targetElement+'').animate({bottom:"+="+moveval+""},period,function(){

});  
}else{
  $(''+targetElement+'').animate({bottom:"0"},period,function(){});
}
}else if(slideDir=="top"){
if(curpostop=="auto"||curpostop2<totalheight-moveval){
$(''+targetElement+'').animate({top:"+="+moveval+""},period,function(){

});  
}else{
  $(''+targetElement+'').animate({top:"0"},period,function(){});
}
}*/
if(statestart=="stop"){
clearTimeout(slideFunctionResponsive);
}else if(timeout!==""&&timeout>0){
slideFunctionResponsive=window.setTimeout("slideMotionResponsive('"+targetElement+"','"+slideDir+"',"+moveval+","+period+","+timeout+","+statestart+")",timeout);
}
}else if(statestart==0){
slideFunctionResponsive=window.setTimeout("slideMotionResponsive('"+targetElement+"','"+slideDir+"',"+moveval+","+period+","+timeout+",1)",timeout);
}else{ 
// console.log(curposleft,curposright,curposright2,curpostop,curposbottom,totalwidth,totalheight);
if(slideDir=="left"){
if(curposleft2>lastpoint){
$(''+targetElement+'').animate({left:"-="+moveval+"%"},1000,function(){

});     
}else{
  $(''+targetElement+'').animate({left:"0%"},2000,function(){});
}
}else if(slideDir=="right"){
if(curposright=="auto"||curposright2<lastpoint){
$(''+targetElement+'').animate({right:"+="+moveval+"%"},2000,function(){

});  
}else{
  $(''+targetElement+'').animate({right:"0%"},2000,function(){});
}
}/*else if(slideDir=="bottom"){
  if(curposbottom=="auto"||curposbottom2<totalheight-moveval){
$(''+targetElement+'').animate({bottom:"+="+moveval+""},period,function(){

});  
}else{
  $(''+targetElement+'').animate({bottom:"0"},period,function(){});
}
}else if(slideDir=="top"){
if(curpostop=="auto"||curpostop2<totalheight-moveval){
$(''+targetElement+'').animate({top:"+="+moveval+""},period,function(){

});  
}else{
  $(''+targetElement+'').animate({top:"0"},period,function(){});
}
}*/ 
}

}
var blockanim=false;
//for responsiveslide drag effect
$(document).on("mousedown","div#slidepointhold",function(e){
console.log(e.clientX,slideFunctionResponsive);
clearTimeout(slideFunctionResponsive);
});

//end
// for responsive slides pointers works with slidepoint plugin
$(document).on("click","div#slidepointleft[data-state=idle],div#slidepointright[data-state=idle]",function(){
event.stopPropagation();
clearTimeout(slideFunctionResponsive);
  var direction=$(this).attr("data-motion");
  $(this).attr("data-state","running");
  var target=$(this).attr("data-target");
  var parentlength=$('div#slidepointhold[data-name='+target+']').width();
  var slidelength=$('div#slidepointhold[data-name='+target+'] div#slidepoint').width();
  var parentcontent=$('div#slidepointhold[data-name='+target+']').attr("data-slides");
  var parpos=$('').css('left');
  var curposleft=$('div#slidepointhold[data-name='+target+']').css("left");
  if(curposleft.indexOf("px")>-1){    
var curposleft2=curposleft.split("p");
curposleft2=Math.floor(curposleft2[0]);
  }else if (curposleft.indexOf("%")>-1) {
var curposleft2=curposleft.split("%");
curposleft2=Math.floor(curposleft2[0]);
  };
  var percentlast=100*parentcontent-100;
  var totpercent=parentcontent*slidelength;
  var lastpoint=slidelength-totpercent;
// console.log(curposleft,lastpoint);
var moveval=100;
var slideDir="left";
var period=3000;
var timeout=20000;
var statestart=0;
  if(direction=="left"){
  if(curposleft2>lastpoint&&blockanim==false){
    blockanim=true;
    $('div#slidepointhold[data-name='+target+']').animate({left:'-=100%'},1000,function(){
/*    var firstel=$('div#slidepointhold[data-name='+target+'] div#slidepoint')[0];
    $('div#slidepointhold[data-name='+target+'] div#slidepoint')[0].remove;
    $(firstel).insertAfter('div#slidepointhold[data-name='+target+'] div#slidepoint:last');*/
slideFunctionResponsive=window.setTimeout("slideMotionResponsive('div#slidepointhold[data-name="+target+"]','"+slideDir+"',"+moveval+","+period+","+timeout+","+statestart+")",timeout);
      blockanim=false;
      $('div#slidepointright[data-motion=left]').attr("data-state","idle");
// console.log($('div#slidepointhold[data-name='+target+'] div[data-motion=left]'));
    });
  }else if(curposleft2<=lastpoint&&blockanim==false){
blockanim=true;
$('div#slidepointhold[data-name='+target+']').animate({left:'0%'},1000,function(){
slideFunctionResponsive=window.setTimeout("slideMotionResponsive('div#slidepointhold[data-name="+target+"]','"+slideDir+"',"+moveval+","+period+","+timeout+","+statestart+")",timeout);
      blockanim=false;
// console.log($('div#slidepointright[data-target='+target+']'));
$('div#slidepointright[data-motion=left]').attr("data-state","idle");
    });
  }
  }else if(direction=="right"){
  var slidelast=$('div#slidepointhold[data-name='+target+'] div#slidepoint').length-1;
  var lastel=$('div#slidepointhold[data-name='+target+'] div#slidepoint')[0];
  if(curposleft2<0){
    blockanim=true;
    $('div#slidepointhold[data-name='+target+']').animate({left:'+=100%'},1000,function(){
      blockanim=false;
$('div#slidepointleft[data-motion=right]').attr("data-state","idle");
    });
  }else if(curposleft2==0){
      blockanim=true;
$('div#slidepointhold[data-name='+target+']').animate({left:'-'+percentlast+'%'},1000,function(){
      blockanim=false;
$('div#slidepointleft[data-motion=right]').attr("data-state","idle");
});
}
  }
});
//for approximation to particular decimal places
(function(){

  /**
   * Decimal adjustment of a number.
   *
   * @param {String}  type  The type of adjustment.
   * @param {Number}  value The number.
   * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
   * @returns {Number}      The adjusted value.
   */
  function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
})();
//usage
//Math.[floor10|round10|ceil10](number,decimalspaceapproximate);
//e.g Math.ceil10(3.4562357,-6) and Math.round10(3.4562357,-6); give 3.456236
//Math.floor10(3.4562357,-6); gives 3.456235
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
$(document).on("click","div[data-name=dropperpoint]",function(){
var curstate=$(this).attr("data-state");
var rotatetarget=$(this).attr("data-rotatetarget");
var target=$(this).attr("data-target");
var target_height=$('div[data-targetname='+target+'] .displaydropperhold').height();
console.log($('div[data-targetname='+target+'] .displaydropperhold'),target_height);
if(curstate=="inactive"){
$(this).css({"-webkit-transform":"rotate(90deg)","moz-transform":"rotate(90deg)","o-transform":"rotate(90deg)","-ms-transform":"rotate(90deg)"});

$('div[data-targetname='+target+']').animate({height:""+target_height+""},1000,function(){
$('div[data-targetname='+target+']').css("height","auto");
});
$(this).attr("data-state","active");
}else if(curstate=="active"){
$(this).attr("data-state","inactive");
$(this).css({"-webkit-transform":"rotate(0deg)","moz-transform":"rotate(0deg)","o-transform":"rotate(0deg)","-ms-transform":"rotate(0deg)"});

$('div[data-targetname='+target+']').animate({height:"30"},1000,function(){

});
}
});
var bgPageCarouselfunc="";
function bgPageCarousel(element,elementchild,cperiod,statecontrol){
  cperiod==null?cperiod=1000:cperiod=cperiod;
  var elemcount=$(''+element+' '+elementchild+'').length;
  // adjust z-index for each carousel entry
  console.log($(''+element+''), $(''+element+' '+elementchild+''),elemcount);
  
//init section on first run
  if(statecontrol==0){
   for(var i=0;i<elemcount;i++){
    var z=i+2;
    $(''+element+' '+elementchild+'')[i].setAttribute("style","z-index:"+z+";");
    $(''+element+' '+elementchild+'')[i].setAttribute("appdata-id",""+i+"");

  }
   $(''+element+'').attr("appdata-curcarousel",""+i+"");
    $(''+element+'').attr("appdata-totcarousel",""+i+"");
    $(''+element+'').attr("appdata-dir","desc");
  bgPageCarouselfunc=window.setTimeout("bgPageCarousel('"+element+"','"+elementchild+"','"+cperiod+"',1)",cperiod);
  }else if(statecontrol==1){
      var curcar=Math.floor($(''+element+'').attr("appdata-curcarousel"));
      var dir=$(''+element+'').attr("appdata-dir");
      var totcar=Math.floor($(''+element+'').attr("appdata-totcarousel"));
      if(elemcount>1){
      if(dir=="desc"){
        $(''+element+' '+elementchild+'[appdata-id='+curcar+']').fadeOut(1500);
        var nextcar=curcar-1;
        if(nextcar>0){
        $(''+element+'').attr("appdata-curcarousel",""+nextcar+"");
          
        }else{
         $(''+element+'').attr("appdata-dir","asc");
        }

        var totcarousel=$(''+element+'').attr("appdata-totcarousel");
      }else if(dir=="asc"){
        $(''+element+' '+elementchild+'[appdata-id='+curcar+']').fadeIn(1500);
        var nextcar=curcar+1;
        if(nextcar<totcar){
        $(''+element+'').attr("appdata-curcarousel",""+nextcar+"");
          
        }else{
         $(''+element+'').attr("appdata-dir","desc");
        }
      }
  bgPageCarouselfunc=window.setTimeout("bgPageCarousel('"+element+"','"+elementchild+"','"+cperiod+"',"+statecontrol+")",cperiod);
  }
  }
}
function responsiveMenu(){
  var curstate=$('div[appdata-name="responsivepanel"]').attr("appdata-state");
  if(typeof($.mobile)=="undefined"){
    console.log("ran through");
  /*$('.selectlinks a[href*=nav-panel]').attr("onClick","responsiveMenu()");
  $('div[appdata-name=responsivepanel] a[data-rel=close]').attr("onClick","responsiveMenu()");*/
  if(curstate=="active"){ 
    $('div[appdata-name="responsivepanel"]').attr("appdata-state","inactive")
  }else{
    $('div[appdata-name="responsivepanel"]').attr("appdata-state","active")

  }
}else{
  $('div[appdata-monitor="responsiveplain"]').attr("appdata-name","");
}
}
function readURL(input,targetElementImg) {
  var results_arr=new Array();
  console.log(input,targetElementImg,input[0]);
  if (input[0].files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      // data list is as follows
      /*
      *e.total=total number of bytes
      *
      *
      *
      *
      */
      $(''+targetElementImg+'').attr('src', e.target.result).removeClass('hidden');
      // console.log(e);
    }
    // console.log(input,targetElementImg,'in here');
    reader.readAsDataURL(input[0].files[0]);
  }
  return results_arr;
}

bytesize=0;
result="";
function readURLTwo(input,type) {
  // var results_arr=[];
  // console.log(input,input[0].files[0],$(input[0]));
  if (input[0].files[0]) {
    var reader = new FileReader();
    $(input[0]).attr("data-state","loading");
    var targetElem=$(input[0]);
    var editelemdata=targetElem.attr("data-edit");
    if(type=="napstanduserimgupload"||type=="napstanduserimgeditupload"){
      var targetelement=targetElem.parent().parent().parent().parent().parent().parent().parent();
      
    }else if(type=="napstanduserzipupload"||type=="napstanduserzipeditupload"){
      var targetelement=targetElem.parent().parent().parent().parent().parent().parent();
      
    }
    var targetparid=targetelement.attr("data-id");
    // console.log(targetelement,targetparid);
    if(targetparid!==""&&typeof(targetelement.attr("data-id"))!=="undefined"){
        targetparid='[data-id='+targetparid+']';
        targetparidmain='div'+targetparid+'';
    }else{
        targetparid="";
        targetparidmain="";
    }
    typeof(editelemdata)=="undefined"||editelemdata=="undefined"?editelemdata="":editelemdata=editelemdata;
    if(type=="napstanduserzipupload"||type=="napstanduserzipeditupload"){
      var filesize=editelemdata!=="edit"?$('input[name=zipfilesizeout]'):$(''+targetparidmain+' input[name=zipfilesizeoutedit]');
      var editsectionhead="div[data-name=upload-zip-section"+editelemdata+"]"+targetparid+" ";
      
      $(''+editsectionhead+'.entrymarker.zip p.total-size').html('<img src="'+host_addr+'images/waiting.gif" class="loadermini">')
      $(''+editsectionhead+'input[name=zipfilesizeout'+editelemdata+']').attr("data-state","loading");
    }else if (type=="napstanduserimgupload"||type=="napstanduserimgeditupload") {
      var filesize=editelemdata!=="edit"?$('input[name=filesizeout]'):$(''+targetparidmain+' input[name=filesizeoutedit]');
      var editsectionhead="div[data-name=upload-image-section"+editelemdata+"]"+targetparid+" ";

    }
    // console.log("Editdata: ",editelemdata," Section head:", editsectionhead," readurl: ",type);

    reader.onload = function(e) {
      // data list is as follows
      /*
      * e.total=total number of bytes
      * e.target.result=total entry
      *
      *
      *
      */
      // $(''+targetElementImg+'').attr('src', e.target.result).removeClass('hidden');
      name=$(input[0]).val();
      totalname=name.split('\\');
      // console.log('name: ',name,' splitname: ',totalname);
      name=totalname[totalname.length-1];
      // console.log(e);
      bytesize=e.total;
      result=e.target.result;
      /*CONTROL Block FOR varying output formats*/
      if(type=="napstanduserimgupload"||type=="napstanduserimgeditupload"){
        var divide=input.attr("name").split('e');
        var c=divide[1];
        
        $(''+editsectionhead+'.img_prev_hold.'+c+'').html('<img src="'+result+'"/>');
        input.attr("data-file-size",bytesize);
        var curtotal=Math.floor(filesize.val());
        curtotal+=bytesize;
        filesize.val(curtotal);
        // recalculate total size
        var totalsize=calculateTotalFileSize(curtotal);
        // deal only in MB
        var cursize='<span class="color-green">'+totalsize['megabyte']+'MB</span>';
        if(totalsize['megabyte']>30){
          cursize='<span class="color-red">'+totalsize['megabyte']+'MB</span>';
        }
        $(''+editsectionhead+'.entrymarker.images p.total-size').html(cursize);
        $(''+editsectionhead+'.entrymarker.images input[name=filesizeout'+editelemdata+']').attr("data-state","loaded");
      }else if(type=="napstanduserzipupload"||type=="napstanduserzipeditupload"){
        // input.attr("data-file-size",bytesize);
        
        var ftype=getExtension(targetElem.val());
        if(ftype['extension']=="zip"){    
          filesize.val(bytesize);
          // recalculate total size
          var totalsize=calculateTotalFileSize(bytesize);
          // deal only in MB
          var cursize='<span class="color-green">'+name+' : '+totalsize['megabyte']+'MB</span>';
          if(totalsize['megabyte']>30){
            cursize='<span class="color-red">'+name+' : '+totalsize['megabyte']+'MB TOO LARGE!!!</span>';
          }
          $(''+editsectionhead+'.entrymarker.zip p.total-size').html(cursize);
          $(''+editsectionhead+'.entrymarker.zip input[name=zipfilesizeout'+editelemdata+']').attr("data-state","loaded");
          
        }else{
          cursize='<span class="color-red">WRONG FILE TYPE : 0MB</span>';
          $(''+editsectionhead+'.entrymarker.zip p.total-size').html(cursize);
          $(''+editsectionhead+'.entrymarker.zip input[name=zipfilesizeout'+editelemdata+']').val("0").attr("data-state","loaded");
        }
      }

      $(input[0]).attr("data-state","loaded");

    }
    reader.readAsDataURL(input[0].files[0]);
    // console.log(bytesize,'in here');
  }else{
    if(type=="napstanduserimgupload"){

    }else if(type=="napstanduserzipupload"){
      $(''+editsectionhead+'.entrymarker.zip p.total-size').html('<span class="color-red">0MB</span>');
      $(''+editsectionhead+'.entrymarker.zip input[name=zipfilesizeout'+editelemdata+']').attr("data-state","loaded");
    }
    $(input[0]).attr("data-state","loaded");
  }
  // return results_arr;
}
function contentImageSelect(input){
    var targetElem=$(input);
    var divide=targetElem.attr("name").split('e');
    var c=divide[1];
    var editelemdata=targetElem.attr("data-edit");
    typeof(editelemdata)=="undefined"||editelemdata=="undefined"?editelemdata="":editelemdata=editelemdata;
    // console.log("c: ",c, input)
    var curfilesize=targetElem.attr('data-file-size');
    var filesize=editelemdata!=="edit"?$('input[name=filesizeout]'):$('input[name=filesizeoutedit]');
    var editsectionhead="div[data-name=upload-image-section] ";
    var editreadurl="napstanduserimgupload";
    if(editelemdata=="edit"){
      editsectionhead="div[data-name=upload-image-sectionedit] ";
      editreadurl="napstanduserimgeditupload";
    }
    // console.log("Editdata: ",editelemdata," Section head:", editsectionhead," readurl: ",editreadurl);

    if(typeof(curfilesize)!=="undefined"&&curfilesize!==""){
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
      $(''+editsectionhead+'.entrymarker.images p.total-size').html(cursize);
      // console.log("contentmarker: ",$(''+editsectionhead+'.entrymarker.images p.total-size'));
      targetElem.attr('data-file-size','0')
    }
    if (targetElem.val()!=="") {
        var ftype=getExtension(targetElem.val());
        if(ftype['type']=="image"){  
            readURLTwo(targetElem,""+editreadurl+"");
            // console.log("src data: ",bytesize,filesrc);
        }else{
            alert("Please Upload an image, no other file format is accepted here");
        }   
    }else{
        $(''+editsectionhead+' .img_prev_hold.'+c+'').html("");

    }

}

function calculateTotalFileSize(bytecount){
    var fileout=[];
    // calculate for KB
    var kb_count=Math.ceil10(Math.floor(bytecount)/1024,-2);
    // Calculate for MB
    var mb_count=Math.ceil10(Math.floor(kb_count)/1024,-2);
    // calculate for GB
    var gb_count=Math.ceil10(Math.floor(mb_count)/1024,-2);
    fileout['kilobyte']=kb_count;
    fileout['megabyte']=mb_count;
    fileout['gigabyte']=gb_count;
    return fileout;
}
function handle_files(inputs) {
  // this function is for multiple 
  // the input selector for the files in the form
  for (i = 0; i < inputs.length; i++) {
    input = inputs[i]
    console.log(input);
    var reader = new inputReader()
    ret = []
    reader.onload = function(e) {
      console.log(e.target.result)
    }
    reader.onerror = function(stuff) {
      console.log("error", stuff)
      console.log (stuff.getMessage())
    }
    reader.readAsText(input) //readAsdataURL
  }

}
function raiseMainModal(title, content, failsuccess,show=""){
      if(failsuccess=="fail"){
        var outclass='bg-yellow-active bg-green-active color-darkgreen bg-aqua-active';
        var inclass='bg-red-active color-red';
      }else if(failsuccess=="success"){
        var outclass='bg-yellow-active bg-red-active color-red bg-aqua-active';
        var inclass='bg-green-active color-darkgreen';
      }else if(failsuccess=="info"){
        var outclass='bg-yellow-active bg-red-active color-red bg-green-active color-darkgreen';
        var inclass='bg-aqua-active';
      }else if(failsuccess=="warning"){
        var outclass='bg-red-active color-red bg-green-active color-darkgreen';
        var inclass='bg-yellow-active';
      }
      // raise the success modal
        $("#mainPageModal .modal-header .modal-title").html(title);
        $("#mainPageModal .modal-body").html(content);
        $("#mainPageModal .modal-content").removeClass(outclass).addClass(inclass);
      if(show=="true"||show==""){
        $("#mainPageModal").modal({show: true});
      }else if(show=="noclose"){
        
      }
        
}
function doBootPagReInit(total,curquery,ipp,selector=""){
  selector==""?selector='.generic_ajax_pages_hold._top, .generic_ajax_pages_hold._bottom':selector=selector;
  $(selector).bootpag({
      total: total,
      page: 1,
      maxVisible: 9,
      leaps: true,
      firstLastUse: true,
      first: '<i class="fa fa-arrow-left"></i>',
      last: '<i class="fa fa-arrow-right"></i>',
      wrapClass: 'pagination',
      dataquery:true,
      datacurquery:curquery,
      dataipp:ipp,
      datavariant:true,
      datapages:[15,25,40,60],
      datatarget:'div.generic_ajax_pages_hold div.page_content_out_hold',
      dataitemloader:'div.content_image_loader_bootpag',
      activeClass: 'active',
      disabledClass: 'disabled',
      nextClass: 'next',
      prevClass: 'prev',
      lastClass: 'last',
      firstClass: 'first'
  })
}
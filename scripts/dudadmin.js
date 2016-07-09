$(document).ready(function(){
hideBind("div[name=closefullcontenthold]","#fullbackground","fadeOut",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontenthold","fadeOut",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontent","html",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontentheader","html",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontentdetails","html",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontentheader","fadeOut",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontentdetails","fadeOut",1000,"","");
hideBind("div[name=closefullcontenthold]","#fullcontentpointerhold","fadeOut",1000,"","");
  var help=new Array();
  help['boats']='Create/Edit a new boats';
  help['articles']='Create/Edit Articles';
  help['medias']='Create/Edit Media content for articles';
$(document).on("click","div#menulinkcontainer a[data-type=mainlink]",function(){
var linkname=$(this).attr("data-name");
$('div#contentdisplayhold').html(help[''+linkname+'']);
});
$(document).on("click","div#menulinkcontainer a[data-type=sublink]",function(){
var linkname=$(this).attr("data-name");
//$('div#contentdisplayhold').html(help[''+linkname+'']);
var sublinkreq=new Request();
  sublinkreq.generate('#contentdisplayhold',true);
  //enter the url
  sublinkreq.url('../snippets/display.php?displaytype='+linkname+'&extraval=admin');
  //send request
  sublinkreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  sublinkreq.update('div#contentdisplayhold','html','fadeIn',1000);
});
     $(document).on("blur",'div#formend select[name=photocount]',function(){
    //window.alert('event called');
    var photocount=$(this).val();
    var photocountmain=photocount;
    var curpics=$('input[name=piccount]').val();
    console.log(curpics,this,photocount)
    var totoptions='<option value="">--add More?--</option>';
    if(curpics==""||curpics<1){
    while(photocount>0){
      $('<br><br><input type="file" class="curved" name="defaultpic'+photocount+'"/>').insertAfter('#formend select[name=photocount]');
      photocount--;
    }
  //update the current number of photo fields displayed
    $('input[name=piccount]').attr('value',''+photocountmain+'');
  //update selection options
  var totpics=10-Math.floor(photocountmain);
  var rempics=Math.floor(totpics);
  // console.log(rempics,photocount);
   if(rempics>0){
    //updates the selection box for he remainning possible photo uploads
    while(rempics>0){
    totoptions+='<option value="'+rempics+'">'+rempics+' File</option>';   
    // $('<option value="'+rempics+'">'+rempics+' Photos</option>').insertBefore('select[name=photocount] option');      
    rempics--;
    }
    $(this).html(totoptions);
  }else{
  totoptions='<option value="">Max Of 10</option>';
  $(this).html(totoptions);    
  }
}else{
//
var photoentry;
while(photocount>0){
photoentry=Math.floor(photocount)+Math.floor(curpics);
      $('<br><br><input type="file" class="curved" name="defaultpic'+photoentry+'"/>').insertAfter('select[name=photocount]');
    photocount--;
}
// console.log("In here");
  var totpics=Math.floor(curpics)+Math.floor(photocountmain);
  var checkpicleft=10-totpics;
  var rempics=checkpicleft;
  console.log(rempics,totpics);
  $('input[name=piccount]').attr('value',''+totpics+'');
  if(rempics>0){
    while(rempics>0){
    totoptions+='<option value="'+rempics+'">'+rempics+' Files</option>';   
    // $('<option value="'+rempics+'">'+rempics+' Photos</option>').insertBefore('select[name=photocount] option');      
    rempics--;
    }
    $(this).html(totoptions);
  }else{
  totoptions='<option value="">Max Of 10</option>';
  $(this).html(totoptions);
  }
}
  });

$(document).on("click","input[type=button][name=mainsearch]",function(){
var searchby=$('form[name=mainsearchform] select[name=searchby').val();
var searchval=$('form[name=mainsearchform] input[name=mainsearch').val();
if(searchby!==""&&searchval!==""){
var searchreq=new Request();
  searchreq.generate('#contentdisplayhold',true);
  //enter the url
  searchreq.url('../snippets/display.php?displaytype=mainsearch&searchby='+searchby+'&mainsearch='+searchval+'&extraval=admin');
  //send request
  searchreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  searchreq.update('div#contentdisplayhold','html','fadeIn',1000);
  
}else{
  window.alert("To use the search feature you must choose a 'Search By' option first then enter your search value next, then you can search, if any is empty you would keep seeing this.....until you follow the simple instruction.");
}
});

$(document).on("click",'#editimgsoptionlinks a',function(){
var linkname=$(this).attr('name');
var linkid=$(this).attr('data-id');
   var albumreq=new Request();
  var albumlinkreq=new Request();
if(linkname=="deletepic"){
//   $('div[name=profimg'+;linkid+']').css("display","none");
var confirm=window.confirm('Are you sure you want to delete this, click "OK" to delete this or "Cancel" to stop')
if(confirm===true){
  albumlinkreq.generate('#fullcontent',false);
  albumlinkreq.url(''+host_addr+'snippets/display.php?displaytype='+linkname+'&extraval='+linkid+'');
  //send request
  albumlinkreq.opensend('GET');
  albumlinkreq.update('#fullcontent','none','none',0);  
  $('div[name=albumimg'+linkid+']').fadeOut(500);
var galid=$(this).attr("data-galleryid");
var thesrc=$(this).attr("data-src");
var galname=$(this).attr("data-galleryname");
galname==""||typeof(galname)=="undefined"?galname="gallerydata":galname=galname;
var galleryimgsrcs=$('input[name='+galname+''+galid+']').attr('data-images');
var galleryimgsizes=$('input[name='+galname+''+galid+']').attr('data-sizes');
var posterpoint=$(this).attr('data-arraypoint');
galleryimgsrcsarray=galleryimgsrcs.split(">");
galleryimgsizesarray=galleryimgsizes.split("|");
var id=$.inArray(thesrc,galleryimgsrcsarray);
var dlength=galleryimgsrcsarray.length;
var newimgsrcs="";
var newsizes="";
for(var t=0;t<dlength;t++){
if(t!==id){
  newimgsrcs==""?newimgsrcs+=galleryimgsrcsarray[t]:newimgsrcs+="]"+galleryimgsrcsarray[t];
  newsizes==""?newsizes+=galleryimgsizesarray[t]:newsizes+="|"+galleryimgsizesarray[t];
}
}
/*$('input[name='+galname+''+galid+']').attr('data-images',''+newimgsrcs+'');
$('input[name='+galname+''+galid+']').attr('data-sizes',''+newsizes+'');*/
var galname=$(this).attr("data-galleryname");
galname==""||typeof(galname)=="undefined"?galname="gallerydata":galname=galname;
var galleryimgsrcs=$('input[name='+galname+''+galid+']').attr('data-images');
var galleryimgsizes=$('input[name='+galname+''+galid+']').attr('data-sizes');
var posterpoint=$(this).attr('data-arraypoint');
var galleryimgsrcsarray=galleryimgsrcs.split(">");
var galleryimgsizesarray=galleryimgsizes.split("|");
var dlength=galleryimgsrcsarray.length;
$('input[name='+galname+''+galid+']').attr({'data-images':''+newimgsrcs+'','data-sizes':''+newsizes+''});
/*$('input[name=gallerycount]').attr('value',''+dlength+'');
$('input[name=currentgalleryview]').attr('value','');
$('input[name=curgallerydata]').attr('data-images',''+newimgsrcs+'');
$('input[name=curgallerydata]').attr('data-sizes',''+newsizes+'');*/
var tlength=$('div[name=galleryfullholder'+galid+']').find("a[name=deletepic]").length;
console.log(id,tlength);
for(var i=0;i<tlength;i++){
var curpoint=$('div[name=galleryfullholder'+galid+']').find("a[name=deletepic]")[i].attributes[4].value;
if(curpoint>posterpoint){
var newpoint=curpoint-1;
$('div[name=galleryfullholder'+galid+']').find("a[name=deletepic]")[i].attributes[4].value=newpoint;
$('div[name=galleryfullholder'+galid+']').find("a[name=viewpic]")[i].attributes[4].value=newpoint;
}
}  
}

}else if (linkname=="viewpic") {
 $('#fullcontent img[name=fullcontentwait]').show();
// var gallery_name=$('input[name=bloggallerydata]').attr('title');
var gallery_name="";
// var gallery_details=$('input[name=bloggallerydata]').attr('data-details');
var posterpoint=$(this).attr('data-arraypoint');
var galleryimgsrcsarray=new Array();
var galleryimgsizesarray=new Array();
var galid=$(this).attr("data-galleryid");
var galname=$(this).attr("data-galleryname");
galname==""||typeof(galname)=="undefined"?galname="gallerydata":galname=galname;
console.log($('input[name='+galname+''+galid+']'),'input[name='+galname+''+galid+']');
var galleryimgsrcs=$('input[name='+galname+''+galid+']').attr('data-images');
var galleryimgsizes=$('input[name='+galname+''+galid+']').attr('data-sizes');
var galleryimgsrcsarray=galleryimgsrcs.split(">");
var galleryimgsizesarray=galleryimgsizes.split("|");
var posterimg=galleryimgsrcsarray[posterpoint];
var gallerydata="";
var gallerytotal=galleryimgsrcsarray.length-1;
gallery_name+='<input type="hidden" name="gallerycount" value="'+gallerytotal+'"/><input type="hidden" name="currentgalleryview" value="'+posterpoint+'"/><input type="hidden" name="curgallerydata" data-images="'+galleryimgsrcs+'" data-sizes="'+galleryimgsizes+'" data-galleryname="'+galname+'" value=""/>';
if(galleryimgsrcsarray.length>1){
for(var i=0;i<galleryimgsrcsarray.length;i++){
// console.log(galleryimgsrcsarray[i],galleryimgsizesarray[i],posterimg);
}
var prevpoint=Math.floor(posterpoint)-1;
var nextpoint=Math.floor(posterpoint)+1;
prevpoint<0?prevpoint=0:prevpoint=prevpoint;
console.log(prevpoint,nextpoint);
nextpoint>=galleryimgsrcsarray.length?nextpoint=galleryimgsrcsarray.length-1:nextpoint=nextpoint;
$('img[name=pointleft]').attr("data-point",""+prevpoint+"");
$('img[name=pointright]').attr("data-point",""+nextpoint+"");
}
var cursize=galleryimgsizesarray[posterpoint].split(',');
var imgwidth=Math.floor(cursize[0]);
var imgheight=Math.floor(cursize[1]);
var contwidth=$('#fullcontent').width();
var contheight=$('#fullcontent').height();
contwidth=Math.floor(contwidth);
contheight=Math.floor(contheight);
var outs= new Array();
outs=produceImageFitSize(imgwidth,imgheight,960,700,"off");
var firstcontent='<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="'+host_addr+'images/closefirst.png" title="Close"class="total"/></div>'+
'<img src="'+posterimg+'" name="galleryimgdisplay" style="'+outs['style']+'" title="'+gallery_name+'"/>'+
'<img src="'+host_addr+'images/waiting.gif" name="fullcontentwait" style="margin-top:285px;margin-left:428px;z-index:80;">'
;
$('#fullcontent').html(""+firstcontent+"");
$('#fullcontentheader').html(gallery_name);
// $('#fullcontentdetails').html(gallery_details);
var topdistance=$(window).scrollTop();
// console.log(topdistance);
if(topdistance>100){
  var pointerpos=topdistance+100;
$('#fullcontent').css("margin-top",""+topdistance+"px");
$('#fullcontentpointerhold').css("margin-top",""+topdistance+"px");
}else{
$('#fullcontent').css("margin-top","0px");
$('#fullcontentpointerhold').css("margin-top","0px");
}

$('#fullbackground').fadeIn(1000);
$('#fullcontenthold').fadeIn(1000);
$('#fullcontent').fadeIn(1000);
$('#fullcontentheader').fadeIn(1000);
$('#fullcontentdetails').fadeIn(1000);
$('#fullcontentpointerhold').fadeIn(1000);
$('img[name=galleryimgdisplay]').load(function(){
$('#fullcontent img[name=fullcontentwait]').hide();
});

}else{
  
}
});


$(document).on("click",'#editmediacontentoptionlinks a',function(){
var linkname=$(this).attr('name');
var linkid=$(this).attr('data-id');
var mediatype=$(this).attr('data-mediatype');
var medianame=$(this).attr('data-medianame');
var mainsrc=$(this).attr('data-src');
   var mediareq=new Request();
  var medialinkreq=new Request();
var outs= new Array();
  if(linkname=="view"){
if(mediatype=="image"){
var imgwidth=$(this).attr('data-width');
var imgheight=$(this).attr('data-height');
outs=produceImageFitSize(imgwidth,imgheight,960,700,"off");
var dispcontent='<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>'+
'<img src="'+mainsrc+'" name="galleryimgdisplay" style="'+outs['style']+'" title=""/>'+
'<img src="../images/waiting.gif" name="fullcontentwait" style="margin-top:285px;margin-left:428px;z-index:80;">'
;

}else if(mediatype=="audio"){
outs=produceImageFitSize(360,80,960,700,"off");
var dispcontent='<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>'+
'<audio src="'+mainsrc+'" controls="" preload="none" style="float:left;'+outs['style']+'" title="">You do not have support for html5 audio <a href="'+mainsrc+'">click here</a> to download this media content</audio>';
}else if(mediatype=="video"){
outs=produceImageFitSize(400,300,960,700,"off");
var dispcontent='<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>'+
'<video title="" id="example_video_1" style="float:left;width:400px;height:300px;'+outs['style']+'" class="video-js vjs-default-skin" controls preload="true" width="" height="200px" poster="" data-setup="{}">'+
'<source src="'+mainsrc+'"/>You do not have support for html5 video <a href="'+mainsrc+'">click here</a> to download this media content</video>';
}
var topdistance=$(window).scrollTop();
// console.log(topdistance);
if(topdistance>100){
  var pointerpos=topdistance+100;
$('#fullcontent').css("margin-top",""+topdistance+"px");
$('#fullcontentpointerhold').css("margin-top",""+topdistance+"px");
}else{
$('#fullcontent').css("margin-top","0px");
$('#fullcontentpointerhold').css("margin-top","0px");
}
$('#fullcontent').html(""+dispcontent+"");
$('#fullcontentheader').html(medianame);
$('img[name=galleryimgdisplay]').load(function(){
$('#fullcontent img[name=fullcontentwait]').hide();
});
$('#fullbackground').fadeIn(1000);
$('#fullcontenthold').fadeIn(1000);
$('#fullcontent').fadeIn(1000);
$('#fullcontentheader').fadeIn(1000);


  }else if(linkname=="delete"){
var confirm=window.confirm('Are you sure you want to delete this, click "OK" to delete this or "Cancel" to stop');
if(confirm===true){
  medialinkreq.generate('#fullcontent',false);
  medialinkreq.url('../snippets/display.php?displaytype='+linkname+'&extraval='+linkid+'');
  //send request
  medialinkreq.opensend('GET');
  medialinkreq.update('#fullcontent','none','none',0);  
  $('div[name=mediacontent'+linkid+']').fadeOut(500);

  }
}
});

$('#fullcontenthold img[name=pointleft]').on("click",function(){
var totalcount=$('#fullcontentheader input[name=gallerycount]').attr("value");
var currentview= $('#fullcontentheader input[name=currentgalleryview]').attr("value");
var galleryimgsrcsarray=new Array();
var galleryimgsizesarray=new Array();
var galleryimgsrcs=$('#fullcontentheader input[name=curgallerydata]').attr('data-images');
var galleryimgsizes=$('#fullcontentheader input[name=curgallerydata]').attr('data-sizes');
/*var galname=$('#fullcontentheader input[name=curgallerydata]').attr('data-galleryname');
galname==""||typeof(galname)=="undefined"?galname="gallerydata":galname=galname;*/
galleryimgsrcsarray=galleryimgsrcs.split(">");
galleryimgsizesarray=galleryimgsizes.split("|");
var nextview;
console.log(currentview,totalcount);
if(Math.floor(currentview)<=Math.floor(totalcount)){
nextview=Math.floor(currentview)-1;
console.log(nextview);
//nextview works in array index format meaning 0 holds a valid position
if(nextview>-1&&nextview<=totalcount){
  $('#fullcontent img[name=fullcontentwait]').show();
  $('div#fullcontent img[name=galleryimgdisplay]').attr("src","").hide();
var nextimg=galleryimgsrcsarray[nextview];
console.log(nextview,nextimg);
var cursize=galleryimgsizesarray[nextview].split(',');
var imgwidth=Math.floor(cursize[0]);
var imgheight=Math.floor(cursize[1]);
var contwidth=$('#fullcontent').width();
var contheight=$('#fullcontent').height();
contwidth=Math.floor(contwidth);
contheight=Math.floor(contheight);
var outs= new Array();
outs=produceImageFitSize(imgwidth,imgheight,960,700,"off");

$('#fullcontent img[name=galleryimgdisplay]').attr({"src":""+nextimg+"","style":""+outs['style']+""}).load(function(){
$(this).fadeIn(1000);
$('#fullcontent img[name=fullcontentwait]').hide();
});
$('#fullcontentheader input[name=currentgalleryview]').attr("value",""+nextview+"");
}
}
});

$('#fullcontentpointerright img[name=pointright]').on("click",function(){
var totalcount=Math.floor($('#fullcontentheader input[name=gallerycount]').attr("value"));
var currentview=Math.floor($('#fullcontentheader input[name=currentgalleryview]').attr("value"));
var galleryimgsrcsarray=new Array();
var galleryimgsizesarray=new Array();
var galleryimgsrcs=$('#fullcontentheader input[name=curgallerydata]').attr('data-images');
var galleryimgsizes=$('#fullcontentheader input[name=curgallerydata]').attr('data-sizes');
galleryimgsrcsarray=galleryimgsrcs.split(">");
galleryimgsizesarray=galleryimgsizes.split("|");
var nextview;
console.log($(this).attr("name"),totalcount);
if(currentview<=totalcount){
nextview=Math.floor(currentview)+1;
//nextview works in array index format meaning 0 holds a valid position
if(nextview>-1&&nextview<=totalcount){
$('#fullcontent img[name=fullcontentwait]').show();
$('div#fullcontent img[name=galleryimgdisplay]').attr("src","").hide();
$('#fullcontent img[name=galleryimgdisplay]').attr({"src":""+host_addr+"images/waiting.gif","style":"margin-top:285px;margin-left:428px;"});
var nextimg=galleryimgsrcsarray[nextview];
console.log(nextview,nextimg);
var cursize=galleryimgsizesarray[nextview].split(',');
var imgwidth=Math.floor(cursize[0]);
var imgheight=Math.floor(cursize[1]);
var contwidth=$('#fullcontent').width();
var contheight=$('#fullcontent').height();
contwidth=Math.floor(contwidth);
contheight=Math.floor(contheight);
var outs= new Array();
outs=produceImageFitSize(imgwidth,imgheight,960,700,"off");
$('#fullcontent img[name=galleryimgdisplay]').attr({"src":""+nextimg+"","style":""+outs['style']+""}).load(function(){
$('#fullcontent img[name=fullcontentwait]').hide();
$(this).fadeIn(1000);
});
$('#fullcontentheader input[name=currentgalleryview]').attr("value",""+nextview+"");
}
}

});

$(document).on("click","#contentdisplayhold table td audio",function(){
// console.log($('#contentdisplayhold table td audio'),$('#contentdisplayhold table td audio').length);
for(var i=0;i<=$('#contentdisplayhold table td audio').length;i++){
  // check if the current audio element has buffered information
  var loadtest=$('#contentdisplayhold table td audio')[i].buffered.length;
  if(loadtest==1 && $('#contentdisplayhold table td audio')[i]!==this){
    $('#contentdisplayhold table td audio')[i].pause();
    $('#contentdisplayhold table td audio')[i].currentTime = 0;
  }
}
// $(this).addClass('activeaudio');

});







$(document).on("blur","select[name=editblogcategory]",function(){
var theval=$(this).val();
console.log(theval);
if(theval!==""){
var editcatreq=new Request();
  editcatreq.generate('#contentdisplayhold',true);
  //enter the url
  var url='../snippets/display.php?displaytype=editblogcategorymain&blogtypeid='+theval+'&extraval=admin';
  editcatreq.url('../snippets/display.php?displaytype=editblogcategorymain&blogtypeid='+theval+'&extraval=admin');
  //send request
  editcatreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  editcatreq.update('div#contentdisplayhold','html','fadeIn',1000);
}else{
  
}

});
$(document).on("blur","select[name=blogtypeid]",function(){
var theid=$(this).val();
if(theid!==""){
var blogcatreq=new Request();
  blogcatreq.generate('select[name=blogcategoryid]',false);
  //enter the url
  blogcatreq.url('../snippets/display.php?displaytype=getblogcategories&blogtypeid='+theid+'&extraval=admin');
  //send request
  blogcatreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  blogcatreq.update('select[name=blogcategoryid]','html','fadeIn',1000);
}else{
  
}
});
$(document).on("click","input[name=viewblogposts]",function(){

var theid=$('select[name=blogtypeid]').val();
var secondid=$('select[name=blogcategoryid]').val();
if(theid!==""){
var blogpostreq=new Request();
  blogpostreq.generate('#contentdisplayhold',false);
  //enter the url
  blogpostreq.url('../snippets/display.php?displaytype=viewblogposts&blogtypeid='+theid+'&blogcategoryid='+secondid+'&extraval=admin');
  //send request
  blogpostreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  blogpostreq.update('div#contentdisplayhold','html','fadeIn',1000);

}else{
  
}
});
$(document).on("click","input[name=viewsubscribers]",function(){

var theid=$('select[name=blogtypeid]').val();
var secondid=$('select[name=blogcategoryid]').val();
if(theid!==""){
var blogpostreq=new Request();
  blogpostreq.generate('#contentdisplayhold',false);
  //enter the url
  blogpostreq.url('../snippets/display.php?displaytype=viewsubscribers&blogtypeid='+theid+'&blogcategoryid='+secondid+'&extraval=admin');
  //send request
  blogpostreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  blogpostreq.update('div#contentdisplayhold','html','fadeIn',1000);

}else{
  
}
});
$(document).on("click","input[name=viewadverts]",function(){
var theid=$('select[name=advertcat]').val();
// var secondid=$('select[name=blogcategoryid]').val();
if(theid!==""){
var advertscatreq=new Request();
  advertscatreq.generate('#contentdisplayhold',false);
  //enter the url
  advertscatreq.url('../snippets/display.php?displaytype=viewadverts&advertcat='+theid+'&extraval=admin');
  //send request
  advertscatreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  advertscatreq.update('div#contentdisplayhold','html','fadeIn',1000);
}else{

}
});
$(document).on("click","a[name=morecatposts]",function(){
var catid=$(this).attr("data-catid");
var nextid=$(this).attr("data-next");
if(nextid>0){
var blogcatpostreq=new Request();
  blogcatpostreq.generate('div[name=waitinghold]',true);
  //enter the url
  blogcatpostreq.url('../snippets/display.php?displaytype=viewblogposts&blogtypeid='+theid+'&blogcategoryid='+secondid+'&extraval=admin');
  //send request
  blogcatpostreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  blogcatpostreq.update('div#contentdisplayhold div:last','insertAfter','fadeIn',1000);
  
}else{
  
}
});
$(document).on("click","a[name=removecomment]",function(){
var cid=$(this).attr("data-cid");
var comremreq=new Request();
  comremreq.generate('div[name=minicommentsearchhold] div[data-id='+cid+']',false);
  //enter the url
  comremreq.url('../snippets/display.php?displaytype=removecomment&cid='+cid+'&extraval=admin');
  //send request
  comremreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  comremreq.update('div[name=minicommentsearchhold] div[data-id='+cid+']','html','',0);
  $('div[name=minicommentsearchhold] div[data-id='+cid+']').fadeOut(500); 
  console.log($('div[name=minicommentsearchhold] div[data-id='+cid+']'));
  });

$(document).on("click","td[name=trcontrolpoint] a",function(){
var linkname=$(this).attr("name");
var linkid=$(this).attr("data-divid");
console.log(linkid,linkname);
if(linkname=="disablecomment"){
$(this).attr({"name":"reactivatecomment","data-type":"reactivatecomment"}).text('Reactivate');
$("td[name=commentstatus"+linkid+"]").text("disabled");
}else if(linkname=="activatecomment"||linkname=="reactivatecomment"){
$(this).attr({"name":"disablecomment","data-type":"disablecomment"}).text('Disable');
$("td[name=commentstatus"+linkid+"]").text("active");

}else if(linkname=="editsingleservicerequest"||linkname=="editsinglebooking"){
$("td[name=servicestatus"+linkid+"]").text("active");
$("td[name=bookingstatus"+linkid+"]").text("active");
}else if(linkname=="disablesubscriber"){
  $(this).attr({"name":"activatesubscriber","data-type":"activatesubscriber"}).text('activate');
$("td[name=subscriptionstatus"+linkid+"]").text("inactive");
}else if(linkname=="activatesubscriber"){
$(this).attr({"name":"disablesubscriber","data-type":"disablesubscriber"}).text('disable');
$("td[name=subscriptionstatus"+linkid+"]").text("active");
}
});

$(document).on("click","input[type=checkbox]",function(){
var datastate=$(this).attr("data-state");
if(datastate=="off"){
$(this).attr("data-state","on");
}else{
$(this).attr("data-state","off");
}
});






$(document).on("click","#contentdisplayhold table td audio",function(){
// console.log($('#contentdisplayhold table td audio'),$('#contentdisplayhold table td audio').length);
for(var i=0;i<=$('#contentdisplayhold table td audio').length;i++){
  // check if the current audio element has buffered information
  var loadtest=$('#contentdisplayhold table td audio')[i].buffered.length;
  if(loadtest==1 && $('#contentdisplayhold table td audio')[i]!==this){
    $('#contentdisplayhold table td audio')[i].pause();
    $('#contentdisplayhold table td audio')[i].currentTime = 0;
  }
}
// $(this).addClass('activeaudio');

});

$(document).on("click","input[type=button][name=mainsearch]",function(){
var searchby=$('form[name=mainsearchform] select[name=searchby').val();
var searchval=$('form[name=mainsearchform] input[name=mainsearch').val();
if(searchby!==""&&searchval!==""){
var searchreq=new Request();
  searchreq.generate('#contentdisplayhold',true);
  //enter the url
  searchreq.url('../snippets/display.php?displaytype=mainsearch&searchby='+searchby+'&mainsearch='+searchval+'&extraval=admin');
  //send request
  searchreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  searchreq.update('div#contentdisplayhold','html','fadeIn',1000);
  
}else{
  window.alert("To use the search feature you must choose a 'Search By' option first then enter your search value next, then you can search, if any is empty you would keep seeing this.....until you follow the simple instruction.");
}
});

$(document).on("blur","select[name=blogentrytype]",function(){
  var curtype=$(this).val();
  // console.log(bcurtype);
  if(curtype=="normal"||curtype==""){
    $('#contentdisplayhold div[data-name=introparagraph]').show(300);
    $('#contentdisplayhold div[data-name=blogentry]').show(300);
    $('#contentdisplayhold div[data-name=coverphoto]').show(300);
    $('#contentdisplayhold div[data-name=coverphotofloat]').show(300);
    $('#contentdisplayhold div[data-name=bannerpicentry]').hide(300);
    $('#contentdisplayhold div[data-name=galleryentry]').hide(300);

  }else if(curtype=="gallery"){
    $('#contentdisplayhold div[data-name=introparagraph]').hide(300);
    $('#contentdisplayhold div[data-name=blogentry]').hide(300);
    $('#contentdisplayhold div[data-name=coverphoto]').hide(300);
    $('#contentdisplayhold div[data-name=coverphotofloat]').hide(300);
    $('#contentdisplayhold div[data-name=bannerpicentry]').hide(300);
    $('#contentdisplayhold div[data-name=galleryentry]').show(300);
  }else if(curtype=="banner"){
    $('#contentdisplayhold div[data-name=introparagraph]').hide(300);
    $('#contentdisplayhold div[data-name=blogentry]').hide(300);
    $('#contentdisplayhold div[data-name=coverphoto]').hide(300);
    $('#contentdisplayhold div[data-name=coverphotofloat]').hide(300);
    $('#contentdisplayhold div[data-name=bannerpicentry]').show(300);
    $('#contentdisplayhold div[data-name=galleryentry]').hide(300);
  }
});
});
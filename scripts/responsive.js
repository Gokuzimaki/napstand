var curpage=getPageName();

var windowwidth=$(window).width();

 //for responsive slider
 /*var contentslides=$('div#slidepointhold div#slidepoint').length;
 if(contentslides>0){
 var fullslidelength=windowwidth*contentslides;
 var percenttotal=100*contentslides;
 $('div#slidepointhold[data-name=homeslider]').attr("data-slides",""+contentslides+"").css("width",""+fullslidelength+"px");
	var slidelength=$('div#slidepointhold[data-name=homeslider] div#slidepoint').width();
// console.log($('div#slidepointhold[data-name=homeslider]'),percenttotal);
slideMotionResponsive('div#slidepointhold[data-name=homeslider]',"left",100,1000,20000,0);
}else{
 $('div#slidepointhold').css("display","none");
}
 $('div#slidepoint img').css("width",""+windowwidth+"px");*/
if(windowwidth<=767){
if(curpage=="index"||curpage==""){
  var elemcount=$('div#pagecarouselhold div.carouselentry').length;
  var carhold="";
  for (var i = elemcount - 1; i >= 0; i++) {
  	var curcar=$("div#pagecarouselhold div.carouselentry")[0].img.getAttribute("src");
 	carhold==""?carhold+=""+curcar:carhold+="|"+curcar;
	$("div#pagecarouselhold div.carouselentry")[0].img.setAttribute("src"," ");
	  	
  };
  $("div#pagecarouselhold").attr("appdata-centries",""+carhold+"");
}

 }
 if(windowwidth>767 && windowwidth<=1023){

 
 }
 if(windowwidth>768 && windowwidth<=902){

 }
 if(windowwidth>=903 && windowwidth<=1023){
 	if(curpage=="index"||curpage==""){
 		$("div#pagecarouselhold div.carouselentry img").load(function(){
 			var theparent=this.parent;
 			console.log(theparent);
 		});
 	}

 }
 if(windowwidth>1023){
if(curpage=="index"||curpage==""){
 		$("div#pagecarouselhold div.carouselentry img").load(function(){
 			var theparent=this.parent;
 			console.log(theparent);
 		});
 	}

 }
$(window).resize(function(){
 windowwidth=$(window).width();
 if(typeof($.mobile)=="undefined"){
  var windowheight=$(window).height();
$('div#main').css("min-height",""+windowheight+"px");
}
  //for responsive slider
 /*var contentslides=$('div#slidepointhold div#slidepoint').length;
 if(contentslides>0){
 var fullslidelength=windowwidth*contentslides;
 var percenttotal=100*contentslides;
 $('div#slidepointhold[data-name=homeslider]').attr("data-slides",""+contentslides+"").css("width",""+fullslidelength+"px");
	var slidelength=$('div#slidepointhold[data-name=homeslider] div#slidepoint').width();
// console.log($('div#slidepointhold[data-name=homeslider]'),percenttotal);
slideMotionResponsive('div#slidepointhold[data-name=homeslider]',"left",100,1000,20000,0);
}else{
 $('div#slidepointhold').css("display","none");
}
 $('div#slidepoint img').css("width",""+windowwidth+"px");*/
if(windowwidth<=767){


 }
 if(windowwidth>767 && windowwidth<=1023){

 
 }
 if(windowwidth>768 && windowwidth<=902){

 }
 if(windowwidth>=903 && windowwidth<=1023){
if(curpage=="index"||curpage==""){
 		$("div#pagecarouselhold div.carouselentry img").load(function(){
 			var theparent=this.parent;
 			console.log(theparent);
 		});
 	}


 }
 if(windowwidth>1023){
if(curpage=="index"||curpage==""){
 		$("div#pagecarouselhold div.carouselentry img").load(function(){
 			var theparent=this.parent;
 			console.log(theparent);
 		});
 	}

 }
})
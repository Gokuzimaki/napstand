tinyMCE.init({
        theme : "advanced",
        selector: "textarea#poster",
        skin:"o2k7",
        skin_variant:"black",
        width:"100%",
        external_image_list_url : "http://localhost/translynxng/snippets/mceexternalimages.php",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        content_css:"http://localhost/translynxng/stylesheets/mce.css",
        theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,pasteWord|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,preview,|insertdate,inserttime,|,spellchecker,advhr,removeformat,|,sub,sup,|,charmap,emotions",
        theme_advanced_buttons3 : "",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : true
});
tinyMCE.init({
        theme : "advanced",
        selector: "textarea#adminposter",
        skin:"o2k7",
        skin_variant:"black",
        width:"90%",
        height:"600px",
        external_image_list_url : "http://localhost/translynxng/snippets/mceexternalimages.php",
        media_external_list_url : "http://localhost/translynxng/snippets/mceexternalmedia.php",
        content_css:"http://localhost/translynxng/stylesheets/mce.css",
 plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
image_advtab: true,
                // Theme options
                theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : true
/*file_browser_callback: "openmanager",
open_manager_upload_path: '../../../../../media/multimedia/'*/
});
tinyMCE.init({
        theme : "advanced",
        selector:"textarea#postersmall",
        plugins : "autolink,advlink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        width:"80%",
        height:"300px",
        skin:"o2k7",
        skin_variant:"black",
        theme_advanced_buttons1 : "bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect,|,link,unlink,outdent,indent,|,undo,redo,|,emotions",
        content_css:"http://localhost/translynxng/stylesheets/mce.css",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",

});
tinyMCE.init({
        theme : "advanced",
        selector:"#postersmalltwo",
        plugins : "autolink,advlink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        width:"300px",
        skin:"o2k7",
        skin_variant:"black",
        theme_advanced_buttons1 : "bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect,|,link,unlink,outdent,indent,|,undo,redo,|,emotions",
        content_css:"http://localhost/translynxng/stylesheets/mce.css",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",

});
function downloadPdf(el) {
    var iframe = document.createElement("iframe");
    iframe.src = "./snippets/download.php?id=1";
    iframe.onload = function() {
        // iframe has finished loading, download has started
        el.innerHTML = "Download";
    }
    iframe.style.display = "none";
    document.body.appendChild(iframe);
}
$(document).ready(function(){

});
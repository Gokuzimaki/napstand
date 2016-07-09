<?php  
  
class Paginator{  
    var $items_per_page;  
    var $items_total;  
    var $current_page;  
    var $num_pages;  
    var $mid_range;  
    var $pagetype;
    var $low;  
    var $high;  
    var $limit;  
    var $return;  
    var $default_ipp = 15;  

    function Paginator()  
    {  
        $this->current_page = 1;  
        $this->mid_range = 15;  
        $this->items_per_page = isset($_GET['ipp'])&&(!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;  
    }  
  
    function paginate()  
    {       
        $pdataout="";   
        $params   = $_SERVER['QUERY_STRING'];
        // $params==""?$comboparam="?":($params==""$comboparam="?");
   isset($_GET['page'])?$pageget=$_GET['page']:$pageget=1;
        if(isset($_GET['ipp'])&&$_GET['ipp'] == 'All')  
        {  
            $this->num_pages = ceil($this->items_total/$this->default_ipp);  
            $this->items_per_page = $this->default_ipp;  
        }  
        else  
        {  
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;  
            $this->num_pages = ceil($this->items_total/$this->items_per_page);  
        } 
        if(!isset($_GET['ipp'])){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $params   = $_SERVER['QUERY_STRING'];
            $params==""?$comboparam="":$comboparam="?";
             $comboparam=="?"?$exitparam="&":$exitparam="?";
            $currentUrl = $protocol . '://' . $host . $script . $comboparam . $params . $exitparam;
            $pdataout=$currentUrl;
        }else{
            $dat=explode("&page",$_SERVER['QUERY_STRING']);
            $dat2=explode("?page",$_SERVER['REQUEST_URI']);
                // echo $_SERVER['REQUEST_URI'];
            if(isset($dat[1])&&$dat[1]!==""){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat[0];
            $pdataout=$protocol . '://' . $host . $script."?".$pdataout."&";
                // echo $pdataout;
            }else if($dat2[1]!==""){
                $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat2[0];
            $pdataout=$protocol . '://' . $host . $script."?";
            }else{
                echo "oh no";
            }
            
        }  
        $this->current_page = (int) $pageget; // must be numeric > 0  
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;  
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;  
        $prev_page = $this->current_page-1;  
        $next_page = $this->current_page+1;  
  
        if($this->num_pages > 10)  
        {  
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"\" href=\"".$pdataout."page=$prev_page&ipp=$this->items_per_page\">« Previous</a> ":"<span class=\"disabled\" href=\"#\">« Previous</span> ";  
  
            $this->start_range = $this->current_page - floor($this->mid_range/2);  
            $this->end_range = $this->current_page + floor($this->mid_range/2);  
  
            if($this->start_range <= 0)  
            {  
                $this->end_range += abs($this->start_range)+1;  
                $this->start_range = 1;  
            }  
            if($this->end_range > $this->num_pages)  
            {  
                $this->start_range -= $this->end_range-$this->num_pages;  
                $this->end_range = $this->num_pages;  
            }  
            $this->range = range($this->start_range,$this->end_range);  
  
            for($i=1;$i<=$this->num_pages;$i++)  
            {  
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";  
                // loop through all pages. if first, last, or in range, display  
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))  
                {  
                    $this->return .= ($i == $this->current_page And $pageget != 'All') ? "<span class=\"current\">$i</span> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"".$pdataout."page=$i&ipp=$this->items_per_page\">$i</a> ";  
                }  
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";  
            }  
//edit the out put here
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($pageget != 'All')) ? "<a class=\"\" href=\"".$pdataout."page=$next_page&ipp=$this->items_per_page\">Next »</a>\n":"<span class=\"disabled\" href=\"#\">» Next</span>\n";  
            $this->return .= ($pageget == 'All') ? "<span class=\"current\" style=\"\">All</span> \n":"<a class=\"paginate\" style=\"\" href=\"".$pdataout."page=1&ipp=All\">All</a> \n";  
        }  
        else  
        {  
            for($i=1;$i<=$this->num_pages;$i++)  
            {  
                $this->return .= ($i == $this->current_page) ? "<span class=\"current\">$i</span> ":"<a class=\"\" href=\"".$pdataout."page=$i&ipp=$this->items_per_page\">$i</a> ";  
            }  
            $this->return .= "<a class=\"\" href=\"".$pdataout."page=1&ipp=All\">All</a> \n";  
        }  
        $this->low = ($this->current_page-1) * $this->items_per_page;  
        $this->high =isset($_GET['ipp'])&& ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;  
        $this->limit = isset($_GET['ipp'])&&($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";  
    }  
    //for javascript
    function paginatejavascript()  
    {  
   isset($_GET['page'])?$pageget=$_GET['page']:$pageget=1;
        if(isset($_GET['ipp'])&&$_GET['ipp'] == 'All')  
        {  
            $this->num_pages = ceil($this->items_total/$this->default_ipp);  
            $this->items_per_page = $this->default_ipp;  
        }  
        else  
        {  
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;  
            $this->num_pages = ceil($this->items_total/$this->items_per_page);  
        }  
        $this->current_page = (int) $pageget; // must be numeric > 0  
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;  
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;  
        $prev_page = $this->current_page-1;  
        $next_page = $this->current_page+1;  
  
        if($this->num_pages > 10)  
        {  
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"\" href=\"##\" data-page=\"$prev_page\" data-ipp=\"$this->items_per_page\">« Previous</a> ":"<span class=\"disabled\" href=\"#\">« Previous</span> ";  
  
            $this->start_range = $this->current_page - floor($this->mid_range/2);  
            $this->end_range = $this->current_page + floor($this->mid_range/2);  
  
            if($this->start_range <= 0)  
            {  
                $this->end_range += abs($this->start_range)+1;  
                $this->start_range = 1;  
            }  
            if($this->end_range > $this->num_pages)  
            {  
                $this->start_range -= $this->end_range-$this->num_pages;  
                $this->end_range = $this->num_pages;  
            }  
            $this->range = range($this->start_range,$this->end_range);  
  
            for($i=1;$i<=$this->num_pages;$i++)  
            {  
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";  
                // loop through all pages. if first, last, or in range, display  
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))  
                {  
                    $this->return .= ($i == $this->current_page And $pageget != 'All') ? "<span class=\"current\">$i</span> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" data-name=\"paginationpage\"href=\"##\" data-page=\"$i\" data-ipp=\"$this->items_per_page\">$i</a> ";  
                }  
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";  
            }  
//edit the out put here
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($pageget != 'All')) ? "<a class=\"\" href=\"##\" data-ipp=\"$this->items_per_page\" data-page=\"$next_page\" data-name=\"paginationnext\">Next »</a>\n":"<span class=\"disabled\" href=\"#\">» Next</span>\n";  
            $this->return .= ($pageget == 'All') ? "<a class=\"current\" data-name=\"paginationpage\" href=\"##\" data-name=\"paginationall\" data-page=\"1\" data-ipp=\"All\"style=\"\">All</a> \n":"<a class=\"paginate\" style=\"\" href=\"##All\" data-name=\"paginationall\" data-page=\"1\" data-ipp=\"All\">All</a> \n";  
        }  
        else  
        {  
            for($i=1;$i<=$this->num_pages;$i++)  
            {  
                $this->return .= ($i == $this->current_page) ? "<a class=\"current\" data-name=\"paginationpage\" href=\"##\" data-page=\"$i\" data-ipp=\"$this->items_per_page\">$i</a> ":"<a class=\"paginate\" data-name=\"paginationpage\" href=\"##\" data-page=\"$i\" data-ipp=\"$this->items_per_page\">$i</a> ";  
            }  
            $this->return .= "<a class=\"\" data-name=\"paginationpage\"href=\"##\" data-page=\"1\" data-ipp=\"All\">All</a> \n";  
        }  
        $this->low = ($this->current_page-1) * $this->items_per_page;  
        $this->high =isset($_GET['ipp'])&& ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;  
        $this->limit = isset($_GET['ipp'])&&($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";  
    }
    function display_items_per_page()  
    {  
        $pdataout="";
        if(!isset($_GET['ipp'])){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $params   = $_SERVER['QUERY_STRING'];
            $params==""?$comboparam="":$comboparam="?";
             $comboparam=="?"?$exitparam="&":$exitparam="?";
            $currentUrl = $protocol . '://' . $host . $script . $comboparam . $params . $exitparam;
            $pdataout=$currentUrl;
        }else{
            $dat=explode("&page",$_SERVER['QUERY_STRING']);
            $dat2=explode("?page",$_SERVER['REQUEST_URI']);
                // echo $_SERVER['REQUEST_URI'];
            if(isset($dat[1])&&$dat[1]!==""){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat[0];
            $pdataout=$protocol . '://' . $host . $script."?".$pdataout."&";
                // echo $pdataout;
            }else if($dat2[1]!==""){
                $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat2[0];
            $pdataout=$protocol . '://' . $host . $script."?";
            }else{
                echo "oh no";
            }
            
        } 
        $items = '';  
        $ipp_array = array(15,25,40,60,'All');  
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";  
        return "<span class=\"disabled\">Entries per page:</span>&nbsp;<select class=\"paginationselect\" onchange=\"window.location='".$pdataout."page=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";  
    }  
    // Javascript equivalent of function
  function display_items_per_page_javascript()  
    {  
        $items = '';  
        $ipp_array = array(15,25,40,60,'All');  
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";  
        return "<span class=\"disabled\">Entries per page:</span>&nbsp;<select class=\"paginationselect\" title=\"Choose a number then click elsewhere to load\" name=\"entriesperpage\">$items</select>\n";  
    }
    function display_jump_menu()  
    {  
        $pdataout="";
        
        if(!isset($_GET['ipp'])){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $params   = $_SERVER['QUERY_STRING'];
            $params==""?$comboparam="":$comboparam="?";
             $comboparam=="?"?$exitparam="&":$exitparam="?";
            $currentUrl = $protocol . '://' . $host . $script . $comboparam . $params . $exitparam;
            $pdataout=$currentUrl;
        }else{
            $dat=explode("&page",$_SERVER['QUERY_STRING']);
            $dat2=explode("?page",$_SERVER['REQUEST_URI']);
                // echo $_SERVER['REQUEST_URI'];
            if(isset($dat[1])&&$dat[1]!==""){
            $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat[0];
            $pdataout=$protocol . '://' . $host . $script."?".$pdataout."&";
                // echo $pdataout;
            }else if($dat2[1]!==""){
                $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
            $host     = $_SERVER['HTTP_HOST'];
            $script   = $_SERVER['SCRIPT_NAME'];
            $pdataout=$dat2[0];
            $pdataout=$protocol . '://' . $host . $script."?";
            }else{
                echo "oh no";
            }
            
        } 
        $option="";
        for($i=1;$i<=$this->num_pages;$i++)  
        {  
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";  
        }  
        return "<span class=\"disabled\">Current Page:</span>&nbsp;<select class=\"paginationselect\" onchange=\"window.location='".$pdataout."page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";  
    }  
    function display_jump_menu_javascript()  
    {  
        $option="";
        for($i=1;$i<=$this->num_pages;$i++)  
        {  
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";  
        }  
        return "<span class=\"disabled\">Current Page:</span>&nbsp;<select class=\"paginationselect\" data-ipp=\"$this->items_per_page\" name=\"jumpmenu\">$option</select>\n";  
    }   
    function display_pages()  
    {  
        return $this->return;  
    }  
}  
?>  
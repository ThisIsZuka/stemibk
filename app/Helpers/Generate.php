<?php 


    //Show Date with user timezone
    function create_form($val)
    {
        $txt = "<form action=''>\n";
        $i = 0;
        foreach($val[0] as $m =>$a){
            $txt.= "<input type='text' id='".$m."' name='".$m."' placeholder='".$m."'><br>\n";
        }
        $txt.= "</form>\n";
        return $txt;
    }

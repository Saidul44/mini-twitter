<?php

    function dayBefore($date) {

        $today =  new \DateTime();

        $calculatedDate = new \DateTime($date);
        
        $diff = $today->diff($calculatedDate);

        $formatedDate = '';

        if($diff->format('%y') > 0) {
            $formatedDate .= ' '.$diff->format('%y')."Y";
        }

        if($diff->format('%m') > 0) {
            $formatedDate .= ' '.$diff->format('%m')."M";
        }

        if($diff->format('%d') > 0) {
            $formatedDate .= ' '.$diff->format('%d')."d";
        }
        
        if($diff->format('%h') > 0) {
            $formatedDate .= ' '.$diff->format('%h')."h";
        }
        
        if($diff->format('%i') > 0) {
            $formatedDate .= ' '.$diff->format('%i')."m";
        }

        return ($formatedDate == '') ? 'now' : $formatedDate;
                
    }


?>
<?php

function is_acute($initial) {
    // labials (p, b, m), velars (k, g, ng), and laryngeals (', h, x) are not acute.
    if (preg_match("/^p|b|m|k|g|ng|'|h|x/", $initial) == 1) {
        return false;
    }
    return true;
}

function prettify($mc) {
    $patterns = array('/ae/', '/ea/', '/\+/', "/'/");
    $replacements = array('æ', 'ɛ', 'ɨ', 'ʔ');
    $mc = preg_replace($patterns, $replacements, $mc); 
    return $mc;
}

function join_initial_final($initial, $final, $tone = 1, $chongniu = 1) {
    // takes a well-formed MC initial and MC final in Baxter's 
    // (1992) notation, and
    // returns the full syllable correctly spelled.
    
    $mc = $initial;
    
    // remove j from final if initial ends in y.
    if (strpos($initial, 'y') !== FALSE && substr($final, 0, 1) == 'j') {
        $final = substr($final, 1);
    }
    
    // merge chongniu finals when initial not grave
    // jie > je, jwie > jwe, ji > i, jwi > wi (transform in that order)
    if (is_acute($initial) && ($chongniu == 3 || $chongniu == 4)) {
        $chongniu = 0;
        $patterns = array('/jie/', '/jwie/', '/ji/', '/jwi/');
        $replacements = array('je', 'jwe', 'i', 'wi');
        $final = preg_replace($patterns, $replacements, $final);
    } 
    
    $mc .= $final;
    
    // add tone
    if ($tone == 2) {
        $mc .= 'X';
    }
    else if ($tone == 3) {
        $mc .= 'H';
    }
    
    if ($chongniu == 3) {
        $mc .= ' (III)';
    }
    else if ($chongniu == 4) {
        $mc .= ' (IV)';
    }
    
    return $mc;
}
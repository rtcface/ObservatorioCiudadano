<?php

function clean_utf(string $string): string {
    $s = (string) $string;
    $len = \strlen($s);
 
    for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
        switch ($s[$i] & "\xF0") {
            case "\xC0":
            case "\xD0":
                $c = (\ord($s[$i] & "\x1F") << 6) | \ord($s[++$i] & "\x3F");
                $s[$j] = $c < 256 ? \chr($c) : '?';
                break;
 
            case "\xF0":
                ++$i;
                // no break
 
            case "\xE0":
                $s[$j] = '?';
                $i += 2;
                break;
 
            default:
                $s[$j] = $s[$i];
        }
    }
 
    return substr($s, 0, $j);
 }

 function iso8859_1_to_utf8(string $s): string {
    $s .= $s;
    $len = \strlen($s);

    for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
        switch (true) {
            case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
            case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
            default: $s[$j] = "\xC3"; $s[++$j] = \chr(\ord($s[$i]) - 64); break;
        }
    }

    return substr($s, 0, $j);
}
?>
<?php
function determine_state_SAD ( $IDADE, $GENERO, $PH, $TEMPERAT, $CONDUTIVIDADE, $ODOR, $VISUAL) {
    /*Terminal Node 1*/
    if (($ODOR == 1) && $PH <= 4.5) {
        $terminalNode = -1;
        $class = 3;
    }

    /*Terminal Node 2*/
    if (($VISUAL == 1) && ($ODOR == 1) && $PH > 4.5 && $PH <= 8.5 && $IDADE <= 48.5) {
        $terminalNode = -2;
        $class = 3;
    }

    /*Terminal Node 3*/
    if (($VISUAL == 1) && ($ODOR == 1) && $PH > 4.5 && $PH <= 8.5 && $IDADE > 48.5) {
        $terminalNode = -3;
        $class = 2;
    }

    /*Terminal Node 4*/
    if (($VISUAL == 0) && ($ODOR == 1) && $PH > 4.5 && $PH <= 8.5 && $TEMPERAT <= 37.5) {
        $terminalNode = -4;
        $class = 1;
    }

    /*Terminal Node 5*/
    if (($VISUAL == 0) && ($ODOR == 1) && $PH > 4.5 && $PH <= 8.5 && $TEMPERAT > 37.5) {
        $terminalNode = -5;
        $class = 2;
    }

    /*Terminal Node 6*/
    if (($ODOR == 1) && $PH > 8.5) {
        $terminalNode = -6;
        $class = 3;
    }

    /*Terminal Node 7*/
    if (($VISUAL == 1) && ($ODOR == 0) && $PH <= 8.5 && $TEMPERAT <= 34.5) {
        $terminalNode = -7;
        $class = 2;
    }

    /*Terminal Node 8*/
    if (($VISUAL == 1) && ($ODOR == 0) && $PH <= 8.5 && $TEMPERAT > 34.5 && $TEMPERAT <= 37.5) {
        $terminalNode = -8;
        $class = 1;
    }

    /*Terminal Node 9*/
    if (($VISUAL == 1) && ($ODOR == 0) && $PH <= 8.5 && $TEMPERAT > 37.5) {
        $terminalNode = -9;
        $class = 2;
    }

    /*Terminal Node 10*/
    if (($VISUAL == 1) && ($ODOR == 0) && $PH > 8.5 && $TEMPERAT <= 37.5) {
        $terminalNode = -10;
        $class = 2;
    }

    /*Terminal Node 11*/
    if (($VISUAL == 1) && ($ODOR == 0) && $PH > 8.5 && $TEMPERAT > 37.5) {
        $terminalNode = -11;
        $class = 3;
    }

    /*Terminal Node 12*/
    if (($VISUAL == 0) && ($ODOR == 0) && $PH <= 8.5) {
        $terminalNode = -12;
        $class = 1;
    }

    /*Terminal Node 13*/
    if (($VISUAL == 0) && ($ODOR == 0) && $PH > 8.5 && $TEMPERAT <= 34.5) {
        $terminalNode = -13;
        $class = 2;
    }

    /*Terminal Node 14*/
    if (($VISUAL == 0) && ($ODOR == 0) && $PH > 8.5 && $TEMPERAT > 34.5 && $TEMPERAT <= 37.5) {
        $terminalNode = -14;
        $class = 1;
    }

    /*Terminal Node 15*/
    if (($VISUAL == 0) && ($ODOR == 0) && $PH > 8.5 && $TEMPERAT > 37.5) {
        $terminalNode = -15;
        $class = 2;
    }
    return $class;
}
?>



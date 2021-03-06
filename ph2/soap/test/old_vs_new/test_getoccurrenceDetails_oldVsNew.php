<?php
/**
 * Created by PhpStorm.
 * User: ckuehne
 * Date: 05.09.15
 * Time: 19:55
 */

// run relative to parent dir
require_once('ph2deafel_old.php');
require_once('testhelpers_oldVsnew.php');

chdir('../..');
require_once('ph2deafel.php');

$success = true;


function compare_getOccurrenceDetails($lemma, $withContext) {
    echo "compare occs for lemma '$lemma' withContext="; echo $withContext ? "true\n" : "false\n";

    $occurrenceIds = getOccurrenceIDs(null, $lemma);

    foreach ($occurrenceIds as $occurrenceId) {
        $occsOld = getOccurrenceDetailsOld($occurrenceId, $withContext);
        $occsNew = getOccurrenceDetails($occurrenceId, $withContext);

        if (!compareOccs($occsOld, $occsNew)) {
            return false;
        }
    }
    return true;
}

// mb_substr() operation in ph2_ccurrence_old.class to work correctly (with utf-8)
mb_internal_encoding("UTF-8");

//$lemma = 'avoir';
$lemma = 'bien';
if(!compare_getOccurrenceDetails($lemma, false))
    return;
if(!compare_getOccurrenceDetails($lemma, true))
    return;

if ($success) {
    echo "Success! \n";
}


?>
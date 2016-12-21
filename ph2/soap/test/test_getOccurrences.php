<?php
/**
 * Created by PhpStorm.
 * User: ckuehne
 * Date: 05.09.15
 * Time: 19:55
 */

require_once('testhelpers.php');
// run relative to grand parent dir
chdir('..');
require_once('ph2deafel.php');

// Set our assert options
assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_WARNING, true);


//$lemma = 'avoir'; // many occs
$lemma = 'tab%';
$mainLemma = "";
$withContext = true;


try {
    // this should throw an exception if there are more than MAX_OCCS (p2deafel.php) lemmatized occurrences in the db
    getOccurrences("%", "%", $withContext);
    echo "\nFailed to throw exception";
} catch (Exception $e) {
    echo $e->getMessage();
}

$occs = getOccurrences($mainLemma, $lemma, $withContext);

// just a basic check
assert(count($occs) > 20);

echo "\nTest done. Success!\n";

?>
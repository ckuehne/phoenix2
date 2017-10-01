<?php

require_once 'abstract_api.php';

require_once('../soap/ph2deafel.php');

class MyAPI extends API {
    public function __construct($request, $origin) {
        parent::__construct($request);
    }

    protected function occurrenceIDs() {
        $mainLemma = $_GET["mainLemma"];
        $lemma = $_GET["lemma"];
        if ($this->method === 'GET') {
            return array(getOccurrenceIDs($mainLemma, $lemma), 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function occurrences() {
        $mainLemma = $_GET["mainLemma"];
        $lemma = $_GET["lemma"];
        $withContext = filter_var($_GET["withContext"], FILTER_VALIDATE_BOOLEAN);
        if ($this->method === 'GET') {
            $occs = getOccurrences ($mainLemma, $lemma, $withContext);
            return array($occs, 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function occurrence() {
        $occurrenceID = $_GET["occurrenceID"];
        $withContext = filter_var($_GET["withContext"], FILTER_VALIDATE_BOOLEAN);
        if ($this->method === 'GET' && ! empty($occurrenceID)) {
            $occs = getOccurrenceDetails($occurrenceID, $withContext);
            return array($occs, 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function allLemmata() {
        if ($this->method === 'GET') {
            return array(getAllLemmata(), 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function numberOfOccurrenceChunks() {
        $mainLemma = $_GET["mainLemma"];
        $lemma = $_GET["lemma"];
        if ($this->method === 'GET') {
            return array(getNumberOfOccurrenceChunks($mainLemma, $lemma), 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function occurrencesChunk() {
        $mainLemma = $_GET["mainLemma"];
        $lemma = $_GET["lemma"];
        $withContext = filter_var($_GET["withContext"], FILTER_VALIDATE_BOOLEAN);
        $chunk = $_GET["chunk"];
        if ($this->method === 'GET') {
            $occs = getOccurrencesChunk($mainLemma, $lemma, $withContext, $chunk);
            return array($occs, 200);
        } else {
            throw new Exception("GET request expected.");
        }
    }

    protected function assignOccurrencesToLemma() {

        $d = $this->retrieveJsonPostDataAsArray();
        $newMainLemmaIdentifier = $d['newMainLemmaIdentifier'];
        $newLemmaIdentifier = $d['newLemmaIdentifier'];
        $occurrenceIDs = $d['occurrenceIDs'];

        if ($this->method === 'POST' && !empty($newMainLemmaIdentifier) && !empty($newLemmaIdentifier)) {

            try {
                $result = assignOccurrencesToLemma($occurrenceIDs, $newMainLemmaIdentifier, $newLemmaIdentifier);
            } catch (Exception $e) {
                // this will occurr when new lemma is not unique -> error on phoenix2 side
                return array($e->getMessage(), 500);
            }

            return array($result, 200);
        } else {
            throw new Exception("invalid request");
        }
    }

    private function retrieveJsonPostDataAsArray() {
        // get the raw POST data
        $rawData = file_get_contents("php://input");

        // this returns null if not valid json
        return json_decode($rawData, true);
    }
}

?>
<?php

require __DIR__ . '/../../src/dbConnection.php';
require __DIR__ . '/../event/upsert.php';
require __DIR__ . '/../employee/create.php';
require __DIR__ . '/../participation/upsert.php';

const PARTITION_OF_JSONDATA = 2;

/**
 * @param $conn
 */
function getJsonData($conn)
{
    $data = file_get_contents(PUBLIC_PATH . "code.json");
    $data = json_decode($data, true);
    setData($conn, $data);
}

getJsonData($conn);

/**
 * @param $conn
 * @param $data
 */
function setData($conn, $data)
{
    if (count($data) > PARTITION_OF_JSONDATA) {
        //if the count of data passed is more then 50(set in Constant)
        //it divides itself into a subset and flushes on every 50
        $pointer = 0;
        do {
            $dataofFiftySet = [];
            for ($i = $pointer; $i < ($pointer + PARTITION_OF_JSONDATA); $i++) {
                $dataofFiftySet[] = $data[$i];
            }
            insertDatabaseBulk($conn, $dataofFiftySet);
            $pointer += 2;
        } while (count($data) > $pointer);
    } else {
        //flushes if there are less then 50 records
        insertDatabaseBulk($conn, $data);
    }
}


/**
 * @param $conn
 * @param $data
 */
function insertDatabaseBulk($conn, $data)
{
    $events = insertEmployee($conn, $data);
    upsertEvent($conn, $events['event']);
    upsertParticipation($conn, $data);
}

<?php

    $csv =array_map('str_getcsv', file('us-states.csv'));
    array_shift($csv);

    // make our headers row so we can index off of them
    // then... for every date, initialize an array of that size with the date as the first entry...
    // and 0 for every other entry
    // then for every state at that date, find the index of the matching state name, and insert the value at that point in the array
    // merge the array into the data array

    // need to collect the data by date ...
    // make an array associated by date with all states nested
    // like...
    // [
        // 2020-01-21 => [
        //      Washington => 53,
        // ],
        // 2020-01-22 => [
        //      Washington => 53,
        // ],
        // 2020-01-23 => [
        //      Washington => 53,
        // ],
        // 2020-01-24 => [
        //      Washington => 53,
        //      Illinois => 17,
        // ]
    // ]

    $states = array();
    $associated_data = array();
    foreach ($csv as $entry) {
        $date = $entry[0];
        $state = $entry[1];
        $cases = $entry[3];
        if (!in_array($state, $states)) {
            array_push($states, $state);
        }
        if (!$associated_data[$date]) {
            $associated_data[$date] = array();
        }
        $associated_data[$date][$state] = $cases;

    }

    $final_data = array();

    foreach ($associated_data as $date => $states_array) {
        $entry = array();
        $entry["date"] = $date;
        foreach ($states as $state) {
            if (array_key_exists($state, $states_array)) {
                $entry[$state] = (int)$states_array[$state];
            } else {
                $entry[$state] = 0;
            }
        }
        // now have an array with an entry for each state
        array_push($final_data, $entry);
    }

    // for each item in the array...
    // then loop through the states and check if you can find it in the values
    // if you find it, put the number
    // if not, put 0
    // turn it into an object
    // push it into the big array

//    $column_headers = array_merge(["date"], $states);
//    $final_data = [$column_headers];
//    foreach ($associated_data as $date => $states) {
//        $entry = array_fill(0,sizeof($column_headers),0);
//        $entry[0] = $date;
//        foreach ($states as $name => $cases) {
//            $index = array_search($name, $column_headers);
//            if ($index) {
//                array_splice($entry, $index, 1, (int)$cases);
//            } else {
//                array_splice($entry, $index, 1, 0);
//            }
//        }
//        array_push($final_data, $entry);
//    };
//
//    var_dump($final_data[67]);
//
    var_dump(json_encode($final_data));

//    print_r($csv[20]);

    // transform data and then turn into json
?>
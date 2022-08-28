<?php
    require_once("dbcon.php");

    $text = file_get_contents($_POST["sourceurl"]);
    $text = preg_replace('/[^a-z0-9]+/i', ' ', $text);
    $words = explode(" " , $text);
    $wordarray = [];

    foreach($words as $word)
    {
        $word = strtoupper($word);
        array_push($wordarray, $word);
    }

    $totalwords = count($wordarray);

    $insert = $db->prepare("INSERT INTO source(source_name , source_url , source_begin , source_end , total_words) VALUES(? , ? , ? , ? , ?)");
    $insert->bind_param("ssssi" , $_POST["sourcename"] , $_POST["sourceurl"] , $_POST["sourcebegin"] , $_POST["sourceend"] , $totalwords);

    $insert->execute();
    $sourceid = $insert->insert_id;

    if($_POST["sourcebegin"] == "" && $_POST["sourceend"] == "")
    {
        foreach($words as $word)
        {
            $frequency[$word] = 0;
        }

        foreach($wordarray as $word)
        {
            $frequency[$word]++;
        }

        // $insert = $db->prepare("INSERT INTO occurrence(source_id , word , freq) VALUES(? , ? , ?)");
        // foreach($frequency as $key=>$value)
        // {
        //     $insert->bind_param("isi" , $sourceid , $key , $value);
        //     $insert->execute();
        // }
    }
    
    if($_POST["sourcebegin"] != "" && $_POST["sourceend"] != "")
    {
        $beginindex = array_search(strtoupper($_POST["sourcebegin"]) , $wordarray);
        $endindex = $totalwords - (array_search(strtoupper($_POST["sourceend"]) , array_reverse($wordarray))) - 1;
        $totalwords = $endindex + 1 - $beginindex;
        echo $totalwords;

        $update = "UPDATE source SET total_words = {$totalwords} WHERE source_id = {$sourceid}";
        $db->query($update);

        for($i=$beginindex; $i<=$endindex; $i++)
        {
            $frequency[$wordarray[$i]] = 0;
        }

        for($i=$beginindex; $i<=$endindex; $i++)
        {
            $frequency[$wordarray[$i]]++;
        }

        $insert = $db->prepare("INSERT INTO occurrence(source_id , word , freq) VALUES(? , ? , ?)");
        foreach($frequency as $key=>$value)
        {
            $insert->bind_param("isi" , $sourceid , $key , $value);
            $insert->execute();
        }
    }
?>
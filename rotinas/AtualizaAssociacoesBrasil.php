<?php

    require('../Conexao.php');
    $con = new Conexao();
        
    define("YOUR_API_KEY","AIzaSyCa2kVlAhgKAjajbdQv7Tvgsz_vhpnTWcY");
    $query = urlencode("proteção veicular bh");
    $pagetoken = "";

    while(true)
    {
        $url ="https://maps.googleapis.com/maps/api/place/textsearch/json?query=".$query."&key=".YOUR_API_KEY."&pagetoken=".$pagetoken;
        echo $url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        var_dump($response_a);
        $pagetoken = $response_a->next_page_token;

        foreach($response_a->results as $associacao)
        {
            $url ="https://maps.googleapis.com/maps/api/place/details/json?place_id=".$associacao->place_id."&key=".YOUR_API_KEY;
            echo $url;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_b = json_decode($response);
            var_dump($response_b);
            var_dump($response_b->result->website);//exit;
            var_dump($response_b->result->place_id);//exit;

            var_dump($con->exec_query("INSERT INTO ASSOCIACOES (SITE,PLACE_ID) VALUES ('".$response_b->result->website."', '".$response_b->result->place_id."')"));    
        }
        
        sleep(5);
    }

?>
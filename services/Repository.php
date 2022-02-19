<?php
namespace app\services;


 class Repository {

    
     /*
    *   Function to list the most popular repositories sorted by number of stars
    *   @params string $sort is the sort type by default will be stars
    *   @params as get
    *   @return SUCCESS - array of json (most popular repositories)
    *   @return ERROR   - array of error code
    */
    public function getRepoData($sort='stars',$search_query,$order='desc'){

  
        $url = "https://api.github.com/search/repositories?q=".$search_query."&sort=".$sort."&order=".$order;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
              "Accept: application/vnd.github.v3+json",
              "Content-Type: text/plain",
              "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        if($result !=false){
            $response =['code'=>200,'message'=>'Data retrieved successfully','data'=>json_decode($result)];
        }else{
            $response =['code'=>404,'message'=>'Failed to fetch data'];

        }
        return $response ;
    }

}
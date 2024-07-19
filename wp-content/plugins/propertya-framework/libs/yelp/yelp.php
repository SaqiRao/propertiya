<?php

/**
 * Yelp Fusion API code sample.
 *
 * This program demonstrates the capability of the Yelp Fusion API
 * by using the Business Search API to query for businesses by a 
 * search term and location, and the Business API to query additional 
 * information about the top result from the search query.
 * 
 * Please refer to http://www.yelp.com/developers/v3/documentation 
 * for the API documentation.
 * 
 * Sample usage of the program:
 * `php sample.php --term="dinner" --location="San Francisco, CA"`
 */

// API key placeholders that must be filled in by users.
// You can find it on
// https://www.yelp.com/developers/v3/manage_app
$API_KEY = NULL;

// Complain if credentials haven't been filled out.
//assert($API_KEY, "Please supply your API key.");

// API constants, you shouldn't have to change these.
$API_HOST = "https://api.yelp.com";
$SEARCH_PATH = "/v3/businesses/search";
$BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.

// Defaults for our simple example.
$DEFAULT_TERM = "dinner";
$DEFAULT_LOCATION = "San Francisco, CA";
$SEARCH_LIMIT = 3;


/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the API after the domain.
 * @param    $url_params    Array of query-string parameters.
 * @return   The JSON response from the request      
 */
function request($host, $path, $url_params = array()) {
    // Send Yelp API Call
	if(!empty(propertya_framework_get_options('prop_yelp_api_secret')))
	{
		$api_sec = '';
		$api_sec = propertya_framework_get_options('prop_yelp_api_secret');
		try {
			$curl = curl_init();
			if (FALSE === $curl)
				throw new Exception('Failed to initialize');
	
			$url = $host . $path . "?" . http_build_query($url_params);
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,  // Capture response.
				CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"authorization: Bearer " . $api_sec,
					"cache-control: no-cache",
				),
			));
	
			$response = curl_exec($curl);
	
			if (FALSE === $response)
				throw new Exception(curl_error($curl), curl_errno($curl));
			$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if (200 != $http_status)
				throw new Exception($response, $http_status);
	
			curl_close($curl);
		} catch(Exception $e) {
			
			echo "<div class='alert custom-alert custom-alert--warning' role='alert'>
			  <div class='custom-alert__top-side'>
				<div class='custom-alert__body'>
				  <h6 class='custom-alert__heading'>
					 ".esc_html__('Whoops!.', 'propertya-framework')."
				  </h6>
				  <div class='custom-alert__content'>
					".$e->getMessage()."
				  </div>
				</div>
			  </div>
			</div>";
		}
		
		// echo 'Something went wrong please try again later';
        /*trigger_error(sprintf(
            'Curl failed with error #%d: %s',
			
            $e->getCode(), $e->getMessage()),$e->getMessage())*/;
    

    return $response;
	}
}

/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $latt,$long) {
	$limit = 3;
	if(!empty(propertya_framework_get_options('prop_yelp_result_limit')))
	{
		$limit = propertya_framework_get_options('prop_yelp_result_limit');
	}
    $url_params = array();
    $url_params['term'] = $term;
    //$url_params['location'] = $location;
	$url_params['latitude'] = $latt;
	$url_params['longitude'] = $long;
    $url_params['limit'] = $limit;
    return request('https://api.yelp.com', '/v3/businesses/search', $url_params);
}

/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = '/v3/businesses/' . urlencode($business_id);
    
    return request("https://api.yelp.com", $business_path);
}

/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
if(!empty(propertya_framework_get_options('prop_yelp_api_secret')))
{ 
	function query_api($term, $latt,$long) {     
		$response = json_decode(search($term, $latt,$long));
		if(isset($response->businesses[0]->id) && $response->businesses[0]->id !="")
		{
			$business_id = $response->businesses[0]->id;
		}
		return  $response;
	}
}

/**
 * User input is handled here 
 */
/*$longopts  = array(
    "term:: ",
    "location::",
);

    
$options = getopt("", $longopts);

$term = 'realestate';
$latt = '33.9691483';
$long = '-118.24548950000002';
//$location = 'San Francisco, CA'; 

echo '<pre>'. query_api($term, $latt,$long).'</pre>';*/

?>

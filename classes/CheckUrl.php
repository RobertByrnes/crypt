<?php

 /**
 * @author Robert Byrnes
 * @created 06/02/2021
 * @example cmd_url.php call this file from cmd with --help to view arguments to execute this class from cmd
 **/


Class CheckURL
{
    /**
     * HTTP response codes array
     * @var array
     */
    protected $responseCodes = array(
        'informational' => array(
            '100' => "Continue",
            '101' => "Switching Protocols",
        ),
        'successful' => array(
            '200' => "OK",
            '201' => "Created",
            '202' => "Accepted",
            '203' => "Non-Authoritative Information",
            '204' => "No Content",
            '205' => "Reset Content",
            '206' => "Partial Content",
        ),
        'redirectional' => array (
            '300' => "Multiple Choices",
            '301' => "Moved Permanently",
            '302' => "Found",
            '303' => "See Other",
            '304' => "Not Modified",
            '305' => "Use Proxy",
            '306' => "(Unused)",
            '307' => "Temporary Redirect",
        ),
        'ClientError' => array (
            '400' => "Bad Request",
            '401' => "Unauthorized",
            '402' => "Payment Required",
            '403' => "Forbidden",
            '404' => "Not Found",
            '405' => "Method Not Allowed",
            '406' => "Not Acceptable",
            '407' => "Proxy Authentication Required",
            '408' => "Request Timeout",
            '409' => "Conflict",
            '410' => "Gone",
            '411' => "Length Required",
            '412' => "Precondition Failed",
            '413' => "Request Entity Too Large",
            '414' => "Request-URI Too Long",
            '415' => "Unsupported Media Type",
            '416' => "Requested Range Not Satisfiable",
            '417' => "Expectation Failed",     
        ),
        'ServerError' => array(
            '500' => "Internal Server Error",
            '501' => "Not Implemented",
            '502' => "Bad Gateway",
            '503' => "Service Unavailable",
            '504' => "Gateway Timeout",
            '505' => "HTTP Version Not Supported",
        )
    );


    /**
     * SSL certificate info codes array
     * @var array
     */
    protected $SSLstatus = array(
        '0' => 'ok the operation was successful',
        '2' => 'unable to get issuer certificate',
        '3' => 'unable to get certificate CRL',
        '4' => 'unable to decrypt certificate\'s signature',
        '5' => 'unable to decrypt CRL\'s signature',
        '6' => 'unable to decode issuer public key',
        '7' => 'certificate signature failure',
        '8' => 'CRL signature failure',
        '9' => 'certificate is not yet valid',
        '10' => 'certificate has expired',
        '11' => 'CRL is not yet valid',
        '12' => 'CRL has expired',
        '13' => 'format error in certificate\'s notBefore field',
        '14' => 'format error in certificate\'s notAfter field',
        '15' => 'format error in CRL\'s lastUpdate field',
        '16' => 'format error in CRL\'s nextUpdate field',
        '17' => 'out of memory',
        '18' => 'self signed certificate',
        '19' => 'self signed certificate in certificate chain',
        '20' => 'unable to get local issuer certificate',
        '21' => 'unable to verify the first certificate',
        '22' => 'certificate chain too long',
        '23' => 'certificate revoked',
        '24' => 'invalid CA certificate',
        '25' => 'path length constraint exceeded',
        '26' => 'unsupported certificate purpose',
        '27' => 'certificate not trusted',
        '28' => 'certificate rejected',
        '29' => 'subject issuer mismatch',
        '30' => 'authority and subject key identifier mismatch',
        '31' => 'authority and issuer serial number mismatch',
        '32' => 'key usage does not include certificate signing',
        '50' => 'application verification failure'
    );

    
    /**
     * array to store information gleaned from curl_getinfo()
     * @var array
     */
    public $targetInfo = array();


    public function __construct(string $url=NULL, $pretty=NULL)
    {
        if($url !=NULL) {
            $this->gainIntel($url, $pretty);
        }
    }


    /**
     * execute curl_getinfo() storing results in an array with added descriptors
     *
     * @param string $url
     * @param bool $pretty
     * @return void
     */
    protected function gainIntel(string $url, $pretty=NULL) : void
    {
        $intel = curl_init($url);
        curl_exec($intel);
        
        try {
            if (!curl_errno($intel)) {
                $info = curl_getinfo($intel);
                $this->addDescriptive($info);
                $this->getMore($url, $info);

                if($pretty != NULL) {
                    echo 'Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "\n";
                    if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {
                        echo '<pre>'.str_repeat('=', 14)."\ncURL RESPONSE:\n".str_repeat('=', 14)."\n  FILE: ".__FILE__."\n  LINE: "
                        .__LINE__."\n".str_repeat('=', 14)."\n".print_r($info, true).'</pre>';
                    }
                }
                $this->targetInfo = $info;
            }

        }
        catch(Exception $e) {
            echo "Error in url, try reformatting e.g. removing https://"; 
        }
        curl_close($intel);
    }


    /**
     * call individual CURL options to retreive added specific information
     *
     * @param string $url
     * @param array $info
     * @return void
     */
    private function getMore($url, &$info) : void
    {
        $intel = curl_init($url);

        curl_setopt($intel, CURLINFO_HEADER_OUT, true);
        curl_setopt($intel, CURLOPT_PRIVATE, true);
        curl_setopt($intel, CURLOPT_PROXY_SSL_VERIFYPEER, true);
        curl_setopt($intel, CURLINFO_FTP_ENTRY_PATH, true);
        curl_setopt($intel, CURLINFO_COOKIELIST, true);
        curl_setopt($intel, CURLINFO_OS_ERRNO, true);
        curl_setopt($intel, CURLINFO_PROXYAUTH_AVAIL, true);
        curl_setopt($intel, CURLINFO_HTTPAUTH_AVAIL, true);
        curl_setopt($intel, CURLINFO_NUM_CONNECTS, true);

        curl_exec($intel);
        $info['header_out'] = curl_getinfo($intel, CURLINFO_HEADER_OUT);
        $info['ftp_entry_path'] = curl_getinfo($intel, CURLINFO_FTP_ENTRY_PATH);
        $info['cookie_list'] = curl_getinfo($intel, CURLINFO_COOKIELIST);
        $info['OS_errno'] = curl_getinfo($intel, CURLINFO_OS_ERRNO);
        $info['proxyauth_avail'] = curl_getinfo($intel, CURLINFO_PROXYAUTH_AVAIL);
        $info['httpauth_avail'] = curl_getinfo($intel, CURLINFO_HTTPAUTH_AVAIL);
        $info['num_connects'] = curl_getinfo($intel, CURLINFO_NUM_CONNECTS);
        curl_close($intel);
    }


    /**
     * add descriptive information to curl_getinfo() reposonse array
     *
     * @param array $info
     * @return void
     */
    private function addDescriptive(&$info) : void
    {
        foreach ($this->responseCodes as $code => $value) {
            foreach ($value as $key => $descript) {
                if ($key == $info['http_code']) {
                    $info['http_code'] = $key.'-'.$descript;
                }
            }    
        }

        foreach ($this->SSLstatus as $status => $message) {
            if($status == $info['ssl_verify_result']) {
                $info['ssl_verify_result'] = $status.'-'.$message;
            }
        }
    }


    /*
	* @param {string} data
	*/
	public function logInfo($filename)
	{
        try { 
            if($filename) {
                $file = fopen('../../logs/'.$filename, "w");
                $date = date('m/d/Y h:i:s a', time());

                if(fwrite($file,"[{$date}] Server: " .  print_r($this->targetInfo, true) . "\n")) {
                    fclose($file);
                    return $this->targetInfo;
                } else {
                    fclose($filename);
                    return false;
                }
            }
            else {
                throw new Exception;
            }
        }
        catch (Exception $e) {
            echo "Filename not given, please enter a filename and retry.";
        }
	}
}
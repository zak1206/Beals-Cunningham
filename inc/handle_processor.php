<?php
define('HANDLE_AUTH_PATH', '/Services/Portal/Security/10/MyAuthenticationService.svc/json/Login');
define('HANDLE_CREATE_ENTITY_PATH', '/Services/Crm/Notes/10/EntityCreateHandler.ashx');

class Handle
{

    public function Login($username, $password)
    {

        $ch = curl_init($this->_appendUrl(HANDLE_AUTH_PATH));
        $options = $this->_getOptions();
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        $jsonData = array(
            'username' => $username,
            'password' => $password,
            'isPersistent' => 'false'
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        $res = $this->_callJson($ch);
        $this->cookies = $res['cookies'];
        return $res;
    }

    public function CreateEntity($entityType, $accountCode, $properties)
    {
        $ch = curl_init($this->_appendUrl(HANDLE_CREATE_ENTITY_PATH));
        $options = $this->_getOptions();
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        if ($this->cookies)
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookies);
        $jsonData = array(
            "EntityType" => $entityType,
            "AccountCode" => $accountCode,
            "Properties" => $properties
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        return $this->_callJson($ch);
    }

    protected function _callJson($ch)
    {
        $result = curl_exec($ch);
        $response['errorCode'] = curl_errno($ch);
        $response['errorMessage']  = curl_error($ch);
        $response['header']  = curl_getinfo($ch);
        curl_close($ch);

        $response['headers'] = substr($result, 0, $response['header']['header_size']);
        $response['body'] = trim(str_replace($response['headers'], '', $result));

        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m";
        preg_match_all($pattern, $response['headers'], $matches);
        $response['cookies'] = implode("; ", $matches['cookie']);

        return $response;
    }

    protected function _getOptions()
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_USERAGENT      => "self::DEFAULT_USER_AGENT",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_HEADER         => true,     // return headers in addition to content
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST           => 1, 		// send a POST request.
            CURLOPT_HTTPHEADER     => array('Content-Type:application/json', 'Accept:application/json'),
        );
        return $options;
    }

    protected function _appendUrl($suffix)
    {
        return $this->baseUrl . $suffix;
    }

    public function __construct($baseUri)
    {
        $this->baseUrl = $baseUri;
    }
}

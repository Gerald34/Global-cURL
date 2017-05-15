<?php
// Global Curl Class
// Author : Gerald Mathabela
// Date Written and tested : 25 January 2017
// Project : Hello Paisa Transaction Portal

class cURL {
    private $userObject;
    private $apiUrl;
    protected $curlObj;
    public $curlReturn;

    public function useCURL($userPostData, $apiUrl) {
        $this->userObject = $userPostData;
        $this->apiUrl = $apiUrl;
        return $this->_curlFunc();
    }

    // Initialize cURL function
    private function _curlFunc() {
        $data_str = json_encode($this->userObject);

        // Init cURL object
        $this->curlObj = curl_init($this->apiUrl);
        return $this->_execCurl($data_str);

    }

    // Execute and return cURL function
    private function _execCurl($data_str) {
        try {
            curl_setopt($this->curlObj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->curlObj, CURLOPT_POST, 1);
            curl_setopt($this->curlObj, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->curlObj, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($this->curlObj, CURLOPT_POSTFIELDS, $data_str);
            curl_setopt($this->curlObj, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_str)
                )
            );
            $this->curlReturn = curl_exec($this->curlObj);
        } catch(PDOException $e) {
            die($e->getMessage());
        }

        return json_decode($this->curlReturn );
    }

}

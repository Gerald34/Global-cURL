<?php
// Global Curl Class
// Author : Gerald Mathabela
// Date Written and tested : 25 January 2017
// Project : Hello Paisa Transaction Portal

class cURL {
    private $settings;
    public function useCURL($userPostData, $apiUrl) {
        return $this->_curlFunc($userPostData, $apiUrl);
    }

    // Initialize cURL function
    private function _curlFunc($userPostData, $apiUrl) {
        $data_str = json_encode($userPostData);
        // Init cURL object
        if($curlObj = curl_init($apiUrl)):
            return $this->_execCurl($userPostData, $curlObj, $data_str);
        else:
            return false;
        endif;
    }

    // Execute and return cURL function
    private function _execCurl($userPostData, $curlObj, $data_str) {
        try {
            curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlObj, CURLOPT_POST, 1);
            curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlObj, CURLOPT_POSTFIELDS, $data_str);
            curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_str)
                )
            );

            if($curl_res = curl_exec($curlObj)):
                return json_decode($curl_res);
            else:
                return false;
            endif;
            curl_close($curlObj);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

}

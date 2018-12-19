<?php

  class opSAMLapiCall {

    var $api_url = 'https://signup.opensocial.me/api/';

    function postData ($url, $data)
    {

      $curl_header = array('Content-Type: application/json');

      $ch = curl_init();   
      $options = array(
        CURLOPT_URL => $this->api_url.$url,
        CURLOPT_HTTPHEADER => $curl_header,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_HEADER => false,
        CURLOPT_REFERER => esc_url(get_site_url()),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data
      );
  
      curl_setopt_array($ch, $options);
      $result = curl_exec($ch);
      curl_close($ch);
  
      return json_decode($result, true);

    }

    function updateData ($url, $data)
    {
      
      $curl_header = array('Content-Type: application/json');

      $ch = curl_init();   
      $options = array(
        CURLOPT_URL => $this->api_url.$url,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_HTTPHEADER => $curl_header,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_HEADER => false,
        CURLOPT_REFERER => esc_url(get_site_url()),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data
      );
  
      curl_setopt_array($ch, $options);
      $result = curl_exec($ch);
      curl_close($ch);
  
      return json_decode($result, true);

    }

    function delData ($url, $data)
    {

      $curl_header = array('Content-Type: application/json');

      $ch = curl_init();   
      $options = array(
        CURLOPT_URL => $this->api_url.$url,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => $curl_header,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_HEADER => false,
        CURLOPT_REFERER => esc_url(get_site_url()),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data
      );
  
      curl_setopt_array($ch, $options);
      $result = curl_exec($ch);
      curl_close($ch);
  
      return json_decode($result, true);

    }

  }

?>
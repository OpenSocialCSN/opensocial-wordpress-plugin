<?php

  // Make sure we don't expose any info if called directly
  if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there! something wrong there please check your wordpress.';
    exit;
  }

  require_once "api.php";

  function op_register_site()
  {
    $api = new opSAMLapiCall;

    $identity = esc_url(get_site_url());
    $acs = $identity.'/wp-login.php?saml_acs';
    $sls = $identity.'/wp-login.php?saml_sls';

    $post_data = array(
      'identity' => $identity,
      'acs' => $acs,
      'sls' => $sls
    );

    $data = json_encode($post_data);
    $msg = $api->postData('subscriber', $data);

    return true;
  }

  function op_unsub_site()
  {

    $api = new opSAMLapiCall;

    $post_data = array(
      'identity' => esc_url(get_site_url()),
    );

    $data = json_encode($post_data);
    $msg = $api->delData('subscriber', $data);

    return true;
  }

?>
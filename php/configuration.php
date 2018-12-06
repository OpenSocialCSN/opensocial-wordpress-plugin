<?php

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  something wrong there please check your wordpress.';
	exit;
}

require_once "compatibility.php";
require_once (dirname(__FILE__) . "/lib/Saml2/Constants.php");
require_once (dirname(__FILE__) . "/extlib/xmlseclibs/xmlseclibs.php");

function plugin_section_status_text() {
  echo "<p>".__("Use this flag for enable or disable the SAML support.", 'opensocial-saml-sso')."</p>";
}

function plugin_setting_boolean_opensocial_saml_enabled() {
  $value = get_option('opensocial_saml_enabled');
  echo '<input type="checkbox" name="opensocial_saml_enabled" id="opensocial_saml_enabled"
      '.($value ? 'checked="checked"': '').'>'.
      '<p class="description">'.__("Check it in order to enable the SAML plugin.", 'opensocial-saml-sso').'</p>';
}

function plugin_setting_boolean_opensocial_saml_keep_local_login() {
  $value = get_option('opensocial_saml_keep_local_login');
  echo '<input type="checkbox" name="opensocial_saml_keep_local_login" id="opensocial_saml_keep_local_login"
      '.($value ? 'checked="checked"': '').'>'.
      '<p class="description">'.__('Enable/disable the normal login form. If disabled, instead of the WordPress login form, WordPress will excecute the SP-initiated SSO flow. If enabled the normal login form is displayed and a link to initiate that flow is displayed.<p class="description">If you do not want to enable local login then you can also bypass SSO and get the login page using '.esc_url(get_site_url()).'/wp-login.php?normal</p>', 'opensocial-saml-sso').'</p>';
}

function plugin_section_options_text() {
  echo "<p>".__("This section customizes the behavior of the plugin.", 'opensocial-saml-sso')."</p>";
}

function plugin_permission_text() {
  echo "<p>".__("This section customizes the permission behavior of your site.", 'opensocial-saml-sso')."</p>";
}

function plugin_setting_boolean_opensocial_permission_enabled() {
  ?>
  Open: <input type="radio" name="opensocial_permission_enabled" id="opensocial_permission_enabled" value="open" <?php checked('open', get_option('opensocial_permission_enabled'), true); ?>> &nbsp;
  Closed: <input type="radio" name="opensocial_permission_enabled" id="opensocial_permission_enabled" value="closed" <?php checked('closed', get_option('opensocial_permission_enabled'), true);?> >
  <p class="description"><?php echo __("Select the <strong>(Open)</strong> option if you want to let any one login on your site.", 'opensocial-saml-sso');?></p>
  <?php
}

function opensocial_saml_configuration_render() {
  $title = __("SSO/SAML Settings", 'opensocial-saml-sso');
  ?>
    <div class="wrap">
      <div class="alignleft">
        <a href="http://www.opensocial.me"><img style="width: 190px;" src="<?php echo esc_url( plugins_url('opensocial.png', dirname(__FILE__)) );?>"></a>
      </div>
      <div class="alignright">
        <a href="<?php echo esc_url( get_site_url().'/wp-login.php?saml_metadata' ); ?>" target="blank"><?php echo __("Go to the metadata of this SP", 'opensocial-saml-sso');?></a><br>
      </div>
      <div style="clear:both"></div>
      <h2><?php echo esc_html( $title ); ?></h2>
      <form action="options.php" method="post">

        <?php settings_fields('opensocial_saml_configuration'); ?>
        <?php do_settings_sections('opensocial_saml_configuration'); ?>

        <div style="margin-top: 10px;"><strong>Note:</strong> You can use <strong>[opensocial_login_button]</strong> shortcode to display OpenSocial login button anywhere on your site.</div>

        <p class="submit">
          <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

      </form>
    </div>
  <?php
}

function opensocial_saml_configuration() {
  
  $current_screen = add_submenu_page( 'options-general.php', 'OpenSocial SSO/Settings', 'OpenSocial SSO/Settings', 'manage_options', 'opensocial_saml_configuration', 'opensocial_saml_configuration_render');

  $helpText = '<p>' . __('OpenSocial Wordpress Plugin is a plugin allowing your users to easily authenticate into your Wordpress site. OpenSocial is a SSO one-click service allowing users to authenticate with their Google, Facebook, Twitter, LinkedIn, Github or OpenSocial accounts. The OpenSocial Wordpress Plugin is backed by the OpenSocial SSO service', 'opensocial-saml-sso') . '</p>' .
    '<p><strong>' . __('For more information', 'opensocial-saml-sso') . '</strong> '.__("access to the", 'opensocial-saml-sso').' <a href="https://www.opensocial.me" target="_blank">'.__("Plugin Info", 'opensocial-saml-sso').'</a> ' .
    __("or visit", 'opensocial-saml-sso') . ' <a href="http://www.opensocial.me/" target="_blank">OpenSocial.me</a>' . '</p>';

  $current_screen = convert_to_screen($current_screen);
  WP_Screen::add_old_compat_help($current_screen, $helpText);

  $option_group = 'opensocial_saml_configuration';

  /* Status */
  add_settings_section('status', __('STATUS', 'opensocial-saml-sso'), 'plugin_section_status_text', $option_group);
  register_setting($option_group, 'opensocial_saml_enabled');
  add_settings_field('opensocial_saml_enabled', __('Enable', 'opensocial-saml-sso'), "plugin_setting_boolean_opensocial_saml_enabled", $option_group, 'status');

  /* Keep local login */
  add_settings_section('options', __('OPTIONS', 'opensocial-saml-sso'), 'plugin_section_options_text', $option_group);
  register_setting($option_group, 'opensocial_saml_keep_local_login');
  add_settings_field('opensocial_saml_keep_local_login', __('Keep Local login', 'opensocial-saml-sso'), "plugin_setting_boolean_opensocial_saml_keep_local_login", $option_group, 'options');

  /* Permissions */
  add_settings_section('permissions', __('Permissions', 'opensocial-saml-sso'), 'plugin_permission_text', $option_group);
  register_setting($option_group, 'opensocial_permission_enabled');
  add_settings_field('opensocial_permission_enabled', __('Permission Type', 'opensocial-saml-sso'), "plugin_setting_boolean_opensocial_permission_enabled", $option_group, 'permissions');

}

?>
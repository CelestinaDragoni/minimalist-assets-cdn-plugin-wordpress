<?php

/*
Plugin Name: Minimalist Assets CDN
Plugin URI: https://github.com/KernelZechs/minimalist-assets-cdn
Description: Simple plugin that will make it so that you're enqueued scripts/styles are pointed at a CDN.
Version: 1.0
Author: Anthony Mattera (KernelZechs)
Author URI: https://github.com/KernelZechs/minimalist-assets-cdn
Text Domain: kz-minimalist-assets-cdn
*/

namespace KernelZechs;

class MinimalistAssetsCDN {

    /** Static instance of this class **/
    static private $_instance = false;

    /** Wordpress text namespace (text domain) **/
    private $_wpNamespace = 'kz-minimalist-assets-cdn';

    /** Wordpress filter/action namespace  **/
    private $_wpFilterNamespace = 'kz_minimalist_assets_cdn';

    /** CDN Url (Default: empty) **/
    private $_cdn = '';

    /** Use CDN for Admin (Default: disabled) **/
    private $_admin = 0;

    /**
     * Singleton constructor.
     * @return KernelZechs\MinimalistAssetsCDN
     */
    public static function getInstance()
    {
        return (self::$_instance) ? self::$_instance : $_instance = new self();
    }

    /**
     * Class constructor
     * @return void
     */
    public function __construct()
    {
        // Throw a warning if someone tries to make another class of this.
        if (self::$_instance) {
            error_log('WARNING: You shouldn\'t construct another instance of MinimalistAssetsCDN. Use ::getInstance() or one of the filters instead.');
            return;
        }

        // Get CDN Value
        $this->_cdn = get_option("{$this->_wpNamespace}-url", '');
        $this->_admin = get_option("{$this->_wpNamespace}-url", 0);

        // Wordpress Action and Filters
        add_action('admin_menu', [$this, 'renderAdminMenu']);
        add_filter('style_loader_src', [$this, 'filterCDN'], 0, 1);
        add_filter('script_loader_src', [$this, 'filterCDN'], 0, 1);

        // Filter for custom plugin work that may need this reference.
        add_filter($this->_wpFilterNamespace.'_format', [$this, 'filterCDN'], 0, 2);
    }


    ///////////////////////////////////////
    //// Wordpress Actions and Filters
    ///////////////////////////////////////

    /**
     * Rewrites asset URLs to CDN path
     * @param string $url
     * @return string
     */
    public function filterCDN($url, $demo=false)
    {
        if (!$demo) {
            // Skip if CDN is empty.
            if (empty($this->_cdn)) {
                return $url;
            }

            // Skip if admin CDN is disabled or we're on the configuration page (for safety)
            if (is_admin() && !$this->_adminEnabled()) {
                return $url;
            }
        }

        // Parse URL
        $parsedUrl = parse_url($url);

        // Assemble new URL
        $url = $this->_cdn.$parsedUrl['path'];
        if (!empty($parsedUrl['query'])) {
            $url .= '?'.$parsedUrl['query'];
        }

        // Return CDNed Url
        return $url;
    }

    /**
     * Creates the admin menu in the sidebar for management.
     * @return void
     */
    public function renderAdminMenu()
    {
        add_submenu_page(
            'options-general.php',
            __( 'Minimalist Assets CDN', $this->_wpNamespace ),
            __( 'Minimalist Assets CDN', $this->_wpNamespace ),
            'manage_options',
            $this->_wpNamespace.'-admin',
            [$this, 'renderAdmin'],
            99
        );
    }

    /**
     * Renders admin settings page.
     * @return void
     */
    public function renderAdmin()
    {
        $updated = false;

        // Update POST data
        if (isset($_POST['data']['cdn']) && isset($_POST['data']['admin'])) {
            $this->_setCDN($_POST['data']['cdn']);
            $this->_setAdmin($_POST['data']['admin']);
            $updated = true;
        }

        require('views/admin.view.php');
    }

    ///////////////////////////////////////
    //// Option Getter and Setters
    ///////////////////////////////////////

    /**
     * Sets the CDN url
     * @param string $cdn
     * @return void
     */
    private function _setCDN($cdn)
    {
        $cdn = !empty($cdn) ? rtrim(esc_url($cdn), '/') : '';
        $this->_cdn = $cdn;
        update_option("{$this->_wpNamespace}-url", $cdn);
    }

    /**
     * Enables/disabled CDN for wordpress admin.
     * @param mixed $admin
     * @return void
     */
    private function _setAdmin($admin)
    {
        $admin = (!empty($admin)) ? 1 : 0;
        $this->_admin = $admin;
        update_option("{$this->_wpNamespace}-admin", $admin);
    }

    /**
     * Checks to see if admin is enabled and if we should use the CDN on this page.
     * @param mixed $admin
     * @return void
     */
    private function _adminEnabled()
    {
        if ((isset($_GET['page']) && $_GET['page'] == "{$this->_wpNamespace}-admin") || !$this->_admin) {
            return false;
        }
        return true;
    }
}

MinimalistAssetsCDN::getInstance();

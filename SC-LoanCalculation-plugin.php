<?php
/**
* @package SC-LoanCalculationPlugin
*/

/*
Plugin Name: SC-Loan Calculation Widget
Plugin URI: http://lbw-573624847.eu-central-1.elb.amazonaws.com/plugins/
Description: SmartCredit.io Loan Calculator Widget allows calculation of the loan amounts and the loan collateral amounts. The integrating website needs to register in SmartCredit.io and enter the referral code into the plugin configuration.
Version: 1.0.11
Author: Smart Credit
Author URI: http://smartcredit.io/
License: GPLv2 or later 
Text Domain : sc-loan-calculation-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die( 'You can\t access this file!' );

class LoanCalculationPlugin {

    public $plugin;
    

    function __construct(){
        $this -> plugin = plugin_basename(__FILE__);
        add_action('wp_enqueue_scripts', array($this, 'add_loan_calculation_script'));
        add_shortcode('loan-calculation-widget', array($this, 'add_loan_calculation_element'));
    }

    function add_loan_calculation_script() {
        wp_register_script('loan-calculator', plugins_url('loan-calculator.js', __FILE__));
        wp_enqueue_script('loan-calculator');
    }

    function add_loan_calculation_element( $atts) {
        $a = shortcode_atts( array(
            'referral' => 'referral',
            'theme' => 'theme',
            'logo' => 'logo'
        ), $atts );
        return '<loan-calculator theme="'. esc_attr($a['theme']).'" referral="'. esc_attr($a['referral']).'" logo="'. esc_attr($a['logo']).'" ></<loan-calculator>';
    }
    
    function activate() {
        //flush rewrite rules refreshing database everytime plugin is activated
        flush_rewrite_rules();
    }

    function deactivate(){
        //flush rewrite rules, refreshing database everytime plugin is deactivated
        flush_rewrite_rules();
    }
}
plugins_url('/assets/SMARTCREDIT-LOGO.jpg', __FILE__);

if ( class_exists( 'LoanCalculationPlugin' )){
    $loanCalculationPlugin = new LoanCalculationPlugin();
}

//activation
register_activation_hook( __FILE__, array( $loanCalculationPlugin, 'activate'));

//deactivation
register_deactivation_hook( __FILE__, array( $loanCalculationPlugin, 'deactivate'));
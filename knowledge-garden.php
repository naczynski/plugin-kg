<?php
/**
* Plugin Name: Knowledge Garden
* Plugin URI:  http://naczynsky.pl
* Description: All modules to KG portal
* Author:      Rafał Naczyński
* Author URI:  http://naczynsky.pl
* Depends: Advance Custom Fields
*/

  if ( ! defined( 'WPINC' ) ) {
    die;
  }

  /* Vendor
     ========================================================================== */

  include plugin_dir_path( __FILE__ ) . 'vendor/autoload.php'; 

  /* Invoices
   ========================================================================== */

  define('DOMPDF_ENABLE_AUTOLOAD', false);
  if(!defined("DOMPDF_ENABLE_CSS_FLOAT")){
      // define("DOMPDF_ENABLE_CSS_FLOAT", true);
  }
  require_once 'vendor/dompdf/dompdf/dompdf_config.inc.php';


  /* TAXONOMY
     ========================================================================== */
  
  include plugin_dir_path( __FILE__ ) . 'kg-resources/ct/subtype.php';

  /* POST TYPES
     ========================================================================== */

  include plugin_dir_path( __FILE__ ) . 'kg-resources/cpt/pdf.php';
  include plugin_dir_path( __FILE__ ) . 'kg-quizes/cpt/quiz.php';
  include plugin_dir_path( __FILE__ ) . 'kg-resources/cpt/link.php';
  include plugin_dir_path( __FILE__ ) . 'kg-resources/cpt/event.php';
  include plugin_dir_path( __FILE__ ) . 'kg-subscriptions/cpt/subscription.php';
  include plugin_dir_path( __FILE__ ) . 'kg-users-groups/cpt/user-group.php';
  include plugin_dir_path( __FILE__ ) . 'kg-tasks/cpt/task.php';

  /* Utils
     ========================================================================== */
  
  function get_loader_class_name($module) {

     $split = explode('-', $module);
     $split = array_map(function($word) { return ucfirst($word); }, $split); 

     return 'KG_' . implode('_' , $split). '_Loader';
  
  }

  /* Factory
    ========================================================================== */

  include plugin_dir_path( __FILE__ ) . 'kg-core/abstract/kg-get.php';

  /* Modules List
    ========================================================================== */

  function KG_get_modules_list() {

      $modules = array(
        'core',
        'users',
        'fields',
        'mails',
        'cocpit',
        'resources-relations',
        'subscriptions',
        'resources-free',
        'resources',
        'messages',
        'quizes',
        'likes',
        'templates',
        'maintenance',
        'stats',
        'generators',
        'orders',
        'files',
        'alerts',
        'activities',
        'invoices',
        'users-groups',
        'tasks',
        'authenticate'
      );

      return $modules;
  }

  /* Incude Modules
     ========================================================================== */

  foreach (KG_get_modules_list() as $module) {
       include plugin_dir_path( __FILE__ ) . 'kg-'.$module.'/kg-'.$module.'-loader.php';
  }

  /* Init
     ========================================================================== */

  function KG_call_init_methods(){
     foreach (KG_get_modules_list() as $module) {
          $module_name_class = get_loader_class_name($module);
          if(class_exists($module_name_class)) {
            $loader = KG_Get::get($module_name_class);
            $loader->init();
          } else {
            error_log('Cant init '. $module_name_class);
          }
      }  
  }

  function KG_init_KG() {
      foreach (KG_get_modules_list() as $module) {
          $module_name_class = get_loader_class_name($module);
          if(class_exists($module_name_class)) {
            $loader = KG_Get::get($module_name_class);
            $loader->init_hooks();
          } else {
            error_log('Cant init '. $module_name_class);
          }
      }  
      KG_call_init_methods();
  }

  add_action('init', 'KG_init_KG');

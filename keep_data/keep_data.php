<?php
/*
 * Plugin Name: Безпечні дані автора
 * Plugin URI:  #
 * Description: Напиши про учня, хто є хто)
 * Version: 1.1
 * Author: Dmytro O
 * Author URI: #
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 */

 if(!defined('ABSPATH')){
    die;
 }
 require_once plugin_dir_path(__FILE__).'widget.php';

 class Keep_Data_Handler
 {
     private $user_name;
     private $user_about;
     private $user_id;
     private $custom_errors = array();
 
     public function __construct($user_name, $user_about = '')
     {
         $this->user_name = $user_name;
         $this->user_about = $user_about;
         $this->user_id = null;
     }
 
     function check_author_existence($author_name) {
        global $wpdb;
        $author_name = $wpdb->esc_like($author_name);
        $this->user_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s",
                '%' . $author_name . '%'
            )
        );
        if (empty($this->user_id)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function registration_validation()
    {    
        if (empty($this->user_name)) {
            $this->custom_errors[] = 'Відсутнє обов’язкове поле форми';
        } else {
            $this->check_author_existence($this->user_name);
    
            if (empty($this->user_id)) {
                $this->custom_errors[] = 'На жаль, такого автора немає на нашому сайті';
            }
        }
    }

    public function complete_registration()
    {
        $this->registration_validation();

        if (count($this->custom_errors) > 0) {
            foreach ($this->custom_errors as $error) {
                echo '<p style="color: red;">';
                echo '<strong>Помилка</strong>:';
                echo $error . '<br/>';
                echo '</p>';
            }
        } else {
            if($this->user_about != '') update_user_meta($this->user_id, 'description', $this->user_about);
            echo '<p>У автора <strong>' . get_author_name($this->user_id) . '</strong> ' . 
                    count_user_posts($this->user_id, 'post') . ' постів<br>Про нього: ' . 
                    get_user_meta( $this->user_id, 'description', false )[0] . '</p>';
        }
        wp_die();
    }
}

new Keep_Data_Form();
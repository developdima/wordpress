<?php
if (!defined('ABSPATH')) {
    die;
}

class Keep_Data_Author_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'keep_data_author_widget',
            'Безпечні дані автора',
            array('description' => 'Введіть ім\'я автора, передайте опис про нього та дізнайтеся кількість статей')
        );
    }

    public function widget($args, $instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
 
		echo $args['before_widget'];
 
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

        echo '<div id="form-response"></div>';
        $form = new Keep_Data_Form();
        $form->render_form();

		echo $args['after_widget'];

    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Заголовок:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo $title; ?>"/>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (isset($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

class Keep_Data_Form
{
    public function __construct()
    {
        add_action('wp_ajax_keepdata', array($this, 'handle_keepdata'));
        add_action('wp_ajax_nopriv_keepdata', array($this, 'handle_keepdata'));
    }

    public function render_form()
    {
        wp_enqueue_script('keepdatas-ajax-script', plugin_dir_url(__FILE__) . 'scripts.js', array(), '1.0', true);
        $nonce = wp_create_nonce('keepdatas_ajax_nonce');
        wp_localize_script('keepdatas-ajax-script', 'keepdatas_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => $nonce
        ));
        ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" id="form-keepdatas" data-action-url="<?php echo admin_url('admin-ajax.php'); ?>">
            <input type="hidden" name="action" value="keepdata"/>
            <?php wp_nonce_field('nonce_user_action', 'nonce_user'); ?>
            <div>
                <label for="username">Ім'я <strong>*</strong></label>
                <div><input type="text" name="username" value=""></div>
            </div>
            <div>
                <label for="userabout">Про автора</label>
                <textarea name="userabout"></textarea>
            </div>
            <input type="submit" name="submit" value="Зберегти"/>
        </form>
        <?php
    }

    public function handle_keepdata()
    {
        if (isset($_POST['action']) && $_POST['action'] === 'keepdata') {
            if( isset( $_POST[ 'nonce_user' ] ) && wp_verify_nonce( $_POST[ 'nonce_user' ], 'nonce_user_action' ) ) {
                $user_name = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
                $user_about = isset($_POST['userabout']) ? sanitize_text_field($_POST['userabout']) : '';

                $handler = new Keep_Data_Handler($user_name, $user_about);
                $handler->complete_registration();
            }
        }
        die();
    }
}

function check_author_name_callback() {
    check_ajax_referer('keepdatas_ajax_nonce', 'nonce');

    $author_name = sanitize_text_field($_POST['author_name']);
    $handler = new Keep_Data_Handler($author_name);
    $result = $handler->check_author_existence($author_name);

    if ($result) {
        echo '<p style="color: green;">Автор з таким ім\'ям існує!</p>';
    } else {
        echo '<p style="color: red;">Автора з таким ім\'ям не знайдено.</p>';
    }

    wp_die();
}

add_action('wp_ajax_check_author_name', 'check_author_name_callback');
add_action('wp_ajax_nopriv_check_author_name', 'check_author_name_callback');


function register_keep_data_author_widget()
{
    register_widget('Keep_Data_Author_Widget');
}

add_action('widgets_init', 'register_keep_data_author_widget');


function enqueue_custom_script() {
    wp_enqueue_script('scripts', plugin_dir_url(__FILE__) . 'scripts.js', array(), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');
?>
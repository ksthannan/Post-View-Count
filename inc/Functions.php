<?php
namespace WedevsAcademy\WpPostViewCount;

/**
 * Class Functions
 */
class Functions{
    // constructors 
    public function __construct(){

        add_shortcode('postvc_view_count', array($this, 'page_view_shortcode'));

        add_filter('manage_posts_columns', array($this, 'postvc_custom_post_list_column'));

        add_action('manage_posts_custom_column', array($this, 'postvc_custom_post_list_column_content'), 10, 2);

        add_action('pre_get_posts', array($this, 'postvc_custom_post_list_orderby'));
        
        add_filter('manage_edit-post_sortable_columns', array($this, 'postvc_custom_post_list_sortable_columns'));

    }

    // Define shortcode 
    public function page_view_shortcode($atts){
        if(is_single()){
            global $post;
            $post_id = $post->ID;
        }else{
            $post_id = '';
        }

        // shortcode attributes
        $atts = shortcode_atts(array(
            'id' => $post_id,   
        ), $atts, 'postvc_view_count');

        $post_id = $atts['id'] ? $atts['id'] : $post_id;

        $count = get_post_meta($post_id, 'postvc_post_views', true);
        $count = number_format(intval($count));

        ob_start();
            ?>
                <div class="postvc_page_view_wrap">
                    <div class="postvc_inner">
                        <h2><?php _e('Page Views', 'postvc'); ?></h2>
                        <h3><?php _e('Total Views', 'postvc'); ?></h3>
                        <p class="postvc_count">
                            <span><?php esc_html_e($count); ?></span>
                        </p>
                    </div>
                </div>
            <?php 
        return ob_get_clean();
    }

    // function for view count column in admin area 
    public function postvc_custom_post_list_column($columns) {
        $columns['postvc_post_views'] = 'Views Count';
        return $columns;
    }

    // Populate custom column with data
    public function postvc_custom_post_list_column_content($column_name, $post_id) {
        if ($column_name == 'postvc_post_views') {
            $views = get_post_meta($post_id, 'postvc_post_views', true);
            echo number_format(intval($views));
        }
    }

    // Make the custom column sortable
    function postvc_custom_post_list_sortable_columns($columns) {
        $columns['postvc_post_views'] = 'postvc_post_views';
        return $columns;
    }

    // Modify the query to support sorting by the custom column
    function postvc_custom_post_list_orderby($query) {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        $orderby = $query->get('orderby');

        if ('postvc_post_views' == $orderby) {
            $query->set('meta_key', 'postvc_post_views');
            $query->set('orderby', 'meta_value_num');
        }
    }


}
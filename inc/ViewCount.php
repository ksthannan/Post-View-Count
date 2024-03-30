<?php 
namespace WedevsAcademy\WpPostViewCount;
/**
 * class ViewCount
 */
if ( ! class_exists( 'ViewCount' ) ) {
    class ViewCount {
        public function __construct(){
            add_action('wp_head', array($this, 'post_view_count'));
        }

        /**
         * Post view count processing
         */
        public function post_view_count(){
            if (is_single()) {
                global $post;
                $views = get_post_meta($post->ID, 'postvc_post_views', true);
                $views = intval($views);
                $views++;
                update_post_meta($post->ID, 'postvc_post_views', $views);
            }
        }
    }

}

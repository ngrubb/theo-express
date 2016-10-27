<?php

class Testimonial_Widget extends WP_Widget
{

    /**
     * Constructor
     */

    function __construct()
    {
        parent::__construct('Testimonial_Widget', 'Testimonials', array('description' => 'Show Testimonials'));
    }



    /**
     * Form
     * Displays the form for our widget in the admin
     * @param [array] $instance Previously saved values from database.
     */

    function form($instance)
    {
       $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
       $count = isset($instance['count']) ? esc_attr($instance['count']) : '';
       $order = isset($instance['order']) ? esc_attr($instance['order']) : '';
       ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text"
                   value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>">
                <?php _e('# to Display:'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>"
                   type="number"
                   value="<?php echo $count; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">
                <?php _e('Order:'); ?>
            </label>
            <select id="<?php echo $this->get_field_id('order'); ?>"
                   name="<?php echo $this->get_field_name('order'); ?>">

                <option value="DESC" <?php selected('DESC', $order); ?>>Newest First</option>
                <option value="ASC" <?php selected('ASC', $order); ?>>Oldest First</option>
                <option value="rand" <?php selected('rand', $order); ?>>Random</option>
            </select>
        </p>

        <?php
    }



    /**
     * Update
     * Function that updates the wdiget html on the frontend
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     * @return array Updated safe values to be saved.
     */

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = strip_tags($new_instance['count']);
        $instance['order'] = strip_tags($new_instance['order']);
        return $instance;
    }



    /**
     * Widget
     * Function that shows the widget html on the frontend
     * @param [array] $args     Widget arguments.
     * @param [array] $instance Saved values from database.
     */

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];
        $order = $instance['order'];
        extract( $args );

        $testimonials = new WP_Query(array(
            'post_type' => 'testimonial'
            ,'posts_per_page' => $count
            ,'orderby' => ($order == 'rand') ? $order : 'id'
            ,'order' => ($order == 'rand') ? 'DESC' : $order
        ));
        ?>
        <div class="testimonials sidebar__block soft--bottom">
        <?php while($testimonials->have_posts()): $testimonials->the_post(); ?>

        <blockquote itemscope itemtype="http://schema.org/Review">
            <cite itemprop="author"><?php echo get_post_meta( get_the_id(), 'client_name', true); ?></cite>
            <span itemprop="reviewBody">
                <?php the_content(); ?>
            </span>
        </blockquote>

        <?php endwhile; wp_reset_postdata(); ?>

        <a href="<?php echo home_url('/testimonials/' ); ?>">Read More Testimonials <span class="icon-double-arrow-right"></span></a>
        </div>
        <?php
    }
}

/**
 * Register the Widget
 */
add_action('widgets_init', create_function('', 'return register_widget("testimonial_widget");'));


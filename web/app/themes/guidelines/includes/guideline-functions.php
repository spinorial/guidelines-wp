<?php class My_Controller extends WP_REST_Posts_Controller {


    protected function get_post( $id ) {
        $error = new WP_Error( 'rest_post_invalid_id', __( 'Invalid post ID. Custom controller' ), array( 'status' => 404 ) );
        if ( (int) $id <= 0 ) {
            return $error;
        }

        $post = get_post( (int) $id );
        if ( empty( $post ) || empty( $post->ID ) || $this->post_type !== $post->post_type ) {
            return $error;
        }

        return $post;
    }



}?>



<?php add_action('init', 'create_guideline_post_type');
function create_guideline_post_type()
{
    register_post_type('guideline',
        array(
            'labels' => array(
                'name' => __('Guidelines'),
                'singular_name' => __('guideline')
            ),
            'public' => true,
            'map_meta_cap' => true,
            'description' => 'Guidelines',
            'menu_position' => 0,
            'menu_icon' => 'dashicons-media-document',
            'show_in_rest' => true,
            'rest_controller_class' => 'My_Controller',
            'supports' => [
                'title',
                'revisions'
            ],
            'hierarchical' => false,
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'guidelines')
        )
    );
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_5b27679f697b7',
    'title' => 'Guidelines',
    'fields' => array(
        array(
            'key' => 'field_5b2767aae6361',
            'label' => 'Guideline Title',
            'name' => 'guideline_title',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => 'Insert guideline title here',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_5b276a5ae6362',
            'label' => 'Guideline Category',
            'name' => 'guideline_category',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'Medical' => 'Medical',
                'Pharmacological' => 'Pharmacological',
            ),
            'default_value' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ),
        array(
            'key' => 'field_5b276ad8e6363',
            'label' => 'Guideline Description',
            'name' => 'guideline_description',
            'type' => 'textarea',
            'instructions' => 'Please enter brief description of guideline.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => 4,
            'new_lines' => '',
        ),
        array(
            'key' => 'field_5b276b5de6364',
            'label' => 'File',
            'name' => 'file',
            'type' => 'file',
            'instructions' => 'Please upload the guideline file',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'library' => 'all',
            'min_size' => '',
            'max_size' => '8mb',
            'mime_types' => 'pdf',
        ),
        array(
            'key' => 'field_5b295c48bb6c1',
            'label' => 'Lead Author',
            'name' => 'lead_author',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 1,
            'max' => 1,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_5b295c66bb6c2',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'Ms' => 'Ms',
                        'Mr' => 'Mr',
                        'Dr' => 'Dr',
                        'Prof' => 'Prof',
                    ),
                    'default_value' => array(
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5b295c91bb6c3',
                    'label' => 'Firstname',
                    'name' => 'firstname',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b295cb2bb6c4',
                    'label' => 'Surname',
                    'name' => 'surname',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b295cbcbb6c5',
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
            ),
        ),
        array(
            'key' => 'field_5b276ce9a8e18',
            'label' => 'Review Panel',
            'name' => 'review_panel',
            'type' => 'repeater',
            'instructions' => 'Please enter details of the review panel',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => 'field_5b276d00a8e19',
            'min' => 1,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_5b276d6da8e1a',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'select',
                    'instructions' => 'Please select title',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'Ms' => 'Ms',
                        'Mr' => 'Mr',
                        'Dr' => 'Dr',
                        'Prof' => 'Prof',
                    ),
                    'default_value' => array(
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5b276e03a8e1b',
                    'label' => 'Firstname',
                    'name' => 'firstname',
                    'type' => 'text',
                    'instructions' => 'Please enter first name',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b276e31a8e1c',
                    'label' => 'Surname',
                    'name' => 'surname',
                    'type' => 'text',
                    'instructions' => 'Please enter surname',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5b276d00a8e19',
                    'label' => 'Email Address',
                    'name' => 'email',
                    'type' => 'email',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
            ),
        ),
        array(
            'key' => 'field_5b5edbedab751',
            'label' => 'Tracker',
            'name' => 'tracker',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'min' => '',
            'max' => '',
            'step' => '',
        ),
        array(
            'key' => 'field_5bc2049967ae3',
            'label' => 'Start Date',
            'name' => 'start_date',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_5bc204cd67ae4',
            'label' => 'End Date',
            'name' => 'end_date',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'guideline',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;
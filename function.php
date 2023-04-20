// Step 1 - Adding a custom tab to the Products Metabox
add_filter( 'woocommerce_product_data_tabs', 'add_shipping_costs_product_data_tab', 99 , 1 );
function add_shipping_costs_product_data_tab( $product_data_tabs ) {
    $product_data_tabs['shipping-costs'] = array(
        'label' => __( 'Shipping costs', 'my_theme_domain' ), // translatable
        'target' => 'shipping_costs_product_data', // translatable
    );
    return $product_data_tabs;
}

// Step 2 - Adding and POPULATING (with data) custom fields in custom tab for Product Metabox
add_action( 'woocommerce_product_data_panels', 'add_shipping_costs_product_data_fields' );
function add_shipping_costs_product_data_fields() {
    global $post;

    $post_id = $post->ID;

    echo '<div id="shipping_costs_product_data" class="panel woocommerce_options_panel">';

    ## THE 6 DIFFERENT FIELD TYPES

    # 1. Text input field
    woocommerce_wp_text_input( array(
        'id'            => '_input_text',
        // 'name'         => '_input_text', // (optional) for different ID attribute than name attribute
        // 'class'         => 'some-class', // (optional)
        // 'wrapper_class' => 'show_if_simple', // (optional) example here for simple products type only
        'placeholder'   => __( 'Enter some data', 'theme_domain' ), // (optional)
        'label'         => __( 'input text Label', 'theme_domain' ), // (optional)
        'description'   => __( 'input text  Description', 'theme_domain' ), // (optional)
        'desc_tip'      => true, // (optional) To show the description as a tip
        // 'data_type'     => '', // (optional formatting options) can be 'price', 'decimal', 'stock' or 'url'
        // 'type'          => '', // (optional additional custom attribute)
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    // 2. Textarea input field
    woocommerce_wp_textarea_input( array(
        'id'            => '_input_textarea',
        // 'name'         => 'input_textarea', // (optional) for different ID attribute than name attribute
        'class'         => 'widefat', // (optional)
        // 'style'         => '' // (optional)
        // 'wrapper_class' => 'show_if_simple', // (optional) example here for simple products type only
        'placeholder'   => __( 'Enter some data', 'theme_domain' ), // (optional)
        'label'         => __( 'input textarea Label', 'theme_domain' ),
        'description'   => __( 'input textarea Description', 'theme_domain' ),
        'desc_tip'      => true, // (optional) To show the description as a tip
        // 'rows'          => 2, // (optional) defining number of rows
        // 'cols'          => 20, // (optional) defining number of columns
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    // 3. Checkbox field
    woocommerce_wp_checkbox( array(
        'id'            => '_input_checkbox',
        // 'name'         => 'input_checkbox', // (optional) for different ID attribute than name attribute
        // 'class'         => 'some-class', // (optional)
        // 'wrapper_class' => 'show_if_simple', // (optional) example here for simple products type only
        'label'         => __( 'input checkbox Label', 'theme_domain' ),
        'description'   => __( 'input checkbox Description', 'theme_domain' ),
        'desc_tip'      => true, // (optional) To show the description as a tip
        // 'cbvalue'       => 'yes', // to make it selected by default
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    // 4. Radio Buttons field
    woocommerce_wp_radio( array(
        'id'            => '_input_radio',
        // 'name'          => 'input_radio', // (optional) for different ID attribute than name attribute
        // 'class'         => 'some-class', // (optional)
        // 'wrapper_class' => 'show_if_simple', // (optional) example here for simple products type only
        'label'         => __(' ', 'my_theme_domain'),
        'description'   => __( 'input Radio Description', 'my_theme_domain' ),
        'desc_tip'      => true,
        'options'       => array(
            'option_value_1'    => __('Displayed option 1'),
            'option_value_2'    => __('Displayed option 2'),
            'option_value_3'    => __('Displayed option 3'),
        ),
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    // 5. Select field
    woocommerce_wp_select( array(
        'id'                => '_select_field',
        // 'name'              => '_select_field', // (optional) for different ID attribute than name attribute
        // 'wrapper_class' => 'show_if_simple', // (optional) example here for simple products type only
        'label'         => __(' ', 'my_theme_domain'),
        'description'   => __( 'input Radio Description', 'my_theme_domain' ),
        'desc_tip'      => true,
        'options'       => array(
            ''               => __('Chose an option'), // Default empty value
            'option_value_1' => __('Displayed option 1'),
            'option_value_2' => __('Displayed option 2'),
            'option_value_3' => __('Displayed option 3')
        ),
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    // 6. Hidden input field
    woocommerce_wp_hidden_input( array(
        'id'            => '_hidden_input',
        // 'name'              => '_hidden_input', // (optional) for different ID attribute than name attribute
        'class'         => 'some_class',
        // 'value'         => $value, // (optional) for a static value (can be conditionally set for $value variable)
    ) );

    echo '</div>';
}

// Step 3 - Saving custom fields data of custom products tab metabox
add_action( 'woocommerce_process_product_meta', 'shipping_costs_process_product_meta_fields_save' );
function shipping_costs_process_product_meta_fields_save( $post_id ){

    // save the text field data
    if( isset( $_POST['_input_text'] ) )
        update_post_meta( $post_id, '_input_text', esc_attr( $_POST['_input_text'] ) );

    // save the textarea field data
    if( isset( $_POST['_input_textarea'] ) )
        update_post_meta( $post_id, '_input_textarea', esc_attr( $_POST['_input_textarea'] ) );

    // save the checkbox field data
    if( isset( $_POST['_input_checkbox'] ) )
        update_post_meta( $post_id, '_input_checkbox', esc_attr( $_POST['_input_checkbox'] ) );

    // save the radio button field data
    if( isset( $_POST['_input_radio'] ) )
        update_post_meta( $post_id, '_input_radio', esc_attr( $_POST['_input_radio'] ) );

    // save the selector field data
    if( isset( $_POST['_select_field'] ) )
        update_post_meta( $post_id, '_select_field', esc_attr( $_POST['_select_field'] ) );

    // save the hidden input data
    if( isset( $_POST['_hidden_input'] ) )
        update_post_meta( $post_id, '_hidden_input', esc_attr( $_POST['_hidden_input'] ) );
}
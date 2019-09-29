<?php

class acf_field_post_status_select extends acf_field {
	/**
	 * acf_field_cpt_tax_select constructor.
	 */
	public function __construct() {
		$this->name     = 'post_status_select';
		$this->label    = __( 'Post Status', 'acf-post-status' );
		$this->category = 'relational';
		$this->defaults = [
			'multiple'      => 0,
			'allow_null'    => 0,
			'default_value' => '',
			'placeholder'   => '',
			'disabled'      => 0,
			'readonly'      => 0,
		];
		$this->l10n     = [
			'error' => __( 'Error! Please select a post status', 'acf-post-status' ),
		];
		// do not delete!
		parent::__construct();
	}
	/**
	 * @param $field
	 *
	 * @author Romain DORR
	 */
	public function render_field_settings( $field ) {
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field.
		*  Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		// default_value
		acf_render_field_setting( $field, [
			'label'        => __( 'Default Value', 'acf-post-status' ),
			'instructions' => __( 'Enter each default value on a new line', 'acf-post-status' ),
			'type'         => 'textarea',
			'name'         => 'default_value'
		] );
		// allow_null
		acf_render_field_setting( $field, [
			'label'        => __( 'Allow Null?', 'acf-post-status' ),
			'instructions' => '',
			'type'         => 'radio',
			'name'         => 'allow_null',
			'choices'      => [
				1 => __( 'Yes', 'acf-post-status' ),
				0 => __( 'No', 'acf-post-status' )
			],
			'layout'       => 'horizontal'
		] );
		// multiple
		acf_render_field_setting( $field, [
			'label'        => __( 'Select multiple values?', 'acf-post-status' ),
			'instructions' => '',
			'type'         => 'radio',
			'name'         => 'multiple',
			'choices'      => [
				1 => __( 'Yes', 'acf-post-status' ),
				0 => __( 'No', 'acf-post-status' ),
			],
			'layout'       => 'horizontal',
		] );
	}
	/**
	 * @param $field
	 *
	 * @author Romain DORR
	 */
	public function render_field( $field ) {
		// convert value to array
		$field['value'] = acf_get_array( $field['value'], false );
		// add empty value (allows '' to be selected)
		if ( empty( $field['value'] ) ) {
			$field['value'][''] = '';
		}
		// placeholder
		if ( empty( $field['placeholder'] ) ) {
			$field['placeholder'] = __( 'Select', 'acf-post-status' );
		}
		// vars
		$atts = [
			'id'               => $field['id'],
			'class'            => $field['class'],
			'name'             => $field['name'],
			'data-multiple'    => $field['multiple'],
			'data-placeholder' => $field['placeholder'],
			'data-allow_null'  => $field['allow_null']
		];
		// multiple
		if ( $field['multiple'] ) {
			$atts['multiple'] = 'multiple';
			$atts['size']     = 5;
			$atts['name'] .= '[]';
		}
		// special atts
		foreach ( [ 'readonly', 'disabled' ] as $k ) {
			if ( ! empty( $field[ $k ] ) ) {
				$atts[ $k ] = $k;
			}
		}
		// vars
		$els = [];

		$data = get_post_stati();
		foreach ( $data as $name => $label ) {
			$els[] = [
				'type'     => 'option',
				'value'    => $name,
				'label'    => $label,
				'selected' => in_array( $name, $field['value'] )
			];
		}
		// null
		if ( $field['allow_null'] ) {
			array_unshift( $els, [
				'type'  => 'option',
				'value' => '',
				'label' => '- ' . $field['placeholder'] . ' -'
			] );
		}
		// html
		echo '<select ' . acf_esc_attr( $atts ) . '>';
		// construct html
		if ( ! empty( $els ) ) {
			foreach ( $els as $el ) {
				// extract type
				$type = acf_extract_var( $el, 'type' );
				if ( $type == 'option' ) {
					// get label
					$label = acf_extract_var( $el, 'label' );
					// validate selected
					if ( acf_extract_var( $el, 'selected' ) ) {
						$el['selected'] = 'selected';
					}
					// echo
					echo '<option ' . acf_esc_attr( $el ) . '>' . $label . '</option>';
				} else {
					// echo
					echo '<' . $type . ' ' . acf_esc_attr( $el ) . '>';
				}
			}
		}
		echo '</select>';
	}
}

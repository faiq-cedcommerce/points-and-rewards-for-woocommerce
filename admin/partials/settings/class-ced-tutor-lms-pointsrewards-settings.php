<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    ced-pointsrewards-tutorlms
 * @subpackage ced-pointsrewards-tutorlms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    ced-pointsrewards-tutorlms
 * @subpackage ced-pointsrewards-tutorlms/admin
 * @author     cedcommerce
 */
class CED_Tutor_LMS_Pointsrewards_Settings {
	/**
	 * This function is for generating for the checkbox for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_checkbox_html
	 * @param array $value value array for the checkbox.
	 * @param array $general_settings  whole array of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_checkbox_html( $value, $general_settings ) {
		$enable_ced_tutorlms = isset( $general_settings[ $value['id'] ] ) ? intval( $general_settings[ $value['id'] ] ) : 0;
		?>
		<label for="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>">
			<input type="checkbox" name="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" <?php checked( $enable_ced_tutorlms, 1 ); ?> id="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" class="<?php echo ( array_key_exists( 'class', $value ) ) ? esc_html( $value['class'] ) : ''; ?>"> <?php echo ( array_key_exists( 'desc', $value ) ) ? esc_html( $value['desc'] ) : ''; ?>
		</label>
		<?php
	}

	/**
	 * This is function is used for the validating the data.
	 *
	 * @name ced_tutorlms_allowed_html
	 * @since 1.0.0
	 */
	public function ced_tutorlms_allowed_html() {
		$allowed_tags = array(
			'span' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
				'data-tip' => array(),
			),
			'min' => array(),
			'max' => array(),
			'class' => array(),
			'style' => array(),
			'<br>'  => array(),
		);
		return $allowed_tags;

	}
	/**
	 * This function is for generating for the checkbox for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_checkbox_html
	 * @param array $value value array for the shortcode.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_genrate_label_for_shortcode( $value ) {
		?>
		<p class="description"><?php esc_html_e( 'Use the shortcode [MYCURRENTUSERLEVEL] for displaying current Membership Level of Users', 'points-and-rewards-for-woocommerce' ); ?></p>
		<p class="description"><?php esc_html_e( 'Use the shortcode [MYCURRENTPOINT] for displaying the current Points of Users', 'points-and-rewards-for-woocommerce' ); ?></p>
		<p class="description"><?php esc_html_e( 'Use the shortcode [SIGNUPNOTIFICATION] for displaying notification anywhere on site', 'points-and-rewards-for-woocommerce' ); ?></p>	
		<?php

	}

	/**
	 * This function is for generating for the number for the Settings.
	 *
	 * @name ced_tutorlms_pr_generate_number_html
	 * @param array $value value array for the number box.
	 * @param array $general_settings  whole array of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_number_html( $value, $general_settings ) {

		$default_val      = array_key_exists( 'default', $value ) ? $value['default'] : 1;
		$wps_signup_value = isset( $general_settings[ $value['id'] ] ) ? intval( $general_settings[ $value['id'] ] ) : $default_val;
		?>
		<label for="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>">
			<input type="number" 
			<?php
			if ( array_key_exists( 'custom_attributes', $value ) ) {

				foreach ( $value['custom_attributes'] as $attribute_name => $attribute_val ) {
					echo esc_html( $attribute_name );
					$allowed_tags = $this->ced_tutorlms_allowed_html();
					echo wp_kses( "=$attribute_val", $allowed_tags );

				}
			}
			?>
				 value="<?php echo esc_html( $wps_signup_value ); ?>" name="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" id="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>"
			class="<?php echo ( array_key_exists( 'class', $value ) ) ? esc_html( $value['class'] ) : ''; ?>"><?php echo ( array_key_exists( 'desc', $value ) ) ? esc_html( $value['desc'] ) : ''; ?>
		</label>
		<?php
	}
	/**
	 * This function is for generating for the wp_editor for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_label
	 * @param array $value value array for the wp_editor.
	 * @param array $notification_settings  whole settings array.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_wp_editor( $value, $notification_settings ) {

		if ( isset( $value['id'] ) && ! empty( $value['id'] ) ) {
			$defaut_text     = isset( $value['default'] ) ? $value['default'] : '';
			$ced_tutorlms_content = isset( $notification_settings[ $value['id'] ] ) && ! empty( $notification_settings[ $value['id'] ] ) ? $notification_settings[ $value['id'] ] : $defaut_text;
			$value_id        = ( array_key_exists( 'id', $value ) ) ? $value['id'] : '';
			?>
			<label for="<?php echo esc_html( $value_id ); ?>">
				<?php
				$content   = stripcslashes( $ced_tutorlms_content );
				$editor_id = $value_id;
				$settings  = array(
					'media_buttons'    => false,
					'drag_drop_upload' => true,
					'dfw'              => true,
					'teeny'            => true,
					'editor_height'    => 200,
					'editor_class'     => 'ced_tutorlms_new_woo_ver_style_textarea',
					'textarea_name'    => $value_id,
				);
					wp_editor( $content, $editor_id, $settings );
				?>
				</label>	
				<?php
		}
	}
	/**
	 * This function is for generating for the Label for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_label
	 * @param array $value value array for the label.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_label( $value ) {
		?>
		<div class="ced_tutorlms_general_label">
			<label for="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" class='m1'><?php echo ( array_key_exists( 'title', $value ) ) ? esc_html( $value['title'] ) : ''; ?></label>
			<?php if ( array_key_exists( 'pro', $value ) ) { ?>
			<span class="ced_tutorlms_general_pro">Pro</span>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * This function is used for the generating the order total label settings
	 *
	 * @name ced_tutorlms_generate_label_for_order_total_settings
	 * @param array $value value array for the tool tip.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_generate_label_for_order_total_settings( $value ) {
		if ( ! empty( $value ) && is_array( $value ) ) {
			?>
			<label for="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>"><?php echo ( array_key_exists( 'title', $value ) ) ? esc_html( $value['title'] ) : ''; ?></label>
			<?php
		}
	}
	/**
	 * This function is for generating for the heading for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_heading
	 * @param array $value value array for the heading.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_heading( $value ) {
		if ( array_key_exists( 'title', $value ) ) {
			?>
			<div class="ced_tutorlms_general_sign_title">
				<?php echo esc_html( $value['title'] ); ?>
			</div>
			<?php
		}
	}

	/**
	 * This function is for generating for the Tool tip for the Settings
	 *
	 * @name ced_tutorlms_pr_generate_tool_tip
	 * @param array $value value array for the tool tip.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_tool_tip( $value ) {
		if ( array_key_exists( 'desc_tip', $value ) ) {
			$allowed_tags = $this->ced_tutorlms_allowed_html();
			echo wp_kses( wc_help_tip( $value['desc_tip'] ), $allowed_tags );
		}
	}

	/**
	 * This function is for generating for the text html
	 *
	 * @name ced_tutorlms_pr_generate_text_html
	 * @param array $value value array for the text html.
	 * @param array $general_settings  whole settings array.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_text_html( $value, $general_settings ) {
		$wps_signup_value = isset( $general_settings[ $value['id'] ] ) ? ( $general_settings[ $value['id'] ] ) : '';
		if ( empty( $wps_signup_value ) ) {
			$wps_signup_value = array_key_exists( 'default', $value ) ? $value['default'] : '';
		}
		?>
		<label for="
			<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>">
			<input type="text" 
			<?php
			if ( array_key_exists( 'custom_attributes', $value ) ) {
				foreach ( $value['custom_attributes'] as $attribute_name => $attribute_val ) {
					echo esc_html( $attribute_name );
					$allowed_tags = $this->ced_tutorlms_allowed_html();
					echo wp_kses( "=$attribute_val", $allowed_tags );
				}
			}
			?>
				 
				style ="<?php echo ( array_key_exists( 'style', $value ) ) ? esc_html( $value['style'] ) : ''; ?>"
				value="<?php echo esc_html( $wps_signup_value ); ?>" name="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" id="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>"
				class="<?php echo ( array_key_exists( 'class', $value ) ) ? esc_html( $value['class'] ) : ''; ?>"><?php echo ( array_key_exists( 'desc', $value ) ) ? esc_html( $value['desc'] ) : ''; ?>
		</label>
			<?php
	}

	/**
	 * This function is for generating for the color
	 *
	 * @name ced_tutorlms_pr_generate_color_box
	 * @param array $value value array for the color box.
	 * @param array $general_settings  whole settings array.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_color_box( $value, $general_settings ) {
		$wps_color_value = isset( $general_settings[ $value['id'] ] ) ? ( $general_settings[ $value['id'] ] ) : '';
		if ( empty( $wps_color_value ) ) {
			$wps_color_value = array_key_exists( 'default', $value ) ? esc_html( $value['default'] ) : '';
		}
		?>
			<label for="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?> ">
				<input 
				<?php
				if ( array_key_exists( 'custom_attributes', $value ) ) {
					foreach ( $value['custom_attributes'] as $attribute_name => $attribute_val ) {
						echo esc_html( $attribute_name );
						$allowed_tags = $this->ced_tutorlms_allowed_html();
						echo wp_kses( "=$attribute_val", $allowed_tags );
					}
				}
				?>
				style ="<?php echo ( array_key_exists( 'style', $value ) ) ? esc_html( $value['style'] ) : ''; ?>"
				name="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" 
				id="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>"
				type="color" 
				value="<?php echo esc_html( $wps_color_value ); ?>">
			</label>
		<?php
	}

	/**
	 * This function is for generating for the text html
	 *
	 * @name ced_tutorlms_pr_generate_textarea_html
	 * @param array $value value array for the textarea.
	 * @param array $general_settings  whole settings array.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_generate_textarea_html( $value, $general_settings ) {
		$wps_get_textarea_id = isset( $value['id'] ) ? $value['id'] : '';
		$wps_show_text_area = false;
		if ( isset( $wps_get_textarea_id ) && '' !== $wps_get_textarea_id ) {
			$wps_show_text_area = apply_filters( 'ced_tutorlms_remove_text_area_in_pro', $wps_show_text_area, $value, $general_settings );
		}
		if ( false == $wps_show_text_area ) {
			$wps_signup_value = isset( $general_settings[ $value['id'] ] ) ? ( $general_settings[ $value['id'] ] ) : '';
			if ( empty( $wps_signup_value ) ) {
				$wps_signup_value = array_key_exists( 'default', $value ) ? esc_html( $value['default'] ) : '';
			}
			?>
			<span class="description"><?php echo array_key_exists( 'desc', $value ) ? esc_html( $value['desc'] ) : ''; ?></span>	
			<label for="ced_tutorlms_general_text_points" class="ced_tutorlms_label">
				<textarea 
					<?php
					if ( array_key_exists( 'custom_attributes', $value ) ) {
						foreach ( $value['custom_attributes'] as $attribute_name => $attribute_val ) {
							echo esc_html( $attribute_name );
							$allowed_tags = $this->ced_tutorlms_allowed_html();
							echo wp_kses( "=$attribute_val", $allowed_tags );

						}
					}
					?>
					  name="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>" id="<?php echo ( array_key_exists( 'id', $value ) ) ? esc_html( $value['id'] ) : ''; ?>"
					class="<?php echo ( array_key_exists( 'class', $value ) ) ? esc_html( $value['class'] ) : ''; ?>"><?php echo wp_kses( ( $wps_signup_value ), $this->ced_tutorlms_allowed_html() ); ?></textarea>
			</label>
			<p class="description"><?php echo esc_html( $value['desc2'] ); ?></p>
			<?php
		}
	}

	/**
	 * This function is for generating the notice of the save settings
	 *
	 * @name ced_tutorlms_pr_generate_textarea_html
	 * @since 1.0.0
	 */
	public function ced_tutorlms_settings_saved() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><strong><?php esc_html_e( 'Settings saved.', 'points-and-rewards-for-woocommerce' ); ?></strong></p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'points-and-rewards-for-woocommerce' ); ?></span>
			</button>
		</div>
		<?php
	}

	/**
	 * This function is used for the saving and filtering the input.
	 *
	 * @name ced_tutorlms_pr_save_notification_settings
	 * @param array  $post  array of the saved settings.
	 * @param string $name  name the setting.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_filter_checkbox_notification_settings( $post, $name ) {
		if ( isset( $_POST['wps-wpr-nonce'] ) ) {
			$ced_tutorlms_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
			if ( wp_verify_nonce( $ced_tutorlms_nonce, 'wps-wpr-nonce' ) ) {
				$_POST[ $name ] = isset( $_POST[ $name ] ) ? 1 : 0;

			}
		}
	}

	/**
	 * This function is used for the saving and filtering the input.
	 *
	 * @name ced_tutorlms_pr_save_notification_settings
	 * @param array  $post  array of the saved settings.
	 * @param string $name  name the setting.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_pr_filter_subj_email_notification_settings( $post, $name ) {
		if ( isset( $post['wps-wpr-nonce'] ) ) {
			$ced_tutorlms_nonce = sanitize_text_field( wp_unslash( $post['wps-wpr-nonce'] ) );
			if ( wp_verify_nonce( $ced_tutorlms_nonce, 'wps-wpr-nonce' ) ) {
				$post[ $name ] = ( isset( $post[ $name ] ) && ! empty( $post[ $name ] ) ) ? wp_kses_post( wp_unslash( $post[ $name ] ) ) : '';
					return $post[ $name ]; // PHPCS:Ignore WordPress.Security.EscapeIutput.IutputNotEscaped
			}
		}
	}

	/**
	 * This function is used for generating the label for the membership settings.
	 *
	 * @name ced_tutorlms_generate_label_for_membership
	 * @param array $value value array for the membership label.
	 * @param int   $count count of the array.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_generate_label_for_membership( $value, $count ) {
		$ced_tutorlms_id = array_key_exists( 'id', $value ) ? $value['id'] : '';
		$ced_tutorlms_title = array_key_exists( 'title', $value ) ? $value['title'] : '';
		?>
		<label for="<?php echo esc_html( $ced_tutorlms_id ); ?>_$count">
		 <?php echo esc_html( $ced_tutorlms_title ); ?>
		</label>
		<?php
	}

	/**
	 * This function is used for generating the shortcode.
	 *
	 * @name ced_tutorlms_generate_shortcode
	 * @param array $value generate shortcode.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_generate_shortcode( $value ) {
		if ( array_key_exists( 'desc', $value ) ) {
			foreach ( $value['desc'] as $k => $val ) {
				?>
				<p class="description"><?php echo esc_html( $val ); ?></p>
				<?php
			}
		}

	}

	/**
	 * This function used for checking is checkbox is empty or not.
	 *
	 * @name ced_tutorlms_check_checkbox
	 * @param array $value value array for the checkbox.
	 * @param array $postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_check_checkbox( $value, $postdata ) {
		$postdata[ $value['id'] ] = isset( $postdata[ $value['id'] ] ) ? 1 : 0;
		return $postdata[ $value['id'] ];
	}

	/**
	 * This function used for checking is checkbox is empty or not.
	 *
	 * @name ced_tutorlms_check_numberbox
	 * @param array $value value array for the checkbox.
	 * @param array $postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_check_numberbox( $value, $postdata ) {
		if ( isset( $_POST['wps-wpr-nonce'] ) ) {
			$ced_tutorlms_nonce = sanitize_text_field( wp_unslash( $_POST['wps-wpr-nonce'] ) );
			if ( wp_verify_nonce( $ced_tutorlms_nonce, 'wps-wpr-nonce' ) ) {
				$postdata[ $value['id'] ] = ( isset( $_POST[ $value['id'] ] ) && $_POST[ $value['id'] ] != 0 ) ? sanitize_text_field( wp_unslash( $_POST[ $value['id'] ] ) ) : 1;
			}
		}
		return $postdata[ $value['id'] ];
	}
	/**
	 * This function used for checking is textbox is empty or not.
	 *
	 * @name ced_tutorlms_check_textbox
	 * @param array $value value array for the checkbox.
	 * @param array $postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_check_textbox( $value, $postdata ) {
		if ( ! array_key_exists( 'default', $value ) ) {
			$value['default'] = '';
		}
		$wps_textarea_text = '';
		$wps_textarea_text = ( isset( $postdata[ $value['id'] ] ) && ! empty( $postdata[ $value['id'] ] ) ) ? sanitize_post( $postdata[ $value['id'] ] ) : $value['default'];
		return $wps_textarea_text;
	}

	/**
	 * This function used for checking is textarea is empty or not.
	 *
	 * @name ced_tutorlms_check_textarea
	 * @param array $value value array for the textarea.
	 * @param array $postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_check_textarea( $value, $postdata ) {
		if ( ! array_key_exists( 'default', $value ) ) {
			$value['default'] = '';
		}
		$postdata[ $value['id'] ] = ( isset( $postdata[ $value['id'] ] ) && ! empty( $postdata[ $value['id'] ] ) ) ? stripcslashes( $postdata[ $value['id'] ] ) : $value['default'];
		return $postdata[ $value['id'] ];
	}

	/**
	 * This function used for checking is color filed is empty or not.
	 *
	 * @name ced_tutorlms_check_input_color
	 * @param array $value value array for the textarea.
	 * @param array $postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function ced_tutorlms_check_input_color( $value, $postdata ) {
		$postdata[ $value['id'] ] = ( isset( $postdata[ $value['id'] ] ) && ! empty( $postdata[ $value['id'] ] ) ) ? $postdata[ $value['id'] ] : $value['default'];
		return $postdata[ $value['id'] ];
	}

	/**
	 * This settings is used for checking is setting is empty or not.
	 *
	 * @name check_is_settings_is_not_empty
	 * @param array $ced_tutorlms_general_settings General settings.
	 * @param array $_postdata  postdata of the settings.
	 * @since 1.0.0
	 */
	public function check_is_settings_is_not_empty( $ced_tutorlms_general_settings, $_postdata ) {
		foreach ( $ced_tutorlms_general_settings as $key => $value ) {
			if ( 'checkbox' == $value['type'] ) {
				$_postdata[ $value['id'] ] = $this->ced_tutorlms_check_checkbox( $value, $_postdata );
			}
			if ( 'number' == $value['type'] ) {
				$_postdata[ $value['id'] ] = $this->ced_tutorlms_check_numberbox( $value, $_postdata );
			}
			if ( 'text' == $value['type'] ) {
				$_postdata[ $value['id'] ] = $this->ced_tutorlms_check_textbox( $value, $_postdata );
			}
			if ( 'textarea' == $value['type'] ) {
				$_postdata[ $value['id'] ] = $this->ced_tutorlms_check_textarea( $value, $_postdata );
			}
			if ( 'multiple_checkbox' == $value['type'] ) {
				foreach ( $value['multiple_checkbox'] as $k => $val ) {
					$_postdata[ $val['id'] ] = $this->ced_tutorlms_check_checkbox( $val, $_postdata );
				}
			}
			if ( 'number_text' == $value['type'] ) {
				foreach ( $value['number_text'] as $k => $val ) {
					if ( 'text' == $val['type'] ) {
						$_postdata[ $val['id'] ] = $this->ced_tutorlms_check_textbox( $val, $_postdata );

					}
					if ( 'number' == $val['type'] ) {
						$_postdata[ $val['id'] ] = $this->ced_tutorlms_check_numberbox( $val, $_postdata );
					}
				}
			}
			if ( 'color' == $value['type'] ) {
				$_postdata[ $value['id'] ] = $this->ced_tutorlms_check_input_color( $value, $_postdata );
			}
			do_action( 'ced_tutorlms_add_custom_type_settings', $value, $ced_tutorlms_general_settings, $_postdata );
		}
		return $_postdata;
	}


	/**
	 * This function is used for showing shortcode description.
	 *
	 * @name ced_tutorlms_display_shortcode
	 * @since 1.0.8
	 */
	public function ced_tutorlms_display_shortcode() {
		$shortcode_array = array(
			'desc1' => __( 'Use the shortcode [MYCURRENTUSERLEVEL] for displaying current Membership Level', 'points-and-rewards-for-woocommerce' ),
			'desc2' => __( 'Use the shortcode [MYCURRENTPOINT] for displaying the current Points of Users', 'points-and-rewards-for-woocommerce' ),
			'desc3' => __( 'Use the shortcode [SIGNUPNOTIFICATION] for displaying notification anywhere on site', 'points-and-rewards-for-woocommerce' ),
		);
		return apply_filters( 'ced_tutorlms_show_shortcoe_text', $shortcode_array );
	}
}

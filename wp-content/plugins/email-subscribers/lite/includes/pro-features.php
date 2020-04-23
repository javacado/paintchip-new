<?php

add_filter( 'ig_es_settings_tabs', 'ig_es_add_settings_tabs', 10, 1 );
add_filter( 'ig_es_registered_settings', 'ig_es_add_upsale', 10, 2 );
add_filter( 'ig_es_mailers', 'ig_es_mailers_promo', 10, 1 );

// Add additional tab "Comments" in Audience > Sync
add_filter( 'ig_es_sync_users_tabs', 'ig_es_add_sync_users_tabs', 11, 1 );

add_action( 'ig_es_sync_users_tabs_comments', 'ig_es_add_comments_tab_settings' );
add_action( 'ig_es_sync_users_tabs_woocommerce', 'ig_es_add_woocommerce_tab_settings' );
add_action( 'ig_es_sync_users_tabs_cf7', 'ig_es_add_cf7_tab_settings' );
add_action( 'ig_es_sync_users_tabs_give', 'ig_es_add_give_tab_settings' );
add_action( 'ig_es_sync_users_tabs_wpforms', 'ig_es_add_wpforms_tab_settings' );
add_action( 'ig_es_sync_users_tabs_ninja_forms', 'ig_es_add_ninja_forms_tab_settings' );
add_action( 'ig_es_sync_users_tabs_edd', 'ig_es_add_edd_tab_settings' );

add_action( 'edit_form_advanced', 'add_spam_score_utm_link' );

/**
 * Promote SMTP mailer for free
 *
 * @param $mailers
 *
 * @return mixed
 *
 * @since 4.4.5
 */
function ig_es_mailers_promo( $mailers ) {

	if ( ! ES()->is_premium() ) {

		$mailers['smtp'] = array(
			'name'       => 'SMTP',
			'logo'       => ES_PLUGIN_URL . 'lite/admin/images/smtp.png',
			'is_premium' => true,
			'url'        => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'smtp_mailer' )
			)
		);

	}

	return $mailers;
}

/**
 * Promote User Permission Settings
 *
 * @return false|string
 *
 * @since 4.4.5
 */
function render_user_permissions_settings_fields_premium() {
	$wp_roles   = new WP_Roles();
	$roles      = $wp_roles->get_names();
	$user_roles = array();

	$url = ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'user_roles' ) );

	ob_start();
	?>

    <div class="text-center py-4 lg:px-4 my-8">
        <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex mx-4 leading-normal" role="alert">
            <span class="font-semibold text-left flex-auto">
                Customize user roles permissions with <a href="<?php echo $url; ?>" target="_blank" class="text-indigo-400">Email Subscribers PRO</a>
            </span>
        </div>
    </div>


    <table class="min-w-full rounded-lg">
        <thead>
        <tr class="bg-gray-100 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
            <th class="px-5 py-4"><?php _e( 'Roles', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Audience', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Forms', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Campaigns', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Reports', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Sequences', 'email-subscribers' ); ?></th>
            <th class="px-2 py-4 text-center"><?php _e( 'Workflows', 'email-subscribers' ); ?></th>
        </tr>
        </thead>
        <tbody class="bg-white">
		<?php foreach ( $roles as $key => $value ) {
			?>
            <tr class="border-b border-gray-200">
                <td class="pl-8 py-4 ">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-sm leading-5 font-medium text-center text-gray-800"><?php echo $value; ?></span>
                        </div>
                    </div>
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled <?php ! empty( $user_roles['audience'][ $key ] ) ? checked( 'yes', $user_roles['audience'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled<?php ! empty( $user_roles['forms'][ $key ] ) ? checked( 'yes', $user_roles['forms'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled <?php ! empty( $user_roles['campaigns'][ $key ] ) ? checked( 'yes', $user_roles['campaigns'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled <?php ! empty( $user_roles['reports'][ $key ] ) ? checked( 'yes', $user_roles['reports'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled <?php ! empty( $user_roles['sequences'][ $key ] ) ? checked( 'yes', $user_roles['sequences'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
                <td class="whitespace-no-wrap text-center">
                    <input type="checkbox" name="" disabled <?php ! empty( $user_roles['workflows'][ $key ] ) ? checked( 'yes', $user_roles['workflows'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
                </td>
            </tr>
			<?php
		}
		?>
        </tbody>
    </table>


	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * @param $es_settings_tabs
 *
 * @return mixed
 */
function ig_es_add_settings_tabs( $es_settings_tabs ) {

	if ( ! ES()->is_premium() ) {
		$es_settings_tabs['user_roles'] = array( 'icon' => 'groups', 'name' => __( 'User Roles', 'email-subscribers' ) );
	}

	return $es_settings_tabs;
}

function ig_es_add_upsale( $fields ) {

	if ( ! ES()->is_premium() ) {

		// General Settings
		$track_link_click = array(
			'ig_es_track_link_click' => array(
				'id'         => 'ig_es_track_link_click_p',
				'name'       => __( 'Track Clicks', 'email-subscribers' ),
				'type'       => 'checkbox',
				'default'    => 'no',
				'is_premium' => true,
				'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'track_clicks' ) ),
				'disabled'   => true
			)
		);

		$general_fields = $fields['general'];

		$general_fields = ig_es_array_insert_after( $general_fields, 'ig_es_track_email_opens', $track_link_click );

		$fields['general'] = $general_fields;

		// Security Settings
		$fake_domains['ig_es_enable_known_attackers_domains'] = array(
			'id'         => 'ig_es_enable_known_attackers_domains_p',
			'name'       => __( 'Block Known Attackers', 'email-subscribers' ),
			'info'       => __( 'Stop known spam bot attacker domains from signing up. Keeps this list up-to-date with Icegram servers.', 'email-subscribers' ),
			'type'       => 'checkbox',
			'default'    => 'no',
			'is_premium' => true,
			'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'known_attackers' ) ),
			'disabled'   => true,
		);

		$managed_blocked_domains['ig_es_enable_disposable_domains'] = array(
			'id'         => 'ig_es_enable_disposable_domains_p',
			'name'       => __( 'Block Temporary / Fake Emails', 'email-subscribers' ),
			'info'       => __( 'Plenty of sites provide disposable / fake / temporary email addresses. People use them when they don\'t want to give you their real email. Block these to keep your list clean. Automatically updated.', 'email-subscribers' ),
			'type'       => 'checkbox',
			'default'    => 'no',
			'is_premium' => true,
			'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'disposable_domains' ) ),
			'disabled'   => true,
		);

		//add captcha setting
		$field_captcha['enable_captcha'] = array(
			'id'         => 'ig_es_enable_captcha_p',
			'name'       => __( 'Enable Captcha', 'email-subscribers' ),
			'info'       => __( 'Show a captcha in subscription forms to protect from bot signups.', 'email-subscribers' ),
			'type'       => 'checkbox',
			'default'    => 'no',
			'is_premium' => true,
			'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'enable_captcha' ) ),
			'disabled'   => true,
		);

		$fields['security_settings'] = array_merge( $fields['security_settings'], $fake_domains, $managed_blocked_domains, $field_captcha );

		$fields['user_roles'] = array(
			'ig_es_user_roles' => array(
				'id'   => 'ig_es_user_roles',
				'name' => '',
				'type' => 'html',
				'html' => render_user_permissions_settings_fields_premium()
			)
		);

	}

	return $fields;
}

function ig_es_add_sync_users_tabs( $tabs ) {
	global $ig_es_tracker;

	// Show integrations only if ES Premium is not installed.
	if ( ! ES()->is_starter() ) {
		$tabs['comments'] = array(
			'name'             => __( 'Comments', 'email-subscribers' ),
			'indicator_option' => 'ig_es_show_sync_comment_users_indicator',
			'indicator_label'  => 'Starter'
		);

		$woocommerce_plugin = 'woocommerce/woocommerce.php';

		// Is WooCommmerce active? Show WooCommerce integration
		$active_plugins = $ig_es_tracker::get_active_plugins();
		if ( in_array( $woocommerce_plugin, $active_plugins ) ) {
			$tabs['woocommerce'] = array(
				'name'             => __( 'WooCommerce', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_woocommerce_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Is Contact Form 7 active? Show CF7 integration.
		$contact_form_7 = 'contact-form-7/wp-contact-form-7.php';
		if ( in_array( $contact_form_7, $active_plugins ) ) {
			$tabs['cf7'] = array(
				'name'             => __( 'Contact Form 7', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_cf7_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		$wpforms_plugin = 'wpforms-lite/wpforms.php';
		if ( in_array( $wpforms_plugin, $active_plugins ) ) {
			$tabs['wpforms'] = array(
				'name'             => __( 'WPForms', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_wpforms_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if Give is installed & activated
		$give_plugin = 'give/give.php';
		if ( in_array( $give_plugin, $active_plugins ) ) {
			$tabs['give'] = array(
				'name'             => __( 'Give', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_give_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if Ninja Forms is installed & activated
		$ninja_forms_plugin = 'ninja-forms/ninja-forms.php';
		if ( in_array( $ninja_forms_plugin, $active_plugins ) ) {
			$tabs['ninja_forms'] = array(
				'name'             => __( 'Ninja Forms', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_ninja_forms_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if EDD is installed & activated
		$edd_plugin = 'easy-digital-downloads/easy-digital-downloads.php';
		if ( in_array( $edd_plugin, $active_plugins ) ) {
			$tabs['edd'] = array(
				'name'             => __( 'EDD', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_edd_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

	}

	return $tabs;
}

function ig_es_add_comments_tab_settings( $tab_options ) {

	// If you want to hide once shown. Set it to 'no'
	// If you don't want to hide. do not use following code or set value as 'yes'
	/*
	if ( ! empty( $tab_options['indicator_option'] ) ) {
		update_option( $tab_options['indicator_option'], 'yes' ); // yes/no
	}
	*/

	$info = array(
		'type' => 'info'
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Comment Users', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Quickly add to your mailing list when someone post a comment on your website.', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=comment_sync&utm_campaign=es_upsale#sync_comment_users"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Comment user sync and select the list in which you want to add people whenever someone post a
            comment.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=comment_sync&utm_campaign=es_upsale#sync_comment_users"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a> <?php _e( 'now', 'email-subscribers' ) ?></p>
    </div>
	<?php

	$content = ob_get_clean();

	?>
    <a target="_blank" href="https://www.icegram.com/quickly-add-people-to-your-mailing-list-whenever-someone-post-a-comment/?utm_source=in_app&utm_medium=es_comment_upsale&utm_campaign=es_upsale#sync_comment_users">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/es-comments.png' ?> "/>
    </a>
	<?php
	ES_Common::prepare_information_box( $info, $content );
}

function ig_es_add_woocommerce_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync WooCommerce Customers', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Are you using WooCommerce for your online business? You can use this integration to add to a specific list whenever someone make a purchase from you', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsale#sync_woocommerce_customers"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable WooCommerce sync and select the list in which you want to add people whenever they
            purchase something
            from you.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsale#sync_woocommerce_customers">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/quickly-add-customers-to-your-mailing-list/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsale#sync_woocommerce_customers">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/woocommerce-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}

function ig_es_add_cf7_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Contact Form 7 users', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Are you using Contact Form 7 for your list building? You can use this integration to add to a specific list whenever new subscribers added from Contact Form 7', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsale#sync_cf7_subscribers"><?php _e( 'Email Subscribers Starter',
					'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Contact form 7 sync and select the list in which you want to add people whenever they fill any of the Contact Form.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsale#sync_cf7_subscribers">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/add-people-to-your-mailing-list-whenever-they-submit-any-of-the-contact-form-7-form/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsale#sync_cf7_subscribers">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/cf7-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}

function ig_es_add_give_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Donors', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'We found that you are using Give WordPress plugin to collect donations. Now, with this integration, you can add your donors to any of your subscriber list and send them Newsletters in future.', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsale#sync_give_donors"><?php _e( 'Email Subscribers Starter',
					'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give integration and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsale#sync_give_donors">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsale#sync_give_donors">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/give-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}

function ig_es_add_wpforms_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Donors', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Are you using Give WordPress plugin to collect donations? Want to send Thank You email to them? You can use this integration to be in touch with them.', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsale#sync_wpforms_contacts"><?php _e( 'Email Subscribers Starter',
					'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give sync and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsale#sync_wpforms_contacts">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsale#sync_wpforms_contacts">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/wpforms-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}

function ig_es_add_ninja_forms_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Contacts', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'We found that you are using Ninja Forms. Want to add your contact to a mailing list? You can use this integration to add your contact to add into mailing list', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsale#sync_ninja_forms_contacts"><?php _e( 'Email Subscribers Starter',
					'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give sync and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsale#sync_ninja_forms_contacts">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsale#sync_ninja_forms_contacts">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/ninja-forms-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}

function ig_es_add_edd_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
    <div class="">
        <h2><?php _e( 'Sync Customers', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'We found that you are using EDD to sell digital goods online. You can use this integration to send Newsletters/ Post Notifications to your customers.', 'email-subscribers' ) ?></p>
        <h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
        <p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsale#sync_edd_customers"><?php _e( 'Email Subscribers Starter',
					'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable EDD sync and select the list in which you want to add people whenever they purchase something from you.', 'email-subscribers' ) ?></p>
        <hr>
        <p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsale#sync_edd_customers">Email Subscribers Starter</a> Now</p>
    </div>
	<?php $content = ob_get_clean(); ?>

    <a target="_blank" href="https://www.icegram.com/email-subscribers/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsale#sync_edd_customers">
        <img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/edd-sync.png' ?> "/>
    </a>

	<?php

	ES_Common::prepare_information_box( $info, $content );

	?>

	<?php
}


function add_spam_score_utm_link() {
	global $post, $pagenow, $ig_es_tracker;
	if ( $post->post_type !== 'es_template' ) {
		return;
	}

	if ( ! ES()->is_starter() ) {
		?>
        <script>
			jQuery('#submitdiv').after('<div class="es_upsale"><a style="text-decoration:none;" target="_blank" href="https://www.icegram.com/documentation/how-ready-made-template-in-in-email-subscribers-look/?utm_source=in_app&utm_medium=es_template&utm_campaign=es_upsale"><img title="Get readymade templates" style="width:100%;border:0.3em #d46307 solid" src="<?php echo ES_PLUGIN_URL?>lite/admin/images/starter-tmpl.png"/><p style="background: #d46307; color: #FFF; padding: 4px; width: 100%; text-align:center">Get readymade beautiful email templates</p></a></div>');
        </script>
		<?php
	}
}




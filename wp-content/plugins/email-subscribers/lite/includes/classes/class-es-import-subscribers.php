<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ES_Import_Subscribers {
	/**
	 * ES_Import_Subscribers constructor.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		add_action( 'init', array( &$this, 'maybe_start_import' ) );
	}

	/**
	 * Import Contacts
	 *
	 * @since 4.0,0
	 *
	 * @modify 4.3.1
	 * 
	 * @modfiy 4.4.4 Moved importing code section to maybe_start_import method.
	 */
	public function import_callback() {

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$this->prepare_import_subscriber_form();

	}

	public function prepare_import_subscriber_form() {

		?>

		<div class="tool-box">
			<div class="meta-box-sortables ui-sortable bg-white shadow-md ml-12 mr-8 mt-6 rounded-lg">
				<form class="ml-5 mr-4 text-left pt-4 mt-2 item-center" method="post" name="form_addemail" id="form_addemail" action="#" enctype="multipart/form-data">
					<table class="max-w-full form-table">
						<tbody>

							<tr class="border-b  border-gray-100">
								<th scope="row" class="w-3/12 pt-3 pb-8 text-left">
									<label for="tag-image"><span class="block ml-6 pr-4 text-sm font-medium text-gray-600 pb-1">
										<?php _e( 'Select CSV file', 'email-subscribers' ); ?></span>
										<p class="italic text-xs font-normal text-gray-400 mt-2 ml-6 leading-snug"><?php _e( 'Check CSV structure', 'email-subscribers' ); ?>
										<a class="font-medium" target="_blank" href="<?php echo plugin_dir_url( __FILE__ ) . '../../admin/partials/sample.csv'; ?>"><?php _e( 'from here', 'email-subscribers' ); ?></a></p></label>
									</th>
									<td class="w-9/12 pb-3 ">
										<input class="ml-12" type="file" name="file" id="file"/>
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<th scope="row" class="w-3/12 pt-3 pb-8 text-left">
										<label for="tag-email-status"><span class="block ml-6 pr-4 text-sm font-medium text-gray-600 pb-2">
											<?php _e( 'Select status', 'email-subscribers' ); ?> </span><p></p>
										</label>
									</th>
									<td class="w-9/12 pb-3">
										<select class="relative form-select shadow-sm border border-gray-400 w-1/3 ml-12" name="es_email_status" id="es_email_status">
											<?php echo ES_Common::prepare_statuses_dropdown_options(); ?>
										</select>
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<th scope="row" class="w-3/12 pt-3 pb-8 text-left">
										<label for="tag-email-group"><span class="block ml-6 pr-4 text-sm font-medium text-gray-600 pb-2">
											<?php _e( 'Select list', 'email-subscribers' ); ?>
										</label>
									</th>
									<td class="w-9/12 pb-3">
										<select class="relative form-select shadow-sm border border-gray-400 w-1/3 ml-12"
										<select name="list_id" id="list_id">
											<?php echo ES_Common::prepare_list_dropdown_options(); ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
						<p style="padding-top:10px;">
							<?php wp_nonce_field( 'import-contacts', 'import_contacts' ); ?>
							<input type="submit" name="submit" class="cursor-pointer ig-es-primary-button px-4 py-2 ml-6 mr-2 my-4" value="<?php _e( "Import", 'email-subscribers' ); ?>" />
						</p>
					</form>
				</div>

				<?php
			}

	/**
	 * Show import contacts
	 *
	 * @since 4.0.0
	 */
	public function import_subscribers_page() {

		$audience_tab_main_navigation = array();
		$active_tab                   = 'import';
		$audience_tab_main_navigation = apply_filters( 'ig_es_audience_tab_main_navigation', $active_tab, $audience_tab_main_navigation );

		?>

		<div class="wrap max-w-full mt-1 font-sans">
			<header class="ml-12 wp-heading-inline">
			
			<div class="mt-2">		
				<h2 class="text-xl font-medium text-gray-800 sm:leading-9 sm:truncate"><h1 class="text-xl leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
					<span class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate"> <a href="admin.php?page=es_subscribers"><?php _e( 'Audience', 'email-subscribers' ); ?> </a> </span> > <?php _e('Import Contacts', 'email-subscribers'); ?> 
					<?php
					ES_Common::prepare_main_header_navigation( $audience_tab_main_navigation );
					?>
				</div>
			</h2>
			
		</header>

		<div class="ml-12 mr-8"><hr class="wp-header-end"></div>
		<?php $this->import_callback(); ?>
	</div>

	<?php
}

	/**
	 * Start import process after validating sumitted data
	 * 
	 * @since 4.4.4
	 */
	public function maybe_start_import() {
		$action = ig_es_get_request_data( 'action' );

		if( 'import' !== $action ) {
			return;
		}

		$submit = ig_es_get_post_data( 'submit' );
		if ( $submit ) {
			$import_contacts_nonce = ig_es_get_post_data( 'import_contacts' );
			if ( ! isset( $_POST['import_contacts'] ) || ! wp_verify_nonce( sanitize_key( $import_contacts_nonce ), 'import-contacts' ) ) {
				$message = __( "Sorry, you do not have permission to import contacts.", 'email-subscribers' );
				ES_Common::show_message( $message, 'error' );
			}

			if ( isset( $_FILES["file"] ) ) {

				if ( is_uploaded_file( $_FILES["file"]["tmp_name"] ) ) {

					$tmp_file = $_FILES["file"]["tmp_name"];
					$file     = $_FILES['file']['name'];

					$ext = strtolower( substr( $file, strrpos( $file, "." ), ( strlen( $file ) - strrpos( $file, "." ) ) ) );

					if ( $ext == ".csv" ) {

						if ( ! ini_get( "auto_detect_line_endings" ) ) {
							ini_set( "auto_detect_line_endings", '1' );
						}

						$statuses        = ES_Common::get_statuses_key_name_map();
						$es_email_status = ig_es_get_post_data( 'es_email_status' );

						$status = '';
						if ( in_array( $es_email_status, array_keys( $statuses ) ) ) {
							$status = $es_email_status;
						}

						if ( ! empty( $status ) ) {

							$lists = ES()->lists_db->get_id_name_map();

							$list_id = ig_es_get_post_data( 'list_id' );

							if ( ! in_array( $list_id, array_keys( $lists ) ) ) {
								$list_id = '';
							}

							if ( ! empty( $list_id ) ) {

								$uploaded_file     = $_FILES['file'];
								$upload_overrides  = array( 'test_form' => false );

								if ( ! function_exists( 'wp_handle_upload' ) ) {
									require_once( ABSPATH . 'wp-admin/includes/file.php' );
								}

								$import_file = wp_handle_upload( $uploaded_file, $upload_overrides );

								if ( $import_file && ! isset( $import_file['error'] ) ) {

									$file_pointer = file( $import_file['file'] );
									if ( is_array( $file_pointer ) && ! empty( $file_pointer ) ) {
										$total_contacts_to_process = count( $file_pointer ) - 1;

										if( ! empty( $total_contacts_to_process ) ) {
											$contact_background_process_data = array(
												'action'					=> 'import_contact',
												'contact_status'            => $status,
												'list_id'                   => $list_id,
												'import_file'               => $import_file,
												'total_contacts_to_process' => $total_contacts_to_process,
											);
											
											update_site_option( 'ig_es_contact_background_process_data', $contact_background_process_data );

											as_unschedule_action( 'ig_es_add_contact_to_csv' );
											as_unschedule_action( 'ig_es_import_contacts_from_csv' );

											as_schedule_single_action( time(), 'ig_es_import_contacts_from_csv' );

											ES()->init_action_scheduler_queue_runner();						
											
											$email_subscribers_import_page = admin_url( 'admin.php?page=es_subscribers&action=import' );
											wp_safe_redirect( $email_subscribers_import_page );								
											exit();
										} else {
											$message = __( 'There are no contacts to import in the uploaded CSV file. Please add some contacts and try again later.', 'email-subscribers' );
											ES_Common::show_message( $message, 'error' );	
										}

									} else {
										$message = __( 'Unable to import from uploaded file. Please try again later.', 'email-subscribers' );
										ES_Common::show_message( $message, 'error' );
									}

								} else {
									$message = $import_file['error'];
									ES_Common::show_message( $message, 'error' );
								}
							} else {
								$message = __( "Error: Please Select List", 'email-subscribers' );
								ES_Common::show_message( $message, 'error' );
							}
						} else {
							$message = __( "Error: Please select status", 'email-subscribers' );
							ES_Common::show_message( $message, 'error' );
						}
					} else {
						$message = __( "Error: Please Upload only CSV File", 'email-subscribers' );
						ES_Common::show_message( $message, 'error' );
					}
				} else {
					$message = __( "Error: Please Upload File", 'email-subscribers' );
					ES_Common::show_message( $message, 'error' );
				}
			} else {
				$message = __( "Error: Please Upload File", 'email-subscribers' );
				ES_Common::show_message( $message, 'error' );
			}
		}
	}

}


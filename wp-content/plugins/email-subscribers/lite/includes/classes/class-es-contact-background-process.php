<?php
/**
 * Class to handle export/import of ES contacts in background
 *
 * @author      Icegram
 * @since       4.4.4
 * @version     1.0.0
 *
 * @package     Email Subscribers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ES_Contact_Background_Process' ) ) {

	/**
	 * ES_Contact_Background_Process Class.
	 */
	class ES_Contact_Background_Process {

		/**
		 * Start time of current process.
		 *
		 * (default value: 0)
		 *
		 * @var int
		 * @access protected
		 */
		protected $start_time = 0;

		/**
		 * Identifier
		 *
		 * @var mixed
		 * @access protected
		 */
		protected $identifier;

		/**
		 * Background process status
		 *
		 * (default value: '')
		 *
		 * @var string
		 * @access protected
		 */
		protected $is_process_running = '';

		/**
		 * Variable to hold instance of ES_Contact_Background_Process
		 *
		 * @var $instance
		 */
		private static $instance = null;

		/**
		 * Contructor
		 * 
		 * @since 4.4.4
		 */
		private function __construct() {

			$this->identifier = 'ig_es_contact_background_process';
			add_action( 'admin_notices', array( $this, 'contact_background_notice' ) );
			add_action( 'wp_ajax_ig_es_contact_background_progress', array( $this, 'ajax_contact_background_progress' ) );
			add_action( 'wp_ajax_ig_es_get_background_process_results', array( $this, 'ajax_get_background_process_results' ) );
			add_action( 'wp_ajax_ig_es_cancel_contact_background_process', array( $this, 'ajax_cancel_contact_background_process' ) );
			add_action( 'wp_ajax_ig_es_download_csv', array( $this, 'ajax_download_csv' ) );
			add_action( 'ig_es_add_contact_to_csv', array( $this, 'add_contact_to_csv' ) );
			add_action( 'ig_es_import_contacts_from_csv', array( $this, 'import_contacts_from_csv' ) );

			add_action( 'action_scheduler_failed_action', array( $this, 'restart_failed_action' ) );
			add_filter( 'cron_schedules', array( $this, 'modify_action_scheduler_default_interval' ), 1000 ); // phpcs:ignore 
		}

		/**
		 * Get single instance of ES_Contact_Background_Process
		 *
		 * @return ES_Contact_Background_Process Singleton object of ES_Contact_Background_Process
		 * 
		 * @since 4.4.4
		 */
		public static function get_instance() {
			// Check if instance is already exists.
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Memory exceeded
		 *
		 * Ensures the batch process never exceeds 90%
		 * of the maximum WordPress memory.
		 *
		 * @return bool
		 * 
		 * @since 4.4.4
		 */
		protected function memory_exceeded() {
			$memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
			$current_memory = memory_get_usage( true );

			if ( $current_memory >= $memory_limit ) {
				return true;
			}

			return false;
		}

		/**
		 * Get memory limit.
		 *
		 * @return int
		 * 
		 * @since 4.4.4
		 */
		protected function get_memory_limit() {
			if ( function_exists( 'ini_get' ) ) {
				$memory_limit = ini_get( 'memory_limit' );
			} else {
				// Sensible default.
				$memory_limit = '128M';
			}

			if ( ! $memory_limit || -1 === intval( $memory_limit ) ) {
				// Unlimited, set to 32GB.
				$memory_limit = '32G';
			}

			return wp_convert_hr_to_bytes( $memory_limit );
		}

		/**
		 * Time exceeded.
		 *
		 * Ensures the batch never exceeds a sensible time limit.
		 * A timeout limit of 30s is common on shared hosting.
		 *
		 * @param string $start_time start timestamp.
		 * 
		 * @return bool
		 * 
		 * @since 4.4.4
		 */
		protected function time_exceeded( $start_time = '' ) {

			if ( ! empty( $start_time ) ) {
				$this->start_time = $start_time;
			}

			$finish = $this->start_time + ( $this->get_time_limit() * 0.9 );
			$return = false;

			if ( time() >= $finish ) {
				$return = true;
			}

			return apply_filters( $this->identifier . '_time_exceeded', $return );
		}

		/**
		 * Method to get Server time limit 
		 * 
		 * @return int $time_limit Server time limit.
		 * 
		 * @since  4.4.4
		 */
		protected function get_time_limit() {
			if ( function_exists( 'ini_get' ) ) {
				$time_limit = ini_get( 'max_execution_time' );
			} else {
				// Sensible default.
				$time_limit = apply_filters( $this->identifier . '_default_time_limit', 20 );
			}

			$time_limit = (int) $time_limit;
			return $time_limit;
		}

		/**
		 * Display notice if a background process is already running or is completed
		 * 
		 * @since 4.4.4
		 */
		public function contact_background_notice() {

			if ( ! ES()->is_es_admin_screen() ) {
				return;
			}

			if ( ! wp_script_is( 'jquery' ) ) {
				wp_enqueue_script( 'jquery' );
			}

			$upload_dir  = wp_upload_dir();
			$upload_path = $upload_dir['path'];
			if ( ! empty( $upload_dir['error'] ) ) {
				?>
				<div id="ig_es_folder_permission_warning" class="error">
					<p>
						<span class="dashicons dashicons-warning"></span>&nbsp;
						<?php /* translators: 1. Important 2. Upload path */ ?>
						<?php echo sprintf( esc_html__( '%1$s: To allow import/export of contacts, please make sure %2$s directory is writable.', 'email-subscribers' ), '<strong>' . esc_html__( 'Important', 'email-subscribers' ) . '</strong>', '<strong><code>' . esc_html( $upload_path ) . '</code></strong>' ); ?>
					</p>
				</div>
				<?php
			} else {
				$action                    = ig_es_get_request_data( 'action' );
				$is_process_running        = $this->is_process_running();
				$background_process_result = get_site_option( 'ig_es_contact_background_process_result', false );

				// If background process is not running and there isn't any background process result to show then return.
				if( 'no' === $is_process_running && empty( $background_process_result )  ) {
					return;
				}

				// Show background process notification only on import/export admin pages.
				if( in_array( $action, array( 'import', 'export' ), true ) ) {
					// Show background process in progress message.
					if ( 'yes' === $is_process_running ) {
						?>
						<div id="ig_es_contact_background_progress" class="error" style="display: none;">
							<p>
								<?php
								$process_data = get_site_option( 'ig_es_contact_background_process_data', false );

								if( ! empty( $process_data ) ) {
									$bulk_action   = $process_data['action'];

									switch ( $bulk_action ) {
										case 'import_contact':
											$bulk_text = __( 'imported', 'email-subscribers' );
											break;

										case 'export_contact':
											$bulk_text = __( 'exported', 'email-subscribers' );
												break;

										default:
											$bulk_text = '';
											break;
									}

									echo '<strong>' . esc_html__( 'Important', 'email-subscribers' ) . '</strong>: ' . esc_html__( 'Contacts are being', 'email-subscribers' );
									echo '&nbsp;' . esc_html( $bulk_text ) . '&nbsp;';
									echo esc_html__( 'in the background.', 'email-subscribers' ) . '&nbsp;';
									?>
									<span id="ig_es_contact_background_prcess_percentage_wrapper" style="display: none;">
										<?php echo esc_html__( 'Progress', 'email-subscribers' ); ?>:&nbsp;
										<strong><span id="ig_es_background_process_percentage"><?php echo esc_html__( '--:--:--', 'email-subscribers' ); ?></span></strong>
									</span>
									<?php
								}
								?>
							</p>
							<p>
								<?php
									echo __( '<a href="#" id="ig-es-cancel-contact-background-process">Click here</a> to cancel this request.', 'email-subscribers' );
								?>
							</p>
						</div>
						<?php
					} else {
						// Check if there are any background process results to show.
						if( ! empty( $background_process_result ) ) {
							$this->get_background_process_results_html( $background_process_result );
						}
					}
				}
				?>
				<script type="text/javascript">
					jQuery(function(){
						// Clear interval callback function.
						let clear_interval_callback = null;

						// Background request object.
						let background_progress_request = null;

						jQuery(document).ready(function(){
							var border_color = jQuery('#ig_es_contact_background_progress').css('border-left-color');
							jQuery('#ig_es_contact_background_progress').css('border-top', '1px solid ' + border_color);
							jQuery('#ig_es_contact_background_progress').css('border-right', '1px solid ' + border_color);
							jQuery('#ig_es_contact_background_progress').css('border-bottom', '1px solid ' + border_color);
							jQuery('#ig_es_contact_background_progress').show();
							jQuery('body').on('click', '.download-csv-wrapper a', function(){
								jQuery('.download-csv-wrapper').hide('slow');
							});
							jQuery('body').on('click', '#ig-es-cancel-contact-background-process', function(e){
								e.preventDefault();
								ig_es_cancel_contact_background_process();
							});
							<?php
							// If background process is running then check it's progress continuously with the interval of 5 seconds.
							if( 'yes' === $is_process_running ) {
							?>
							ig_es_check_contact_background_progress();
							clear_interval_callback = setInterval(function(){
								ig_es_check_contact_background_progress();
							},5000);
							<?php
							} else {
								// If there are background results to show then show it using 
								if( ! empty( $background_process_result ) ) {
									?>
									ig_es_get_background_process_results();
									<?php
								}
							}
							?>
						});

						let admin_ajax_url = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
						
						function ig_es_start_contact_background_progress_percentage( progress_data, target_dom ) {
							let target_element_wrapper = target_dom.find('#ig_es_contact_background_prcess_percentage_wrapper');
							let target_element         = target_dom.find('#ig_es_background_process_percentage');
							let percent_completion     = progress_data.percent_completion;
							let contact_action         = progress_data.contact_action;
							let action_data            = progress_data.action_data;

							target_element_wrapper.show();
							percent_completion = Math.round( percent_completion  * 100 ) / 100;
							target_element.text(percent_completion + '%');
						}

						function ig_es_disable_import_form() {
							if( 1 === jQuery('#ig_es_contact_background_progress').length ) {
								jQuery('form#form_addemail').find('[name="submit"]').attr('disabled','disabled');
							}
						}

						function ig_es_enable_import_form() {
							if( 1 === jQuery('#ig_es_contact_background_results').length ) {
								jQuery('form#form_addemail').find('[name="submit"]').removeAttr('disabled');
							}
						}

						function ig_es_check_contact_background_progress() {
							ig_es_disable_import_form();
							background_progress_request = jQuery.ajax({
								url: admin_ajax_url,
								method: 'post',
								dataType: 'json',
								data: {
									action: 'ig_es_contact_background_progress',
									security: '<?php echo esc_attr( wp_create_nonce( 'ig-es-background-contact-progress' ) ); ?>'
								},
								success: function( response ) {

									let percent_completion = response.percent_completion;
									let contact_action = response.contact_action;
									let action_stage = response.action_stage;
									let action_data = response.action_data;

									let progress_data = {
										percent_completion: response.percent_completion,
										contact_action: response.contact_action,
										action_stage: response.action_stage,
										action_data: response.action_data
									}

									let target_dom = jQuery('#ig_es_contact_background_progress');

									if ( response.percent_completion !== undefined && response.percent_completion !== '' ) {
										if( 100 == response.percent_completion) {
											clearInterval(clear_interval_callback);
											ig_es_get_background_process_results();
										}
										target_dom.show();
										ig_es_start_contact_background_progress_percentage( progress_data, target_dom );
									}
								}
							});
						}

						function ig_es_get_background_process_results() {
							jQuery.ajax({
								url: admin_ajax_url,
								method: 'post',
								dataType: 'json',
								data: {
									action: 'ig_es_get_background_process_results',
									security: '<?php echo esc_attr( wp_create_nonce( 'ig-es-background-contact-process-results' ) ); ?>'
								},
								success: function( response ) {
									if( 'undefined' !== typeof response.response_html && '' !== response.response_html ) {
										
										// Check if results already shown then return.
										if( 1 === jQuery('#ig_es_contact_background_results').length ) {
											return;
										}

										let result_html = jQuery.parseHTML( response.response_html );
										// If there is background process progress message being shown then replace it with background process result html else show background process result after page heading.
										if( 1 === jQuery('#ig_es_contact_background_progress').length ) {
											jQuery('#ig_es_contact_background_progress').replaceWith( result_html );
										} else {
											jQuery(result_html).insertAfter( '.wp-heading-inline' );
										}
										ig_es_enable_import_form();
									}
								}
							});
						}

						function ig_es_cancel_contact_background_process() {
							clearInterval(clear_interval_callback);
							jQuery.ajax({
								url: admin_ajax_url,
								method: 'post',
								dataType: 'json',
								beforeSend: function() { 
									// Cancel previous request for checking background progress.
									if( null !== background_progress_request) {
										background_progress_request.abort();
									}
								},
								data: {
									action: 'ig_es_cancel_contact_background_process',
									security: '<?php echo esc_attr( wp_create_nonce( 'ig-es-cancel-contact-background-process' ) ); ?>'
								},
								success: function( response ) {
									if( 'undefined' !== typeof response.response_html && '' !== response.response_html ) {
										let response_html = jQuery.parseHTML( response.response_html );
										jQuery('#ig_es_contact_background_progress').replaceWith( response_html );
										ig_es_enable_import_form();
									}
								}
							});
						}
					});
				</script>
				<?php
			}
		}

		/**
		 * Get background process progress via ajax
		 * 
		 * @since 4.4.4
		 */
		public function ajax_contact_background_progress() {

			check_ajax_referer( 'ig-es-background-contact-progress', 'security' );

			$response = array();

			$progress = $this->calculate_contact_background_progress();

			if ( isset( $progress['percent_completion'] ) ) {
				$response['percent_completion'] = $progress['percent_completion'];
			}

			$process_data = get_site_option( 'ig_es_contact_background_process_data', false );

			if ( ! empty( $process_data ) ) {

				$contact_action             = $process_data['action'];
				$response['contact_action'] = $contact_action;
			} else {
				$process_result = get_site_option( 'ig_es_contact_background_process_result', false );
				if( ! empty( $process_result ) ) {
					$response['percent_completion'] = 100;
					$response['contact_action']     = $process_result['action'];
				}
			}

			wp_send_json( $response );
		}

		/**
		 * Get exported CSV file.
		 * 
		 * @since 4.4.4
		 */
		public function ajax_download_csv() {

			check_ajax_referer( 'ig_es_download_csv', 'download_nonce' );

			$background_process_result = get_site_option( 'ig_es_contact_background_process_result', false );

			if ( $background_process_result ) {

				$file_path     = $background_process_result['action_data']['csv_file_path'];
				$file_name     = basename( $file_path );
				$dirname       = dirname( $file_path );
				$mime_type     = 'text/x-csv';

				if ( file_exists( $file_path ) && is_readable( $file_path ) ) {

					nocache_headers();
					header( 'X-Robots-Tag: noindex, nofollow', true );
					header( 'Content-Type: ' . $mime_type . '; charset=UTF-8' );
					header( 'Content-Description: File Transfer' );
					header( 'Content-Transfer-Encoding: binary' );
					header( 'Content-Disposition: attachment; filename="' . sanitize_file_name( $file_name ) . '";' );
					readfile( $file_path ); // phpcs:ignore
					unlink( $file_path );
				} else {
					echo esc_html__( 'Failed to create export file.', 'email-subscribers' );
					exit();
				}

				delete_site_option( 'ig_es_contact_background_process_result' );
				exit();

			}
		}

		/**
		 * Cancel current background process
		 * 
		 * @since 4.4.4.1
		 */
		public function ajax_cancel_contact_background_process() {

			check_ajax_referer( 'ig-es-cancel-contact-background-process', 'security' );
			$response = array();
			$background_process_process_data = get_site_option( 'ig_es_contact_background_process_data', false );
			ob_start();
			if ( $background_process_process_data ) {
				// Delete data related to background process.
				delete_site_option( 'ig_es_contact_background_process_data' );
				delete_site_option( 'ig_es_contact_background_process_result' );

				// Unschedule existing scheduled action schedulers.
				as_unschedule_action( 'ig_es_add_contact_to_csv' );
				as_unschedule_action( 'ig_es_import_contacts_from_csv' );
				?>
				<div id="ig_es_contact_background_results" class="updated">
					<p>
					<?php
						echo __( 'The background process has been canceled successfully. You can start a new process again by importing or exporting.', 'email-subscribers' );
					?>
					</p>
				</div>
				<?php
			} else {
				// Till we processed this cancel request current import/export process got completed therefore show success background message instead.
				$background_process_result = get_site_option( 'ig_es_contact_background_process_result', false );
				if( false !== $background_process_result ) {
					$this->get_background_process_results_html( $background_process_result );
				}
			}
			$response_html = ob_get_clean();
			$response['response_html'] = $response_html;
			wp_send_json( $response );
		}

		/**
		 * Checks if background process is running
		 *
		 * @return string  $is_process_running
		 * 
		 * @since 4.4.4
		 */
		public function is_process_running() {

			// Return process status if it has already been saved.
			if ( ! empty( $this->is_process_running ) ) {
				return $this->is_process_running;
			}

			$process_data              = get_site_option( 'ig_es_contact_background_process_data', false );
			$this->is_process_running = ( ! empty( $process_data ) ) ? 'yes' : 'no';

			return $this->is_process_running;
		}

		/**
		 * Calculate progress of background contact process
		 *
		 * @return array $progress
		 * 
		 * @since 4.4.4
		 */
		public function calculate_contact_background_progress() {
			
			$progress     = array();
			$process_data = get_site_option( 'ig_es_contact_background_process_data', false );

			if( ! empty( $process_data ) ) {
				$total_contacts_to_process = ! empty( $process_data['total_contacts_to_process'] ) ?  $process_data['total_contacts_to_process'] : 0;
				$total_contacts_processed  = ! empty( $process_data['total_contacts_processed'] ) ? $process_data['total_contacts_processed'] : 0;

				$percent_completion = 0;
				if ( ! empty( $total_contacts_to_process ) ) {
					$percent_completion             = ( ( intval( $total_contacts_processed ) ) * 100 ) / intval( $total_contacts_to_process );
				}
				$progress['percent_completion'] = floatval( $percent_completion );
			}

			return $progress;
		}

		/**
		 * Add Contacts to CSV from saved contact's data
		 * 
		 * @since 4.4.4
		 */
		public function add_contact_to_csv() {

			global $wpdb;

			$process_data = get_site_option( 'ig_es_contact_background_process_data', true );

			// Check status of contacts to be exported. Return if empty.
			if( empty( $process_data['contact_status'] ) ) {
				return;
			}

			$contact_status           = $process_data['contact_status'];
			$total_contacts_processed = ! empty( $process_data['total_contacts_processed'] ) ? $process_data['total_contacts_processed'] : 0;
			$list_id                  = ! empty( $process_data['list_id'] ) ? $process_data['list_id'] : 0; // Contact list id.
			$last_contact_id          = ! empty( $process_data['last_contact_id'] ) ? $process_data['last_contact_id'] : 0; // ID of last exported contact.

			$email_subscribe_table = IG_CONTACTS_TABLE;

			$contact_results = array();
			if ( 'all' === $contact_status ) {
				$contact_results = ES()->lists_contacts_db->get_all_contacts();
			} elseif ( 'subscribed' === $contact_status ) {
				$contact_results = ES()->lists_contacts_db->get_all_subscribed_contacts();
			} elseif ( 'unsubscribed' === $contact_status ) {
				$contact_results = ES()->lists_contacts_db->get_all_unsubscribed_contacts();
			} elseif ( 'confirmed' === $contact_status ) {
				$contact_results = ES()->lists_contacts_db->get_all_confirmed_contacts();
			} elseif ( 'unconfirmed' === $contact_status ) {
				$contact_results = ES()->lists_contacts_db->get_all_unconfirmed_contacts();
			} elseif ( 'select_list' === $contact_status ) {
				$list_id = absint( $list_id );
				$contact_results = ES()->lists_contacts_db->get_all_contacts_from_list( $list_id );
			}

			$subscribers = array();

			// Set fail safe limit to process contact to export.
			$fail_safe_limit    = apply_filters( 'ig_es_fail_safe_contact_export_limit', 1000 );

			// ID of last processed contact list data.
			$last_processed_list_contact_id  = ! empty( $process_data['last_processed_list_contact_id'] ) ? $process_data['last_processed_list_contact_id'] : 0;

			if ( count( $contact_results ) > 0 ) {
				$total_contacts_to_process = count( $contact_results );

				$process_data['total_contacts_to_process'] = $total_contacts_to_process;
				$contact_list_map   = array();
				$contact_ids        = array();
				if( ! empty( $last_processed_list_contact_id ) ) {
					$last_processed_list_contact_id_index = array_search($last_processed_list_contact_id, array_column( $contact_results, 'id') );
					// Remove contact results before $last_processed_list_contact_id_index since they have been processed in last run.
					$contact_results                      = array_splice( $contact_results, $last_processed_list_contact_id_index + 1 );
				}

				foreach ( $contact_results as $result_count => $result ) {
					if ( ! in_array( $result['contact_id'], $contact_ids ) ) {
						$contact_ids[] = $result['contact_id'];
					}

					$contact_list_map[ $result['contact_id'] ][] = array(
						'status'     => $result['status'],
						'list_id'    => $result['list_id'],
						'optin_type' => $result['optin_type']
					);

					// If contact fail safe limit reached then set id of list contact data. This will be used in next run while processing $contact_results.
					if( $result_count >= $fail_safe_limit ) {
						$last_processed_list_contact_id = $result['id'];
						break;
					}
				}
				$contact_ids_str = "'" . implode( "' , '", $contact_ids ) . "' ";

				$query = "SELECT `id`, `first_name`, `last_name`, `email`, `created_at` FROM {$email_subscribe_table} WHERE id IN ({$contact_ids_str}) ORDER BY FIELD( id, {$contact_ids_str})";
				$subscribers = $wpdb->get_results( $query, ARRAY_A );
			}

			$subscribers_count = count( $subscribers );

			$batch_start_time = time();

			if ( isset( $process_data['export_file'] ) && is_array( $process_data['export_file'] ) ) {
				$export_file      = $process_data['export_file'];
				$csv_folder       = $export_file['wp_upload_dir'];
				$file_name        = $export_file['file_name']; 
				$csv_file_path    = $csv_folder . $file_name;
				$csv_file_handler = fopen( $csv_file_path, 'a' ); // phpcs:ignore
				
				// Proceed only if file has opened in append mode.
				if ( false !== $csv_file_handler ) {
					$last_subscriber    = end( $subscribers );
					$last_subscriber_id = $last_subscriber['id'];
					$lists_id_name_map  = ES()->lists_db->get_list_id_name_map();
					foreach ( $subscribers as $subscriber ) {
						$subscriber_id = $subscriber['id'];
						$data = array();
						$data['first_name'] = trim( str_replace( '"', '""', $subscriber['first_name'] ) );
						$data['last_name']  = trim( str_replace( '"', '""', $subscriber['last_name'] ) );
						$data['email']      = trim( str_replace( '"', '""', $subscriber['email'] ) );
						$contact_id = $subscriber['id'];
						if ( ! empty( $contact_list_map[ $contact_id ] ) ) {
							foreach ( $contact_list_map[ $contact_id ] as $list_details ) {
								$file_data          = "\n";
								$data['list']       = $lists_id_name_map[ $list_details['list_id'] ];
								$data['status']     = ucfirst( $list_details['status'] );
								$data['optin_type'] = ( $list_details['optin_type'] == 1 ) ? 'Single Opt-In' : 'Double Opt-In';
								$data['created_at'] = $subscriber['created_at'];
								$file_data          .= '"' . implode( '","', $data ) . '"';
								if ( $file_data ) {
									fwrite( $csv_file_handler, $file_data ); // phpcs:ignore
								}
								$total_contacts_processed++;							
							}
						}

						// If loop is completed or time is reached or memory limit is reached then set required options for next run and break the loop.
						if ( $last_subscriber_id === $subscriber_id || $this->time_exceeded( $batch_start_time ) || $this->memory_exceeded() ) {
							// Update background process data only if it exists to ensure we don't start another process in this request if it was cancelled previously by user.
							if( false !== get_site_option( 'ig_es_contact_background_process_data', false ) ) {
								$process_data['last_contact_id']                = $subscriber_id;
								$process_data['total_contacts_processed']       = $total_contacts_processed;
								$process_data['last_processed_list_contact_id'] = $last_processed_list_contact_id;
								update_site_option( 'ig_es_contact_background_process_data', $process_data );
								if ( function_exists( 'as_schedule_single_action' ) ) {
									as_schedule_single_action( time(), 'ig_es_add_contact_to_csv' );
								}
								break;
							}
						}
					}

					fclose( $csv_file_handler ); // phpcs:ignore

					// If all contacts are processed.
					if ( $total_contacts_processed >= $total_contacts_to_process ) {

						$contact_background_process_result = array(
							'action'                   => 'export_contact',
							'total_contacts_processed' => $total_contacts_processed,
							'action_data' 			   => array(
								'csv_file_path' => $csv_file_path,
							),
						);

						as_unschedule_action( 'ig_es_add_contact_to_csv' );
						as_unschedule_action( 'ig_es_import_contacts_from_csv' );

						// Delete background process data as it is now completed.
						delete_site_option( 'ig_es_contact_background_process_data' );

						update_site_option( 'ig_es_contact_background_process_result', $contact_background_process_result );
					}
				}
			}
		}

		/**
		 * Generate Contacts from generated/imported csv file
		 * 
		 * @since 4.4.4
		 */
		public function import_contacts_from_csv() {

			$process_data              = get_site_option( 'ig_es_contact_background_process_data', true );
			$total_contacts_to_process = ! empty( $process_data['total_contacts_to_process'] ) ? (int) $process_data['total_contacts_to_process'] : 0;

			if ( isset( $process_data['import_file'] ) && is_array( $process_data['import_file'] ) && ! empty( $total_contacts_to_process ) ) {

				$contact_status = $process_data['contact_status'];
				$list_id        = $process_data['list_id'];
				$import_file    = $process_data['import_file'];
				$csv_file       = $import_file['file'];
				$file_position  = isset( $import_file['file_position'] ) && is_numeric( $import_file['file_position'] ) ? $import_file['file_position'] : 0;

				// Set locale.
				$encoding = mb_detect_encoding( $csv_file, 'UTF-8, ISO-8859-1', true );
				if ( $encoding ) {
					setlocale( LC_ALL, 'en_US.' . $encoding );
				}
				ini_set( 'auto_detect_line_endings', true ); // phpcs:ignore
				$csv_file_handler = fopen( $csv_file, 'r' ); // phpcs:ignore
				if ( false !== $csv_file_handler ) {

					$delimiter = $this->get_delimiter( $csv_file );

					// Get Headers
					$csv_header = array_map( 'trim', fgetcsv( $csv_file_handler, 0, $delimiter ) );

					$batch_start_time = time();

					$reading_completed              = false;
					$no_of_remaining_contacts       = -1;
					$existing_contacts_email_id_map = ES()->contacts_db->get_email_id_map();

					$existing_contacts = array();
					if ( count( $existing_contacts_email_id_map ) > 0 ) {
						$existing_contacts = array_keys( $existing_contacts_email_id_map );
						$existing_contacts = array_map( 'strtolower', $existing_contacts );
					}

					$invalid_emails_count     = ! empty( $process_data['invalid_emails_count'] ) ? $process_data['invalid_emails_count'] : 0;
					$total_contacts_processed = ! empty( $process_data['total_contacts_processed'] ) ? $process_data['total_contacts_processed'] : 0;
					$existing_contacts_count  = ! empty( $process_data['existing_contacts_count'] ) ? $process_data['existing_contacts_count'] : 0;
					$processed_emails         = array();
					$contacts_data            = array();
					$current_date_time        = ig_get_current_date_time();

					for ( $no_of_contacts_imported = 1; $no_of_contacts_imported <= $total_contacts_to_process; $no_of_contacts_imported++ ) {

						$result            = $this->parse_data_by_row( $csv_file_handler, $csv_header, $file_position, $encoding, $delimiter );
						$file_position     = $result['file_position'];
						$parsed_csv_data   = $result['parsed_csv_data'];
						$reading_completed = $result['reading_completed'];
						if ( ! $reading_completed ) {

							$parsed_csv_data = array_map( 'trim', $parsed_csv_data );
							
							$email = isset( $parsed_csv_data['Email'] ) ? strtolower( sanitize_email( trim( $parsed_csv_data['Email'] ) ) ) : '';
							if ( empty( $email ) ) {
								$total_contacts_processed++;
								$invalid_emails_count++;
								continue;
							}

							if ( ! in_array( $email, $existing_contacts ) ) {
								$contacts_data = array();
								$name          = isset( $parsed_csv_data['Name'] ) ? trim( $parsed_csv_data['Name'] ) : '';
								$first_name    = isset( $parsed_csv_data['First Name'] ) ? sanitize_text_field( trim( $parsed_csv_data['First Name'] ) ) : '';
								$last_name     = isset( $parsed_csv_data['Last Name'] ) ? sanitize_text_field( trim( $parsed_csv_data['Last Name'] ) ) : '';

								// If we don't get the first_name & last_name, consider Name field.
								// If name empty, get the name from Email
								if ( empty( $first_name ) && empty( $last_name ) ) {

									if ( empty( $name ) ) {
										$name = ES_Common::get_name_from_email( $email );
									}

									$names      = ES_Common::prepare_first_name_last_name( $name );
									$first_name = sanitize_text_field( $names['first_name'] );
									$last_name  = sanitize_text_field( $names['last_name'] );
								}

								$guid = ES_Common::generate_guid();

								$contacts_data['first_name'] = $first_name;
								$contacts_data['last_name']  = $last_name;
								$contacts_data['email']      = $email;
								$contacts_data['source']     = 'import';
								$contacts_data['status']     = 'verified';
								$contacts_data['hash']       = $guid;
								$contacts_data['created_at'] = $current_date_time;

								ES()->contacts_db->bulk_insert( array( $contacts_data ) );

							} else {
								$existing_contacts_count++;
							}
							$processed_emails[] = $email;
							$total_contacts_processed++;
						}

						$no_of_remaining_contacts = $total_contacts_to_process - $total_contacts_processed;

						if ( 0 === $no_of_remaining_contacts ) {

							$contact_ids = ES()->contacts_db->get_contact_ids_by_emails( $processed_emails );
							if( ! empty( $contact_ids ) ) {
								ES()->lists_contacts_db->remove_contacts_from_lists( $contact_ids, $list_id );
								ES()->lists_contacts_db->do_import_contacts_into_list( $list_id, $contact_ids, $contact_status, 1, $current_date_time );
							}

							$contact_background_process_result = array(
								'action'                    => 'import_contact',
								'total_contacts_to_process' => $total_contacts_to_process,
								'total_contacts_processed'  => $total_contacts_processed,
								'existing_contacts_count'   => $existing_contacts_count,
								'invalid_emails_count'      => $invalid_emails_count,
							);

							fclose( $csv_file_handler ); // phpcs:ignore
							unlink( $csv_file );
							delete_site_option( 'ig_es_contact_background_process_data' );

							update_site_option( 'ig_es_contact_background_process_result', $contact_background_process_result, 'no' );
							break;
						}
						
						if ( $this->time_exceeded( $batch_start_time ) || $this->memory_exceeded() ) {

							$contact_ids = ES()->contacts_db->get_contact_ids_by_emails( $processed_emails );
							if( ! empty( $contact_ids ) ) {
								ES()->lists_contacts_db->remove_contacts_from_lists( $contact_ids, $list_id );
								ES()->lists_contacts_db->do_import_contacts_into_list( $list_id, $contact_ids, $contact_status, 1, $current_date_time );
							}

							fclose( $csv_file_handler ); // phpcs:ignore

							// Update background process data only if it exists to ensure we don't start another process in this request if it was cancelled previously by user.
							if( false !== get_site_option( 'ig_es_contact_background_process_data', false ) ) {
								$process_data['import_file']['file_position'] = $file_position;
								$process_data['total_contacts_processed']     = $total_contacts_processed;
								$process_data['existing_contacts_count']      = $existing_contacts_count;
								$process_data['invalid_emails_count']         = $invalid_emails_count;
								update_site_option( 'ig_es_contact_background_process_data', $process_data );
								if ( function_exists( 'as_schedule_single_action' ) ) {
									as_schedule_single_action( time(), 'ig_es_import_contacts_from_csv' );
								}
								break;
							}
						}
					}
				}
			}
		}

		/**
		 * Restart scheduler after one minute if it fails
		 *
		 * @param  array $action_id id of failed action.
		 * 
		 * @since 4.4.4
		 */
		public function restart_failed_action( $action_id = 0 ) {

			if ( empty( $action_id ) || ! class_exists( 'ActionScheduler' ) || ! is_callable( array( 'ActionScheduler', 'store' ) ) || ! function_exists( 'as_schedule_single_action' ) ) {
				return;
			}

			$action      = ActionScheduler::store()->fetch_action( $action_id );
			$action_hook = $action->get_hook();

			if ( in_array( $action_hook, array( 'ig_es_add_contact_to_csv', 'ig_es_import_contacts_from_csv' ), true ) ) {
				as_schedule_single_action( time() + MINUTE_IN_SECONDS, $action_hook );
			}
		}

		/**
		 * Parse data one row at a time
		 *
		 * @param  boolean $file_handler        CSV file handler.
		 * @param  array   $header        CSV header meta column name.
		 * @param  integer $file_position file pointer posistion to read from.
		 * @param  string  $encoding      Character encoding.
		 * @param  string  $delimiter     Delimiting character.
		 * 
		 * @return array  $result parsed data with current file pointer position
		 * 
		 * @since 4.4.4
		 */
		public function parse_data_by_row( $file_handler = false, $header = array(), $file_position = 0, $encoding = '', $delimiter = ',' ) {

			$parsed_csv_data = array();

			$reading_completed = false;

			if ( false !== $file_handler ) {

				if ( $file_position > 0 ) {

					fseek( $file_handler, (int) $file_position );

				}

				if ( false !== ( $postmeta = fgetcsv( $file_handler, 0, $delimiter ) ) ) { // phpcs:ignore
					$row = array();
					foreach ( $header as $key => $heading ) {

						// Put all CSV data into an associative array by row.
						$row[ $heading ] = ( isset( $postmeta[ $key ] ) ) ? $this->format_data_from_csv( stripslashes( $postmeta[ $key ] ), $encoding ) : '';
					}

					$parsed_csv_data = $row;

					unset( $postmeta, $row );

				} else {

					$reading_completed = true;

				}

				$file_position = ftell( $file_handler );
			}

			$result = array(
				'parsed_csv_data'   => $parsed_csv_data,
				'file_position'     => $file_position,
				'reading_completed' => $reading_completed,
			);

			return $result;
		}

		/**
		 * Format data passed from CSV
		 *
		 * @param array  $data The data to format.
		 * @param string $enc Encoding.
		 * 
		 * @since 4.4.4
		 */
		public function format_data_from_csv( $data, $enc ) {
			return ( 'UTF-8' === $enc ) ? $data : utf8_encode( $data );
		}

		/**
		 * Get CSV file delimiter
		 *
		 * @param $file
		 * @param int $check_lines
		 *
		 * @return mixed
		 *
		 * @since 4.4.4
		 */
		public function get_delimiter( $file, $check_lines = 2 ) {

			$file = new SplFileObject( $file );

			$delimiters = array( ',', '\t', ';', '|', ':' );
			$results    = array();
			$i          = 0;
			while ( $file->valid() && $i <= $check_lines ) {
				$line = $file->fgets();
				foreach ( $delimiters as $delimiter ) {
					$regExp = '/[' . $delimiter . ']/';
					$fields = preg_split( $regExp, $line );
					if ( count( $fields ) > 1 ) {
						if ( ! empty( $results[ $delimiter ] ) ) {
							$results[ $delimiter ] ++;
						} else {
							$results[ $delimiter ] = 1;
						}
					}
				}
				$i ++;
			}

			if ( count( $results ) > 0 ) {

				$results = array_keys( $results, max( $results ) );

				return $results[0];
			}

			return ',';

		}

		/**
		 * Function to modify action scheduler's default interval between two consecutive scheduler when background process running
		 *
		 * @param array $schedules schedules with interval and display.
		 * 
		 * @return array $schedules
		 * 
		 * @since 4.4.4
		 */
		public function modify_action_scheduler_default_interval( $schedules = array() ) {

			if ( 'yes' === $this->is_process_running() ) {

				$schedules['every_minute'] = array(
					'interval' => 5,
					'display'  => __( 'Every 5 Seconds', 'email-subscribers' ),
				);
			}

			return $schedules;
		}


		/**
		 * Method to get background process result HTML in ajax request.
		 * 
		 * @return array $response Response HTML array
		 * 
		 * @since 4.4.4
		 */
		public function ajax_get_background_process_results() {

			check_ajax_referer( 'ig-es-background-contact-process-results', 'security' );

			$background_process_result = get_site_option( 'ig_es_contact_background_process_result', false );

			$response = array(
				'response_html' => '',
			);

			if ( false !== $background_process_result ) {
				switch ( $background_process_result['action'] ) {
					case 'export_contact':
						$action_text  = __( 'exported', 'email-subscribers' );
						break;
					default:
						$action_text  = __( 'imported', 'email-subscribers' );
						break;
				}
				ob_start();
				$this->get_background_process_results_html( $background_process_result );
				$response_html = ob_get_clean();
				$response['response_html'] = $response_html;
				wp_send_json( $response );
			}
		}

		/**
		 * Method to get background process result HTML
		 * 
		 * @since 4.4.4
		 */
		public function get_background_process_results_html( $background_process_result ) {

			if ( ! empty( $background_process_result ) ) {
				switch ( $background_process_result['action'] ) {
					case 'export_contact':
						$action_text  = __( 'exported', 'email-subscribers' );
						break;
					default:
						$action_text  = __( 'imported', 'email-subscribers' );
						break;
				}
				?>
				<div id="ig_es_contact_background_results" class="updated">
					<p>
						<?php echo esc_html__( 'Successfully', 'email-subscribers' ) . ' ' . esc_html( $action_text ) . ' ' . esc_html( $background_process_result['total_contacts_processed'] ) . ' ' . esc_html( _n( 'contact', 'contacts', $background_process_result['total_contacts_processed'], 'email-subscribers' ) ) . '.'; ?>
					</p>
					<?php
					if ( 'export_contact' === $background_process_result['action'] ) {
						$action_data = ! empty( $background_process_result['action_data'] ) ? $background_process_result['action_data'] : '';
						if( ! empty( $action_data ) && ! empty( $action_data['csv_file_path' ] ) ) {
							?>
							<p class="download-csv-wrapper">
								<?php
									echo esc_html__( 'CSV file has been generated. You can download it from ', 'email-subscribers' ) . '<a href="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '?action=ig_es_download_csv&download_nonce=' . esc_attr( wp_create_nonce( 'ig_es_download_csv' ) ) . '">' . esc_html__( 'here', 'email-subscribers' ) . '</a>.';
								?>
							</p>
							<?php
						}
					} else if( 'import_contact' === $background_process_result['action'] ) {
						$existing_contacts_count = ! empty( $background_process_result['existing_contacts_count'] ) ? $background_process_result['existing_contacts_count'] : 0;
						$invalid_emails_count = ! empty( $background_process_result['invalid_emails_count'] ) ? $background_process_result['invalid_emails_count'] : 0;

						if( ! empty( $existing_contacts_count ) ) :
							?>
							<p class="ig-es-existing-contacts-message">
								<?php
									echo sprintf( __( '%d contacts are already existed.', 'email-subscribers' ), $existing_contacts_count );
								?>
							</p>
							<?php
						endif;

						if( ! empty( $invalid_emails_count ) ) :
							?>
							<p class="ig-es-invalid-contacts-message">
								<?php
									echo sprintf( __( '%d contacts are invalid.', 'email-subscribers' ), $invalid_emails_count );;
								?>
							</p>
							<?php
						endif;
						?>
						<?php
						delete_site_option( 'ig_es_contact_background_process_result' );	
					}
					?>
				</div>
				<?php
			}
		}
	}

}

ES_Contact_Background_Process::get_instance();

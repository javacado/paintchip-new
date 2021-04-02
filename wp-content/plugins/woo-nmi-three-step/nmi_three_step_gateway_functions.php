<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class NMI_Custom_Payment_Gateway extends WC_Payment_Gateway {
    public function __construct() {
        global $woocommerce;

        $this->id                   = 'nmi_three_step';
        $this->icon                 = null;
        $this->has_fields           = false;
        $this->method_title         = __( 'NMI Gateway For WooCommerce', 'nmi_three_step' );
	$this->order_button_text    = __( 'Pay Securely', 'nmi_three_step' );
        $this->gatewayURL           = 'https://secure.networkmerchants.com/api/v2/three-step';

        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables.
        $this->title                        = $this->get_option('title');
        $this->description                  = $this->get_option('description');
        $this->instructions                 = $this->get_option('instructions');
	$this->enable_for_methods           = $this->get_option('enable_for_methods', array());
	$this->apikey                       = sanitize_text_field($this->get_option('apikey'));
	$this->transactiontype              = sanitize_text_field($this->get_option('transactiontype'));
        $this->finalorderstatus             = $this->get_option('finalorderstatus');
        $this->redirecturl                  = $this->get_option('redirecturl');
          
        
        


        if (isset($_GET['token-id']) && isset($_GET['order']) && !isset($_GET['complete'])) {            
            //redirect if token are defined
            //order was previously able to return in the url.
            
            //split order by ***.  nmi doesn't like & in their redirect url values
            if (strpos($_GET['order'], '***') !== false) {
                $details = explode("***", $_GET['order']);
                //expecting orderid, action, plugin.  this is also split in the successful_request function
                $orderid = $details[0];
                $action = $details[1];
                $thisid = $details[2];
            }
            else {
                $action = "";
            }
           
            //if ($thisid == $this->id
            if (isset($_GET['action']) && $action == 'addbilling' && $thisid == $this->id) {
                //die("attempt".print_r($_GET,1));
                $this->successful_request(sanitize_text_field(''), sanitize_text_field($_GET['order']), $details);
            }
            elseif (isset($_GET['rc']) && isset($_GET['tid'])) {
                //saved payment method
                $detials['ispaymentmethod']     = "Y";
                $details['rc']                  = sanitize_text_field($_GET['rc']);
                $details['tid']                 = sanitize_text_field($_GET['tid']);
                $details['ac']                  = sanitize_text_field($_GET['ac']);
                $details['ar']                  = sanitize_text_field($_GET['ar']);
                
                $this->successful_request(sanitize_text_field($_GET['token-id']), sanitize_text_field($_GET['order']), $details);
            }
            else {
                $details['ispaymentmethod'] = "N";
                $this->successful_request(sanitize_text_field($_GET['token-id']), sanitize_text_field($_GET['order']), $details);
            }
            wp_die();
        }

        // Actions.
        add_action( 'woocommerce_api_callback', array( $this, 'successful_request' ) );
	add_action( 'woocommerce_receipt_nmi_three_step', array( $this, 'receipt_page' ) );
        add_action( 'woocommerce_confirm_order_nmi_three_step', array( $this, 'confirm_order_page' ) );
        add_action( 'woocommerce_update_options_payment_gateways', array( $this, 'process_admin_options' ) );
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
        
        $this->supports = array(
            'refunds'
            ,'tokenization'
            //,'products'
            //,'subscriptions'
            //,'subscription_cancellation'
            //,'subscription_suspension'
            //,'subscription_reactivation'
            //,'subscription_amount_changes'
            //,'subscription_date_changes'
            //,'subscription_payment_method_change'
        );
    }

    /* Admin Panel Options.*/
    function admin_options() {
        ?>
        <h3><?php _e('NMI Gateway For WooCommerce','nmi_three_step'); ?></h3>
        <table class="form-table">
            <?php $this->generate_settings_html(); ?>
        </table> <?php
    }

    /* Initialise Gateway Settings Form Fields. */
    public function init_form_fields() {
        global  $woocommerce ;
        $shipping_methods = array();
        if ( is_admin() ) {
            foreach ( $woocommerce->shipping->load_shipping_methods() as $method ) {
                $shipping_methods[$method->id] = $method->get_title();
            }
        }
        //free version settings
        if ( ngfw_fs()->is_not_paying() ) {
            $this->form_fields = array(
                'enabled'                  => array(
                'title'   => __( 'Enable/Disable', 'nmi_three_step' ),
                'type'    => 'checkbox',
                'label'   => __( 'Enable NMI Gateway For WooCommerce', 'nmi_three_step' ),
                'default' => 'no',
            ),
                'title'                    => array(
                'title'       => __( 'Title', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'nmi_three_step' ),
                'default'     => _x( 'NMI Gateway For WooCommerce', 'NMI Gateway', 'nmi_three_step' ),
                'desc_tip'    => true,
            ),
                'description'              => array(
                'title'       => __( 'Description', 'nmi_three_step' ),
                'type'        => 'textarea',
                'description' => __( 'This controls the description which the user sees during checkout.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => __( '', 'nmi_three_step' ),
            ),
                'instructions'             => array(
                'title'       => __( 'Instructions', 'nmi_three_step' ),
                'type'        => 'textarea',
                'description' => __( 'Instructions that will be added to the thank you page.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => __( '', 'nmi_three_step' ),
            ),
                'apikey'                   => array(
                'title'       => __( 'API Key', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( '', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => '',
            ),
                'savepaymentmethodstoggle' => array(
                'title'       => __( 'Turn Saved Payment Methods On/Off', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( 'Allows you to turn saved payment methods on and off. Upgrade to the premium version to enable this functionality.', 'nmi_three_step' ),
                'default'     => 'off',
                'desc_tip'    => true,
                'disabled'    => true,
                'options'     => array(
                    'off' => 'Off',
                ),
            ),
                'transactiontype'          => array(
                'title'       => __( 'Transaction Type', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( '', 'nmi_three_step' ),
                'default'     => '',
                'desc_tip'    => true,
                'options'     => array(
                    'auth' => 'Authorize Only',
                    'sale' => 'Authorize & Capture',
                ),
            ),
                'finalorderstatus'          => array(
                'title'       => __( 'Final Order Status', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( 'This option allows you to set the final status of an order after it has been processed successfully by the gateway.', 'nmi_three_step' ),
                'default'     => 'Processing',
                'desc_tip'    => true,
                'options'     => array(
                    'Processing' => 'Processing',
                    'Pending' => 'Pending',
                    'On-Hold' => 'On-Hold',
                    'Completed' => 'Completed',
                ),
            ),
                'redirecturl'                   => array(
                'title'       => __( 'Return URL', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( 'This is the URL the user will be taken to once the sale has been completed. Please enter the full URL of the page. It must be an active page on the same website. If left blank, it will take the buyer to the default order received page.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => get_site_url().'/cart/',
            ),
            );
        }
        
        //premium version settings
        if ( ngfw_fs()->is_plan('Premium') ) {
            $this->form_fields = array(
                'enabled'                  => array(
                'title'   => __( 'Enable/Disable', 'nmi_three_step' ),
                'type'    => 'checkbox',
                'label'   => __( 'Enable NMI Gateway For WooCommerce', 'nmi_three_step' ),
                'default' => 'no',
            ),
                'title'                    => array(
                'title'       => __( 'Title', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'nmi_three_step' ),
                'default'     => _x( 'NMI Gateway For WooCommerce', 'NMI Gateway', 'nmi_three_step' ),
                'desc_tip'    => true,
            ),
                'description'              => array(
                'title'       => __( 'Description', 'nmi_three_step' ),
                'type'        => 'textarea',
                'description' => __( 'This controls the description which the user sees during checkout.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => __( '', 'nmi_three_step' ),
            ),
                'instructions'             => array(
                'title'       => __( 'Instructions', 'nmi_three_step' ),
                'type'        => 'textarea',
                'description' => __( 'Instructions that will be added to the thank you page.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => __( '', 'nmi_three_step' ),
            ),
                'apikey'                   => array(
                'title'       => __( 'API Key', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( '', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => '',
            ),
                'savepaymentmethodstoggle' => array(
                'title'       => __( 'Turn Saved Payment Methods On/Off', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( 'Allows you to turn saved payment methods on and off.', 'nmi_three_step' ),
                'default'     => 'off',
                'desc_tip'    => true,
                'options'     => array(
                    'on' => 'On',
                    'off' => 'Off',
                ),
            ),
                'transactiontype'          => array(
                'title'       => __( 'Transaction Type', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( '', 'nmi_three_step' ),
                'default'     => '',
                'desc_tip'    => true,
                'options'     => array(
                    'auth' => 'Authorize Only',
                    'sale' => 'Authorize & Capture',
                ),
            ),
                'finalorderstatus'          => array(
                'title'       => __( 'Final Order Status', 'nmi_three_step' ),
                'type'        => 'select',
                'description' => __( 'This option allows you to set the final status of an order after it has been processed successfully by the gateway.', 'nmi_three_step' ),
                'default'     => 'Processing',
                'desc_tip'    => true,
                'options'     => array(
                    'Processing' => 'Processing',
                    'Pending' => 'Pending',
                    'On-Hold' => 'On-Hold',
                    'Completed' => 'Completed',
                ),
            ),
                'redirecturl'                   => array(
                'title'       => __( 'Return URL', 'nmi_three_step' ),
                'type'        => 'text',
                'description' => __( 'This is the URL the user will be taken to once the sale has been completed. Please enter the full URL of the page. It must be an active page on the same website. If left blank, it will take the buyer to the order received page in their account.', 'nmi_three_step' ),
                'desc_tip'    => true,
                'default'     => get_site_url().'/cart/',
            ),
            );
        }
    }
    
    function payment_fields() {
        $user                 = wp_get_current_user();
        //$display_tokenization = $this->supports( 'tokenization' ) && is_checkout() && $this->saved_cards && $user->ID;    //previous version
        $display_tokenization = $this->supports( 'tokenization' ) && is_checkout() && $user->ID;

        if ( $user->ID ) {
            $user_email = get_user_meta( $user->ID, 'billing_email', true );
            $user_email = $user_email ? $user_email : $user->user_email;
        } else {
            $user_email = '';
        }

        //displays description
        if ( $this->description ) {
            echo wpautop( wp_kses_post( $this->description ) );
        }
    }
          
    /* Process the payment and return the result. */
    function process_payment ($order_id) {
        //get woo version
        if (class_exists('WooCommerce')) {
            global $woocommerce;
            $woo_version = $woocommerce->version;
	}
        else $woo_version = "old";
        
        $order = new WC_Order($order_id);
        $order_key = $order->get_order_key();  
        
        //get redirect url based on the version
        if ($woo_version == 'old')  $redirect = add_query_arg( 'order', $order->get_id(), add_query_arg( 'key', $order_key, get_permalink( get_option( 'woocommerce_pay_page_id' ) ) ) );
        else $redirect = $order->get_checkout_payment_url( true );
        
        return array(
            'result'   => 'success',
            'redirect' => $redirect,
        );
    }
    
    function receipt_page( $order_id ) {
        global $woocommerce;
        $order = new WC_Order( $order_id );
        wp_enqueue_script('backThatUp', plugin_dir_url(__FILE__) . '/js/backToCheckout.js');
        
        if (get_current_user_id() > 0) {
            $user = get_userdata(get_current_user_id());
            $user_email = sanitize_email($user->user_email);
            $userid = sanitize_text_field($user->user_id);
        }
        else {
            $user_email = "";
            $userid = "";
        }
        
        $customervaultid = '';
        
        //get settings
        $this->init_settings();
        
        //check for ssl
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $isssl = "Y";
        else $isssl = "N";
        
        //build js data array to pass into step one    
        echo '<script type="text/javascript">';
        echo '  function nmi701_arrangeData() {';
        echo '      var pmselected = "N";';
        echo '      var radios = document.getElementsByName("paymentmethod");';
        echo '      for (var i = 0, len = radios.length; i < len; i++) {';
        echo '          if (radios[i].checked) {';
        echo '              pmselected="Y"';
        echo '          }';
        echo '      }';
        
        echo '      if (pmselected == "N") {';
        echo '          alert("Please select a payment method or create a new one");';
        echo '          document.getElementById("backbutton").disabled = false;';
        echo '          document.getElementById("submitbutton").disabled = false;';
        //hide spinner
        echo '          document.getElementById("spinner").style.display = "none";';
        echo '          return false;';
        echo '      }';
        
        //echo disable form fields, show spinner
        echo '      document.getElementById("backbutton").disabled = true;';
        echo '      document.getElementById("submitbutton").disabled = true;';
        echo '      document.getElementById("spinner").style.display = "block";';
        
        echo '      var elementexists = document.getElementById(\'savepaymentmethod\');';
        
        echo '      if (elementexists && document.getElementById(\'savepaymentmethod\').checked) var savepaymentmethod = "Y";';
        echo '      else var savepaymentmethod = "N";';
        
        echo '      if (document.getElementById(\'paymentmethodid\').value != \'\') var billingid = document.getElementById(\'paymentmethodid\').value;';
        echo '      else var billingid = "";';
        
        echo '      var customervaultid = document.getElementById("customervaultid").value;';
        echo '      var last4 = document.getElementById("billingccnumber").value.slice(-4);';
        echo '      var expiry = document.getElementById("billingccexp").value;';
        echo '      var gcaptcha = document.getElementById("g-recaptcha-response").value;';
        
        $order_shipping =     get_post_meta( $order->get_id(), '_order_shipping', true);
        $order_discount =     get_post_meta( $order->get_id(), '_cart_discount', true);
        $order_discount_tax = get_post_meta( $order->get_id(), '_cart_discount_tax', true);
        $order_tax =          get_post_meta( $order->get_id(), '_order_tax', true);
        $order_shipping_tax = get_post_meta( $order->get_id(), '_order_shipping_tax', true);

        // this one you get it yet
        $order_total =        get_post_meta( $order->get_id(), '_order_total', true);

        //fix for having product names with double quotes - thanks to abirchler for pointing this one out
        $data = array(
            'thisid'            => nmi701_cleanTheData($this->id),
            'orderid'           => nmi701_cleanTheData($order_id,'integer'),
            'apikey'            => nmi701_cleanTheData($this->apikey,'string'),
            'transactiontype'   => nmi701_cleanTheData($this->transactiontype,'string'),
            'gatewayurl'        => nmi701_cleanTheData($this->gatewayURL,'url'),
            'user_email'        => sanitize_email($user_email), 
            'userid'            => sanitize_text_field(get_current_user_id()), 
            'ordertotal'        => $order_total, 
            'ordertax'          => $order_tax, 
            'ordershipping'     => $order_shipping, 
            'billingfirstname'  => nmi701_cleanTheData($order->get_billing_first_name(),'string'), 
            'billinglastname'   => nmi701_cleanTheData($order->get_billing_last_name(),'string'), 
            'billingaddress1'   => nmi701_cleanTheData($order->get_billing_address_1(),'string'), 
            'billingcity'       => nmi701_cleanTheData($order->get_billing_city(),'string'), 
            'billingstate'      => nmi701_cleanTheData($order->get_billing_state(),'string'), 
            'billingpostcode'   => nmi701_cleanTheData($order->get_billing_postcode(),'string'),
            'billingcountry'    => nmi701_cleanTheData($order->get_billing_country(),'string'),
            'billingemail'      => sanitize_email($order->get_billing_email()),
            'billingphone'      => sanitize_text_field($order->get_billing_phone()),
            'billingcompany'    => nmi701_cleanTheData($order->get_billing_company(),'string'),
            'billingaddress2'   => nmi701_cleanTheData($order->get_billing_address_2(),'string'),
            'shippingfirstname' => nmi701_cleanTheData($order->get_shipping_first_name(),'string'),
            'shippinglastname'  => nmi701_cleanTheData($order->get_shipping_last_name(),'string'),
            'shippingaddress1'  => nmi701_cleanTheData($order->get_shipping_address_1(),'string'),
            'shippingcity'      => nmi701_cleanTheData($order->get_shipping_city(),'string'),
            'shippingstate'     => nmi701_cleanTheData($order->get_shipping_state(),'string'),
            'shippingpostcode'  => sanitize_text_field($order->get_shipping_postcode()),
            'shippingcountry'   => nmi701_cleanTheData($order->get_shipping_country(),'string'),
            'shippingphone'     => sanitize_text_field($order->get_billing_phone()),
            'shippingcompany'   => nmi701_cleanTheData($order->get_shipping_company(),'string'),
            'shippingaddress2'  => nmi701_cleanTheData($order->get_shipping_address_2(),'string'),
            'security'          => wp_create_nonce( 'checkout-nonce' ),
        );
        
        //loop through items, build array
        $items = $order->get_items();
        $y = 0;
        foreach (array_values($items) AS $x => $item) {
            $data['items'][$x] = array(
                'productid'         => $item['product_id'],
                'name'              => htmlspecialchars($item['name']),
                'line_total'        => $item['line_total'], 
                'qty'               => $item['qty'],
                'line_subtotal'     => $item['line_subtotal']
            );
            $y++;
        }

         
        //encode the php as the value of the js array (this is what was the original problem)
        echo '      var data = '.json_encode($data).';';
    echo '       data["g_recaptcha_response"] = gcaptcha;';
        echo '      if (billingid != "") data["action"] = "nmi701_stepOne";';
        echo '      else data["action"] = "nmi701_stepOne_addBilling";';
        echo '      data["savepaymentmethod"] = savepaymentmethod;';
        echo '      data["customervaultid"] = customervaultid;';
        echo '      data["billingid"] = billingid;';  
        echo '      data["last4"] = last4;';
        echo '      data["expiry"] = expiry;';
        echo '      data["itemcount"] = '.$y.';';
      // echo '  console.log(data.g_recaptcha_response);';
      //  echo ' alert("checkiut2");';
        
        echo '      return nmi701_stepOne(data, "'.plugin_dir_url(__FILE__).'");';
        echo '}';
        echo '</script>';     
        ?>
            <style type="text/css">
                ul.paymentmethods {
                    list-style:none;
                    margin-left:0;
                }
                ul.paymentmethods li, #pmtable {
                    width:100%;
                    padding:3px;
                    margin-bottom:5px;
                    border:1px solid #CCCCCC;
                    background-color:#FDFDFD;
                }

                ul.paymentmethods li.active, #pmtable.active {
                    border:3px solid #333333;
                }

                ul.paymentmethods li label {
                    width:100%;
                    display:block;
                }

                .cc {
                    width:64px;
                    height:40px;
                    float:right;
                    background-image:url('<?php echo plugins_url( 'img/icon_cc_blank.png', __FILE__ ); ?>');
                    background-repeat:no-repeat;
                    background-size:contain;
                    background-position:center center;
                }

                .cc.Visa {
                    background-image:url('<?php echo plugins_url( 'img/icon_cc_visa.png', __FILE__ ); ?>');
                }

                .cc.Mastercard {
                    background-image:url('<?php echo plugins_url( 'img/icon_cc_mastercard.png', __FILE__ ); ?>');
                }

                .cc.Discover {
                    background-image:url('<?php echo plugins_url( 'img/icon_cc_discover.png', __FILE__ ); ?>');
                }

                .cc.Amex {
                    background-image:url('<?php echo plugins_url( 'img/icon_cc_amex.png', __FILE__ ); ?>');
                }
                </style>
                <script type="text/javascript">
                    function nmi701_toggleState(id, vaultid, total, e) {
                        //using the event, make sure the list item is being clicked on, not the delete link
                        //console.log(e.target.nodeName);
                        if (e.target.nodeName == 'INPUT') {
                            document.getElementById('paymentmethodid').value = "";
                            for (var x=1;x<=total;x++) {
                                document.getElementById('paymentmethodli' + x).className = "";
                            }
                            document.getElementById('pmtable').className = "";
                            document.getElementById('paymentmethodnew').className = "";

                            if (id != 'new') {
                                document.getElementById('paymentmethodli' + id).className = "active";
                                document.getElementById('paymentmethodid').value = document.getElementById('paymentmethod' + id).value;
                                document.getElementById('customervaultid').value = vaultid;
                            }
                            else {
                                document.getElementById('paymentmethodnew').checked = true;
                                document.getElementById('pmtable').className = "active";
                            }
                        }
                    }
                    
                    function nmi701_cc_validate() {
                        //disable form fields
                        document.getElementById("backbutton").disabled = true;
                        document.getElementById("submitbutton").disabled = true;
                        //show spinner
                        document.getElementById("spinner").style.display = "block";


                        

                        if(jQuery("#g-recaptcha-response").val() ==''){
                            alert("Please click the Captcha");
                            document.getElementById("backbutton").disabled = false;
                                document.getElementById("submitbutton").disabled = false;
                                //show spinner
                                document.getElementById("spinner").style.display = "none";
                                return false;
                        }
                               



                        
                        //only do this if the new cc number option is checked
                        if (document.getElementById('paymentmethodnew').checked) {
                            var ccnumber = document.getElementById('billingccnumber').value;
                            var ccexp = document.getElementById('billingccexpmonth').value + "/" + document.getElementById('billingccexpyear').value;
                            //var ccvcc = document.getElementById('cvv').value;
                            var error = "";

                            //validate ccnumber, remove all spaces and check for non-numeric chars.  if it fails, show an alert.  otherwise, the gateway will handle a failed number too
                            var test_ccnumber = ccnumber.replace(/ /g,'');
                            if (isNaN(test_ccnumber) == true) error += "- Not a valid credit card number\n";

                            if (test_ccnumber == '') error += "- Credit card number must not be blank\n";

                            //check exp date.  
                            if (document.getElementById('billingccexpmonth').value != '' && document.getElementById('billingccexpmonth').value != '') {
                                document.getElementById('billingccexp').value = document.getElementById('billingccexpmonth').value + document.getElementById('billingccexpyear').value;
                            }
                            else {
                                error += "- Valid Expiration Date";
                            }

                            if (error != '') {
                                alert('Please make sure the following are correct:\n' + error);
                                document.getElementById("backbutton").disabled = false;
                                document.getElementById("submitbutton").disabled = false;
                                //show spinner
                                document.getElementById("spinner").style.display = "none";
                                return false;
                            }
                            else nmi701_arrangeData();
                        }
                        else nmi701_arrangeData(); //implies user is selecting a saved pm
                    }
                    
                    function populate() {
                        //auto populate - loads the cc form with dummy info
                        document.getElementById('billingccnumber').value = "4111111111111111";
                        //document.getElementById('billingccexp').value = "04/19";
                        document.getElementById('cvv').value = "159";
                        document.getElementById('savepaymentmethod').checked = true;
                    }
                </script>
            <?php
        if ($this->apikey != '') {
            echo "<h3>Pay via the NMI Payment Gateway</h3>";
            echo '<form name="submitpayment" id="submitpayment" action="" method="POST">';
            
            $paymentmethods = array();
            
            if (ngfw_fs()->is_plan('Premium')) {
                if ( is_user_logged_in() && $this->settings['savepaymentmethodstoggle'] == 'on' ) {
                    //display saved pm's (new way)
                    //get the saved payment tokens from WC
                    $payment_tokens = WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );

                    $token = array();
                    foreach ( $payment_tokens as $pt ) {
                        $billingid = $pt->get_token();

                        //query nmi to get the rest of the details for this billing id
                        $paymentmethod = nmi701_getPMDetailsByVaultId( $billingid, $this->apikey );
                        $customervaultid = $paymentmethod['customer']['@attributes']['id'];

                        $thispm = array();
                        $thispm['tokenid']          = $tokenid;
                        $thispm['internalid']       = $pt->get_id();
                        $thispm['billingid']        = $billingid;
                        $thispm['customervaultid']  = $paymentmethod['customer']['@attributes']['id'];
                        $thispm['ccnumber']         = $paymentmethod['customer']['billing']['cc_number'];
                        $thispm['ccexp']            = substr_replace($paymentmethod['customer']['billing']['cc_exp'], '/', 2, 0);
                        $thispm['cardtype']         = $pt->get_card_type();
                        array_push( $paymentmethods, $thispm );
                    }

                    if (count($paymentmethods) > 0) {
                        echo  '<h4>Saved Payment Methods</h3>' ;
                        echo  '<ul class="paymentmethods">' ;
                        $nonce = wp_create_nonce( 'delete-pm-nonce' );
                        for ( $x = 0 ;  $x < count( $paymentmethods ) ;  $x++ ) {
                            $y = $x + 1;
                            if ( $customervaultid == '' ) {
                                $customervaultid = $paymentmethods[$x]['customervaultid'];
                            }
                            $cardtype = nmi701_getCardType( $paymentmethods[$x]['ccnumber'] );
                            ?>
                            <li style="width:100%;margin-bottom:5px;padding:10px;" id="paymentmethodli<?php echo  $y ; ?>" onclick="nmi701_toggleState(<?php echo  $y ; ?>,'<?php echo  esc_html( $paymentmethods[$x]['customervaultid'] ); ?>', <?php echo count( $paymentmethods ); ?>, event);"><input type="radio" name="paymentmethod" id="paymentmethod<?php echo $y; ?>" value="<?php echo esc_html( $paymentmethods[$x]['billingid'] ); ?>" style="float:left;margin-right:15px;display:none;">
                                <label for="paymentmethod<?php echo $y; ?>">
                                    <div class="cc <?php echo $cardtype; ?>"></div>
                                    <div style="float:left;">
                                        <?php $nonce = wp_create_nonce( 'delete_pm' . ${$paymentmethods[$x]['billingid']} ); ?>
                                        <b>Card ending in <?php echo  esc_html( $paymentmethods[$x]['ccnumber'] ); ?></b><br>
                                        <em>Expires <?php echo esc_html( $paymentmethods[$x]['ccexp'] ); ?></em> | 
                                        <a href="javascript:;" onclick="nmi701_deletePM('<?php echo esc_html( $paymentmethods[$x]['billingid'] ); ?>','<?php echo esc_html( $this->apikey ); ?>','<?php echo esc_url( $this->gatewayURL ); ?>','<?php echo esc_html( $paymentmethods[$x]['customervaultid'] ); ?>',<?php echo $y; ?>, event, '<?php echo $nonce; ?>', '<?php echo $paymentmethods[$x]['internalid']; ?>');">Delete</a>
                                        <br clear="all">
                                    </div>
                                    <br clear="all">
                                </label>    
                            </li>
                            <?php 
                        }
                        echo  '</ul>' ;
                    }
                }
            }
            
            echo '<div style="display:none;">';
            echo '<input type="text" name="paymentmethodid" id="paymentmethodid" value="" class="large"><br>';
            echo '<input type="text" name="customervaultid" id="customervaultid" value="'.esc_html($customervaultid).'" class="large"><br>';
            echo '</div>';  
            
            if ( ngfw_fs()->is_plan('Premium') ) {
                if (is_user_logged_in() && $this->settings['savepaymentmethodstoggle'] == 'on') echo "<h4>New Payment Method</h4>";
                else echo "<h4>Please Enter Your Payment Information Below</h4>";
            }
            elseif ( ngfw_fs()->is_not_paying() ) {
                if (is_user_logged_in()) echo "<h4>Please Enter Your Payment Information Below</h4>";
            }
            
            //echo '<a href="javascript:;" onclick="populate();">populate</a>';
            
            echo '<div id="timeoutdsp" class="woocommerce" style="display:none;">
                    <ul class="woocommerce-info" style="list-style:none;">
                        <li>Your checkout has been sitting still for a while.  Please submit your payment or we\'ll take you back to your cart contents in a few minutes.</li>
                    </ul>
                </div>
                <label for="paymentmethodnew" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);">
                <table id="pmtable">
                        <tr><td colspan="2" style="display:none;"><input type="radio" name="paymentmethod" id="paymentmethodnew" value="new" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);"></td></tr>
                        <tr><td>Credit Card Number</td><td><INPUT type ="text" name="billing-cc-number" id="billingccnumber" value="" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);"> </td></tr>
                        <tr><td>Expiration Date</td><td>
                            <select name="billing-cc-exp-month" id="billingccexpmonth" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);">
                                <option value="">---</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                            /
                            <select name="billing-cc-exp-year" id="billingccexpyear" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);">
                                <option value="">----</option>
                                ';
                                for ($x=date("y");$x<=(date("y")+15);$x++) {
                                    if ($x < 10) $dsp = "0";
                                    else $dsp = "";
                                    $year = "20".$dsp.$x;
                                    echo '<option value="'.$dsp.$x.'">'.$year.'</option>';
                                }
            echo ' 
                            </select>
                            <input type="hidden" name="billing-cc-exp" id="billingccexp" value="">
                        </td></tr>
                        <tr><td>CVV</td><td><INPUT type ="text" name="cvv" id="cvv" value="" onclick="nmi701_toggleState(\'new\',\''.esc_html($customervaultid).'\','.count($paymentmethods).', event);"> </td></tr>';
echo $this->getCaptchaThing();
            if ( ngfw_fs()->is_plan('Premium') ) {
                if (is_user_logged_in() && $this->settings['savepaymentmethodstoggle'] == 'on') echo '        <tr><td colspan="2"><label for="savepaymentmethod"><input type="checkbox" name="savepaymentmethod" id="savepaymentmethod" value="Y"> Save this payment method for later?</label></td></tr>';
            }

            echo '    </table>            
                </label>
                <br clear="all">
                <div id="buttons" onload="checkJS()">
                    JavaScript has been disabled in this browser.  Please enable it or <a href="https://www.google.com/chrome/browser/" target="_blank">update your browser</a> to place this order.
                </div>
              </form>
              <form name="submitpaymentmethod" id="submitpaymentmethod" method="post" action=""></form>
            ';
            ?>
                <script type="text/javascript">
                    function checkJS() {
                        //nmi701_backToCheckout('<?php echo $order_id; ?>', '')
                        var buttons = "<INPUT type =\"button\" id=\"backbutton\" value=\"Back to Cart\" onclick=\"window.location='/cart/';\" style=\"float:left;\">&nbsp;<INPUT type=\"button\" id=\"submitbutton\" value=\"Submit\" style=\"float:left;margin-left:15px;\" onclick=\"nmi701_cc_validate();\"><img src=\"<?php echo plugins_url( 'img/spinner.gif', __FILE__ ); ?>\" id=\"spinner\" style=\"display:none;float:left;padding-top:10px;margin-left:15px;\">";
                        document.getElementById('buttons').innerHTML = buttons;
                    }
                    checkJS();
                </script>        
            <?php
            add_action('init', 'checkJS');
        }
        else {
            ?>
            <div style="color: red;font-size:16px;border:1px solid red;border-radius:10px;background-color:#FDFDFD;padding:15px;">
                <b>Checkout is not available at this time.</b><br>
                Please try again later.
            </div>            
            <?php
        }
    }

    /**
     * Get Captcha thing
     */

     function getCaptchaThing() {
         $v='<tr><td id="finalpaymentpage">Captcha</td><td>';
         $v.= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
         $v.='<div class="g-recaptcha" data-sitekey="6LfrYY0aAAAAADEgrZFDsl3IhO911wIEk3E0ic42"></div>';
         $v.='</td></tr>';
         return $v;
     }
    
    /**
     * Successful Payment!
     **/
    function successful_request($tokenid, $orderid, $details = []) {
        
        global $woocommerce;
        //check to see if the order var contains an action        
        if (strpos($orderid, "***")) {
            $splitme = explode("***", $orderid);
            $orderid = $splitme[0];

            $splitme_action = explode("=", $splitme[1]);
            $action = $splitme_action[1];
        }
            
        //define redirect url.  pull from settigns value or use default
        $order = new WC_Order( $orderid );
        
        $redirecturl = $this->redirecturl;
        //if ($redirecturl == '') $redirecturl = $order->get_view_order_url();  
        if ($redirecturl == '') $redirecturl = "/checkout/order-received/".$orderid."/?key=".$order->get_order_key();
        
        $redirecturl_dev = $order->get_checkout_order_received_url();
        $redirecturl = $order->get_checkout_order_received_url();
//        
//        echo "redirect url: ".$redirecturl."<br>";
//        echo "dev redirect: ".$redirecturl_dev;
//        exit;
        
        if (!is_array($details)) $details = []; //temp fix.  need to be able to recreate this error before we know it'll work: Uncaught Error: Cannot use object of type WP_Error as array 
        
        if ($action == 'addbilling') {
            //sale action
            $order = new WC_Order( $orderid );
            //$order_data = $order->get_data();
            $order_total = $order->get_total();
            $payment_status = "OK";

            $APIKey = $this->apikey;
            $token = sanitize_text_field($_GET['token-id']);
            $oncomplete_action = $this->finalorderstatus;            
            
            //check order status
            if ($order->get_status() != 'Completed') {
                if ($details['ispaymentmethod'] == 'N') {
                    //step 3
                    // Get cURL resource
                    // Create body
                    $body = '<complete-action> 
                        <api-key>'.$APIKey.'</api-key>
                        <token-id>'.$token.'</token-id>
                    </complete-action>';

                    $args = array(
                        "headers"       => array(
                            "Content-type"  => "text/xml; charset=\"UTF-8\""
                        ),
                        "body"          => $body
                    );

                    //use wp function to handle curl calls
                    $response = wp_remote_post($this->gatewayURL, $args);
                    
                    $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    $result = json_decode($json, TRUE);  
                    
                    //need to have the correct values coming back
                    if($result['result'] != 1) {
                        //failure
                        $payment_status = "failure";

                        //split error message to hide REFID: 
                        $dsp_error = explode("REFID",$result['result-text']);
                        $dsp_error = $dsp_error[0];

                        $dsp_error = $result['result-text'];

                        //friendly errors as needed
                        if ($dsp_error == 'DECLINE') $dsp_error = "Your card has been declined";

                        //add extra info, if available
                        if (nmi701_getResultCodeText($result['result-code']) != '') {
                            $dsp_error.= " (".nmi701_getResultCodeText($result['result-code']).")";
                        }

                        //display confirmation message
                        wc_add_notice(__('There was a problem with your order: '.$dsp_error, 'nmi_three_step'), 'error');
                        $order->update_status('failed', $error_message.", ".$dsp_error);

                        //die & go back to the cart to display the error
                        wp_safe_redirect($redirecturl);
                        exit;
                    } 
                    else {
                        //pull values from response
                        $userid = get_current_user_id();
                        $customerid =       $result['customer-id'];
                        $customervaultid =  $result['customer-vault-id'];
                        $billingid =        $result['billing']['billing-id'];
                        $ccnumber =         $result['billing']['cc-number'];
                        $ccexp =            $result['billing']['cc-exp'];
                        $cctype =           nmi701_getCardType($ccnumber);
                        $last4 = substr($ccnumber, -4);
                                
                        $token = new WC_Payment_Token_CC();
                        $token->set_token($billingid);
                        $token->set_gateway_id('');
                        $token->set_user_id($userid);
                        $token->set_last4($last4);   //sending full, might need just last 4?
                        $token->set_expiry_month(substr($ccexp, 0, 2));
                        $token->set_expiry_year('20'.substr($ccexp, -2 ));
                        $token->set_card_type($cctype);
                        $token->save();    

                        //send order to gateway
                        $body = '<sale> 
                                    <api-key>'.$APIKey.'</api-key>
                                    <amount>'.$order_total.'</amount>
                                    <customer-vault-id>'.$customervaultid.'</customer-vault-id>
                                    <order-id>'.$orderid.'</order-id>
                                    <billing>
                                        <billing-id>'.$billingid.'</billing-id>
                                    </billing>';
                        
                        $items = $order->get_items();
                        foreach ($items AS $item) {
                            $body.= '<product>';
                            $body.= '   <product-code>'.$item["product_id"].'</product-code>';
                            $body.= '   <description>'.$item["name"].'</description>';
                            $body.= '   <commodity-code></commodity-code>';
                            $body.= '   <unit-of-measure></unit-of-measure>';
                            $body.= '   <unit-cost>'.round($item["line_total"],2).'</unit-cost>';
                            $body.= '   <quantity>'.round($item["qty"]).'</quantity>';
                            $body.= '   <total-amount>'.round($item["line_subtotal"],2).'</total-amount>';
                            $body.= '   <tax-amount></tax-amount>';
                            $body.= '   <tax-rate>1.00</tax-rate>';
                            $body.= '   <discount-amount></discount-amount>';
                            $body.= '   <discount-rate></discount-rate>';
                            $body.= '   <tax-type></tax-type>';
                            $body.= '   <alternate-tax-id></alternate-tax-id>';
                            $body.= '</product>';
                        }
        
                        $body.= '</sale>';

                        $args = array(
                            "headers"       => array(
                                "Content-type"  => "text/xml; charset=\"UTF-8\""
                            ),
                            "body"          => $body
                        );

                        //use wp function to handle curl calls
                        $response = wp_remote_post($this->gatewayURL, $args);

                        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $result = json_decode($json, TRUE);  
                        
                        //update subscription status?
                        $payment_status = "OK";
                    }
                }
                else {
                    $payment_status = "OK";
                    $result['result-code'] = sanitize_text_field($details['rc']);
                    $result['transaction-id'] = sanitize_text_field($details['tid']);
                    $result['authorization-code'] = sanitize_text_field($details['ac']);
                    $result['avs-result'] = sanitize_text_field($details['ar']);
                }

                //finalize order
                if ($payment_status == 'OK') {            
                    $resultCodeText = nmi701_getResultCodeText($result['result-code']);

                    // Payment has been successful
                    $order->add_order_note( __( 'NMI Gateway payment completed.', 'nmi_three_step' ) );

                    // Add helpful notes
                    $note = "Order Details:\n";
                    $note.= "Transaction ID: ".sanitize_text_field($result['transaction-id'])."\n";
                    $note.= "Result Code Text: ".sanitize_text_field($resultCodeText)." (Code: ".$result['result-code'].")\n";
                    $note.= "Authorization Code: ".sanitize_text_field($result['authorization-code'])."\n";
                    $note.= "Address Match: ".sanitize_text_field($result['avs-result']);
                    $order->add_order_note( __( $note, 'nmi_three_step' ) );

                    // Mark as paid/payment complete
                    $order->payment_complete($token);    // Return thankyou redirect
                    
                    // Empty cart
                    $woocommerce->cart->empty_cart();

                    //only flag as completed if the settings tell us to do so
                    if ($oncomplete_action == 'Completed') {
                        //flag the order as completed in the eyes of woo
                        $order->update_status('completed', 'Successful payment by the NMI Three Step Gateway');
                    }
                    elseif ($oncomplete_action == 'Ready to Ship') {
                        //flag the order as completed in the eyes of woo
                        $order->update_status('ready-to-ship', 'Successful payment by the NMI Three Step Gateway');
                    }
                    
                    //if woocommerce_thankyou exists and the settings checkbox is checked, run it
                    if (has_action('woocommerce_thankyou')) {
                        do_action('woocommerce_thankyou', $orderid);
                    }

                    //display confirmation message
                    wc_add_notice(__('Your order is complete!  Thank you!', 'nmi_three_step'), 'success');

                    //redirect to the empty cart w/ display message
                    wp_safe_redirect($redirecturl);
                    exit;
                }
                else {
                    //if payment fails
                    // Add helpful notes
                    $note = "Failure Details:\n";
                    $note.= "Result Code Text: ".$resultCodeText." (Code: ".$result['result-code'].")\n";
                    $order->add_order_note( __( $note, 'nmi_three_step' ) );
                    wc_add_notice(__('Payment Failed: '.$dsp_error, 'nmi_three_step'), 'error');
                    return;
                }
            }
        }
        else {
            //sale action
            $order = new WC_Order( $orderid );
            $payment_status = "OK";

            $APIKey = $this->apikey;
            $token = sanitize_text_field($_GET['token-id']);
            $oncomplete_action = $this->finalorderstatus;
            
            //check order status
            if ($order->get_status() != 'Completed') {
                if ($details['ispaymentmethod'] == 'N') {
                    //step 3
                    // Get cURL resource
                    // Create body
                    $body = '<complete-action> 
                        <api-key>'.$APIKey.'</api-key>
                        <token-id>'.$token.'</token-id>
                    </complete-action>';
                    
                    $args = array(
                        "headers"       => array(
                            "Content-type"  => "text/xml; charset=\"UTF-8\""
                        ),
                        "body"          => $body
                    );

                    //use wp function to handle curl calls
                    $response = wp_remote_post($this->gatewayURL, $args);
                    
                    if (is_object(($response))) {
                        $response = $response->errors;
                        
                        $result['result'] = "Failed Transaction";
                        $result['result-text'] = $response['http_request_failed'][0];
                        $result['result-code'] = "";
                    }
                    else {
                        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $result = json_decode($json, TRUE);  
                    }

                    //need to have the correct values coming back
                    if($result['result'] != 1) {
                        //failure
                        $payment_status = "failure";

                        //split error message to hide REFID: 
                        $dsp_error = explode("REFID",$result['result-text']);
                        $dsp_error = $dsp_error[0];

                        $dsp_error = $result['result-text'];

                        //friendly errors as needed
                        if ($dsp_error == 'DECLINE') $dsp_error = "Your card has been declined";

                        //add extra info, if available
                        if (nmi701_getResultCodeText($result['result-code']) != '') {
                            $dsp_error.= " (".nmi701_getResultCodeText($result['result-code']).")";
                        }

                        //display confirmation message
                        wc_add_notice(__('There was a problem with your order: '.$dsp_error, 'nmi_three_step'), 'error');

                        $order->update_status('failed', $error_message.", ".$dsp_error);

                        //die & go back to the cart to display the error
                        wp_safe_redirect($redirecturl);
                        exit;
                    } else {
                        //success, leave in for debug
                        $payment_status = "OK";
                    }
                }
                else {
                    $payment_status = "OK";
                    $result['result-code'] = sanitize_text_field($details['rc']);
                    $result['transaction-id'] = sanitize_text_field($details['tid']);
                    $result['authorization-code'] = sanitize_text_field($details['ac']);
                    $result['avs-result'] = sanitize_text_field($details['ar']);
                }

                //finalize order
                if ($payment_status == 'OK') {            
                    $resultCodeText = nmi701_getResultCodeText($result['result-code']);

                    // Payment has been successful
                    $order->add_order_note( __( 'NMI Gateway payment completed.', 'nmi_three_step' ) );

                    // Add helpful notes
                    $note = "Order Details:\n";
                    $note.= "Transaction ID: ".sanitize_text_field($result['transaction-id'])."\n";
                    $note.= "Result Code Text: ".sanitize_text_field($resultCodeText)." (Code: ".$result['result-code'].")\n";
                    $note.= "Authorization Code: ".sanitize_text_field($result['authorization-code'])."\n";
                    $note.= "Address Match: ".sanitize_text_field($result['avs-result']);
                    $order->add_order_note( __( $note, 'nmi_three_step' ) );

                    // Mark as paid/payment complete
                    $order->payment_complete($token);    // Return thankyou redirect
                    
                    // Empty cart
                    $woocommerce->cart->empty_cart();

                    //only flag as completed if the settings tell us to do so
                    if ($oncomplete_action == 'Completed') {
                        //flag the order as completed in the eyes of woo
                        $order->update_status('completed', 'Successful payment by the NMI Three Step Gateway');
                    }
                    elseif ($oncomplete_action == 'Ready to Ship') {
                        //flag the order as completed in the eyes of woo
                        $order->update_status('ready-to-ship', 'Successful payment by the NMI Three Step Gateway');
                    }
                    
                    //if woocommerce_thankyou exists and the settings checkbox is checked, run it
                    if (has_action('woocommerce_thankyou')) {
                        do_action('woocommerce_thankyou', $orderid);
                    }

                    //display confirmation message
                    wc_add_notice(__('Your order is complete!  Thank you!', 'nmi_three_step'), 'success');

                    //redirect to the empty cart w/ display 
                    wp_safe_redirect($redirecturl);
                    exit;
                }
                else {
                    //if payment fails
                    // Add helpful notes
                    $note = "Failure Details:\n";
                    $note.= "Result Code Text: ".$resultCodeText." (Code: ".$result['result-code'].")\n";
                    $order->add_order_note( __( $note, 'nmi_three_step' ) );
                    wc_add_notice(__('Payment Failed: '.$dsp_error, 'nmi_three_step'), 'error');
                    return;
                }
            }
        }
    }

    /* Output for the order received page.   */
    function thankyou() {
        echo $this->instructions != '' ? wpautop( $this->instructions ) : '';
    }
    
    /* Refund */
    public function process_refund( $order_id, $amount = null, $reason = '' ) {
        //check for ssl
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $isssl = "Y";
        else $isssl = "N";
        
        // Do your refund here. Refund $amount for the order with ID $order_id
        $order = new WC_Order( $order_id );
        $APIKey = $this->apikey;  
        $total = $order->get_total();
        $transactionid = nmi701_getTransactionId($order_id, $APIKey);
        $isrefunded = "N";
        
        //if amount to refund is the same as the total of the order, try to void it first
        if ($amount == $total && $transactionid != '') {    
            // Create body
            $body = '<void> 
                <api-key>'.$APIKey.'</api-key>
                <transaction-id>'.$transactionid.'</transaction-id>
            </void>';
            
            $args = array(
                "headers"       => array(
                    "Content-type"  => "text/xml; charset=\"UTF-8\""
                ),
                "body"          => $body
            );
        
            //use wp function to handle curl calls
            $response = wp_remote_post($this->gatewayURL, $args);

            $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $result = json_decode($json, TRUE);
            
            $result_id = $result['result'];         //1, 3
            $result_text = $result['result-text'];  //Transaction Void Successful, Only transactions pending settlement can be voided
            $result_code = $result['result-code'];  //100, 300
            
            if ($result_id == 1) {
                $isrefunded = "Y";
                
                //defined note posted to woocommerce cart details
                $note = "This transaction was refunded in full.";
            }
        }
        
        if ($isrefunded == 'N') {
            //refund the transaction for the specified amount   
            // Create body
            $body = '<refund> 
                <api-key>'.$APIKey.'</api-key>
                <transaction-id>'.$transactionid.'</transaction-id>
                <amount>'.$amount.'</amount>
            </refund>';
        
            $args = array(
                "headers"       => array(
                    "Content-type"  => "text/xml; charset=\"UTF-8\""
                ),
                "body"          => $body
            );
        
            //use wp function to handle curl calls
            $response = wp_remote_post($this->gatewayURL, $args);

            $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $result = json_decode($json, TRUE);

            $result_id = $result['result'];         //1, 3
            $result_text = $result['result-text'];  //Transaction Void Successful, Only transactions pending settlement can be voided
            $result_code = $result['result-code'];  //100, 300
            
            if ($result_id == 1) {
                if ($amount == $total) $note = "This transaction was refunded in full";
                else $note = "$".$amount." was refunded toward this transaction.";
                $isrefunded = "Y";
            }
            else $note = "There was an error in posting the refund to this order: ".$result_text;
        }
        
        // Add helpful notes
        $order->add_order_note( __( $note, 'nmi_three_step' ) );

        if ($isrefunded == 'Y') return true;
        else return false;
    }
}

//shared methods
function nmi701_getPMDetailsByVaultId($billingid, $apikey) {
    //gather payment methods for this customervaultid
    $APIKey     = sanitize_text_field($apikey);
    $url        = "https://secure.networkmerchants.com/api/query.php";

    // Create body
    $body = [
        "keytext"               => $APIKey,
        "report_type"           => 'customer_vault',
        "ver"                   => 2,
        "billing_id"            => $billingid,
    ];
    $body = http_build_query($body);

    $args = array(
        "headers"       => array(
            "Content-type"  => "application/x-www-form-urlencoded; charset=utf-8"
        ),
        "body"          => $body
    );

    //use wp function to handle curl calls
    $response = wp_remote_post($url, $args);
    
    //check
    if (isset($response['response']['code']) && $response['response']['code'] == 200) {
        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $resp = json_decode($json, TRUE);

        //$paymentmethods = nmi701_organizePaymentMethods($resp['customer_vault']['customer']);
        //gets details on nmi entry by billing id and api key
        $paymentmethod = $resp['customer_vault'];
        
        return $paymentmethod;
    }            
    else {
        return "no results";
    }
}

function nmi701_organizePaymentMethods($pms){
    //this function takes in the results from getting all the payment methods and reorganizes them to a simple array that makes more sense
    //paymentmethods[$x]['customervaultid']
    //paymentmethods[$x]['billingid']
    //paymentmethods[$x]['ccnumber']
    //paymentmethods[$x]['ccexp'] (add slash for dsp)
        
    $paymentmethods = [];
    $foundbillingids = [];

    for ($x=0;$x<count($pms);$x++) {
        //check for multiple billing ids per vault id
        if (isset($pms[$x]['billing'][0]['@attributes']['id'])) {
            //should imply more than one billing id for this customer vault
            for ($y=0;$y<count($pms[$x]['billing']);$y++) {
                if (!in_array($pms[$x]['billing'][$y]['@attributes']['id'], $foundbillingids) && !is_array($pms[$x]['billing'][$y]['cc_number'])) {
                    $item = [];
                    $item['customervaultid'] = sanitize_text_field($pms[$x]['billing'][$y]['customer_vault_id']);
                    $item['billingid'] = sanitize_text_field($pms[$x]['billing'][$y]['@attributes']['id']);
                    $item['ccnumber'] = sanitize_text_field($pms[$x]['billing'][$y]['cc_number']);
                    $item['ccexp'] = sanitize_text_field(substr_replace($pms[$x]['billing'][$y]['cc_exp'], "/", 2, 0));
                    array_push($paymentmethods, $item);
                    array_push($foundbillingids, $pms[$x]['billing'][$y]['@attributes']['id']);
                }
            }
        }
        elseif (isset($pms[0]['@attributes']['id'])) {
            if (!in_array($pms[$x]['billing']['@attributes']['id'], $foundbillingids) && !is_array($pms[$x]['billing']['cc_number'])) {
                //should imply there is a single billing id for this customer vault
                $item = [];
                $item['customervaultid'] = sanitize_text_field($pms[$x]['billing']['customer_vault_id']);
                $item['billingid'] = sanitize_text_field($pms[$x]['billing']['@attributes']['id']);
                $item['ccnumber'] = sanitize_text_field($pms[$x]['billing']['cc_number']);
                $item['ccexp'] = sanitize_text_field(substr_replace($pms[$x]['billing']['cc_exp'], "/", 2, 0));
                array_push($paymentmethods, $item);
                array_push($foundbillingids, $pms[$x]['billing']['@attributes']['id']);
            }
        }
        elseif (isset($pms['billing'][0]['@attributes']['id'])) {
            //should imply there is a single vault with multiple billing ids
            for ($y=0;$y<count($pms['billing']);$y++) {
                if (!in_array($pms['billing'][$y]['@attributes']['id'], $foundbillingids) && !is_array($pms['billing'][$y]['cc_number'])) {
                    $item = [];
                    $item['customervaultid'] = sanitize_text_field($pms['billing'][$y]['customer_vault_id']);
                    $item['billingid'] = sanitize_text_field($pms['billing'][$y]['@attributes']['id']);
                    $item['ccnumber'] = sanitize_text_field($pms['billing'][$y]['cc_number']);
                    $item['ccexp'] = sanitize_text_field(substr_replace($pms['billing'][$y]['cc_exp'], "/", 2, 0));
                    array_push($paymentmethods, $item);
                    array_push($foundbillingids, $pms['billing'][$y]['@attributes']['id']);
                }
            }
        }
        elseif (isset($pms['@attributes']['id'])) {
            if (!in_array($pms['billing']['@attributes']['id'], $foundbillingids) && !is_array($pms['billing']['cc_number'])) {
                //should imply there is a single billing id for a single customer vault 
                $item = [];
                $item['customervaultid'] = sanitize_text_field($pms['billing']['customer_vault_id']);
                $item['billingid'] = sanitize_text_field($pms['billing']['@attributes']['id']);
                $item['ccnumber'] = sanitize_text_field($pms['billing']['cc_number']);
                $item['ccexp'] = sanitize_text_field(substr_replace($pms['billing']['cc_exp'], "/", 2, 0));
                array_push($paymentmethods, $item);
                array_push($foundbillingids, $pms['billing']['@attributes']['id']);
            }
        }
    }

    return $paymentmethods;
}

function nmi701_getCardType($number) {
    //The first six digits of a card number (including the initial MII digit) are known as the issuer identification number (IIN). 
    //These identify the card issuing institution that issued the card to the card holder. 
    //The rest of the number is allocated by the card issuer. The card number's length is its number of digits. 
    //Many card issuers print the entire IIN and account number on their card.
    //source: https://en.wikipedia.org/wiki/Payment_card_number
    $cardtype = "";
    
    if (substr($number, 0) == 4) {
        //check for visa
        //first digit is 4
        $cardtype = "Visa";
    }
    elseif (substr($number, 0, 2) == 37 || substr($number, 0, 2) == 32) {
        //check for american express
        //first 2 digits are 34 o 37
        $cardtype = "Amex";
    }
    elseif (substr($number, 0) == 6) {
        //check for discover card
        //first digit is 6
        $cardtype = "Discover";
    }
    elseif (substr($number, 0) == 5) {
        //check for mastercard
        //first digit is 5
        $cardtype = "Mastercard";
    }
    else $cardtype = "Unknown";

    return $cardtype;
}

function nmi701_getResultCodeText($code) {
    //definitions
    $codes = [
        array(1,'Transaction was approved'),
        array(100,'Transaction was approved'),
        array(200,'Transaction was delined by processor'),
        array(201,'Do not honor'),
        array(202,'Insufficient funds'),
        array(203,'Over limit'),
        array(204,'Transaction not allowed'),
        array(220,'Incorrect payment information'),
        array(221,'No such card issuer'),
        array(222,'No card number on file with issuer'),
        array(223,'Expired card'),
        array(224,'Invalid expiration date'),
        array(225,'Invalid card security code'),
        array(240,'Call issuer for further information'),
        array(250,'Pick up card'),
        array(251,'Lost card'),
        array(252,'Stolen card'),
        array(253,'Fraudulent Card'),
        array(260,'Declined with further instructions available'),
        array(261,'Declined-Stop all recurring payments'),
        array(262,'Declined-Stop this recurring program'),
        array(263,'Declined-Update cardholder data available'),
        array(264,'Declined-Retry in a few days'),
        array(300,'Transaction was rejected by gateway'),
        array(400,'Transaction error returned by processor'),
        array(410,'Invalid merchant configuration'),
        array(411,'Merchant account is inactive'),
        array(420,'Communication error'),
        array(421,'Communication error with issuer'),
        array(430,'Duplicate transaction at processor'),
        array(440,'Processor format error'),
        array(441,'Invalid transaction information'),
        array(460,'Processor feature not available'),
        array(461,'Unsupported card type')
    ];

    $resultCodeText = "";

    for ($x=0;$x<count($codes);$x++) {
        if ($codes[$x][0] == $code) {
            $resultCodeText = $codes[$x][1];
            break;
        }
    }

    return $resultCodeText;
}

function nmi701_getTransactionId($order_id, $apikey) {
    //check for ssl
    // Create body
    $body = [
     ];
    $body = http_build_query($body);
        
    $args = array(
        "headers"       => array(
            "Content-type"  => "Content-Type: application/x-www-form-urlencoded; charset=utf-8"
        ),
        "body"          => $body
    );

    //use wp function to handle curl calls
    $resp = wp_remote_get('https://secure.networkmerchants.com/api/query.php?keytext='.$apikey.'&ver=2&action_type=sale&order_id='.$order_id, $args);

    $xml = simplexml_load_string($resp['body'], "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $result = json_decode($json, TRUE);

    if(!$resp) {
        $transactionid = "";
        $response = "error";
    } else {
        $response = $resp;
        $transactionid = sanitize_text_field($result['transaction']['transaction_id']);
    }
    
    return $transactionid;
}


function nmi701_cleanTheData($data, $datatype = 'none') {
    // per WP's requirements, we need to sanitze, validate and escape data passed in from the form.  I'm attempting to do that in one function
    // $data is the value to clean, $datatype (if defined) is the expected data type of $data
    // based on the datatype, we'll run some extra validation as well.  in the end, we'll return either the scrubbed data value or a null value if it doesn't comply
    
    // validate data
    switch ($datatype) {
        case 'string':
            if (gettype($data) != 'string') $data = "";
            $data = sanitize_text_field($data);
            break;
        case 'int':
            if (gettype($data) != 'integer') $data = "0";
            $data = sanitize_text_field($data);
            break;
        case 'url':
            if (filter_var($data, FILTER_VALIDATE_URL) == false) $data = "";
            $data = sanitize_text_field($data);
            break;
        case 'email':
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) $data = "";
            $data = sanitize_email($data);
            break;
    }
    
    // sanitize data
    if ($data != '') {
        $data = esc_html(htmlspecialchars($data));
    }
    
    return $data;
}

function nmi701_pw_load_scripts() {
    wp_enqueue_script( 'nmi701_ajax_custom_script',  plugin_dir_url(__FILE__) . 'js/stepOne.js', array('jquery') );
    wp_localize_script( 'nmi701_ajax_custom_script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script( 'nmi701_ajax_custom_script1',  plugin_dir_url(__FILE__) . 'js/deletePaymentMethod.js', array('jquery') );
    wp_localize_script( 'nmi701_ajax_custom_script1', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action('wp_enqueue_scripts', 'nmi701_pw_load_scripts');

function nmi701_stepOne_addBilling() {
    $security = sanitize_text_field($_POST['security']);
    check_ajax_referer( 'checkout-nonce', 'security', false );

    //catch variables passed in and define them
    $thisid = sanitize_text_field($_POST['thisid']);
    $orderid = sanitize_text_field($_POST['orderid']);
    $apikey = sanitize_text_field($_POST['apikey']);
    $transactiontype = sanitize_text_field($_POST['transactiontype']);
    $gatewayurl = sanitize_text_field($_POST['gatewayurl']);
    $ordertotal = sanitize_text_field($_POST['ordertotal']);
    $ordertax = sanitize_text_field($_POST['ordertax']);
    $ordershipping = sanitize_text_field($_POST['ordershipping']);
    $savepaymentmethod = sanitize_text_field($_POST['savepaymentmethod']);
    $customervaultid = sanitize_text_field($_POST['customervaultid']);
    $user_email = sanitize_email($_POST['user_email']);
    $userid = sanitize_text_field($_POST['userid']);
    $last4 = sanitize_text_field($_POST['last4']);
    $expiry = sanitize_text_field($_POST['expiry']);
        
    $billingid = sanitize_text_field($_POST['billingid']);
    
    //get the saved payment tokens from WC
    $payment_tokens = WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );

    $token = array();
    foreach ( $payment_tokens as $pt ) {
        $billingid = $pt->get_token();

        //query nmi to get the rest of the details for this billing id
        $paymentmethod = nmi701_getPMDetailsByVaultId( $billingid, $apikey );
        $customervaultid = $paymentmethod['customer']['@attributes']['id'];

        $thispm = array();
        $thispm['tokenid']          = $tokenid;
        $thispm['internalid']       = $pt->get_id();
        $thispm['billingid']        = $billingid;
        $thispm['customervaultid']  = $paymentmethod['customer']['@attributes']['id'];
        $thispm['ccnumber']         = $paymentmethod['customer']['billing']['cc_number'];
        $thispm['ccexp']            = substr_replace($paymentmethod['customer']['billing']['cc_exp'], '/', 2, 0);
        $thispm['cardtype']         = $pt->get_card_type();
        array_push( $paymentmethods, $thispm );
    }

    //now that we have all the payment methods, we need to find the ones that match just the selected vault id
    $usedbillingids = array();
    for ( $x = 0 ;  $x < count( $paymentmethods ) ;  $x++ ) {
        if ( $paymentmethods[$x]['customervaultid'] == $customervaultid ) {
            array_push( $usedbillingids, $paymentmethods[$x]['billingid'] );
        }
    }

    //come up with a unique billing id
    $fail = 'Y';
    $length = 10;
    while ( $fail == 'Y' ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString = '';
        for ( $i = 0 ;  $i < $length ;  $i++ ) {
            $randomString .= $characters[rand( 0, $charactersLength - 1 )];
        }

        if ( !in_array( $randomString, $usedbillingids ) ) {
            $newbillingid = $randomString;
            $billingid = $randomString;
            $fail = 'N';
        }
    }
    
    $billingfirstname = sanitize_text_field($_POST['billingfirstname']);
    $billinglastname = sanitize_text_field($_POST['billinglastname']);
    $billingaddress1 = sanitize_text_field($_POST['billingaddress1']);
    $billingcity = sanitize_text_field($_POST['billingcity']);
    $billingstate = sanitize_text_field($_POST['billingstate']);
    $billingpostcode = sanitize_text_field($_POST['billingpostcode']);
    $billingcountry = sanitize_text_field($_POST['billingcountry']);
    $billingemail = sanitize_email($_POST['billingemail']);
    $billingphone = sanitize_text_field($_POST['billingphone']);
    $billingcompany = sanitize_text_field($_POST['billingcompany']);
    $billingaddress2 = sanitize_text_field($_POST['billingaddress2']);
    $shippingfirstname = sanitize_text_field($_POST['shippingfirstname']);
    $shippinglastname = sanitize_text_field($_POST['shippinglastname']);
    $shippingaddress1 = sanitize_text_field($_POST['shippingaddress1']);
    $shippingcity = sanitize_text_field($_POST['shippingcity']);
    $shippingstate = sanitize_text_field($_POST['shippingstate']);
    $shippingpostcode = sanitize_text_field($_POST['shippingpostcode']);
    $shippingcountry = sanitize_text_field($_POST['shippingcountry']);
    $shippingphone = sanitize_text_field($_POST['shippingphone']);
    $shippingcompany = sanitize_text_field($_POST['shippingcompany']);
    $shippingaddress2 = sanitize_text_field($_POST['shippingaddress2']);

    //referrer url issue - nmi can't accept a url with a query string in it (http://someurl.com/checkout/?key=wc_order_996889&order=555)
    $referrer = explode("?", $_SERVER["HTTP_REFERER"]);
    $thisreferrer = $referrer[0];
    $thisreferrer.= "?order=".$orderid."***action=addbilling***plugin=".$thisid;
    
    //build item list
    $items = [];
    for ($x=0;$x<$_POST['itemcount'];$x++) {
        $item = [
            "product_id" => sanitize_text_field($_POST['items'][$x]['productid']),
            "name" => sanitize_text_field(stripslashes($_POST['items'][$x]['name'])),
            "line_total" => sanitize_text_field(($_POST['items'][$x]['line_total'] / $_POST['items'][$x]['qty'])),
            "qty" => sanitize_text_field($_POST['items'][$x]['qty']),
            "line_subtotal" => sanitize_text_field($_POST['items'][$x]['line_subtotal'])
        ];
        array_push($items, $item);
    }
    
    //add billing
    $body = '<add-billing>
            <api-key>'.$apikey.'</api-key>
            <redirect-url>'.$thisreferrer.'</redirect-url>
            <customer-vault-id>'.$customervaultid.'</customer-vault-id>
            <billing>
                <billing-id>'.$billingid.'</billing-id>
                <email>'.$billingemail.'</email>
                <first-name>'.$billingfirstname.'</first-name>
                <last-name>'.$billinglastname.'</last-name>
                <address1>'.$billingaddress1.'</address1>
                <city>'.$billingcity.'</city>
                <state>'.$billingstate.'</state>
                <postal>'.$billingpostcode.'</postal>
                <country>'.$billingcountry.'</country>
            </billing>
        </add-billing>';

    $args = array(
        "headers"       => array(
            "Content-type"  => "text/xml; charset=\"UTF-8\""
        ),
        "body"          => $body
    );

    //use wp function to handle curl calls
    $response = wp_remote_post($gatewayurl, $args);

    $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $full_response = json_decode($json, TRUE); 

    //if successful, submit order thru the direct post now that we have the billing id/token
    echo  $full_response['form-url']."--||--".$billingid;
    wp_die();
}

function nmi701_stepOne() {  
    global $woocommerce;
    $security = sanitize_text_field($_POST['security']);
    check_ajax_referer( 'checkout-nonce', 'security', false );


    // test the captcha against google

    

    //catch variables passed in and define them
    $captcha_response = sanitize_text_field($_POST['g_recaptcha_response']);


    $respcaptcha = wp_remote_post(
        'https://www.google.com/recaptcha/api/siteverify',
        array(
            'body' => array(
                'secret'   => '6LfrYY0aAAAAAP2-MzwBCeMAnQukQcmmyHONhivt',
                'response'     => $captcha_response
            )
        )
    );


$capcheck = json_decode($respcaptcha['body'])    ;
$orderid = sanitize_text_field($_POST['orderid']);

/* 
$order = new WC_Order( $orderid );

$dsp_error=" The thing no worky";
//display confirmation message
wc_add_notice(__('There was a problem with your order: '.$dsp_error, 'nmi_three_step'), 'error');
$order->update_status('failed', $dsp_error);

//die & go back to the cart to display the error
$redirecturl = $this->redirecturl;
wp_safe_redirect( $redirecturl);
die(); */

if ($capcheck->success) {
     //pass thru
} else {

   // wp_die();

}
    //die("R::".$captcha_response);
    
    $apikey = sanitize_text_field($_POST['apikey']);
    $transactiontype = sanitize_text_field($_POST['transactiontype']);
    $gatewayurl = sanitize_text_field($_POST['gatewayurl']);
    $ordertotal = sanitize_text_field($_POST['ordertotal']);
    $ordertax = sanitize_text_field($_POST['ordertax']);
    $ordershipping = sanitize_text_field($_POST['ordershipping']);
    $savepaymentmethod = sanitize_text_field($_POST['savepaymentmethod']);
    $customervaultid = sanitize_text_field($_POST['customervaultid']);
    $user_email = sanitize_email($_POST['user_email']);
    $userid = sanitize_text_field($_POST['userid']);
    $last4 = sanitize_text_field($_POST['last4']);
    $expiry = sanitize_text_field($_POST['expiry']);
        
    $billingid = sanitize_text_field($_POST['billingid']);
    $billingfirstname = sanitize_text_field($_POST['billingfirstname']);
    $billinglastname = sanitize_text_field($_POST['billinglastname']);
    $billingaddress1 = sanitize_text_field($_POST['billingaddress1']);
    $billingcity = sanitize_text_field($_POST['billingcity']);
    $billingstate = sanitize_text_field($_POST['billingstate']);
    $billingpostcode = sanitize_text_field($_POST['billingpostcode']);
    $billingcountry = sanitize_text_field($_POST['billingcountry']);
    $billingemail = sanitize_email($_POST['billingemail']);
    $billingphone = sanitize_text_field($_POST['billingphone']);
    $billingcompany = sanitize_text_field($_POST['billingcompany']);
    $billingaddress2 = sanitize_text_field($_POST['billingaddress2']);
    $shippingfirstname = sanitize_text_field($_POST['shippingfirstname']);
    $shippinglastname = sanitize_text_field($_POST['shippinglastname']);
    $shippingaddress1 = sanitize_text_field($_POST['shippingaddress1']);
    $shippingcity = sanitize_text_field($_POST['shippingcity']);
    $shippingstate = sanitize_text_field($_POST['shippingstate']);
    $shippingpostcode = sanitize_text_field($_POST['shippingpostcode']);
    $shippingcountry = sanitize_text_field($_POST['shippingcountry']);
    $shippingphone = sanitize_text_field($_POST['shippingphone']);
    $shippingcompany = sanitize_text_field($_POST['shippingcompany']);
    $shippingaddress2 = sanitize_text_field($_POST['shippingaddress2']);

    //referrer url issue - nmi can't accept a url with a query string in it (http://someurl.com/checkout/?key=wc_order_996889&order=555)
    $referrer = explode("?", $_SERVER["HTTP_REFERER"]);
    $referrer = $referrer[0];
    $referrer.= "?order=".$orderid;
    
    //build item list
    $items = [];
    for ($x=0;$x<$_POST['itemcount'];$x++) {
        $item = [
            "product_id" => sanitize_text_field($_POST['items'][$x]['productid']),
            "name" => sanitize_text_field(stripslashes($_POST['items'][$x]['name'])),
            "line_total" => sanitize_text_field(($_POST['items'][$x]['line_total'] / $_POST['items'][$x]['qty'])),
            "qty" => sanitize_text_field($_POST['items'][$x]['qty']),
            "line_subtotal" => sanitize_text_field($_POST['items'][$x]['line_subtotal'])
        ];
        array_push($items, $item);
    }

    if ($billingid != '') {
        //implies user selected a previously existing payment method (billing id)
        // Create body
        $body = '
            <'.$transactiontype.'>
                <api-key>'.$apikey.'</api-key>
                <redirect-url>'.$referrer.'</redirect-url>
                <amount>'. $ordertotal.'</amount>
                <ip-address>'.$_SERVER['remote_address'].'</ip-address>
                <currency>USD</currency>
                <order-id>'.$orderid.'</order-id>
                <order-description>Online Order</order-description>
                <tax-amount>'.$ordertax.'</tax-amount>
                <shipping-amount>'.$ordershipping.'</shipping-amount>
                <customer-vault-id>'.$customervaultid.'</customer-vault-id>
                <billing>
                    <billing-id>'.$billingid.'</billing-id>
                    <first-name>'.$billingfirstname.'</first-name>
                    <last-name>'.$billinglastname.'</last-name>
                    <address1>'.$billingaddress1.'</address1>
                    <city>'.$billingcity.'</city>
                    <state>'.$billingstate.'</state>
                    <postal>'.$billingpostcode.'</postal>
                    <country>'.$billingcountry.'</country>
                    <email>'.$billingemail.'</email>
                    <phone>'.$billingphone.'</phone>
                    <company>'.$billingcompany.'</company>
                    <address2>'.$billingaddress2.'</address2>
                    <fax></fax>
                </billing>
                <shipping>
                    <first-name>'.$shippingfirstname.'</first-name>
                    <last-name>'.$shippinglastname.'</last-name>
                    <address1>'.$shippingaddress1.'</address1>
                    <city>'.$shippingcity.'</city>
                    <state>'.$shippingstate.'</state>
                    <postal>'.$shippingpostcode.'</postal>
                    <country>'.$shippingcountry.'</country>
                    <phone>'.$shippingphone.'</phone>
                    <company>'.$shippingcompany.'</company>
                    <address2>'.$shippingaddress2.'</address2>
                </shipping>
                ';
        foreach ($items AS $item) {
            $body.= '<product>';
            $body.= '   <product-code>'.$item["product_id"].'</product-code>';
            $body.= '   <description>'.$item["name"].'</description>';
            $body.= '   <commodity-code></commodity-code>';
            $body.= '   <unit-of-measure></unit-of-measure>';
            $body.= '   <unit-cost>'.round($item["line_total"],2).'</unit-cost>';
            $body.= '   <quantity>'.round($item["qty"]).'</quantity>';
            $body.= '   <total-amount>'.round($item["line_subtotal"],2).'</total-amount>';
            $body.= '   <tax-amount></tax-amount>';
            $body.= '   <tax-rate>1.00</tax-rate>';
            $body.= '   <discount-amount></discount-amount>';
            $body.= '   <discount-rate></discount-rate>';
            $body.= '   <tax-type></tax-type>';
            $body.= '   <alternate-tax-id></alternate-tax-id>';
            $body.= '</product>';
        }
        $body.= '    </'.$transactiontype.'>';

        $args = array(
            "headers"       => array(
                "Content-type"  => "text/xml; charset=\"UTF-8\""
            ),
            "body"          => $body
        );

        //use wp function to handle curl calls
        $response = wp_remote_post($gatewayurl, $args);

        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $full_response = json_decode($json, TRUE);

        //die("<h3>Output!</h3><pre>".print_r($full_response,1)."</pre>");
        

        if ( 1 == 2 ) {
           //$error_message = $response->get_error_message();
           //echo "Something went wrong: $error_message";
        } else {
            //$full_response now contains the response
            // result
            //result-text
            //result-code
            //billing
                //billing-id
            
            $formURL = $full_response['form-url'];
            $rc = $full_response['result'];
            $tid = $full_response['transaction-id'];
            $ac = $full_response['authorization-code'];
            $ar = $full_response['avs-result'];
            echo $formURL."||".$rc."||".$tid."||".$ac."||".$ar;
            
            wp_die();
        }     
        wp_die();
    }
    elseif ($savepaymentmethod == 'Y') {
        //save a new payment method to an existing vault
        //get current payment methods.  use the vault id from the first one found
        //display saved pm's (new way)
        
        //get the saved payment tokens from WC
        $payment_tokens = WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );

        $token = array();
        foreach ( $payment_tokens as $pt ) {
            $billingid = $pt->get_token();

            //query nmi to get the rest of the details for this billing id
            $paymentmethod = nmi701_getPMDetailsByVaultId( $billingid, $this->apikey );
            $customervaultid = $paymentmethod['customer']['@attributes']['id'];

            $thispm = array();
            $thispm['tokenid']          = $tokenid;
            $thispm['internalid']       = $pt->get_id();
            $thispm['billingid']        = $billingid;
            $thispm['customervaultid']  = $paymentmethod['customer']['@attributes']['id'];
            $thispm['ccnumber']         = $paymentmethod['customer']['billing']['cc_number'];
            $thispm['ccexp']            = substr_replace($paymentmethod['customer']['billing']['cc_exp'], '/', 2, 0);
            $thispm['cardtype']         = $pt->get_card_type();
            array_push( $paymentmethods, $thispm );
        }
        
        //now that we have all the payment methods, we need to find the ones that match just the selected vault id
        $usedbillingids = array();
        for ( $x = 0 ;  $x < count( $paymentmethods ) ;  $x++ ) {
            if ( $paymentmethods[$x]['customervaultid'] == $customervaultid ) {
                array_push( $usedbillingids, $paymentmethods[$x]['billingid'] );
            }
        }
        
        //come up with a unique billing id
        $fail = 'Y';
        $length = 10;
        while ( $fail == 'Y' ) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen( $characters );
            $randomString = '';
            for ( $i = 0 ;  $i < $length ;  $i++ ) {
                $randomString .= $characters[rand( 0, $charactersLength - 1 )];
            }
            
            if ( !in_array( $randomString, $usedbillingids ) ) {
                $newbillingid = $randomString;
                $billingid = $randomString;
                $fail = 'N';
            }
        
        }
        
        if ( $customervaultid == '' ) {
            //no existing customer vaults, must create a new one with a billing id
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen( $characters );
            $randomString = '';
            for ( $i = 0 ;  $i < $length ;  $i++ ) {
                $randomString .= $characters[rand( 0, $charactersLength - 1 )];
            }
            $customervaultid = $randomString;
            //implies there is no customer vault, need to create a new one
            // Create body
            $body = '
                <' . $transactiontype . '>
                    <api-key>' . $apikey . '</api-key>
                    <redirect-url>' . $referrer . '</redirect-url>
                    <amount>' . $ordertotal . '</amount>
                    <ip-address>' . $_SERVER['remote_address'] . '</ip-address>
                    <currency>USD</currency>
                    <order-id>' . $orderid . '</order-id>
                    <order-description>Online Order</order-description>
                    <tax-amount>' . $ordertax . '</tax-amount>
                    <shipping-amount>' . $ordershipping . '</shipping-amount>
                    <billing>
                        <billing-id>' . $billingid . '</billing-id>
                        <first-name>' . $billingfirstname . '</first-name>
                        <last-name>' . $billinglastname . '</last-name>
                        <address1>' . $billingaddress1 . '</address1>
                        <city>' . $billingcity . '</city>
                        <state>' . $billingstate . '</state>
                        <postal>' . $billingpostcode . '</postal>
                        <country>' . $billingcountry . '</country>
                        <email>' . $billingemail . '</email>
                        <phone>' . $billingphone . '</phone>
                        <company>' . $billingcompany . '</company>
                        <address2>' . $billingaddress2 . '</address2>
                        <fax></fax>
                    </billing>
                    <shipping>
                        <first-name>' . $shippingfirstname . '</first-name>
                        <last-name>' . $shippinglastname . '</last-name>
                        <address1>' . $shippingaddress1 . '</address1>
                        <city>' . $shippingcity . '</city>
                        <state>' . $shippingstate . '</state>
                        <postal>' . $shippingpostcode . '</postal>
                        <country>' . $shippingcountry . '</country>
                        <phone>' . $shippingphone . '</phone>
                        <company>' . $shippingcompany . '</company>
                        <address2>' . $shippingaddress2 . '</address2>
                    </shipping>
                    <add-customer>
                        <customer-vault-id>' . $customervaultid . '</customer-vault-id>
                    </add-customer>
                    ';
            foreach ( $items as $item ) {
                $body .= '<product>';
                $body .= '   <product-code>' . $item['product_id'] . '</product-code>';
                $body .= '   <description>' . $item['name'] . '</description>';
                $body .= '   <commodity-code></commodity-code>';
                $body .= '   <unit-of-measure></unit-of-measure>';
                $body .= '   <unit-cost>' . round( $item['line_total'], 2 ) . '</unit-cost>';
                $body .= '   <quantity>' . round( $item['qty'] ) . '</quantity>';
                $body .= '   <total-amount>' . round( $item['line_subtotal'], 2 ) . '</total-amount>';
                $body .= '   <tax-amount></tax-amount>';
                $body .= '   <tax-rate>1.00</tax-rate>';
                $body .= '   <discount-amount></discount-amount>';
                $body .= '   <discount-rate></discount-rate>';
                $body .= '   <tax-type></tax-type>';
                $body .= '   <alternate-tax-id></alternate-tax-id>';
                $body .= '</product>';
            }
            $body .= '    </' . $transactiontype . '>';
            $args = array(
                'headers' => array(
                'Content-type' => 'text/xml; charset="UTF-8"',
            ),
                'body'    => $body,
            );
            
            //use wp function to handle curl calls
            $response = wp_remote_post( $gatewayurl, $args );
            $xml = simplexml_load_string( $response['body'], 'SimpleXMLElement', LIBXML_NOCDATA );
            $json = json_encode( $xml );
            $full_response = json_decode( $json, TRUE );
            
            if ( !$full_response ) {
            } else {
                //using an existing vault id seems to add another pm with the same billing id.  for now, we will be generating a random string for each vault and using that
                //save token/payment method to woo
                $token = new WC_Payment_Token_CC();
                $token->set_token($billingid);
                $token->set_gateway_id('');
                $token->set_user_id($userid);
                $token->set_last4($last4);
                $token->set_expiry_month(substr($expiry, 0, 2));
                $token->set_expiry_year('20'.substr($expiry, -2 ));
                $token->set_card_type('unknown');
                $token->save();
                //$full_response now contains the response
                // result
                //result-text
                //result-code
                //billing
                //billing-id
                echo  $full_response['form-url'] ;
            }
        } 
        else {
            //customer vault exists, add payment method to this vault  --  at some point, we will have to check to total number of billing ids per vault
            //add new billing id to existing vault id
            $body = "<add-billing>
                <api-key>".$apikey."</api-key>
                <redirect-url>".$referrer."</redirect-url>
                <customer-vault-id>".$customervaultid."</customer-vault-id>
                <billing>
                    <billing-id>".$billingid."</billing-id>
                    <email>".$billingemail."</email>
                    <first-name>".$billingfirstname."</first-name>
                    <last-name>".$billinglastname."</last-name>
                    <address1>".$billingaddress1."</address1>
                    <city>".$billingcity."</city>
                    <state>".$billingstate."</state>
                    <postal>".$billingpostcode."</postal>
                    <country>".$billingcountry."</country>
                    <company>".$billingcompany."</company>
                    <address2 />
                </billing>
            </add-billing>";            
            
            $args = array(
                "headers"       => array(
                    "Content-type"  => "text/xml; charset=\"UTF-8\""
                ),
                "body"          => $body
            );

            //use wp function to handle curl calls
            $response = wp_remote_post($gatewayurl, $args);

            $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $full_response = json_decode($json, TRUE);
            
            echo  $full_response['form-url'] ;
        }
    /* end get billing and vault ids */         
    }
    else {
        //implies one time sale, do not save the payment method for later
        // Create body
        $body = '
            <'.$transactiontype.'>
                <api-key>'.$apikey.'</api-key>
                <redirect-url>'.$referrer.'</redirect-url>
                <amount>'.$ordertotal.'</amount>
                <ip-address>'.$_SERVER["REMOTE_ADDR"].'</ip-address>
                <currency>USD</currency>
                <order-id>'.$orderid.'</order-id>
                <order-description>Online Order</order-description>
                <tax-amount>'.$ordertax.'</tax-amount>
                <shipping-amount>'.$ordershipping.'</shipping-amount>
                <billing>
                    <first-name>'.$billingfirstname.'</first-name>
                    <last-name>'.$billinglastname.'</last-name>
                    <address1>'.$billingaddress1.'</address1>
                    <city>'.$billingcity.'</city>
                    <state>'.$billingstate.'</state>
                    <postal>'.$billingpostcode.'</postal>
                    <country>'.$billingcountry.'</country>
                    <email>'.$billingemail.'</email>
                    <phone>'.$billingphone.'</phone>
                    <company>'.$billingcompany.'</company>
                    <address2>'.$billingaddress2.'</address2>
                    <fax></fax>
                </billing>
                <shipping>
                    <first-name>'.$shippingfirstname.'</first-name>
                    <last-name>'.$shippinglastname.'</last-name>
                    <address1>'.$shippingaddress1.'</address1>
                    <city>'.$shippingcity.'</city>
                    <state>'.$shippingstate.'</state>
                    <postal>'.$shippingpostcode.'</postal>
                    <country>'.$shippingcountry.'</country>
                    <phone>'.$shippingphone.'</phone>
                    <company>'.$shippingcompany.'</company>
                    <address2>'.$shippingaddress2.'</address2>
                </shipping>';
        foreach ($items AS $item) {
            $body.= '<product>';
            $body.= '   <product-code>'.$item["product_id"].'</product-code>';
            $body.= '   <description>'.$item["name"].'</description>';
            $body.= '   <commodity-code></commodity-code>';
            $body.= '   <unit-of-measure></unit-of-measure>';
            $body.= '   <unit-cost>'.round($item["line_total"],2).'</unit-cost>';
            $body.= '   <quantity>'.round($item["qty"]).'</quantity>';
            $body.= '   <total-amount>'.round($item["line_subtotal"],2).'</total-amount>';
            $body.= '   <tax-amount></tax-amount>';
            $body.= '   <tax-rate>1.00</tax-rate>';
            $body.= '   <discount-amount></discount-amount>';
            $body.= '   <discount-rate></discount-rate>';
            $body.= '   <tax-type></tax-type>';
            $body.= '   <alternate-tax-id></alternate-tax-id>';
            $body.= '</product>';
        }
        $body.= '    </'.$transactiontype.'>';

        $args = array(
            "headers"       => array(
                "Content-type"  => "text/xml; charset=\"UTF-8\""
            ),
            "body"          => $body
        );

        //use wp function to handle curl calls
        $response = wp_remote_post($gatewayurl, $args);

        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $full_response = json_decode($json, TRUE);

       if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            echo $full_response['form-url'];
        }   
    }    

    wp_die(); // this is required to terminate immediately and return a proper response
}

function nmi701_deletePaymentMethod() {  
    $security = $_POST['security'];
    check_ajax_referer( 'delete-pm-nonce', 'security', false );

    //delete vault (customer vault id)
    $vaultid        = nmi701_cleanTheData($_POST['vaultid'], 'integer');
    $billingid      = nmi701_cleanTheData($_POST['billingid'], 'integer');
    $apikey         = nmi701_cleanTheData($_POST['apikey'], 'string');
    $gatewayurl     = nmi701_cleanTheData($_POST['gatewayurl'], 'string');
    $tokenid        = nmi701_cleanTheData($_POST['tokenid'], 'string');
    
    //delete local token reference
    WC_Payment_Tokens::delete( $tokenid );
    
    // Create body
    $body = '<delete-billing>
        <api-key>'.$apikey.'</api-key>
        <customer-vault-id>'.$vaultid.'</customer-vault-id>
        <billing>
            <billing-id>'.$billingid.'</billing-id>
        </billing>
    </delete-billing>';

    $args = array(
        "headers"    => array(
            "Content-type"  => "text/xml; charset=\"UTF-8\""
        ),
        "body"          => $body
    );

    //use wp function to handle curl calls
    $response = wp_remote_post($gatewayurl, $args);

    $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $full_response = json_decode($json, TRUE);      
        
    if($full_response['result-code'] != 100) {
        //die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));   //old error reporting
        $resultid = $full_response['result'];
    } else {
        //$full_response now contains the response
        //result
        //result-text
        //result-code
        //billing
            //billing-id
        $resultid = $full_response['result'];
    }

    if ($resultid == 3) {
        //deleting the single billing id failed due to it being the last one in the vault.  now delete the vault.
        // Create body
        $body = '<delete-customer>
            <api-key>'.$apikey.'</api-key>
            <customer-vault-id>'.$vaultid.'</customer-vault-id>
        </delete-customer>';

        $args = array(
            "headers"       => array(
                "Content-type"  => "text/xml; charset=\"UTF-8\""
            ),
            "body"          => $body
        );

        //use wp function to handle curl calls
        $response = wp_remote_post($gatewayurl, $args);

        $xml = simplexml_load_string($response['body'], "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $full_response = json_decode($json, TRUE); 

        if($full_response['result-code'] != 100) {
            //die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        } else {
            $resultid = 1;
        }
    }
        
    // Close request to clear
    echo $resultid;
}

add_action( 'wp_ajax_nopriv_nmi701_stepOne_addBilling', 'nmi701_stepOne_addBilling' );
add_action( 'wp_ajax_nmi701_stepOne_addBilling', 'nmi701_stepOne_addBilling' );

add_action( 'wp_ajax_nopriv_nmi701_stepOne', 'nmi701_stepOne' );
add_action( 'wp_ajax_nmi701_stepOne', 'nmi701_stepOne' );

add_action( 'wp_ajax_nopriv_nmi701_deletePaymentMethod', 'nmi701_deletePaymentMethod' );
add_action( 'wp_ajax_nmi701_deletePaymentMethod', 'nmi701_deletePaymentMethod' );
?>

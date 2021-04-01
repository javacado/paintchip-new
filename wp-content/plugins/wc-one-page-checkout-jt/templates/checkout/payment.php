<?php
/**
 * Fitlering the template for Payment
 */
add_filter( 'wc_get_template', 'my_custom_payment_template', 20, 2 );

function my_custom_payment_template( $template, $template_name ) {
  if ( 'checkout/payment.php' !== $template_name ) {
    return $template;
  }
  
  return plugin_dir_path( WC_ONE_PAGE_CHECKOUT_JT ) . 'templates/' . $template_name;
}
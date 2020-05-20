<?php
/**
 * Thumbnail settings tab.
 *
 * @link       https://shapedplugin.com/
 * @since      1.0.0
 *
 * @package    Woo_Category_Slider
 * @subpackage Woo_Category_Slider/admin/partials/section/metabox
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Thumbnail settings tab.
 *
 * @since 1.0.0
 */
class SP_WCS_Thumbnail {
	/**
	 * Thumbnail section.
	 *
	 * @param [type] $prefix
	 * @return void
	 */
	public static function section( $prefix ) {

		SP_WCS::createSection(
			$prefix,
			array(
				'title'  => __( 'Thumbnail Settings', 'woo-category-slider' ),
				'icon'   => 'fa fa-image',
				'fields' => array(
					array(
						'id'         => 'wcsp_thumbnail',
						'type'       => 'switcher',
						'title'      => __( 'Thumbnail', 'woo-category-slider' ),
						'subtitle'   => __( 'Show/Hide thumbnail.', 'woo-category-slider' ),
						'text_on'    => __( 'Show', 'woo-category-slider' ),
						'text_off'   => __( 'Hide', 'woo-category-slider' ),
						'text_width' => 80,
						'default'    => true,
					),
					array(
						'id'         => 'wcsp_thumbnail_size',
						'type'       => 'image_sizes',
						'title'      => __( 'Thumbnail Sizes', 'woo-category-slider' ),
						'subtitle'   => __( 'Set sizes for thumbnail.', 'woo-category-slider' ),
						'chosen'     => true,
						'default'    => 'full',
						'dependency' => array(
							'wcsp_thumbnail',
							'==',
							'true',
						),
					),
					array(
						'id'                => 'wcsp_cat_thumb_width_height',
						'type'              => 'dimensions_advanced',
						'title'             => __( 'Custom Size', 'woo-category-slider' ),
						'subtitle'          => __( 'Set a custom width and height of the thumbnail.', 'woo-category-slider' ),
						'chosen'            => true,
						'class'             => 'wcsp-cat-thum-size',
						'bottom'            => false,
						'left'              => false,
						'color'             => false,
						'pro_only'          => true,
						'top_icon'          => '<i class="fa fa-arrows-h"></i>',
						'right_icon'        => '<i class="fa fa-arrows-v"></i>',
						'top_placeholder'   => 'width',
						'right_placeholder' => 'height',
						'styles'            => array(
							'Hard-crop',
							'Soft-crop',
						),
						'default'           => array(
							'top'   => '400',
							'right' => '445',
							'style' => 'Hard-crop',
							'unit'  => 'px',
						),
						'attributes'        => array(
							'min' => 0,
						),
						'dependency'        => array(
							'wcsp_thumbnail|wcsp_thumbnail_size',
							'==|==',
							'true|custom',
						),
					),
					array(
						'id'         => 'wcsp_cat_thumbnail_shape',
						'type'       => 'radiof',
						'title'      => __( 'Shape', 'woo-category-slider' ),
						'subtitle'   => __( 'Choose a shape for thumbnail.', 'woo-category-slider' ),
						'options'    => array(
							'square'  => array(
								'text'     => __( 'Square', 'woo-category-slider' ),
								'pro_only' => false,
							),
							'rounded' => array(
								'text'     => __( 'Rounded (Pro)', 'woo-category-slider' ),
								'pro_only' => true,
							),
							'circle'  => array(
								'text'     => __( 'Circle (Pro)', 'woo-category-slider' ),
								'pro_only' => true,
							),
						),
						'default'    => 'square',
						'dependency' => array(
							'wcsp_thumbnail',
							'==',
							'true',
						),
					),
					array(
						'id'         => 'wcsp_cat_border_box_shadow',
						'type'       => 'checkboxf',
						'title'      => __( 'Border', 'woo-category-slider' ),
						'subtitle'   => __( 'Border on/off.', 'woo-category-slider' ),
						'options'    => array(
							'border' => array(
								'text'     => __( 'Border', 'woo-category-slider' ),
								'pro_only' => false,
							),
						),
						'default'    => 'border',
						'dependency' => array(
							'wcsp_thumbnail',
							'==',
							'true',
						),
					),
					array(
						'id'          => 'wcsp_cat_thumb_border',
						'type'        => 'border',
						'title'       => __( 'Border', 'woo-category-slider' ),
						'subtitle'    => __( 'Set border for thumbnail.', 'woo-category-slider' ),
						'class'       => 'wcsp-cat-thumb-border',
						'hover_color' => true,
						'default'     => array(
							'top'         => '1',
							'left'        => '1',
							'right'       => '1',
							'bottom'      => '1',
							'color'       => '#e2e2e2',
							'hover_color' => '#e2e2e2',
						),
						'dependency'  => array(
							'wcsp_thumbnail|wcsp_cat_border_box_shadow',
							'==|==',
							'true|true',
						),
					),
					array(
						'id'         => 'wcsp_thumb_margin',
						'type'       => 'spacing',
						'title'      => __( 'Margin', 'woo-category-slider' ),
						'subtitle'   => __( 'Set margin for thumbnail.', 'woo-category-slider' ),
						'class'      => 'wcsp-thumb-margin',
						'units'      => array( 'px', '%' ),
						'default'    => array(
							'top'    => '0',
							'right'  => '0',
							'bottom' => '0',
							'left'   => '0',
							'unit'   => 'px',
						),
						'dependency' => array(
							'wcsp_thumbnail',
							'==',
							'true',
						),
					),

				), // End of fields array.
			)
		); // Thumbnail settings section end.
	}
}

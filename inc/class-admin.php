<?php
/**
 * WordPress Feature Flags - Admin Class
 *
 * Define Admin class and register ACF Options page & feature flag fields.
 */

declare(strict_types=1);

namespace WPFeatureFlags;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin {

    /**
     * Registers the ACF Options page & feature flag fields.
     */
    public function register_acf_feature_flags_page(): void {
        if ( \function_exists( 'acf_add_options_page' ) ) {

            // Create the Options Page
            \acf_add_options_page([
                'page_title'  => __( 'Feature Flags', 'wp-feature-flags' ),
                'menu_title'  => __( 'Feature Flags', 'wp-feature-flags' ),
                'menu_slug'   => 'wpff-feature-flags',
                'capability'  => 'manage_options',
                'redirect'    => false,
                'position'    => '99.5', // near bottom of Settings
                'icon_url'    => 'dashicons-lightbulb',
            ]);

            // Register fields
            $this->register_acf_fields();
        }
    }

    /**
     * Define ACF field groups and fields for the feature flags.
     */
    protected function register_acf_fields(): void {
        if ( \function_exists( 'acf_add_local_field_group' ) ) {
            \acf_add_local_field_group([
                'key'                   => 'group_wpff_feature_flags',
                'title'                 => __( 'Feature Flags Settings', 'wp-feature-flags' ),
                'fields'                => [
                    [
                        'key'           => 'field_wpff_feature_flags',
                        'label'         => __( 'Feature Flags', 'wp-feature-flags' ),
                        'name'          => 'wpff_feature_flags',
                        'type'          => 'repeater',
                        'instructions'  => __( 'Add your feature flags below.', 'wp-feature-flags' ),
                        'button_label'  => __( 'Add Feature Flag', 'wp-feature-flags' ),
                        'layout'        => 'row',
                        'sub_fields'    => [
                            [
                                'key'          => 'field_wpff_flag_name',
                                'label'        => __( 'Flag Name', 'wp-feature-flags' ),
                                'name'         => 'flag_name',
                                'type'         => 'text',
                                'instructions' => __( 'Unique identifier for the feature flag (e.g. "new_header").', 'wp-feature-flags' ),
                                'required'     => 1,
                            ],
                            [
                                'key'          => 'field_wpff_flag_enabled',
                                'label'        => __( 'Enable Flag?', 'wp-feature-flags' ),
                                'name'         => 'flag_enabled',
                                'type'         => 'true_false',
                                'ui'           => 1,
                                'ui_on_text'   => __( 'Enabled', 'wp-feature-flags' ),
                                'ui_off_text'  => __( 'Disabled', 'wp-feature-flags' ),
                            ],
                            [
                                'key'          => 'field_wpff_user_override',
                                'label'        => __( 'Enabled for Specific User', 'wp-feature-flags' ),
                                'name'         => 'user_override',
                                'type'         => 'user',
                                'instructions' => __( 'Select a user to silo this flag to.', 'wp-feature-flags' ),
                                'allow_null'   => 1,
                                'required'     => 0,
                                'multiple'     => 0,
                                'return_format'=> 'array', // So we can access user data easily
                            ],
                        ],
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'options_page',
                            'operator' => '==',
                            'value'    => 'wpff-feature-flags',
                        ],
                    ],
                ],
            ]);
        }
    }
}

<?php
/**
 * WordPress Feature Flags - Utils Class
 *
 * Define Utils class and helper functions.
 */

declare(strict_types=1);

namespace WPFeatureFlags;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Utils {

    /**
     * Returns all feature flags (raw array from ACF).
     *
     * @return array
     */
    public static function get_feature_flags(): array {
        $flags = \get_field('wpff_feature_flags', 'option');
        return \is_array($flags) ? $flags : [];
    }

    /**
     * Check if a specific feature flag is enabled for the current or specified user.
     *
     * @param string $flag_name The identifier for the feature flag
     * @param int|null $user_id Optional user ID to test. Defaults to current user.
     * @return bool
     */
    public static function is_feature_enabled(string $flag_name, ?int $user_id = null): bool {
        
        if (empty($flag_name)) {
            return false;
        }

        $user_id = $user_id ?? \get_current_user_id();
        $flags   = self::get_feature_flags();

        foreach ($flags as $flag) {
            if (isset($flag['flag_name']) && $flag['flag_name'] === $flag_name) {
                $enabled_global = !empty($flag['flag_enabled']) && $flag['flag_enabled'] === true;
                $user_override  = $flag['user_override'] ?? null;

                // If the global toggle is on, return true immediately
                if ($enabled_global) {
                    return true;
                }

                // If the user override matches this user, the flag is on for them specifically
                if ($user_override && \is_array($user_override) && isset($user_override['ID'])) {
                    if ((int) $user_override['ID'] === $user_id) {
                        return true;
                    }
                }

                // If the flag was found but isn't enabled globally or overridden, return false
                return false;
            }
        }

        // If the flag wasn't found at all, default to false.
        return false;
    }
    
    /**
     * Enqueues feature flags for JavaScript usage
     */
    public static function enqueue_js_feature_flags(): void {
        // Get all feature flags
        $flags = self::get_feature_flags();
        $current_user_id = get_current_user_id();
        
        // Create an array of enabled flags for the current user
        $js_flags = [];
        foreach ($flags as $flag) {
            if (isset($flag['flag_name'])) {
                $js_flags[$flag['flag_name']] = self::is_feature_enabled($flag['flag_name'], $current_user_id);
            }
        }
        
        // Register and enqueue our script
        wp_register_script(
            'wp-feature-flags', 
            WPFF_PLUGIN_URL . 'assets/js/wp-feature-flags.js',
            ['jquery'],
            WPFF_VERSION,
            true
        );
        
        wp_enqueue_script('wp-feature-flags');
        
        // Localize the script with our data
        wp_localize_script('wp-feature-flags', 'wpFeatureFlags', [
            'flags' => $js_flags
        ]);
    }
}
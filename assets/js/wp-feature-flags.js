/**
 * WordPress Feature Flags - JavaScript API
 */
var WPFeatureFlags = (function () {
    return {
        /**
         * Check if a feature is enabled
         * 
         * @param {string} flagName - The name of the feature flag
         * @return {boolean} - Whether the feature is enabled
         */
        isFeatureEnabled: function (flagName) {
            if (typeof wpFeatureFlags === 'undefined' ||
                typeof wpFeatureFlags.flags === 'undefined' ||
                typeof wpFeatureFlags.flags[flagName] === 'undefined') {
                return false;
            }

            return wpFeatureFlags.flags[flagName] === true;
        }
    };
})();

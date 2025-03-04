## WordPress Feature Flags

#### In template usage:

``
if ( \WPFeatureFlags\Utils::is_feature_enabled('new_header') ) {
    // Output new code
}
``

#### Target specicic user:

``
$user_id = 5;
if ( \WPFeatureFlags\Utils::is_feature_enabled('new_header', $user_id) ) {
    // Run new header code for user #5
}
``

#### JavaScript usage:

``
// Check if a feature is enabled
if (WPFeatureFlags.isFeatureEnabled('new_header')) {
    // Run new header code
    $('#site-header').addClass('new-design');
} else {
    // Run old header code
    $('#site-header').addClass('classic-design');
}
``

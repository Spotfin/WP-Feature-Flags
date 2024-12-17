## WordPress Feature Flags

#### In template usage:

``
if ( \WPFeatureFlags\Utils::is_feature_enabled('some_new_feature') ) {
    // Output new code
}
``

#### Target specicic user:

``
$user_id = 5;
if ( \WPFeatureFlags\Utils::is_feature_enabled('beta_feature', $user_id) ) {
    // Beta feature code for user #5
}
``

#### Coming Soon:
- JavaScript feature flag
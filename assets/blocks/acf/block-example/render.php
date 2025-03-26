<?php

/** Block Example */

$baseClass = 'block-example';
$blockClass = [$baseClass];

$additionalClass = $args['additionalClass'] ?? '';
$additionalClass = is_array($additionalClass) ? implode(' ', $additionalClass) : $additionalClass;

if (!empty($additionalClass)) {
    $blockClass[] = $additionalClass;
}

?>
<div class="<?php echo $baseClass; ?>">
    <h2 class="block-example__title">Block Example</h2>
    <p class="block-example__content">This is a block example</p>
</div>


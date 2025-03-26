<?php

/*
## Arguments example :

$args = [
    'class' => 'my-input-wrapper-class',
    'type' => 'search',
    'label' => 'My input label',
    'name' => 'my_input_name',
    'placeholder' => 'My search placeholder',
];

// Or

$args = [
    'class' => 'my-input-wrapper-class',
    'input' => [
        'class' => 'my-input-class',
        'type' => 'search',
        'name' => 'my_input_name',
        'placeholder' => 'My search placeholder',
    ],
];

// Or

$args = [
    'class' => 'my-input-wrapper-class',
    'type' => 'select',
    'label' => 'My select label',
    'name' => 'my_select_name',
    'options' => [
        [
            'value' => '1',
            'label' => 'Option 1',
        ],
        [
            'selected' => true,
            'value' => '2',
            'label' => 'Option 2',
        ],
    ],
];
*/

$args ??= [];

$tag = $args['tag'] ?? 'label';
$labelTag = $args['labelTag'] ?? 'span';

$label = $args['label'] ?? '';

$input = $args['input'] ?? [];

$type = $args['type'] ?? $input['type'] ?? 'text';

$fieldAtom = match (true) {
    'textarea' === $type => 'textarea',
    'select' === $type => 'select',
    default => 'input',
};

$fieldArgs = match (true) {
    'textarea' === $fieldAtom => [
        'class' => 'input-wrapper__field input-wrapper__field--textarea',
        ...$input,
    ],
    'select' === $fieldAtom => [
        'class' => 'input-wrapper__field input-wrapper__field--select',
        'options' => $args['options'] ?? [],
        'groups' => $args['groups'] ?? [],
        ...$input,
    ],
    'input' === $fieldAtom => [
        'class' => 'input-wrapper__field input-wrapper__field--input input-wrapper__field--' . $type,
        'type' => $type,
        ...$input,
    ],
};

$classList = [
    'input-wrapper',
    'input-wrapper--' . $fieldAtom,
    'input-wrapper--type-' . $type,
    $args['class'] ?? '',
];

?>

<<?= $tag ?>
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'tag', 'labelTag', 'type', 'label', 'options', 'groups']) ?>
>
    <?php if (!in_array($type, ['radio', 'checkbox'])): ?>
        <?php atom('label', [
            'class' => 'input-wrapper__label',
            'label' => $label,
            'tag' => $labelTag,
        ]) ?>
    <?php endif; ?>

    <?php atom($fieldAtom, $fieldArgs) ?>

    <?php if (in_array($type, ['radio', 'checkbox'])): ?>
        <?php atom('label', [
            'class' => 'input-wrapper__label',
            'label' => $label,
            'tag' => $labelTag,
        ]) ?>
    <?php endif; ?>
</<?= $tag ?>>

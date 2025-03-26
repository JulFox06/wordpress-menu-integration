<?php

/*
Arguments example :

$args = [
    'class' => 'my-class',
    'name' => 'my-name',
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
    'groups' => [
        [
            'label' => 'Group 1',
            'options' => [
                [
                    'value' => '3',
                    'label' => 'Option 3',
                ],
                [
                    'value' => '4',
                    'label' => 'Option 4',
                ],
            ],
        ],
    ],
];
*/

$args ??= [];

$options = $args['options'] ?? [];
$groups = $args['groups'] ?? [];

$classList = [
    'select',
    $args['class'] ?? '',
];

?>

<select
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    <?= array_to_html_attributes($args, ['class', 'options', 'groups']) ?>
>
    <?php foreach($options as $option): ?>
        <option
            <?= array_to_html_attributes($option, ['label']) ?>
        ><?= $option['label'] ?? $option['text'] ?? '' ?></option>
    <?php endforeach; ?>

    <?php foreach($groups as $group): ?>
        <optgroup
            <?= array_to_html_attributes($group, ['options']) ?>
        >
            <?php foreach(($group['options'] ?? []) as $option): ?>
                <option
                    <?= array_to_html_attributes($option, ['label']) ?>
                ><?= $option['label'] ?? $option['text'] ?? '' ?></option>
            <?php endforeach; ?>
        </optgroup>
    <?php endforeach; ?>
</select>

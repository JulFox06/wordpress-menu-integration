<?php

$errorCode = $args['errorCode'] ?? 404;

$pageTitle = $args['pageTitle'] ?? ('error.php | `' . $errorCode . '`');

$classList = [
    'template',
    'template-error',
    'template-error--' . $errorCode,
    $args['class'] ?? '',
];

layout('parts/header');

?>

<main
    class="<?= esc_attr(implode(' ', $classList)) ?>"
    id="<?= esc_attr(to_kebab_case(__('Contenu', 'jrenard'))) ?>"
>

    <div class="template-error__wrapper">

        <?php atom('heading', [
            'label' => $pageTitle,
            'tag' => 'h3',
            'class' => 'template-error__title',
        ]) ?>

    </div>

</main>

<?php

layout('parts/footer');

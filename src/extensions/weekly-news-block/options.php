<?php
/* @var $options array contains all the options the current block we're ediging contains */
/* @var $controls NewsletterControls */
/* @var $fields NewsletterFields */

$extensions_url = '?page=newsletter_main_extension';
if (class_exists('NewsletterExtensions')) {
    $extensions_url = '?page=newsletter_extensions_index';
}
?>

<?php if ($context['type'] == 'automated') { ?>

<div class="tnp-field-box">
    <p>
        <strong>AUTOMATED</strong><br>
        While composing all posts are shown while on sending posts are extrated following the rules below.
    </p>
    <?php $fields->select('automated_disabled', '', ['' => 'Use the last newsletter date and...', '1' => 'Do not consider the last newsletter']) ?>

    <div class="tnp-field-row">
        <div class="tnp-field-col-2">
            <?php
            $fields->select('automated_include', __('If there are new posts', 'newsletter'),
                    [
                        'new' => __('Include only new posts', 'newsletter'),
                        'max' => __('Include specified max posts', 'newsletter')
                    ],
                    ['description' => '', 'class' => 'tnp-small'])
            ?>
        </div>
        <div class="tnp-field-col-2">
            <?php
            $fields->select('automated', __('If there are not new posts', 'newsletter'),
                    [
                        '' => 'Show the message below',
                        '1' => 'Do not send the newsletter',
                        '2' => 'Remove this block'
                    ],
                    ['description' => '', 'class' => 'tnp-small'])
            ?>
            <?php $fields->text('automated_no_contents', null, ['placeholder' => 'No new posts message']) ?>
        </div>
    </div>
    <div style="clear: both"></div>
</div>
<?php } ?>

<?php $fields->language(); ?>

<?php $fields->section(__('Filters', 'newsletter')) ?>
<?php $fields->categories(); ?>


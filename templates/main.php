<?php
/** @var array $_ */
script('zammadapiticketsubmission', 'main'); // ensures js/main.js is loaded
// If you also have a style bundle: style($_['appId'], 'style');
?>
<div class="section">
    <h1 class="page-heading"><?php p($l->t('Help')); ?></h1>

    <!-- Vue mounts here -->
    <div id="zammad-help"></div>

    <p class="hint">
        <?php p($l->t('Use this form to submit a support ticket to Zammad.')); ?>
    </p>
</div>

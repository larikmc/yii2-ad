<?php

/**
 * Ad rendering template with reliable delayed execution and clean markup
 *
 * @var array $ad
 * @var int $positionId
 */

$marginTop = (int)($ad['margin_top'] ?? 0);
$wait = (int)($ad['wait'] ?? 0);
$frequency = max(1, (int)($ad['frequency'] ?? 1));
$rawCode = (string)($ad['code'] ?? '');

$shouldDelay = ($wait > 0) && ($frequency === 1 || mt_rand(1, $frequency) === 1);
$containerId = 'ad-block-' . $positionId . '-' . mt_rand(1000, 9999);
$style = $marginTop > 0 ? "margin-top: {$marginTop}px;" : '';
?>

<?php if (!$shouldDelay): ?>
    <div id="<?= $containerId ?>" class="ad-block ad-block-<?= (int)$positionId ?>"<?= $style !== '' ? ' style="' . $style . '"' : '' ?>>
        <?= $rawCode ?>
    </div>
<?php else: ?>
    <?php
    // Extract <script> elements safely
    $scriptPattern = '/<script\b(?<attrs>[^>]*)>(?<code>.*?)<\/script>/is';
    $hasScripts = preg_match_all($scriptPattern, $rawCode, $scriptMatches, PREG_SET_ORDER);
    ?>

    <?php if ($hasScripts): ?>
        <?php
        // Render non-script HTML immediately so target containers (<div id="yandex_rtb_...">) exist in DOM
        $htmlOnly = preg_replace($scriptPattern, '', $rawCode);
        ?>
        <div id="<?= $containerId ?>" class="ad-block ad-block-<?= (int)$positionId ?>"<?= $style !== '' ? ' style="' . $style . '"' : '' ?>>
            <?= $htmlOnly ?>
            <script>
            (function() {
                var delay = <?= (int)$wait ?>;
                function executeAd() {
                    <?php foreach ($scriptMatches as $match): ?>
                        (function() {
                            var s = document.createElement('script');
                            <?php
                            $attrs = $match['attrs'];
                            if (preg_match('/src=([\'"])(.*?)\1/i', $attrs, $srcM)) {
                                echo 's.src = ' . json_encode($srcM[2]) . ';';
                            }
                            if (preg_match('/type=([\'"])(.*?)\1/i', $attrs, $typeM)) {
                                echo 's.type = ' . json_encode($typeM[2]) . ';';
                            }
                            if (preg_match('/async\b/i', $attrs)) {
                                echo 's.async = true;';
                            }
                            $codeBody = trim($match['code']);
                            if ($codeBody !== '') {
                                echo 's.textContent = ' . json_encode($codeBody) . ';';
                            }
                            ?>
                            document.head.appendChild(s);
                        })();
                    <?php endforeach; ?>
                }
                if (delay > 0) {
                    setTimeout(executeAd, delay);
                } else {
                    executeAd();
                }
            })();
            </script>
        </div>
    <?php else: ?>
        <div id="<?= $containerId ?>" class="ad-block ad-block-<?= (int)$positionId ?>" style="display:none;<?= $style ?>">
            <?= $rawCode ?>
        </div>
        <script>
        setTimeout(function() {
            var el = document.getElementById(<?= json_encode($containerId) ?>);
            if (el) {
                el.style.display = '';
            }
        }, <?= (int)$wait ?>);
        </script>
    <?php endif; ?>
<?php endif; ?>

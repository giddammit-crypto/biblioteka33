<?php
$file = 'wp-content/themes/city-library/js/voice-control.js';
$content = file_get_contents($file);

$search = <<<'JS'
        let spokenText = text.replace(/[*_#`~[\]]/g, '');
        spokenText = spokenText.replace(/\([^)]*\)/g, '');
        spokenText = spokenText.replace(/https?:\/\/[^\s]+/g, 'ссылка');

        if (spokenText.length > 500) {
            spokenText = spokenText.substring(0, 500) + '... Я могу рассказать больше, если вы попросите.';
        }

        const utterance = new SpeechSynthesisUtterance(spokenText);
JS;

$replace = <<<'JS'
        let spokenText = text.replace(/[*_#`~[\]]/g, '');
        spokenText = spokenText.replace(/\([^)]*\)/g, '');
        spokenText = spokenText.replace(/https?:\/\/[^\s]+/g, 'ссылка');

        // Extract up to the first 3 sentences based on standard sentence-ending punctuation
        const sentences = spokenText.match(/[^.!?]+[.!?]+(?:\s|$)/g) || [spokenText];
        spokenText = sentences.slice(0, 3).join(' ');

        if (sentences.length > 3 || spokenText.length > 500) {
            if (spokenText.length > 500) {
                spokenText = spokenText.substring(0, 500) + '...';
            }
            spokenText += ' Я могу рассказать больше, если вы попросите.';
        }

        const utterance = new SpeechSynthesisUtterance(spokenText);
JS;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

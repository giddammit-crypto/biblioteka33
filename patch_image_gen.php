<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "                if (isset(\$data['choices'][0]['message']['content'])) {
                    \$content = \$data['choices'][0]['message']['content'];

                    if (preg_match('/!\[.*?\]\((.*?)\)/', \$content, \$matches)) {
                        \$image_url = \$matches[1];
                    } elseif (filter_var(\$content, FILTER_VALIDATE_URL)) {
                        \$image_url = \$content;
                    } elseif (preg_match('/https?:\/\/[^\s\"\'<>]+/', \$content, \$matches)) {
                        \$image_url = \$matches[0];
                    } elseif (strpos(\$content, 'data:image') === 0 || strpos(\$content, 'iVBORw0KGgo') === 0) {
                        // It returned a base64 image directly
                        \$image_url = (strpos(\$content, 'data:image') === 0) ? \$content : 'data:image/png;base64,' . \$content;
                    }

                    if (!empty(\$image_url)) {
                        \$used_model = \$img_model;
                        break; // Success! Exit the loop.
                    }
                }";

$replace = "                if (isset(\$data['choices'][0]['message']['content'])) {
                    \$content = \$data['choices'][0]['message']['content'];

                    // Fallback to parsing text content for image URLs
                    if (preg_match('/!\[.*?\]\((.*?)\)/', \$content, \$matches)) {
                        \$image_url = \$matches[1];
                    } elseif (filter_var(trim(\$content), FILTER_VALIDATE_URL)) {
                        \$image_url = trim(\$content);
                    } elseif (preg_match('/https?:\/\/[^\s\"\'<>]+(?:\.png|\.jpg|\.jpeg|\.webp|\.gif)/i', \$content, \$matches)) {
                        \$image_url = \$matches[0];
                    } elseif (preg_match('/https?:\/\/[^\s\"\'<>]+/', \$content, \$matches)) {
                        // Less strict regex if extension is missing but it's a URL
                        \$image_url = \$matches[0];
                    } elseif (strpos(\$content, 'data:image') === 0) {
                        \$image_url = \$content;
                    } else {
                        // If it's pure text but no URL is found, treat the text as an error or just fallback
                        \$image_url = '';
                    }

                    if (!empty(\$image_url)) {
                        \$used_model = \$img_model;
                        break; // Success! Exit the loop.
                    }
                }";

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);
echo "Patched Image Parsing.\n";

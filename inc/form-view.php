<?php
/*
MIT License

Copyright (c) 2026 Armin Deck

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

$filename = $filename ?? "";
$type = $type ?? "classic";
$version = $version ?? "";
$render = $render ?? "";

$containers = $containers ?? ["", ""];
$count_containers = count($containers);

// View select type
$is_classic_select = $type == "classic" ? " selected" : "";
$is_standard_select = $type == "standard" ? " selected" : "";
$is_modern_select = $type == "modern" ? " selected" : "";

$view_select_type = <<<HTML
    <label for="type" class="flex space-between items-center gap-8">
        <strong>Type:</strong>
        <select name="type" id="type" onchange="window.location.href='?type='+this.value" required>
            <option value="classic">--- Type ---</option>
            <option value="classic"{$is_classic_select}>Classic</option>
            <option value="standard"{$is_standard_select}>Standard</option>
            <option value="modern"{$is_modern_select}>Modern</option>
        </select>
    </label>
HTML;

$view_field_filename = <<<HTML
    <label class="flex flex-column gap-8">
        <strong>Filename:</strong>
        <input type="text" name="filename" id="filename" value="{$filename}" placeholder="Filename: template-classic.json...">
    </label>
HTML;

$view_field_version = <<<HTML
    <label class="flex space-between gap-8 items-center">
        <strong>Versión:</strong>
        <input type="text" name="version" id="version" value="{$version}" placeholder="Version: (1.0.0, 1.1.0)...">
    </label>
HTML;

$view_field_count_containers = <<<HTML
    <label class="flex space-between gap-8 items-center">
        <strong>Containers:</strong>
        <input type="number" name="count_containers" id="count_containers" value="{$count_containers}" min="0" max="99" placeholder="Containers: (1, 2, 3)...">
    </label>
HTML;

$view_small_markdown_is_supported = <<<HTML
    <small style="font-weight: bold; color: white; background-color: darkslategray; padding: 2px 6px; border-radius: 4px;">
        Markdown is supported
    </small>
HTML;

$view_small_commands_is_supported = <<<HTML
    <small style="font-weight: bold; color: white; background-color: darkslategray; padding: 2px 6px; border-radius: 4px;">
        Commands is supported
    </small>
HTML;

$view_textarea_render = <<<HTML
    <textarea name="render" id="render" cols="30" rows="10" class="flex-1" placeholder="<header>\n  {{ page.name }}\n</header>\n<main>\n  {{ main }}\n</main>\n<footer>\n  &amp;copy; {{ page.year }} {{ page.name }}.\n</footer>">{$render}</textarea>
HTML;

$view_textarea_render_standard = "";

foreach ($containers as $key => $value) {
    $container_key_plus = $key + 1;
    $value_enabled = !empty($value["enabled"]) ? " selected" : "";
    $value_render = secureString($value["render"] ?? "");

    $view_textarea_render_standard .= <<<HTML
        <fieldset class="flex flex-column gap-8 p-8">
            <legend>Container {$container_key_plus}</legend>
            <label for="enabled[]" class="flex space-between items-center gap-8">
                <strong>Show:</strong>
                <select name="enabled[]" id="enabled[]">
                    <option value="">No</option>
                    <option value="1"{$value_enabled}>Yes</option>
                </select>
            </label>
            <textarea name="render[]" id="render[]" rows="12" placeholder="<header>\n  {{ page.name }}\n</header>\n<main>\n  {{ main }}\n</main>\n<footer>\n  &amp;copy; {{ page.year }} {{ page.name }}.\n</footer>">{$value_render}</textarea>
        </fieldset>
    HTML;
}

$view_label_markdown_is_supported = <<<HTML
    <label for="render" class="flex gap-4 flex-wrap">
        {$view_small_markdown_is_supported}
    </label>
HTML;

$view_label_commands_is_supported = <<<HTML
    <label for="render" class="flex gap-4 flex-wrap">
        {$view_small_commands_is_supported}
    </label>
HTML;

$view_label_markdown_and_commands_is_supported = <<<HTML
    <label for="render" class="flex gap-4 flex-wrap">
        {$view_small_markdown_is_supported}
        {$view_small_commands_is_supported}
    </label>
HTML;

$view_form_classic = <<<HTML
    $view_select_type
    $view_field_filename
    $view_field_version
    $view_label_markdown_and_commands_is_supported
    $view_textarea_render
HTML;

$view_form_standard = <<<HTML
    $view_select_type
    $view_field_filename
    $view_field_version
    $view_field_count_containers
    $view_label_markdown_and_commands_is_supported
    $view_textarea_render_standard
HTML;

echo file_exists(RAIZ . "assets/css/lite.css") ? "<style type=\"text/css\">" . (file_get_contents(RAIZ . "assets/css/lite.css") ?? "") . "</style>" : "";
?>
<body>
    <form method="post">
        <?= $type == "classic" ? $view_form_classic : "" ?>
        <?= $type == "standard" ? $view_form_standard : "" ?>
        <button type="submit" name="save_template">Save</button>
    </form>
</body>
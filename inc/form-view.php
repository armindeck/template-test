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

// View select type
$is_classic_select = $type == "classic" ? " selected" : "";
$is_standard_select = $type == "standard" ? " selected" : "";
$is_modern_select = $type == "modern" ? " selected" : "";

$view_select_type = <<<HTML
    <label for="type" style="display: flex; justify-content: space-between; align-items: center; gap: 4px;">
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
    <input type="text" name="filename" id="filename" value="{$filename}" placeholder="Filename: template-classic.json...">
HTML;

$view_field_version = <<<HTML
    <input type="text" name="version" id="version" value="{$version}" placeholder="Version: (1.0.0, 1.1.0)...">
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
    <textarea name="render" id="render" cols="30" rows="10" style="flex: 1;" placeholder="<header>\n  {{ page.name }}\n</header>\n<main>\n  {{ main }}\n</main>\n<footer>\n  &amp;copy; {{ page.year }} {{ page.name }}.\n</footer>">{$render}</textarea>
HTML;

$view_label_markdown_is_supported = <<<HTML
    <label for="render" style="display: flex; gap: 4px; flex-wrap: wrap;">
        {$view_small_markdown_is_supported}
    </label>
HTML;

$view_label_commands_is_supported = <<<HTML
    <label for="render" style="display: flex; gap: 4px; flex-wrap: wrap;">
        {$view_small_commands_is_supported}
    </label>
HTML;

$view_label_markdown_and_commands_is_supported = <<<HTML
    <label for="render" style="display: flex; gap: 4px; flex-wrap: wrap;">
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
?>
<style>
    * {
        margin: 0;
        padding: 0;
    }
    body {
        display: flex;
        justify-content: center;
        min-height: 100vh;
    }
    form {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 8px;
        padding: 8px 10px;
    }
    input, button, select, textarea {
        padding: 8px 8px;
    }
</style>
<body>
    <form method="post">
        <?= $type == "classic" ? $view_form_classic : "" ?>
        <button type="submit" name="save_template">Save</button>
    </form>
</body>
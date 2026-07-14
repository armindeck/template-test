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

session_start([
    "cookie_secure" => true, // Solo HTTPS
    "cookie_httponly" => true, // No accesible desde JS
    "cookie_samesite" => "lax", // Protección CSRF
    "use_strict_mode" => true // Evita session fixation
]);

require __DIR__ . "/inc/Model.php";
require __DIR__ . "/inc/App.php";
require __DIR__ . "/inc/Template.php";
require __DIR__ . "/inc/Commands.php";
require __DIR__ . "/inc/function.php";
require __DIR__ . "/inc/lib/Markdown.php";
require __DIR__ . "/inc/lib/MarkdownExtra.php";


use inc\App, inc\Model, inc\Template, inc\Commands, Michelf\Markdown, Michelf\MarkdownExtra;

$model = new Model();

$slug = secureString($_GET["slug"] ?? "home");
$slug_explode = explode("/", $slug);

$app = new App("core.json", "config.json");
$app->set_template($app->get_config()["template"] ?? "");
$app->set_commands("commands.json");

$content_data = $model->read("database/content.json");
$content_data["content"] = MarkdownExtra::defaultTransform($content_data["content"]);

$template_commands = new Commands(
    commands: $app->get_commands(),
    content: $app->get_template(),
    core: $app->get_core(),
    config: $app->get_config()
);

$content_commands = new Commands(
    commands: $app->get_commands(),
    content: $content_data,
    core: $app->get_core(),
    config: $app->get_config()
);

$template = new Template($template_commands->render(true), $content_commands->render(true));

require __DIR__ . "/inc/web.php";
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

define("RAIZ", __DIR__ . "/");

require __DIR__ . "/inc/Model.php";
require __DIR__ . "/inc/App.php";
require __DIR__ . "/inc/Commands.php";
require __DIR__ . "/inc/Template.php";
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

/*
$template_data = $app->get_template();

$content_data = $model->read($model->get_posts_path() . secureStringFile($slug) . ".json") ?? [];
$content_data["content"] = MarkdownExtra::defaultTransform($content_data["content"] ?? "");

$commands = new Commands(
    commands: $app->get_commands(),
    core: $app->get_core(),
    config: $app->get_config()
);

$commands->set_content([
    "title" => $content_data["title"],
    "content" => $content_data["content"]
]);
$transform = $commands->transform(true);
$content_data["title"] = $transform["title"];
$content_data["content"] = $transform["content"];

$commands->set_content($template_data["render"]);
$commands->set_content_post_data($content_data);
echo $commands->transform();

// --------------- RENDERIZAR COMANDOS SENCILLOS - new Template no funciona -------------------
//exit();

$template = new Template(
    $app->get_commands(),
    $app->get_core(),
    $app->get_config(),
    $template_data
);
$commands->set_content($template_data["render"]);

$template->set_content_post_data($content_data);
echo $template->transform();

*/

require __DIR__ . "/inc/web.php";
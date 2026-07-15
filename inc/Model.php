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

namespace inc;

class Model
{
    private const DATABASE_DIR = __DIR__ . "/../database/";
    private const TEMPLATES_DIR = self::DATABASE_DIR . "templates/";
    private const POSTS_DIR = self::DATABASE_DIR . "posts/";
    private const COMMANDS_DIR = self::DATABASE_DIR;

    public function read(string $file, bool $in_string = false, bool $enabled_cache = false, bool $local = true): array|string {
        if ($enabled_cache) {
            static $cache = [];
            
            // Si el archivo ya está en caché, devolverlo
            if (isset($cache[$file])) {
                $content = $cache[$file];
                return $in_string ? $content : json_decode($content, true) ?? [];
            }
            
            // Si no está en caché, leerlo y guardarlo
            $content = $local ? (file_exists($file) ? file_get_contents($file) ?? "" : "") : file_get_contents($file) ?? "";
            $cache[$file] = $content;
            
            return $in_string ? $content : json_decode($content, true) ?? [];
        }
        
        // Sin caché - comportamiento original
        $content = $local ? (file_exists($file) ? file_get_contents($file) ?? "" : "") : file_get_contents($file) ?? "";
        return $in_string ? $content : json_decode($content, true) ?? [];
    }

    public function write(string $file, array $data): bool
    {
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    public function save_template(string $core_version_state): void {
        if(isset($_POST["save_template"])){
            $filename_origin = str_replace(".json", "", $_POST["filename" ?? ""]);
            $filename_complete = secureStringFile($filename_origin) . ".json";
            $filename_not_empty = !empty($filename_origin);
            $path_file = $this->get_database_path() . "templates/" . $filename_complete;
            $filename_exists = $filename_not_empty ? file_exists($path_file) : false;
            $type_list = ["classic", "standard", "modern"];

            $date = date_year_month_day_minute_second();

            $data = [
                "filename"   => $filename_complete,
                "type"      => secureString($_POST["type"] ?? ""),
                "version"   => secureString($_POST["version"] ?? ""),
                "version_core" => $core_version_state,
                "created"   => $filename_exists ? $this->read($path_file)["created"] ?? $date : $date,
                "updated"   => $date
            ];

            if(empty($filename_origin) || empty($data["type"]) || empty($data["version"])){
                header("Location: form?error=Llene_todos_los_datos" . ($filename_not_empty ? "&filename={$filename_complete}" : ""));
            }

            if($data["type"] == "classic"){
                $data["render"] = $_POST["render"] ?? "";
            }

            if($data["type"] == "standard"){
                $count_containers = (int) $_POST["count_containers"] ?? 0;
                for ($i = 0; $i < $count_containers; $i++) { 
                    $data["containers"][$i] = [
                        "enabled" => !empty($_POST["enabled"][$i]),
                        "render" => $_POST["render"][$i] ?? "",
                    ];
                }
            }

            $confirm = $this->write($path_file, $data);
            $message = ($confirm ? "Se guardaron los datos de: " : "Error al guardar los datos de: ") . $data["filename"];
            header("Location: form?msg=$message" . ($filename_not_empty ? "&filename={$filename_complete}" : ""));
        }
    }

    public function get_database_path(): string {
        return self::DATABASE_DIR;
    }

    public function get_templates_path(): string {
        return self::TEMPLATES_DIR;
    }

    public function get_posts_path(): string {
        return self::POSTS_DIR;
    }

    public function get_commands_path(): string {
        return self::COMMANDS_DIR;
    }
}
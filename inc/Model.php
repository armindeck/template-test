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
    public function read(string $file, bool $in_string = false): array|string
    {
        $content = file_get_contents($file) ?? "";
        return $in_string ? $content : json_decode($content, true) ?? [];
    }

    public function write(string $file, array $data): bool
    {
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    public function save_template(): void {
        if(isset($_POST["save_template"])){
            $id_file = str_replace(".json", "", $_POST["id_file" ?? ""]);

            $data = [
                "id_file"   => secureStringFile($id_file) . ".json",
                "type"      => secureString($_POST["type"] ?? ""),
                "version"   => secureString($_POST["version"] ?? ""),
                "render"    => $_POST["render"] ?? "",
            ];

            if(empty($data["id_file"]) || empty($data["type"]) || empty($data["version"]) || empty($data["render"])){
                die("Llene todos los datos");
            }

            $confirm = $this->write(__DIR__ . "/../database/{$data['id_file']}", $data);

            die(($confirm ? "Se guardaron los datos de: " : "Error al guardar los datos de: ") . $data["id_file"]);
        }
    }
}
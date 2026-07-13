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

class Template
{
    public function __construct(
        private array $template,
        private array $content
    ){}

    public function get_template(): array {
        return $this->template;
    }

    public function render(string $type = ""): string
    {
        if(empty($this->template)){ return "-----> Plantilla vacia <-----"; }

        $type = !empty($type) ? $type : $this->template["type"] ?? "";
        if(!method_exists($this, $type)){
            return "-----> Template Type not exists <-----";
        }

        $undefined = "-----> Undefined template <-----";
        return $this->{$type}() ?? $undefined;
    }

    private function classic(): string {
        return !empty($this->template["render"]) ? str_replace("{{ main }}", $this->content["content"] ?? "", $this->template["render"]) : "";
    }

    private function standard(): string {
        $output = "";
        foreach ($this->template["containers"] ?? [] as $container){
            if($container["enabled"] && !empty($container["render"])){
                $output .= str_replace("{{ main }}", $this->content["content"] ?? "", $container["render"]);
            }
        }

        return $output;
    }

    private function modern(): string {
        return "-----> Construct template <-----";
    }
}
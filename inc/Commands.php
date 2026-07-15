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

class Commands
{
    private string|array $content;
    private array $content_post_data;
    
    public function __construct(
        private array $commands,
        private array $core,
        private array $config
    ){}
    
    public function transform(bool $in_array = false): string|array {
        if (is_array($this->content)) {
            $result = [];
            foreach ($this->content as $key => $value) {
                // Crear nueva instancia con los mismos parámetros
                $command = new self($this->commands, $this->core, $this->config);
                // Establecer el contenido
                $command->set_content($value);
                // Si hay datos post, también los pasamos
                if (isset($this->content_post_data)) {
                    $command->set_content_post_data($this->content_post_data);
                }
                $result[$key] = $command->transform(false);
            }
            return $in_array ? $result : json_encode($result, JSON_PRETTY_PRINT);
        }
        
        $output = $this->content;
        
        if ($output === null) {
            $output = '';
        }
        
        foreach ($this->commands as $key_group => $value_group) {
            foreach ($value_group as $cmd_key => $cmd_value) {
                if ($cmd_key == "example_command") continue;
                $search_command = "";
                
                if(in_array($key_group, ["app", "content", "global"])){
                    $search_command = "{{ $cmd_key }}";
                    $cmd = explode(".", $cmd_key);

                    if($cmd[0] == "page") {
                        $cmd_value = $this->config[$cmd_value] ?? $search_command;
                    } elseif ($cmd[0] == "core") {
                        if(isset($cmd[1]) && $cmd[1] == "social" && isset($cmd[2]) && isset($cmd[3])){
                            $cmd_value = $this->core[$cmd[1]][$cmd[2]][$cmd[3]] ?? $search_command;
                        } else if(isset($cmd[1]) && $cmd[1] != "social") {
                            // Corregir: usar $cmd[1] como clave, no $cmd_value
                            $cmd_value = $this->core[$cmd[1]] ?? $search_command;
                        } else {
                            $cmd_value = $search_command;
                        }
                    } else if ($cmd[0] == "content"){
                        $cmd_value = $this->content_post_data[$cmd[1] ?? ""] ?? $search_command;
                    } else if ($key_group == "global") {
                        $cmd_value = $cmd_value == "main" ? $this->content_post_data["content"] ?? "" : $cmd_value ?? $search_command;
                    }
                } elseif ($key_group == "freely") {
                    $search_command = $cmd_key;
                }

                if (!empty($search_command)) {
                    $output = str_replace($search_command, $cmd_value, $output);
                }
            }
        }
        
        return $in_array ? json_decode($output, true) : $output;
    }

    public function set_content(string|array $content): void {
        $this->content = $content;
    }

    public function set_content_post_data(array $data): void {
        $this->content_post_data = $data;
    }
}
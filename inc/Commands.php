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
    public function __construct(
        private array $commands,
        private string|array $content,
        private array $core,
        private array $config
    ){}

    public function render(bool $in_array = false): string|array {
        $output = is_array($this->content) ? json_encode($this->content) : $this->content;
        foreach ($this->commands as $key_group => $value_group) {
            foreach ($value_group as $cmd_key => $cmd_value) {
                if ($cmd_key == "example_command") continue;

                if($key_group == "app"){
                    $search_command = "{{ $cmd_key }}";
                    $cmd = explode(".", $cmd_key);

                    if($cmd[0] == "page") {
                        $cmd_value = $this->config[$cmd_value] ?? $search_command;
                    } elseif ($cmd[0] == "core") {
                        if($cmd[1] == "social" && isset($cmd[2]) && isset($cmd[3])){
                            $cmd_value = $this->core[$cmd[1]][$cmd[2]][$cmd[3]] ?? $search_command;
                        } else if($cmd[1] != "social") {
                            $cmd_value = $this->core[$cmd_value] ?? $search_command;
                        }
                    }
                } elseif ($key_group == "freely") {
                    $search_command = $cmd_key;
                }
                
                $output = str_replace($search_command, $cmd_value, $output);
            }
        }
        return $in_array ? json_decode($output, true) : $output;
    }
}
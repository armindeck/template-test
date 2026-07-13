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

class TemplateUltimate
{
    public function __construct(
        private array $template,
        private array $commands = []
    ){}

    public function render(): string
    {
        return json_encode($this->template, JSON_PRETTY_PRINT);
    }

    public function search_commands(): array {
        $data = json_encode($this->template);
        $commands = [];
        preg_match_all('/\{\{ (.*?) \}\}/', $data, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $commands[] = $match;
            }
        }

        return $commands;
    }

    public function search_commands_and_params(): array {
        $commands = $this->search_commands();
        $transformed = [];
        foreach ($commands as $command) {
            $parts = explode(' ', $command);
            $transformed[] = [
                'command' => $parts[0],
                'params' => array_slice($parts, 1)
            ];
        }
        return $transformed;
    }

    public function search_commands_and_params_replace(): array {
        $commands = $this->search_commands_and_params();
        $replaced = [];
        foreach ($commands as $command) {
//            if (isset($this->commands[$command['command']])) {
                $replaced[] = [
                    'command' => $this->commands[$command['command']],
                    'params' => $command['params']
                ];
  /*          } else {
                $replaced[] = [
                    'command' => null,
                    'params' => $command['params']
                ];
            }*/
        }
        return $replaced;
    }

    public function get_commands(): array {
        return $this->commands;
    }

    public function get_template(): array {
        return $this->template;
    }
}
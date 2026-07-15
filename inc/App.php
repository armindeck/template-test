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

use inc\Model;

class App extends Model
{
    public function __construct(
        private string $core,
        private string $config,
    ){}
        
    private string $template;
    private string $commands;

    public function get_core(): array {
        return $this->read($this->get_database_path() . $this->core, enabled_cache: true);
    }

    public function get_config(): array {
        return $this->read($this->get_database_path() . $this->config, enabled_cache: true);
    }

    public function get_template(): array {
        return $this->read($this->get_templates_path() . $this->template, enabled_cache: true);
    }

    public function get_commands(): array {
        return $this->read($this->get_commands_path() . $this->commands, enabled_cache: true);
    }

    public function set_template(string $filename_template): void {
        $this->template = $filename_template;
    }

    public function set_commands(string $filename_commands): void {
        $this->commands = $filename_commands;
    }
}
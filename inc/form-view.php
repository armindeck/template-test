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
        <input type="text" name="id_file" id="id_file" placeholder="ID file: (template-classic.json)...">
        <select name="type" id="type" required>
            <option value="">--- Type ---</option>
            <option value="classic">Classic</option>
            <option value="standard">Standard</option>
            <option value="Modern">Modern</option>
        </select>
        <input type="text" name="version" id="version" placeholder="Version: (1.0.0, 1.1.0)...">
        <label for="render" style="display: flex; gap: 4px; flex-wrap: wrap;">
            <small style="font-weight: bold; color: white; background-color: darkslategray; padding: 2px 6px; border-radius: 4px;">
                Markdown is supported
            </small>
            <small style="font-weight: bold; color: white; background-color: darkslategray; padding: 2px 6px; border-radius: 4px;">
                Commands is supported
            </small>
        </label>
        <textarea name="render" id="render" cols="30" rows="10" style="flex: 1;" placeholder="Content: "></textarea>

        <button type="submit" name="save_template">Save</button>
    </form>
</body>
# PHP-unused-CSS-tracker

A small php script, to figure out for unused CSS.

## Usage

Call the **unusedCSS::find_all_IDs_CLASSes_TAGs(( HTML_content <= string ), ( SCSS_content <= string ), ( JS_Content <= string ));** function to get all ids, classes and tags. This function requires strings as values from each file you wanna compare. Push the result into an array. Afterwards call the **`unusedCSS::find_unused_CSS(( all_IDs_CLASSes_TAGs <= array ), ( HTML_file <= file path), ( SCSS_file <= file path ), ( JS_file <= file path ), ( project_directory <= root directory ));`** function for each file to compare them. The result is a multiple array of all unused CSS.

## Note!

Matched only `getElementById`, `$(#id)`, `getElementsByClassName`, `addClass`, `hasClass`, `removeClass` and `$(.class)` in the JavaScript files.

You can flatten the result to an array with one level with e.g.:

    $all_unused_CSS = unusedCSS::flatten_array($all_unused_CSS);
    $all_unused_CSS = array_map('json_encode', $all_unused_CSS);
    $all_unused_CSS = array_values(array_unique($all_unused_CSS));
    $all_unused_CSS = array_map('json_decode', $all_unused_CSS);
    $all_unused_CSS = json_decode(json_encode($all_unused_CSS), True);

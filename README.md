# PHP unused CSS/SCSS tracker

A small php script, to figure out for unused CSS/SCSS.

## Note!

Matched only `getElementById`, `$(#id)`, `getElementsByClassName`, `addClass`, `hasClass`, `removeClass` and `$(.class)` in the JavaScript files and the function doesn't compare HTML tags in the SCSS or JavaScript files (otherwise you get multiple unused HTML tags).


## Usage

    require 'regex.php';
    require 'namespaceCSS.php';

    // if $selectors is null the function search for selectors with the given directory and file paths
    $unusedCSS = new unusedCSS(
        $selectors,
        $html_dirs,
        $scss_dirs,
        $js_dirs,
        $project_dir,
        $directory
    );

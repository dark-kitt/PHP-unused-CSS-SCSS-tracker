# PHP unused CSS/SCSS tracker

A small php script, to figure out for unused CSS/SCSS.

## Usage

Call the **`unusedCSS::find_all_IDs_CLASSes_TAGs(( HTML_content <= string ), ( SCSS_content <= string ), ( JS_Content <= string ));`** function to get all ids, classes and tags. This function requires strings of each whole content, this means you have to merge the content before, like in the example below. Afterwards call the **`unusedCSS::find_unused_CSS(( all_IDs_CLASSes_TAGs <= array ), ( HTML_file <= file path ), ( SCSS_file <= file path ), ( JS_file <= file path ), ( project_directory <= root directory ));`** function for each file, to compare them. The result is a multiple array with objects of all unused CSS/SCSS.

## Note!

Matched only `getElementById`, `$(#id)`, `getElementsByClassName`, `addClass`, `hasClass`, `removeClass` and `$(.class)` in the JavaScript files and the function doesn't compare HTML tags in the SCSS or JavaScript files (otherwise you get multiple unused HTML tags).


## Example:

    require 'unusedCSS.php';

    // glob all is normally just a star withou the backslash//
    $all_HTML_files = glob( 'test/html/\*.php' );
    $all_SCSS_files = glob( 'test/scss/\*.scss' );
    $all_JS_files = glob( 'test/js/\*.js' );

    $all_HTML_content = '';
    $all_SCSS_content = '';
    $all_JS_content = '';
    foreach ( $all_HTML_files as $html_file )
    {
        $all_HTML_content .= file_get_contents($html_file);
    }
    foreach ( $all_SCSS_files as $scss_file )
    {
        $all_SCSS_content .= file_get_contents($scss_file);
    }
    foreach ( $all_JS_files as $js_file )
    {
        $all_JS_content .= file_get_contents($js_file);
    }

    $store_all_IDs_CLASSes_TAGs = unusedCSS::find_all_IDs_CLASSes_TAGs($all_HTML_content, $all_SCSS_content, $all_JS_content);

    $all_unused_CSS = [];
    $project_path = __DIR__;
    foreach ( $all_HTML_files as $html_file )
    {
        foreach ( $all_SCSS_files as $scss_file )
        {
            foreach ( $all_JS_files as $js_file )
            {
                array_push($all_unused_CSS, unusedCSS::find_unused_CSS($store_all_IDs_CLASSes_TAGs, $html_file, $scss_file, $js_file, $project_path));
            }
        }
    }

    //workaround to unique the result the array//
    $all_unused_CSS = unusedCSS::flatten_array($all_unused_CSS);
    $all_unused_CSS = array_map('json_encode', $all_unused_CSS);
    $all_unused_CSS = array_values(array_unique($all_unused_CSS));
    $all_unused_CSS = array_map('json_decode', $all_unused_CSS);
    $all_unused_CSS = json_decode(json_encode($all_unused_CSS), True);

    echo "<pre>";
    var_dump($all_unused_CSS);

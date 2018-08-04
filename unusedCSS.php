<?php

    class unusedCSS {

        public static function flatten_array(array $array)
        {
            $return = array();
            array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
            return $return;
        }

        public static function find_all_IDs_CLASSes_TAGs($HTML_content = null , $SCSS_content = null, $JS_content = null)
        {
            $pattern_all_ids_classes_tags_SCSS = '/(?|(?:\{(?(?=\s+)\s+)[^\{\$]*?(?=\}))|(?=\{)\{[^\{\}]*?(?=\{(?(?=\s+)\s+)\$)\{[^\{]*?(?=\})\}(?(?=[^\{]*?(?=\#\{)\#\{[^\{]*?(?=\})\})(?:[^\{]*?(?=\#\{)\#\{[^\{]*?(?=\})\})+)[^\{]*?(?=\})|(?(?=\s+)\s+)(?:\@(?:-webkit-keyframes)).*?(?=\}(?(?=\s+)\s+)\})|(?(?=\s+)\s+)(?:\@(?:keyframes)).*?(?=\}(?(?=\s+)\s+)\}))(*SKIP)(*FAIL)|(?|(?(?=(?:\{(?(?=\s+)\s+)\{)|(?:\{(?(?=\s+)\s+)\})|(?:\}(?(?=\s+)\s+)\})|(?:\}(?(?=\s+)\s+)\{))\0|(?:\{|\})(?(?=\s+)\s+)(?(?=\@)\0|([^\%\;\@]*?(?(?=\#\{\$)\#\{\$.*?(?=\})))(?(?=\s+)\s+))(?(?=\}|\{\$)\0)(?=\{))|(?=\;)\;(?(?=\s+)\s+)([^\%\;\@\{\}]*?(?(?=\#\{\$)\#\{\$.*?(?=\})\}))(?(?=\s+)\s+)(?=\{)|(^[^\%\;\@]*?(?(?=\#\{\$)\#\{\$.*?(?=\})))(?=\{))/';

            $pattern_all_ids_SCSS = '/(?(?=\#\w+)\#([\w\-]+)(?:(?=\,)|(?=\:)|(?=\s+)|(?=\.)|(?=\+)|(?=\~)|(?=\>)|(?=\[)|\#[\w\-]+|)|\0)/';
            $pattern_all_classes_SCSS = '/(?(?=\.\w+)\.([\w\-]+)(?:(?=\,)|(?=\:)|(?=\s+)|(?=\#)|(?=\+)|(?=\~)|(?=\>)|(?=\[)|\.[\w\-]+|)|\0)/';
            $pattern_all_tags_SCSS = '/(?(?=\#\w+)\#\w+|\0)(*SKIP)(*FAIL)|(?(?=\.\w+)\.\w+|\0)(*SKIP)(*FAIL)|(?(?=\-\w+)\-\w+|\0)(*SKIP)(*FAIL)|(?(?=\_\w+)\_\w+|\0)(*SKIP)(*FAIL)|(?(?=(?:\:lang\b|\:nth-child\b|\:nth-last-child\b|\:nth-last-of-type\b|\:nth-of-type\b)\((?(?=\s+)\s+).+?(?=\))\))(?:\:lang\b|\:nth-child\b|\:nth-last-child\b|\:nth-last-of-type\b|\:nth-of-type\b)\((?(?=\s+)\s+).+?(?=\))\)|\0)(*SKIP)(*FAIL)|(?(?=\:\w+)\:\w+|\0)(*SKIP)(*FAIL)|(?(?=\[(?(?=\s+)\s+)\w+)\[(?(?=\s+)\s+)\w+|\0)(*SKIP)(*FAIL)|(?(?=\=(?(?=\s+)\s+)\w+)\=(?(?=\s+)\s+)\w+|\0)(*SKIP)(*FAIL)|(?(?=\"(?(?=\s+)\s+)\w+)\"(?(?=\s+)\s+)\w+|\0)(*SKIP)(*FAIL)|(?(?=\'(?(?=\s+)\s+)\w+)\'(?(?=\s+)\s+)\w+|\0)(*SKIP)(*FAIL)|(\w+)/';

            $pattern_all_ids_HTML = '/id\b(?(?=\s+)\s+)\=(?(?=\s+)\s+)\"(?(?=\s+)\s+)([\w+\-]+)(?(?=\s+)\s+)(?=\")/';
            $pattern_all_classes_HTML = '/class\b(?(?=\s+)\s+)\=(?(?=\s+)\s+)\"(?(?=\s+)\s+)(.*?)(?(?=\s+)\s+)(?=\")/';
            $pattern_all_tags_HTML = '/<(?(?=\s+)\s+)(\w+)/';

            $pattern_get_id_JS = '/(?:getElementById\b)\(.*?[\"\'](?(?=\s+)\s+)([\w+\-]+)(?(?=\s+)\s+)[\"\']/';
            $pattern_get_class_JS = '/(?:getElementsByClassName\b)\(.*?[\"\'](?(?=\s+)\s+)([\w+\-]+)(?(?=\s+)\s+)[\"\']/';

            $pattern_add_rem_hasClass_JQuery = '/(?:\.addClass\b|\.hasClass\b|\.removeClass\b)\((?(?=\s+)\s+)[\"\'](?(?=\s+)\s+)(.+?)(?=\"|\')[\"\']\)/';
            $pattern_selector_all_JQuery = '/(?:\$)\((?(?=\s+)\s+)[\"\'](?(?=\s+)\s+)(?(?=[a-zA-Z0-9\*\s\-\:\>\[\]\~\+\*\,\|\=\$\^\'\"\_\d]+?)[a-zA-Z0-9\*\s\-\:\>\[\]\~\+\*\,\|\=\$\^\'\"\_\d]+?)(?=\#|\.)(?|([\#\.a-zA-Z0-9\*\s\-\:\>\[\]\~\+\*\,\|\=\$\^\"\'\_\d\(\)]+?))(?(?=\s+)\s+)[\"\'](?(?=\s+)\s+)\)/';

            $pattern_filter_id_JQuery = '/\#[\w\-]+/';
            $pattern_filter_class_JQuery = '/\.[\w\-]+/';

            if ($SCSS_content !== null)
            {
                preg_match_all( $pattern_all_ids_classes_tags_SCSS, $SCSS_content, $SCSS_matches );
                $SCSS_match_result = str_replace(',,', ',', preg_replace( '/\s+/', ',', join( ',', $SCSS_matches[1] )));

                preg_match_all( $pattern_all_ids_SCSS, $SCSS_match_result, $SCSS_ids );
                preg_match_all( $pattern_all_classes_SCSS, $SCSS_match_result, $SCSS_classes );
                preg_match_all( $pattern_all_tags_SCSS, $SCSS_match_result, $SCSS_tags );

                foreach( $SCSS_ids as $id_key => $id_value )
                {
                    $SCSS_ids[$id_key] = str_replace( '#', '', $id_value );
                }
                $SCSS_ids = array_filter( array_unique( unusedCSS::flatten_array( $SCSS_ids ) ), function($value) { return $value !== ''; } );

                foreach( $SCSS_classes as $class_key => $class_value )
                {
                    $SCSS_classes[$class_key] = str_replace( '.', '', $class_value );
                }
                $SCSS_classes = array_filter( array_unique( unusedCSS::flatten_array( $SCSS_classes ) ), function($value) { return $value !== ''; } );

                $SCSS_tags = array_filter( array_unique( unusedCSS::flatten_array( $SCSS_tags ) ), function($value) { return $value !== ''; } );
            }

            if ($HTML_content !== null)
            {
                preg_match_all( $pattern_all_ids_HTML, $HTML_content, $HTML_ids );
                preg_match_all( $pattern_all_classes_HTML, $HTML_content, $HTML_class_match );
                /*workaround for whitespaces in HTML e.g. class="class    class class"*/
                preg_match_all('/(?|(.+?)(?:\,)|(.+))/', preg_replace( '/\s+/', ',', join(',',array_filter($HTML_class_match[1], function($value) { return $value !== ''; } ))), $HTML_classes);
                preg_match_all( $pattern_all_tags_HTML, $HTML_content, $HTML_tags );

                $HTML_ids = array_filter( array_unique( unusedCSS::flatten_array( $HTML_ids[1] ) ), function($value) { return $value !== ''; } );

                $HTML_classes = array_unique( $HTML_classes[1] );

                $HTML_tags = array_filter( array_unique( unusedCSS::flatten_array( $HTML_tags[1] ) ), function($value) { return $value !== ''; } );
            }

            if ($JS_content !== null)
            {
                preg_match_all( $pattern_get_id_JS, $JS_content, $JS_get_ids );
                $JS_get_ids = array_filter( array_unique( unusedCSS::flatten_array( $JS_get_ids[1] ) ), function($value) { return $value !== ''; } );

                preg_match_all( $pattern_get_class_JS, $JS_content, $JS_get_classes );
                $JS_get_classes = array_filter( array_unique( unusedCSS::flatten_array( $JS_get_classes[1] ) ), function($value) { return $value !== ''; } );

                preg_match_all( $pattern_add_rem_hasClass_JQuery, $JS_content, $JS_add_rem_hasClass_match_JQuery );
                preg_match_all( '/[\w\-]+/', join(',', $JS_add_rem_hasClass_match_JQuery[1]), $JS_add_rem_hasClass_JQuery);

                $JS_add_rem_hasClass_JQuery = array_filter( array_unique( unusedCSS::flatten_array( $JS_add_rem_hasClass_JQuery[0] ) ), function($value) { return $value !== ''; } );

                preg_match_all( $pattern_selector_all_JQuery, $JS_content, $JS_selector_all_JQuery );

                preg_match_all( $pattern_filter_id_JQuery, join(',', $JS_selector_all_JQuery[1]), $JS_selector_id_jQuery );
                foreach( $JS_selector_id_jQuery as $id_key => $id_value )
                {
                    $JS_selector_id_jQuery[$id_key] = str_replace( '#', '', $id_value );
                }
                $JS_selector_id_jQuery = array_filter( array_unique( unusedCSS::flatten_array( $JS_selector_id_jQuery[0] ) ), function($value) { return $value !== ''; } );

                preg_match_all( $pattern_filter_class_JQuery, join(',', $JS_selector_all_JQuery[1]), $JS_selector_class_jQuery );
                foreach( $JS_selector_class_jQuery as $class_key => $class_value )
                {
                    $JS_selector_class_jQuery[$class_key] = str_replace( '.', '', $class_value );
                }
                $JS_selector_class_jQuery = array_filter( array_unique( unusedCSS::flatten_array( $JS_selector_class_jQuery[0] ) ), function($value) { return $value !== ''; } );
            }

            if ($HTML_content !== null && $SCSS_content !== null && $JS_content !== null)
            {
                return [
                    [
                        $SCSS_ids,
                        $SCSS_classes,
                        $SCSS_tags
                    ],
                    [
                        $HTML_ids,
                        $HTML_classes,
                        $HTML_tags
                    ],
                    [
                        $JS_ids = [
                            $JS_get_ids,
                            $JS_selector_id_jQuery
                        ],
                        $JS_classes = [
                            $JS_get_classes,
                            $JS_add_rem_hasClass_JQuery,
                            $JS_selector_class_jQuery
                        ]
                    ]
                ];
            }
            else
            {
                if ($HTML_content !== null)
                {
                    return [
                        $HTML_ids,
                        $HTML_classes,
                        $HTML_tags
                    ];
                }
                if ($SCSS_content !== null)
                {
                    return [
                        $SCSS_ids,
                        $SCSS_classes,
                        $SCSS_tags
                    ];
                }
                if ($JS_content !== null)
                {
                    return [
                        $JS_ids = [
                            $JS_get_ids,
                            $JS_selector_id_jQuery
                        ],
                        $JS_classes = [
                            $JS_get_classes,
                            $JS_add_rem_hasClass_JQuery,
                            $JS_selector_class_jQuery
                        ]
                    ];
                }

            }
        }

        public static function find_unused_CSS($all_IDs_CLASSes_TAGs, $HTML_file, $SCSS_file, $JS_file, $project_directory)
        {
            $unused_CSS = [];

            $SCSS_ids = $all_IDs_CLASSes_TAGs[0][0];
            $SCSS_classes = $all_IDs_CLASSes_TAGs[0][1];
            $SCSS_tags = $all_IDs_CLASSes_TAGs[0][2];

            $HTML_ids = $all_IDs_CLASSes_TAGs[1][0];
            $HTML_classes = $all_IDs_CLASSes_TAGs[1][1];
            $HTML_tags = $all_IDs_CLASSes_TAGs[1][2];

            $JS_ids = $all_IDs_CLASSes_TAGs[2][0];
            $JS_classes = $all_IDs_CLASSes_TAGs[2][1];

            $JS_ids_flatten_array = unusedCSS::flatten_array( $JS_ids );
            $JS_class_flatten_array = unusedCSS::flatten_array( $JS_classes );

            $SCSS_content = file_get_contents( $SCSS_file );
            $current_SCSS_IDs_CLASSes_TAGs = unusedCSS::find_all_IDs_CLASSes_TAGs(null, $SCSS_content, null);
            $current_SCSS_ids = $current_SCSS_IDs_CLASSes_TAGs[0];
            $current_SCSS_classes = $current_SCSS_IDs_CLASSes_TAGs[1];
            $current_SCSS_tags = $current_SCSS_IDs_CLASSes_TAGs[2];

            $JS_content = file_get_contents( $JS_file );
            $current_JS_IDs_CLASSes_TAGs = unusedCSS::find_all_IDs_CLASSes_TAGs(null, null, $JS_content);
            $current_JS_ids = $current_JS_IDs_CLASSes_TAGs[0];
            $current_JS_classes = $current_JS_IDs_CLASSes_TAGs[1];

            $current_JS_ids_flatten_array = unusedCSS::flatten_array( $current_JS_ids );
            $current_JS_class_flatten_array = unusedCSS::flatten_array( $current_JS_classes );

            if ( count($SCSS_ids) > 0 )
            {
                foreach ( $SCSS_ids as $SCSS_id_search_value )
                {
                    if ( !in_array( $SCSS_id_search_value, $HTML_ids ) &&
                         !in_array( $SCSS_id_search_value, $JS_ids_flatten_array ) &&
                          in_array( $SCSS_id_search_value, $current_SCSS_ids ) )
                    {
                        array_push( $unused_CSS, $unused = (object) [
                            "identifier" => '#' . $SCSS_id_search_value,
                            "message" => 'CSS id not found in HTML or JS file.',
                            "line" => unusedCSS::find_row('\#', $SCSS_id_search_value, $SCSS_file),
                            "directory" => str_replace ( $project_directory , '', $SCSS_file )
                        ]);
                    }
                }
            }

            if ( count($SCSS_classes) > 0 )
            {
                foreach ( $SCSS_classes as $SCSS_class_search_value )
                {
                    if ( !in_array( $SCSS_class_search_value, $HTML_classes ) &&
                         !in_array( $SCSS_class_search_value, $JS_class_flatten_array )  &&
                          in_array( $SCSS_class_search_value, $current_SCSS_classes ) )
                    {
                        array_push( $unused_CSS, $unused = (object) [
                            "identifier" => '.' . $SCSS_class_search_value,
                            "message" => "CSS class not found in HTML or JS file.",
                            "line" => unusedCSS::find_row('\.', $SCSS_class_search_value, $SCSS_file),
                            "directory" => str_replace ( $project_directory , '', $SCSS_file )
                        ]);
                    }
                }
            }

            if ( count($SCSS_tags) > 0 )
            {
                foreach ( $SCSS_tags as $SCSS_tag_search_value )
                {
                    if ( !in_array( $SCSS_tag_search_value, $HTML_tags ) &&
                          $SCSS_tag_search_value !== 'body' &&
                          $SCSS_tag_search_value !== 'html'  &&
                          in_array( $SCSS_tag_search_value, $current_SCSS_tags ))
                    {
                        array_push( $unused_CSS, $unused = (object) [
                            "identifier" => $SCSS_tag_search_value,
                            "message" => "CSS tag not found in HTML file.",
                            "line" => unusedCSS::find_row('\<', $SCSS_tag_search_value, $SCSS_file),
                            "directory" => str_replace ( $project_directory , '', $SCSS_file )
                        ]);
                    }
                }
            }

            if ( count($HTML_ids) > 0 )
            {
                foreach ( $HTML_ids as $HTML_id_search_value )
                {
                    if ( !in_array( $HTML_id_search_value, $SCSS_ids ) &&
                         !in_array( $HTML_id_search_value, $JS_ids_flatten_array ))
                    {
                        array_push( $unused_CSS, $unused = (object) [
                            "identifier" => 'id="' . $HTML_id_search_value . '"',
                            "message" => "HTML id not found in SCSS or JS file.",
                            "line" => unusedCSS::find_row('id\b', $HTML_id_search_value, $HTML_file),
                            "directory" => str_replace ( $project_directory , '', $HTML_file )
                        ]);
                    }
                }
            }

            if ( count($HTML_classes) > 0 )
            {
                foreach ( $HTML_classes as $HTML_class_search_value )
                {
                    if ( !in_array( $HTML_class_search_value, $SCSS_classes ) &&
                         !in_array( $HTML_class_search_value, $JS_class_flatten_array ) )
                    {
                        array_push( $unused_CSS, $unused = (object) [
                            "identifier" => 'class="' . $HTML_class_search_value . '"',
                            "message" => "HTML class not found in SCSS or JS file.",
                            "line" => unusedCSS::find_row('class\b', $HTML_class_search_value, $HTML_file),
                            "directory" => str_replace ( $project_directory , '', $HTML_file )
                        ]);
                    }
                }
            }

            if ( count($JS_ids) > 0 )
            {
                if ( count($JS_ids[0]) > 0 )
                {
                    foreach ( $JS_ids[0] as $JS_get_id_search_value )
                    {
                        if ( !in_array( $JS_get_id_search_value, $SCSS_ids ) &&
                             !in_array( $JS_get_id_search_value, $HTML_ids )  &&
                              in_array( $JS_get_id_search_value, $current_JS_ids_flatten_array ))
                        {
                            array_push( $unused_CSS, $unused = (object) [
                                "identifier" => '.getElementById("' . $JS_get_id_search_value . '")',
                                "message" => "CSS id in JS file not found in HTML or SCSS file.",
                                "line" => unusedCSS::find_row('\.getElementById\b\(', $JS_get_id_search_value, $JS_file),
                                "directory" => str_replace ( $project_directory , '', $JS_file )
                            ]);
                        }
                    }
                }
                if ( count($JS_ids[1]) > 0 )
                {
                    foreach ( $JS_ids[1] as $JS_selector_id_jQuery_search_value )
                    {
                        if ( !in_array( $JS_selector_id_jQuery_search_value, $SCSS_ids ) &&
                             !in_array( $JS_selector_id_jQuery_search_value, $HTML_ids ) &&
                              in_array( $JS_selector_id_jQuery_search_value, $current_JS_ids_flatten_array ))
                        {
                            array_push( $unused_CSS, $unused = (object) [
                                "identifier" => '$("#' . $JS_selector_id_jQuery_search_value . '")',
                                "message" => "CSS id in JS file not found in HTML or SCSS file.",
                                "line" => unusedCSS::find_row('\$\(', '\#' . $JS_selector_id_jQuery_search_value, $JS_file),
                                "directory" => str_replace ( $project_directory , '', $JS_file )
                            ]);
                        }
                    }
                }
            }

            if ( count($JS_classes) > 0 )
            {
                if ( count($JS_classes[0]) > 0 )
                {
                    foreach ( $JS_classes[0] as $JS_get_class_search_value )
                    {
                        if ( !in_array( $JS_get_class_search_value, $SCSS_classes ) &&
                             !in_array( $JS_get_class_search_value, $HTML_classes ) &&
                              in_array( $JS_get_class_search_value, $current_JS_class_flatten_array ))
                        {
                            array_push( $unused_CSS, $unused = (object) [
                                "identifier" => '.getElementsByClassName("' . $JS_get_class_search_value . '")',
                                "message" => "CSS class in JS file not found in HTML or SCSS file.",
                                "line" => unusedCSS::find_row('\.getElementsByClassName\b\(', $JS_get_class_search_value, $JS_file),
                                "directory" => str_replace ( $project_directory , '', $JS_file )
                            ]);
                        }
                    }
                }
                if ( count($JS_classes[1]) > 0 )
                {
                    foreach ( $JS_classes[1] as $JS_add_rem_hasClass_JQuery_search_value )
                    {
                        if ( !in_array( $JS_add_rem_hasClass_JQuery_search_value, $SCSS_classes ) &&
                             !in_array( $JS_add_rem_hasClass_JQuery_search_value, $HTML_classes ) &&
                              in_array( $JS_add_rem_hasClass_JQuery_search_value, $current_JS_class_flatten_array ))
                        {
                            array_push( $unused_CSS, $unused = (object) [
                                "identifier" => '.addClass | .hasClass | .removeClass("' . $JS_add_rem_hasClass_JQuery_search_value . '")',
                                "message" => "CSS class in JS file not found in HTML or SCSS file.",
                                "line" => unusedCSS::find_row('(?:\.addClass\b|\.hasClass\b|\.removeClass\b)', $JS_add_rem_hasClass_JQuery_search_value, $JS_file),
                                "directory" => str_replace ( $project_directory , '', $JS_file )
                            ]);
                        }
                    }
                }
                if ( count($JS_classes[2]) > 0 )
                {
                    foreach ( $JS_classes[2] as $JS_selector_class_jQuery_search_value )
                    {
                        if ( !in_array( $JS_selector_class_jQuery_search_value, $SCSS_classes ) &&
                             !in_array( $JS_selector_class_jQuery_search_value, $HTML_classes ) &&
                              in_array( $JS_selector_class_jQuery_search_value, $current_JS_class_flatten_array ))
                        {
                            array_push( $unused_CSS, $unused = (object) [
                                "identifier" => '$(".' . $JS_selector_class_jQuery_search_value . '")',
                                "message" => "CSS class in JS file not found in HTML or SCSS file.",
                                "line" => unusedCSS::find_row('(?:\.addClass\b|\.hasClass\b|\.removeClass\b)', $JS_selector_class_jQuery_search_value, $JS_file),
                                "directory" => str_replace ( $project_directory , '', $JS_file )
                            ]);
                        }
                    }
                }
            }

            return $unused_CSS;
        }

        public static function find_row( $identifier, $search, $inputFile )
        {
            $line_number = false;
            $lines = [];

            if ( $identifier === '\#' || $identifier === '\.' )
            {
                $pattern = '/' . $identifier . $search . '\b/';
            }
            elseif ( $identifier === '\<' )
            {
                $pattern = '/(?(?=\#' . $search . '\b)\#' . $search . '\b|\0)(*SKIP)(*FAIL)|(?(?=\.' . $search . '\b)\.' . $search . '\b|\0)(*SKIP)(*FAIL)|(?(?=\-' . $search . '\b)\-' . $search . '\b|\0)(*SKIP)(*FAIL)|(?(?=' . $search . '\b\-)' . $search . '\b\-|\0)(*SKIP)(*FAIL)|(?(?=\_' . $search . '\b)\_' . $search . '\b|\0)(*SKIP)(*FAIL)|(?(?=\w' . $search . '\b)\w' . $search . '\b|\0)(*SKIP)(*FAIL)|(?(?=\:' . $search . '\b)\:' . $search . '\b|\0)(*SKIP)(*FAIL)|' . $search . '\b/';
            }
            else
            {
                $pattern = '/' . $identifier . '.*?' . $search . '\b/';
            }

            if ($handle = fopen($inputFile, "r"))
            {
                $count = 0;

                while (($line = fgets($handle)))
                {
                    $count++;
                    $line_number = (preg_match( $pattern, $line ) !== 0) ? $count : $line_number;

                    if ($line_number !== false && $line_number === $count)
                    {
                        array_push($lines, $line_number);
                    }
                }
                fclose($handle);

                return $lines;
            }

        }
    }

?>

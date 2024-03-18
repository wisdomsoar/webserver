<?php
/**
*
*
*/
function DisplayThemeConfig()
{
    $themes = [
        "default" => "HackerNews",
       // "custom"    => "RaspAP (default)",
       // "terminal"   => "Terminal"
    ];
    $themeFiles = [
        "default" => "hackernews.css",
      //  "custom"    => "custom.css",
        //"terminal"   => "terminal.css"
    ];
    $selectedTheme = array_search($_COOKIE['theme'], $themeFiles);

    echo renderTemplate("themes", compact("themes", "selectedTheme"));
}

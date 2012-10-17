(function ($) {
    $("head").append(
    '<link href="http://alexgorbatchev.com/pub/sh/current/styles/shCore.css" rel="stylesheet" type="text/css" />'
    ).append(
    '<link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />'
    );
    function setupSyntaxHighlighterAutoloads() {
        console.log("calling SyntaxHighlighter");
        SyntaxHighlighter.autoloader(
              'applescript            http://alexgorbatchev.com/pub/sh/current/scripts/shBrushAppleScript.js',
              'actionscript3 as3      http://alexgorbatchev.com/pub/sh/current/scripts/shBrushAS3.js',
              'bash shell             http://alexgorbatchev.com/pub/sh/current/scripts/shBrushBash.js',
              'coldfusion cf          http://alexgorbatchev.com/pub/sh/current/scripts/shBrushColdFusion.js',
              'cpp c                  http://alexgorbatchev.com/pub/sh/current/scripts/shBrushCpp.js',
              'c# c-sharp csharp      http://alexgorbatchev.com/pub/sh/current/scripts/shBrushCSharp.js',
              'css                    http://alexgorbatchev.com/pub/sh/current/scripts/shBrushCss.js',
              'delphi pascal          http://alexgorbatchev.com/pub/sh/current/scripts/shBrushDelphi.js',
              'diff patch pas         http://alexgorbatchev.com/pub/sh/current/scripts/shBrushDiff.js',
              'erl erlang             http://alexgorbatchev.com/pub/sh/current/scripts/shBrushErlang.js',
              'groovy                 http://alexgorbatchev.com/pub/sh/current/scripts/shBrushGroovy.js',
              'java                   http://alexgorbatchev.com/pub/sh/current/scripts/shBrushJava.js',
              'jfx javafx             http://alexgorbatchev.com/pub/sh/current/scripts/shBrushJavaFX.js',
              'js jscript javascript  http://alexgorbatchev.com/pub/sh/current/scripts/shBrushJScript.js',
              'perl pl                http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPerl.js',
              'php                    http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPhp.js',
              'text plain             http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPlain.js',
              'py python              http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPython.js',
              'ruby rails ror rb      http://alexgorbatchev.com/pub/sh/current/scripts/shBrushRuby.js',
              'sass scss              http://alexgorbatchev.com/pub/sh/current/scripts/shBrushSass.js',
              'scala                  http://alexgorbatchev.com/pub/sh/current/scripts/shBrushScala.js',
              'sql                    http://alexgorbatchev.com/pub/sh/current/scripts/shBrushSql.js',
              'vb vbnet               http://alexgorbatchev.com/pub/sh/current/scripts/shBrushVb.js',
              'xml xhtml xslt html    http://alexgorbatchev.com/pub/sh/current/scripts/shBrushXml.js'
       );
       SyntaxHighlighter.all();
    }
    $.getScript("http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js",
        function () {
            $.getScript("http://alexgorbatchev.com/pub/sh/current/scripts/shAutoloader.js",setupSyntaxHighlighterAutoloads);
    });
})(jQuery);


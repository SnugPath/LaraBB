<?php

namespace App\Helpers\Classes;

class Utilities
{
    public static function bbCodeToHtml(string $bbcode): string
    {

        // Sanitize input
        $bbcode = htmlspecialchars($bbcode, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        //
        $bbcode = strip_tags($bbcode, '<b><strong><i><em><u><s><a><img><ul><ol><li>
            <span><div><blockquote><code><pre><br><input><label><hr><audio><video><source><iframe>
            <h1><h2><h3><h4><h5><h6><p><style><link><main><sub><sup><mark><svg><table><tbody>
            <thead><tfoot><tr><td><th><select><radio>');

        // text styles
        $bbcode = preg_replace('/\[b](.*?)\[\/b]/is', '<b>$1</b>', $bbcode);
        $bbcode = preg_replace('/\[i](.*?)\[\/i]/is', '<i>$1</i>', $bbcode);
        $bbcode = preg_replace('/\[u](.*?)\[\/u]/is', '<u>$1</u>', $bbcode);
        $bbcode = preg_replace('/\[s](.*?)\[\/s]/is', '<s>$1</s>', $bbcode);

        // url
        $bbcode = preg_replace('/\[url](.*?)\[\/url]/is', '<a href="$1">$1</a>', $bbcode);
        $bbcode = preg_replace('/\[url=(.*?)](.*?)\[\/url]/is', '<a href="$1">$2</a>', $bbcode);

        // images
        $bbcode = preg_replace('/\[img](.*?)\[\/img]/is', '<img src="$1" alt="">', $bbcode);

        // spoiler
        $bbcode = preg_replace('/\[spoiler](.*?)\[\/spoiler]/is', '<dl><dt>Spoiler:</dt><dd>$1</dd></dl>', $bbcode);
        $bbcode = preg_replace('/\[spoiler=(.*?)](.*?)\[\/spoiler]/is', '<dl><dt>$1:</dt><dd>$2</dd></dl>', $bbcode);

        //quotes
        $bbcode = preg_replace('/\[quote](.*?)\[\/quote]/is', '<blockquote>$1</blockquote>', $bbcode);
        $bbcode = preg_replace('/\[quote=(.*?)](.*?)\[\/quote]/is', '<blockquote><cite>$1 escribió:</cite>$2</blockquote>', $bbcode);

        // code
        $bbcode = preg_replace('/\[code](.*?)\[\/code]/s', '<code>$1</code>', $bbcode);

        // preformatted
        $bbcode = preg_replace('/\[pre](.*?)\[\/pre]/s', '<pre>$1</pre>', $bbcode);

        // lists
        $bbcode = preg_replace('/\[list](.*?)\[\/list]/s', '<ul>$1</ul>', $bbcode);
        $bbcode = preg_replace('/\[list=1](.*?)\[\/list]/s', '<ol>$1</ol>', $bbcode);
        $bbcode = preg_replace('/\[list=a](.*?)\[\/list]/s', '<ol style="list-style-type:lower-alpha">$1</ol>', $bbcode);
        $bbcode = preg_replace('/\[\*](.*?)\n/s', '<li>$1</li>', $bbcode);

        // color
        $bbcode = preg_replace('/\[color=(.*?)](.*?)\[\/color]/is', '<span style="color: $1;">$2</span>', $bbcode);

        // font size
        $bbcode = preg_replace('/\[size=([0-9]+)](.*?)\[\/size]/s', '<span style="font-size: $1px">$2</span>', $bbcode);

        // alignment
        $bbcode = preg_replace('/\[center](.*?)\[\/center]/is', '<div style="text-align:center">$1</div>', $bbcode);
        $bbcode = preg_replace('/\[left](.*?)\[\/left]/is', '<div style="text-align:left">$1</div>', $bbcode);
        $bbcode = preg_replace('/\[right](.*?)\[\/right]/is', '<div style="text-align:right">$1</div>', $bbcode);
        $bbcode = preg_replace('/\[justify](.*?)\[\/justify]/is', '<div style="text-align:justify">$1</div>', $bbcode);

        return preg_replace('/(\r\n|\n|\r)+/', '<br>', $bbcode);
    }
}

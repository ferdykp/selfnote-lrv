<?php
namespace App\Support;
class NoteHtml {
    public static function clean(string $html): string {
        if (!class_exists(\DOMDocument::class)) return nl2br(htmlspecialchars(strip_tags($html), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
        $dom = new \DOMDocument('1.0','UTF-8');
        $prev=libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div id="note-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
        libxml_clear_errors(); libxml_use_internal_errors($prev);
        $root=$dom->getElementById('note-root');
        if (!$root) return '';
        $allowed=['p','div','br','strong','b','em','i','u','s','del','h1','h2','h3','blockquote','ul','ol','li','a','code','pre'];
        $walk=function ($parent) use (&$walk,$allowed) {
            foreach (iterator_to_array($parent->childNodes) as $node) {
                if ($node instanceof \DOMComment) {$parent->removeChild($node);continue;}
                if (!($node instanceof \DOMElement)) continue;
                $tag=strtolower($node->tagName);
                if (in_array($tag,['script','style','iframe','object','embed','svg','math','form','input','button'],true)) {$parent->removeChild($node);continue;}
                $walk($node);
                if (!in_array($tag,$allowed,true)) {
                    while($node->firstChild) $parent->insertBefore($node->firstChild,$node);
                    $parent->removeChild($node);continue;
                }
                $href=$tag==='a'?$node->getAttribute('href'):'';
                $alignment=$node->getAttribute('style');
                while($node->attributes->length) $node->removeAttributeNode($node->attributes->item(0));
                if (preg_match('/(?:^|;)\s*text-align:\s*(left|center|right)\s*(?:;|$)/i', $alignment, $m)) $node->setAttribute('style', 'text-align:'.strtolower($m[1]));
                if ($tag==='a' && preg_match('~^https?://~i',$href)) { $node->setAttribute('href',$href);$node->setAttribute('rel','noopener noreferrer');$node->setAttribute('target','_blank'); }
            }
        };
        $walk($root); $out=''; foreach($root->childNodes as $node) $out.=$dom->saveHTML($node);return $out;
    }
}

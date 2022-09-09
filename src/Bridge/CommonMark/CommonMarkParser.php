<?php declare(strict_types=1);

namespace Mni\FrontYAML\Bridge\CommonMark;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\MarkdownConverterInterface;
use Mni\FrontYAML\Markdown\MarkdownParser;

/**
 * Bridge to the League CommonMark parser
 */
class CommonMarkParser implements MarkdownParser
{
    private MarkdownConverterInterface $parser;

    public function __construct(MarkdownConverterInterface $commonMarkConverter = null)
    {
        $this->parser = $commonMarkConverter ?: new CommonMarkConverter;
    }

    public function parse(string $markdown): string
    {
        $html = $this->parser->convertToHtml($markdown);
        if (is_object($html)) $html = $html->getContent();
        if (preg_match("!(<h\d[^>]*)>!isU", $html, $match) && !preg_match("!<h\d[^>]*class=\"title\">!isU", $html, $match2)):
            $html = str_replace($match[1], $match[1]." class=\"title\"", $html);
        endif;
        return $html;
    }
}

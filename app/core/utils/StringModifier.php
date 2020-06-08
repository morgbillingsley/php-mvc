<?php

namespace Core\Utils;

class StringModifier
{
    public static $articles = array( "a", "an", "the", "for", "and", "nor", "but", "or", "yet", "so", "at", "around", "by", "after", "along", "for", "from", "of", "on", "to", "with", "without" );
    public static $delimeters = array( "_", "-", " ", ",", ".", "\t", "\n", "'" );
    public $text = "";

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function title(): string
    {
        $spacedText = $this->replaceDelimeters();
        $words = explode(" ", $spacedText);
        $capitalizedWords = array_map([ self, "capitalizeTitleWord" ], $words);
        return implode(" ", $capitalizedWords);
    }

    public function snake(): string
    {
        $snake = $this->replaceDelimeters("_");
        return strtolower($snake);
    }

    public function kebab(): string
    {
        $kebab = $this->replaceDelimeters("-");
        return strtolower($kebab);
    }

    public function camel(): string
    {
        $words = $this->split;
        $capitalizedWords = array_map([ self, "capitalizeCamelWord" ], $words, array_keys( $words ));
        return implode("", $capitalizedWords);
    }

    public function pascal(): string
    {
        $words = $this->split();
        $capitalizedWords = array_map("ucfirst", $words);
        return implode("", $capitalizedWords);
    }

    public function capitalize(): string
    {
        $words = explode(" ", $this->text);
        $capitalizedWords = array_map("ucfirst", $words);
        return implode(" ", $capitalizedWords);
    }

    public static function isArticle(string $word): bool
    {
        return in_array($word, $this->articles);
    }

    public function replaceDelimeters(string $replacement = " "): string
    {
        $newString = $this->text;
        foreach ($this->delimeters as $delimeter) {
            $newString = str_replace($delimeter, $replacement, $newString);
        }
        return $newString;
    }

    private static function capitalizeTitleWord(string $word): string
    {
        if (self::isArticle($word)) {
            return strtolower($word);
        } else {
            return ucfirst($word);
        }
    }

    private static function capitalizeCamelWord(string $word, int $index): string
    {
        if ($index !== 0) {
            return ucfirst($word);
        } else {
            return strtolower($word);
        }
    }

    public function split(): array
    {
        $stringWithSpaces = $this->replaceDelimeters();
        return explode(" ", $stringWithSpaces);
    }
}
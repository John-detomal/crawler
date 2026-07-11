<?php

namespace App\Services\Scraper\Parser\Xpath;

use DOMDocument;
use DOMNode;
use DOMNodeList;

class XpathResult
{
    private ?DOMNode $node = null;
    public $type = 'xpath';


    public function __construct(
        private ?DOMDocument $dom,
        private ?DOMNodeList $nodes,
        private ?string $errors = null,
    ) {}

    public function item(int $index = 0): self
    {
        $this->node = $this->nodes->item($index);

        return $this;
    }

    public function text(): string
    {
        return $this->node?->textContent ?? '';
    }

    public function html(): string
    {
        if (!$this->node) {
            return '';
        }

        return $this->dom->saveHTML($this->node);
    }


    public function attr(string $name): string
    {
        if (!$this->node?->attributes) {
            return '';
        }

        return $this->node
            ->attributes
            ->getNamedItem($name)
            ?->nodeValue ?? '';
    }

    public function htmlAll(): array
    {
        if ($this->nodes === null) {
            return [];
        }

        $results = [];

        foreach ($this->nodes as $node) {
            $results[] = $this->dom->saveHTML($node);
        }

        return $results;
    }

    public function textAll(): array
    {
        if ($this->nodes === null) {
            return [];
        }

        $results = [];

        foreach ($this->nodes as $node) {
            $results[] = $node->textContent;
        }

        return $results;
    }

    public function attrAll(string $name): array
    {
        if ($this->nodes === null) {
            return [];
        }

        $results = [];

        foreach ($this->nodes as $node) {

            if (!$node->attributes) {
                continue;
            }

            $results[] = $node
                ->attributes
                ->getNamedItem($name)
                ?->nodeValue ?? '';
        }

        return $results;
    }

    public function all(): DOMNodeList
    {
        return $this->nodes;
    }

    public function count(): int
    {
        return $this->nodes->length;
    }

    public function first(): self
    {
        return $this->item(0);
    }

    public function last(): self
    {
        return $this->item(
            max(0, $this->nodes->length - 1)
        );
    }

    public function errors()
    {
        return $this->errors;
    }
}

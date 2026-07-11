<?php

namespace App\Services\Scraper\Parser\Regex;

class RegexResult
{
    private array $current = [];
    public $type = 'regex';

    public function __construct(
        private array $matches,
        private ?string $errors = null,
    ) {}

    public function item(int $index = 0): self
    {
        $this->current = $this->matches[$index] ?? [];

        return $this;
    }

    public function text(?int $group = 0): string
    {
        return $this->current[$group] ?? '';
    }

    public function html(int $group = 0): string
    {
        return $this->text($group);
    }

    public function all(): array
    {
        return $this->matches;
    }

    public function textAll(int $group = 0): array
    {
        $results = [];

        foreach ($this->matches as $match) {
            $results[] = $match[$group] ?? '';
        }

        return $results;
    }

    public function htmlAll(int $group = 0): array
    {
        return $this->textAll($group);
    }

    public function count(): int
    {
        return count($this->matches);
    }

    public function first(): self
    {
        return $this->item(0);
    }

    public function last(): self
    {
        return $this->item(
            max(0, count($this->matches) - 1)
        );
    }

    public function errors()
    {
        return $this->errors;
    }
}

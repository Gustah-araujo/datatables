<?php

namespace GustahAraujo\Datatables\Column;

use Illuminate\Contracts\View\View;

abstract class BaseColumn
{
    protected string $name;
    protected string|null $label = null;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return is_null($this->label) ? $this->name : $this->label;
    }

    abstract public function renderHeader(): string|View;
    abstract public function renderRow($item): string|View;
}

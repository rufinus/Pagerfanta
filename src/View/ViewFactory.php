<?php declare(strict_types=1);

namespace Pagerfanta\View;

use Pagerfanta\Exception\InvalidArgumentException;

final class ViewFactory implements ViewFactoryInterface
{
    /**
     * @var array<string, ViewInterface>
     */
    private array $views = [];

    public function set(string $name, ViewInterface $view): void
    {
        $this->views[$name] = $view;
    }

    public function has(string $name): bool
    {
        return isset($this->views[$name]);
    }

    /**
     * @param array<string, ViewInterface> $views
     */
    public function add(array $views): void
    {
        foreach ($views as $name => $view) {
            $this->set($name, $view);
        }
    }

    /**
     * @throws InvalidArgumentException if the view does not exist
     */
    public function get(string $name): ViewInterface
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('The view "%s" does not exist.', $name));
        }

        return $this->views[$name];
    }

    /**
     * @throws InvalidArgumentException if the view does not exist
     */
    public function remove(string $name): void
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('The view "%s" does not exist.', $name));
        }

        unset($this->views[$name]);
    }

    /**
     * @return array<string, ViewInterface>
     */
    public function all(): array
    {
        return $this->views;
    }

    public function clear(): void
    {
        $this->views = [];
    }
}

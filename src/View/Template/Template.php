<?php

namespace Pagerfanta\View\Template;

use Pagerfanta\Exception\InvalidArgumentException;
use Pagerfanta\Exception\RuntimeException;

abstract class Template implements TemplateInterface
{
    protected static array $defaultOptions = [];

    /**
     * @var callable
     */
    private $routeGenerator;

    private array $options;

    public function __construct()
    {
        $this->options = static::$defaultOptions;
    }

    public function setRouteGenerator(callable $routeGenerator): void
    {
        $this->routeGenerator = $routeGenerator;
    }

    public function setOptions(array $options): void
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Generate the route (URL) for the given page
     */
    protected function generateRoute(int $page): string
    {
        $generator = $this->getRouteGenerator();

        return $generator($page);
    }

    /**
     * @throws RuntimeException if the route generator has not been set
     */
    private function getRouteGenerator(): callable
    {
        if (!$this->routeGenerator) {
            throw new RuntimeException(sprintf('The route generator was not set to the template, ensure you call %s::setRouteGenerator().', static::class));
        }

        return $this->routeGenerator;
    }

    /**
     * @return mixed The option value if it exists
     *
     * @throws InvalidArgumentException if the option does not exist
     */
    protected function option(string $name)
    {
        if (!isset($this->options[$name])) {
            throw new InvalidArgumentException(sprintf('The option "%s" does not exist.', $name));
        }

        return $this->options[$name];
    }
}

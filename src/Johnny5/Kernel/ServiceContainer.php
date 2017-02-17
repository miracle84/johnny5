<?php

namespace Johnny5\Kernel;

use Exception;
use ReflectionClass;

/**
 * Class ServiceContainer
 * @package Johnny5\Kernel\SerivceContainer
 */
class ServiceContainer
{
    /** @var array */
    private $serviceList = [];
    /** @var array */
    private $paramList = [];
    /** @var ServiceContainer|null */
    private static $instance = null;
    /** @var array */
    private $serviceDependencyList;

    private function __construct(array $serviceDependencyList = [], array $paramList = [])
    {
        $this->serviceDependencyList = $serviceDependencyList;
        $this->paramList = $paramList;
        $this->fillDependency();
    }

    private function fillDependency()
    {
        $serviceDependencyList = $this->serviceDependencyList;

        $previousCount = 0;
        while (true) {
            $info = each($serviceDependencyList);
            if (!$info) {
                if (!$serviceDependencyList) {
                    break;
                } else {
                    if (count($serviceDependencyList) === $previousCount) {
                        $notCreateServiceList = array_column($serviceDependencyList, 'name');
                        $notCreateServiceStr = implode(', ', $notCreateServiceList);

                        throw new Exception('Service creation error: ' . $notCreateServiceStr);
                    } else {
                        reset($serviceDependencyList);
                        $previousCount = count($serviceDependencyList);
                        $info = each($serviceDependencyList);
                    }
                }
            }

            $reflectionClass = new ReflectionClass($info['value']['name']);
            $argumentList = (isset($info['value']['argument_list'])) ? $info['value']['argument_list'] : [];
            $argumentFillList = [];

            if ($argumentList) {
                $temporarySkipService = false;
                foreach ($argumentList as $argument) {
                    if (0 != preg_match('/^%([^%]+)%$/', $argument, $result)) {
                        // parameter
                        if (array_key_exists($result[1], $this->paramList)) {
                            $argumentFillList[] = $this->paramList[$result[1]];
                        } else {
                            throw new Exception('Parameter ' . $result[1] . ' does not exists');
                        }
                    } else {
                        // service
                        if (array_key_exists($argument, $this->serviceList)) {
                            $argumentFillList[] = $this->serviceList[$argument];
                        } else {
                            $temporarySkipService = true;
                            break;
                        }
                    }
                }

                if ($temporarySkipService) {
                    continue;
                }
            }

            $class = $reflectionClass->newInstanceArgs($argumentFillList);
            $this->serviceList[$info['key']] = $class;
            unset($serviceDependencyList[$info['key']]);
        }
    }

    /**
     * @param array $config
     * @param array $paramList
     */
    public static function init(array $config = [], array $paramList = [])
    {
        if (!self::$instance) {
            self::$instance = new self($config, $paramList);
        }
    }

    /**
     * @return ServiceContainer|null
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @param string $name
     *
     * @return object|null
     */
    public function get($name)
    {
        $service = (isset($this->serviceList[$name])) ? $this->serviceList[$name] : null;

        return $service;
    }

    /**
     * @param string $tag
     *
     * @return object[]
     */
    public function getListByTag($tag)
    {
        $serviceKeyList = array_filter($this->serviceDependencyList, function ($info) use ($tag) {
            return (array_key_exists('tag', $info) && $info['tag'] == $tag);
        });

        if ($serviceKeyList) {
            $serviceList = array_intersect_key($this->serviceList, $serviceKeyList);
        } else {
            $serviceList = [];
        }

        return $serviceList;
    }

    /**
     * @param string $name
     * @param object $class
     */
    public function set($name, $class)
    {
        $this->serviceList[$name] = $class;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}

<?php

namespace App\Base;

use Illuminate\Support\Arr;
use Cache;

/**
 * Class CoreHelper.
 */
class CoreHelper
{
    const TAG = 'core';
    
    /**
     * Get modules
     *
     * @return array
     */
    public static function getModules() : array
    {
        return Cache::tags(self::TAG)->remember(self::TAG . '_getModules_', 60*60*24, function() {
            $skip = ['.', '..'];
            $modules = [];

            $path = app_path() . '/Modules';
            $files = scandir($path);
            foreach ($files as $module) {
                if (!in_array($module, $skip) && is_dir($path . '/' . $module)) {
                    $modules[] = $module;
                }
            }
            
            return $modules;
        });          
    }
    
    /**
     * Get widgets
     *
     * @return array
     */
    public static function getWidgets() : array
    {
        return Cache::tags(self::TAG)->remember(self::TAG . '_getWidgets_', 60*60*24, function() {
            $widgets = [];

            foreach (self::getModules() as $module) {
                $file = app_path() . '/Modules/' . $module . '/Front/Widget.php';

                if (is_file($file)) {
                    $widgetNamespace = self::getWidgetNamespace($module);
                    $widgetObject = new $widgetNamespace;

                    $widgets[] = [
                        'id' => $module,
                        'name' => $widgetObject->getName(),
                        'config' => $widgetObject->getConfig(),
                    ];
                }
            }

            return $widgets;
        });    
    }
    
    /*
     * @param string $id
     * @return string
     */
    public static function getWidgetNamespace(string $id): string
    {
        return $widgetNamespace = "\App\Modules\\$id\Front\Widget";
    }
    
    /*
     * @param string $widgetId 
     * @return WidgetBase 
     */
    public static function getWidgetInstance(string $widgetId): WidgetBase
    {
        $namespace = self::getWidgetNamespace($widgetId);
        return new $namespace;
    }
    
    
    /**
     * Get widgets
     *
     * @return array
     */
    public static function getWidgetsIds() : array
    {
        return Arr::pluck(self::getWidgets(), 'id');
    }
      
     /**
     * Get side menu
     *
     * @return array
     */
    public static function getMenu() : array
    {
        return Cache::tags(self::TAG)->remember(self::TAG . '_getMenu_', 60*60*24, function() {
            $items = [];

            foreach (self::getModules() as $module) {
                $file = app_path() . '/Modules/' . $module . '/Admin/Config/menu.php';
                
                preg_match('/app\/Modules\/(.*?)\/Admin\/Config/', $file, $match);
                
                if (is_file($file)) {
                    $itemFile = require $file;
                    //$itemFile[0]['module'] = $match[1];
                    $items = array_merge($items, $itemFile);
                }
            }
            
            $items = array_values(Arr::sort($items, function ($value) {
                return $value['rank'];
            }));        
            
            return $items;
        });   
    }
   
    
}

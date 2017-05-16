<?php
/**
 * @author Vadim Trunov <vadim.tr@bigdropinc.com>
 *
 * @copyright (C) 2017 - Bigdrop Inc
 *
 * @license https://opensource.org/licenses/BSD-3-Clause
 */

namespace \bigdropinc\db;


use Yii;
use yii\helpers\BaseInflector;


trait FindByAttribute
{

    public static function getFindByAttributeName($name)
    {

        if(strpos($name, 'findAllBy') === 0){
            $attributeName = BaseInflector::underscore(str_replace('findAllBy', '', $name));
        }
        else if(strpos($name, 'findBy') === 0){
            $attributeName = BaseInflector::underscore(str_replace('findBy', '', $name));
        }
        return isset($attributeName) && static::isColumnExist($attributeName) ? $attributeName : null;

    }

    public static function getFindByMethodName($name)
    {
        if(strpos($name, 'findAllBy') === 0){
            return 'all';
        }
        else if(strpos($name, 'findBy') === 0){
            return 'one';
        } else {
            return null;
        }
    }

    public static function isFindByCanProcess($name)
    {
        return !empty(static::getFindByAttributeName($name));
    }

    public static function processFindBy($name, $arguments)
    {
        if($attributeName = static::getFindByAttributeName($name)){
            $findMethod = static::getFindByMethodName($name);
            $value = $arguments[0];
            return static::callFindByMethod($findMethod, $attributeName, $value);
        }
    }

    public static function callFindByMethod($findMethod, $attributeName, $value)
    {
        $query = static::find()->where([static::tableName().'.'.$attributeName => $value]);
        return $query->$findMethod();
    }

    private static function isColumnExist($column)
    {
        $table = Yii::$app->db->schema->getTableSchema(static::tableName());
        return isset($table->columns[$column]);
    }
}
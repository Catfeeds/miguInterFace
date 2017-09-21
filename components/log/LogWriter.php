<?php
/**
 * Description:
 * put the description here.
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-8-18
 * Time: 下午1:54
 *
 */

class LogWriter
{

    /**
     * model 保存失败
     * @param $model
     * @param string $class_method
     * @param array $params
     */
    public static function logModelSaveError($model, $class_method = '', $params = array())
    {
        $errStr = '';
        if ($model instanceof CActiveRecord) {
            foreach ($model->getErrors() as $error) {
                $errStr .= $error[0];
            }
            $logStr = $model->tableName() . "保存失败: " . $errStr . ".";
            if (!empty($class_method))
                $logStr .= "发生于：" . $class_method . ".";
            if (isset($params)&& is_array($params)) {
                foreach ($params as $paramKey => $paramValue) {
                    $logStr .= "参数[" . $paramKey . "=>" . $paramValue . "];";
                }
            }

            Yii::log('[' . date('Y-m-d H:i:s') . ']' . $logStr, 'error');
        }

    }

    /**
     * @param $msg
     * @param string $class_method
     * @param array $params
     */
    public static function logMsg($msg, $class_method = '', $params = array())
    {
        $logStr = $msg;
        if (!empty($class_method))
            $logStr .= ",发生于：" . $class_method . ".";
        if(is_array($params)){
            if (isset($params)) {
                foreach ($params as $paramKey => $paramValue) {
                    $logStr .= "参数[" . $paramKey . "=>" . $paramValue . "]；";
                }
            }
        }elseif(is_string($params)){
            $logStr = $params;
        }

        Yii::log('[' . date('Y-m-d H:i:s') . ']' . $logStr, 'error');
    }
}

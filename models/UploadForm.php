<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/24 0024
 * Time: 16:42
 */


/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends CFormModel
{

    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }
}